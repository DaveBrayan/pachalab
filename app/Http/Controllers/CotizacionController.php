<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CotizacionController extends Controller
{
    /**
     * Obtiene la configuración de correo SMTP desde storage o variables de entorno.
     */
    protected function getMailConfig(): array
    {
        $cmsFile = storage_path('cms/pachalab_content.json');
        $cms = [];
        if (File::exists($cmsFile)) {
            $cms = json_decode(File::get($cmsFile), true) ?: [];
        }

        return [
            'host' => $cms['mail_host'] ?? env('MAIL_HOST', 'mail.pachabol.com'),
            'port' => (int) ($cms['mail_port'] ?? env('MAIL_PORT', 465)),
            'encryption' => strtolower($cms['mail_encryption'] ?? env('MAIL_ENCRYPTION', 'ssl')),
            'username' => $cms['mail_username'] ?? env('MAIL_USERNAME', 'notificaciones@pachabol.com'),
            'password' => $cms['mail_password'] ?? env('MAIL_PASSWORD', ''),
            'from_address' => $cms['mail_from_address'] ?? env('MAIL_FROM_ADDRESS', 'notificaciones@pachabol.com'),
            'from_name' => $cms['mail_from_name'] ?? env('MAIL_FROM_NAME', 'PachaLab - Cotizaciones'),
            'notify_email' => $cms['mail_notify_recipient'] ?? 'laboratorio@pachabol.com',
            'attach_pdf' => (bool) ($cms['mail_attach_pdf'] ?? 1),
            'notify_client' => (bool) ($cms['mail_notify_client'] ?? 1),
            'notify_team' => (bool) ($cms['mail_notify_team'] ?? 1),
        ];
    }

    /**
     * Aplica la configuración SMTP dinámicamente en tiempo de ejecución.
     */
    protected function applyMailConfig(array $cfg): void
    {
        $isSsl = ($cfg['port'] == 465 || $cfg['encryption'] === 'ssl');
        
        Config::set('mail.default', 'smtp');
        Config::set('mail.mailers.smtp.transport', 'smtp');
        Config::set('mail.mailers.smtp.scheme', $isSsl ? 'smtps' : null);
        Config::set('mail.mailers.smtp.host', $cfg['host']);
        Config::set('mail.mailers.smtp.port', $cfg['port']);
        Config::set('mail.mailers.smtp.username', $cfg['username']);
        Config::set('mail.mailers.smtp.password', $cfg['password']);
        Config::set('mail.from.address', $cfg['from_address']);
        Config::set('mail.from.name', $cfg['from_name']);

        // Opciones de stream SSL tolerantes para certificados de cPanel compartidos
        Config::set('mail.mailers.smtp.stream', [
            'ssl' => [
                'allow_self_signed' => true,
                'verify_peer' => false,
                'verify_peer_name' => false,
            ]
        ]);
    }

    /**
     * Procesa y envía una cotización por correo electrónico.
     */
    public function enviarCorreo(Request $request)
    {
        $data = $request->validate([
            'cliente_nombre' => 'required|string|max:190',
            'cliente_email' => 'required|email|max:190',
            'cliente_telefono' => 'nullable|string|max:50',
            'cliente_empresa' => 'nullable|string|max:190',
            'departamento' => 'nullable|string|max:100',
            'cargo' => 'nullable|string|max:100',
            'tipo_cotizacion' => 'nullable|string|max:100',
            'codigo_cotizacion' => 'nullable|string|max:100',
            'total' => 'nullable|string|max:50',
            'items' => 'nullable|array',
            'pdf_base64' => 'nullable|string',
            'detalles' => 'nullable|string',
        ]);

        $cfg = $this->getMailConfig();
        $this->applyMailConfig($cfg);

        $codigo = !empty($data['codigo_cotizacion'])
            ? $data['codigo_cotizacion']
            : $this->getNextQuotationCode('COT-GEN');
        $tipoNombre = match ($data['tipo_cotizacion'] ?? '') {
            'ambiental' => 'Monitoreo Ambiental',
            'ocupacional' => 'Monitoreo Ocupacional',
            'equipos' => 'Alquiler de Equipos',
            default => 'Cotización General de Servicios'
        };

        // Generar cuerpo del correo en HTML responsivo y elegante
        $htmlContent = $this->buildEmailHtml($data, $codigo, $tipoNombre);
        $backupHtmlContent = $this->buildEmailHtml($data, $codigo, $tipoNombre, true);

        // Archivo temporal para adjunto PDF si fue generado por jsPDF
        $tempPdfPath = null;
        if (!empty($data['pdf_base64']) && $cfg['attach_pdf']) {
            try {
                $base64 = $data['pdf_base64'];
                if (str_contains($base64, ',')) {
                    $base64 = explode(',', $base64)[1];
                }
                $pdfBinary = base64_decode($base64);
                if ($pdfBinary !== false) {
                    $tempPdfPath = tempnam(sys_get_temp_dir(), 'cot_') . '.pdf';
                    File::put($tempPdfPath, $pdfBinary);
                }
            } catch (\Throwable $e) {
                Log::warning('No se pudo procesar adjunto PDF base64: ' . $e->getMessage());
            }
        }

        $sentCount = 0;
        $errors = [];

        // 1. Envío al Cliente
        if ($cfg['notify_client'] && !empty($data['cliente_email'])) {
            try {
                Mail::html($htmlContent, function ($message) use ($data, $cfg, $codigo, $tipoNombre, $tempPdfPath) {
                    $message->to($data['cliente_email'], $data['cliente_nombre'])
                            ->from($cfg['from_address'], $cfg['from_name'])
                            ->subject("Cotización {$tipoNombre} N° {$codigo} — PachaLab Pachabol");

                    if ($tempPdfPath && File::exists($tempPdfPath)) {
                        $message->attach($tempPdfPath, [
                            'as' => "Cotizacion_{$codigo}_PachaLab.pdf",
                            'mime' => 'application/pdf',
                        ]);
                    }
                });
                $sentCount++;
            } catch (\Throwable $e) {
                $errors[] = 'Cliente: ' . $e->getMessage();
                Log::error('Error enviando cotización al cliente: ' . $e->getMessage());
            }
        }

        // 2. Copia de respaldo interna con el mismo PDF adjunto a laboratorio@pachabol.com
        if ($cfg['notify_team'] && !empty($cfg['notify_email'])) {
            try {
                $empresaRespaldo = $data['cliente_empresa'] ?? 'Sin empresa';
                $internalSubject = "[RESPALDO NUEVA COTIZACIÓN] {$tipoNombre} N° {$codigo} — {$data['cliente_nombre']} ({$empresaRespaldo})";
                Mail::html($backupHtmlContent, function ($message) use ($cfg, $internalSubject, $tempPdfPath, $codigo) {
                    $message->to($cfg['notify_email'])
                            ->from($cfg['from_address'], $cfg['from_name'])
                            ->subject($internalSubject);

                    if ($tempPdfPath && File::exists($tempPdfPath)) {
                        $message->attach($tempPdfPath, [
                            'as' => "Cotizacion_{$codigo}_PachaLab.pdf",
                            'mime' => 'application/pdf',
                        ]);
                    }
                });
                $sentCount++;
            } catch (\Throwable $e) {
                $errors[] = 'Equipo: ' . $e->getMessage();
                Log::error('Error enviando copia de respaldo a PachaLab: ' . $e->getMessage());
            }
        }

        // Eliminar archivo temporal si existe
        if ($tempPdfPath && File::exists($tempPdfPath)) {
            @unlink($tempPdfPath);
        }

        // Registrar la cotización en la bandeja (JSON compartido + MySQL PachaDash)
        $this->saveQuotationRecord($data, $codigo, $tipoNombre, $sentCount > 0);

        if ($sentCount > 0) {
            return response()->json([
                'status' => 'success',
                'message' => 'Cotización enviada con éxito desde ' . $cfg['from_address'] . ' a ' . $data['cliente_email'],
                'codigo' => $codigo,
                'from' => $cfg['from_address']
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Cotización guardada en bandeja, pero hubo un error enviando el correo: ' . implode(' | ', $errors),
            'codigo' => $codigo
        ], 500);
    }

    /**
     * Registra la cotización generada en el historial compartido y directamente en MySQL PachaDash.
     */
    protected function saveQuotationRecord(array $data, string $codigo, string $tipoNombre, bool $emailSent): void
    {
        $now = date('Y-m-d H:i:s');
        $record = [
            'codigo' => $codigo,
            'tipo' => $data['tipo_cotizacion'] ?? 'general',
            'tipo_nombre' => $tipoNombre,
            'cliente_nombre' => $data['cliente_nombre'] ?? 'Cliente',
            'cliente_email' => $data['cliente_email'] ?? '',
            'cliente_telefono' => $data['cliente_telefono'] ?? '',
            'cliente_empresa' => $data['cliente_empresa'] ?? 'No especificada',
            'departamento' => $data['departamento'] ?? 'Bolivia',
            'cargo' => $data['cargo'] ?? '-',
            'total' => $data['total'] ?? '0.00',
            'items' => $data['items'] ?? [],
            'detalles' => $data['detalles'] ?? '',
            'estado' => 'pendiente',
            'email_enviado' => $emailSent ? 1 : 0,
            'created_at' => $now,
        ];

        // 1. Guardar en JSON compartido (storage/cms/cotizaciones_log.json)
        try {
            $cmsDir = storage_path('cms');
            if (!File::exists($cmsDir)) {
                File::makeDirectory($cmsDir, 0755, true, true);
            }
            $logFile = $cmsDir . '/cotizaciones_log.json';
            $list = File::exists($logFile) ? (json_decode(File::get($logFile), true) ?: []) : [];
            if (!is_array($list)) $list = [];

            // Evitar duplicados por código
            $exists = false;
            foreach ($list as $idx => $item) {
                if (($item['codigo'] ?? '') === $codigo) {
                    $list[$idx] = $record;
                    $exists = true;
                    break;
                }
            }
            if (!$exists) {
                array_unshift($list, $record);
            }
            File::put($logFile, json_encode($list, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        } catch (\Throwable $e) {
            Log::warning('Error guardando cotización en cotizaciones_log.json: ' . $e->getMessage());
        }

        // 2. Insertar directamente en MySQL PachaDash (pachadash.cotizaciones)
        try {
            $dashEnv = 'D:/Dave/Proyectos/Pachabol/Pachabol/PachaDash/.env';
            $dbHost = '127.0.0.1';
            $dbPort = '3306';
            $dbName = 'pachadash';
            $dbUser = 'root';
            $dbPass = '';

            if (File::exists($dashEnv)) {
                $envText = File::get($dashEnv);
                if (preg_match('/^DB_HOST=(.*)$/m', $envText, $m)) $dbHost = trim($m[1], " \t\n\r\"'");
                if (preg_match('/^DB_PORT=(.*)$/m', $envText, $m)) $dbPort = trim($m[1], " \t\n\r\"'");
                if (preg_match('/^DB_DATABASE=(.*)$/m', $envText, $m)) $dbName = trim($m[1], " \t\n\r\"'");
                if (preg_match('/^DB_USERNAME=(.*)$/m', $envText, $m)) $dbUser = trim($m[1], " \t\n\r\"'");
                if (preg_match('/^DB_PASSWORD=(.*)$/m', $envText, $m)) $dbPass = trim($m[1], " \t\n\r\"'");
            }

            $pdo = new \PDO(
                "mysql:host={$dbHost};port={$dbPort};dbname={$dbName};charset=utf8mb4",
                $dbUser,
                $dbPass,
                [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
            );

            $stmt = $pdo->prepare("
                INSERT INTO cotizaciones
                (codigo, tipo, tipo_nombre, cliente_nombre, cliente_email, cliente_telefono, cliente_empresa, departamento, cargo, total, items, detalles, estado, email_enviado, created_at, updated_at)
                VALUES
                (:codigo, :tipo, :tipo_nombre, :cliente_nombre, :cliente_email, :cliente_telefono, :cliente_empresa, :departamento, :cargo, :total, :items, :detalles, :estado, :email_enviado, :created_at, :updated_at)
                ON DUPLICATE KEY UPDATE
                email_enviado = VALUES(email_enviado),
                updated_at = VALUES(updated_at)
            ");

            $stmt->execute([
                ':codigo' => $record['codigo'],
                ':tipo' => $record['tipo'],
                ':tipo_nombre' => $record['tipo_nombre'],
                ':cliente_nombre' => $record['cliente_nombre'],
                ':cliente_email' => $record['cliente_email'],
                ':cliente_telefono' => $record['cliente_telefono'],
                ':cliente_empresa' => $record['cliente_empresa'],
                ':departamento' => $record['departamento'],
                ':cargo' => $record['cargo'],
                ':total' => $record['total'],
                ':items' => json_encode($record['items'], JSON_UNESCAPED_UNICODE),
                ':detalles' => $record['detalles'],
                ':estado' => $record['estado'],
                ':email_enviado' => $record['email_enviado'],
                ':created_at' => $now,
                ':updated_at' => $now,
            ]);
        } catch (\Throwable $e) {
            Log::warning('Nota: No se pudo insertar directo a MySQL PachaDash (se sincronizará vía JSON): ' . $e->getMessage());
        }
    }

    /**
     * Envía un correo de prueba para verificar las credenciales SMTP configuradas.
     */
    public function probarSmtp(Request $request)
    {
        $target = $request->input('email', $request->input('correo'));
        if (!$target || !filter_var($target, FILTER_VALIDATE_EMAIL)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Por favor proporcione un correo válido de prueba.'
            ], 422);
        }

        $cfg = $this->getMailConfig();

        // Si se enviaron datos temporales desde el formulario de ajustes, usarlos prioritariamente
        if ($request->filled('host')) $cfg['host'] = $request->input('host');
        if ($request->filled('port')) $cfg['port'] = (int) $request->input('port');
        if ($request->filled('encryption')) $cfg['encryption'] = $request->input('encryption');
        if ($request->filled('username')) $cfg['username'] = $request->input('username');
        if ($request->filled('password')) $cfg['password'] = $request->input('password');
        if ($request->filled('from_address')) $cfg['from_address'] = $request->input('from_address');
        if ($request->filled('from_name')) $cfg['from_name'] = $request->input('from_name');

        $this->applyMailConfig($cfg);

        try {
            $testHtml = "
            <div style='font-family:sans-serif; max-width:540px; margin:0 auto; padding:24px; border:1px solid #bcebec; border-radius:16px; background:#f9fdfd;'>
              <h2 style='color:#06454a; margin-top:0;'>✓ Verificación de Conexión SMTP Exitosa</h2>
              <p style='color:#273b43; font-size:14px;'>Este es un mensaje de prueba generado desde el ecosistema <strong>PachaDash / PachaLab</strong>.</p>
              <div style='background:#ffffff; border-radius:10px; padding:16px; margin:16px 0; border:1px solid #e1ebed;'>
                <p style='margin:4px 0; font-size:13px;'><strong>Servidor SMTP:</strong> {$cfg['host']}:{$cfg['port']}</p>
                <p style='margin:4px 0; font-size:13px;'><strong>Remitente (FROM):</strong> {$cfg['from_address']}</p>
                <p style='margin:4px 0; font-size:13px;'><strong>Cifrado:</strong> " . strtoupper($cfg['encryption']) . "</p>
                <p style='margin:4px 0; font-size:13px;'><strong>Fecha y Hora:</strong> " . date('Y-m-d H:i:s') . "</p>
              </div>
              <p style='color:#095b12; font-size:13px; font-weight:bold;'>El servicio de correo está listo para enviar cotizaciones oficiales a tus clientes.</p>
            </div>";

            Mail::html($testHtml, function ($message) use ($target, $cfg) {
                $message->to($target)
                        ->from($cfg['from_address'], $cfg['from_name'])
                        ->subject("✓ Prueba de Conexión SMTP Exitosa - {$cfg['from_name']}");
            });

            return response()->json([
                'status' => 'success',
                'message' => "¡Conexión SMTP exitosa! Correo de prueba enviado a {$target} desde {$cfg['from_address']}."
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Fallo de conexión SMTP: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Devuelve el siguiente código correlativo de cotización iniciando desde 0.
     */
    public function siguienteCodigo(Request $request)
    {
        $suffix = $request->query('suffix', 'COT-REF');
        $codigo = $this->getNextQuotationCode($suffix);

        return response()->json([
            'status' => 'success',
            'codigo' => $codigo,
        ]);
    }

    /**
     * Genera e incrementa el correlativo de cotización iniciando en 00.
     */
    protected function getNextQuotationCode(string $suffix = 'COT-REF'): string
    {
        $cmsDir = storage_path('cms');
        if (!File::exists($cmsDir)) {
            File::makeDirectory($cmsDir, 0755, true, true);
        }

        $counterFile = $cmsDir . '/cotizacion_counter.txt';
        $current = 0;

        if (File::exists($counterFile)) {
            $raw = trim(File::get($counterFile));
            if (is_numeric($raw)) {
                $current = (int) $raw;
            }
        }

        $numFormatted = str_pad((string) $current, 2, '0', STR_PAD_LEFT);
        $year = date('y');
        $codigo = "{$numFormatted}-{$year}-{$suffix}";

        File::put($counterFile, (string) ($current + 1));

        return $codigo;
    }

    /**
     * Genera la plantilla HTML con acabado corporativo de lujo de PachaLab.
     */
    protected function buildEmailHtml(array $data, string $codigo, string $tipoNombre, bool $isBackup = false): string
    {
        $nombre = htmlspecialchars($data['cliente_nombre'] ?? 'Cliente');
        $emailCliente = htmlspecialchars($data['cliente_email'] ?? '-');
        $empresa = htmlspecialchars($data['cliente_empresa'] ?? 'No especificada');
        $telefono = htmlspecialchars($data['cliente_telefono'] ?? '-');
        $ciudad = htmlspecialchars($data['departamento'] ?? 'Bolivia');
        $cargo = htmlspecialchars($data['cargo'] ?? '-');
        $total = htmlspecialchars($data['total'] ?? '0.00');
        $detalles = !empty($data['detalles']) ? nl2br(htmlspecialchars($data['detalles'])) : null;
        $items = $data['items'] ?? [];
        $fecha = date('d/m/Y');

        $backupBanner = $isBackup
            ? "<div style='background:#e6f9f2; border:1px solid #bcead8; border-radius:10px; padding:12px 16px; margin-bottom:16px; font-size:12.5px; color:#06454a;'>
                 <strong>📋 COPIA DE RESPALDO INTERNA:</strong> Se ha generado una nueva cotización en la web y se envió al correo del cliente (<strong>{$emailCliente}</strong>) con el PDF adjunto.
               </div>"
            : "";

        $rowsHtml = '';
        if (!empty($items) && is_array($items)) {
            foreach ($items as $item) {
                $nombreItem = htmlspecialchars($item['parametro'] ?? $item['equipo'] ?? '-');
                $subtexto = htmlspecialchars($item['metodologia'] ?? $item['caracteristicas'] ?? '');
                $cant = htmlspecialchars($item['cantidad'] ?? $item['dias'] ?? '1');
                $pu = htmlspecialchars($item['precio'] ?? '0.00');
                $subtotal = htmlspecialchars($item['subtotal'] ?? '0.00');

                $rowsHtml .= "
                <tr style='border-bottom:1px solid #eef2f3;'>
                    <td style='padding:10px 12px; font-size:13px; color:#0d1e24;'>
                        <strong>{$nombreItem}</strong>
                        " . ($subtexto ? "<div style='font-size:11px; color:#657982;'>{$subtexto}</div>" : '') . "
                    </td>
                    <td style='padding:10px 12px; font-size:13px; text-align:center; color:#273b43;'>{$cant}</td>
                    <td style='padding:10px 12px; font-size:13px; text-align:right; color:#273b43;'>Bs. {$pu}</td>
                    <td style='padding:10px 12px; font-size:13px; text-align:right; font-weight:bold; color:#06454a;'>Bs. {$subtotal}</td>
                </tr>";
            }
        }

        return "
        <!DOCTYPE html>
        <html>
        <head>
          <meta charset='utf-8'>
          <meta name='viewport' content='width=device-width, initial-scale=1.0'>
          <title>Cotización PachaLab</title>
        </head>
        <body style='margin:0; padding:24px 10px; background-color:#edf4f4; font-family:\"Segoe UI\", Roboto, Helvetica, Arial, sans-serif;'>
          <table align='center' border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width:620px; background:#ffffff; border-radius:20px; overflow:hidden; box-shadow:0 12px 36px rgba(6,69,74,0.08); border:1px solid #d8e9ea;'>
            
            <!-- HEADER -->
            <tr>
              <td style='padding:28px 32px; background:linear-gradient(135deg, #06454a 0%, #04353a 60%, #032a2e 100%); color:#ffffff;'>
                <table width='100%'>
                  <tr>
                    <td>
                      <span style='background:rgba(22,183,193,0.22); color:#20d4e0; font-size:11px; font-weight:800; padding:4px 12px; border-radius:999px; text-transform:uppercase; letter-spacing:0.05em;'>PACHALAB · LABORATORIO PACHABOL</span>
                      <h1 style='margin:10px 0 2px; font-size:22px; font-weight:800; letter-spacing:-0.02em;'>Cotización Oficial de Servicios</h1>
                      <div style='font-size:13px; color:rgba(255,255,255,0.75);'>{$tipoNombre}</div>
                    </td>
                    <td align='right' style='vertical-align:top;'>
                      <div style='background:#ffffff; color:#06454a; font-size:12px; font-weight:800; padding:8px 14px; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.15); display:inline-block;'>
                        N° {$codigo}
                      </div>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

            <!-- DATOS DEL CLIENTE -->
            <tr>
              <td style='padding:24px 32px 14px;'>
                {$backupBanner}
                <p style='margin:0 0 16px; font-size:15px; color:#0d1e24;'>Estimado(a) <strong>{$nombre}</strong>,</p>
                <p style='margin:0 0 18px; font-size:13.5px; color:#4a686b; line-height:1.5;'>
                  Agradecemos su interés en los servicios especializados de <strong>PachaLab</strong>. A continuación le presentamos el desglose detallado de su cotización formal:
                </p>

                <table width='100%' style='background:#f4f9f9; border-radius:14px; padding:14px 16px; border:1px solid #e1ebed; font-size:12.5px;'>
                  <tr>
                    <td style='padding:4px 0; color:#657982;'><strong>Empresa/Institución:</strong></td>
                    <td style='padding:4px 0; color:#0d1e24;'>{$empresa}</td>
                    <td style='padding:4px 0; color:#657982;'><strong>Atención / Cargo:</strong></td>
                    <td style='padding:4px 0; color:#0d1e24;'>{$cargo}</td>
                  </tr>
                  <tr>
                    <td style='padding:4px 0; color:#657982;'><strong>Ciudad:</strong></td>
                    <td style='padding:4px 0; color:#0d1e24;'>{$ciudad}</td>
                    <td style='padding:4px 0; color:#657982;'><strong>Celular/Teléfono:</strong></td>
                    <td style='padding:4px 0; color:#0d1e24;'>{$telefono}</td>
                  </tr>
                  <tr>
                    <td style='padding:4px 0; color:#657982;'><strong>Fecha Emisión:</strong></td>
                    <td style='padding:4px 0; color:#0d1e24;'>{$fecha}</td>
                    <td style='padding:4px 0; color:#657982;'><strong>Validez Oferta:</strong></td>
                    <td style='padding:4px 0; color:#229c71; font-weight:bold;'>3 días calendario</td>
                  </tr>
                </table>
              </td>
            </tr>

            " . ($detalles ? "
            <!-- DETALLES ADICIONALES -->
            <tr>
              <td style='padding:0 32px 16px;'>
                <div style='background:#fff9e6; border:1px solid #fae69e; border-radius:10px; padding:12px 16px; font-size:12.5px; color:#7a5a00;'>
                  <strong>Requerimiento Específico:</strong><br>{$detalles}
                </div>
              </td>
            </tr>
            " : "") . "

            <!-- TABLA DE ITEMS -->
            " . ($rowsHtml ? "
            <tr>
              <td style='padding:8px 32px 14px;'>
                <table width='100%' border='0' cellpadding='0' cellspacing='0' style='border-collapse:collapse; width:100%; border:1px solid #e1ebed; border-radius:12px; overflow:hidden;'>
                  <thead>
                    <tr style='background:#168d08; color:#ffffff; font-size:11.5px; text-transform:uppercase;'>
                      <th align='left' style='padding:10px 12px;'>Concepto / Servicio</th>
                      <th align='center' style='padding:10px 12px;'>Cant.</th>
                      <th align='right' style='padding:10px 12px;'>P/U</th>
                      <th align='right' style='padding:10px 12px;'>Subtotal</th>
                    </tr>
                  </thead>
                  <tbody>
                    {$rowsHtml}
                  </tbody>
                </table>
              </td>
            </tr>
            " : "") . "

            <!-- TOTAL DESTACADO -->
            <tr>
              <td style='padding:12px 32px;'>
                <table width='100%' style='background:linear-gradient(135deg, #e6f9f2 0%, #e2f7f7 100%); border-radius:14px; padding:16px 20px; border:1px solid #bcebec;'>
                  <tr>
                    <td style='font-size:14px; color:#06454a; font-weight:bold;'>TOTAL ESTIMADO DE LA COTIZACIÓN:</td>
                    <td align='right' style='font-size:22px; font-weight:800; color:#06454a;'>Bs. {$total}</td>
                  </tr>
                </table>
              </td>
            </tr>

            <!-- TÉRMINOS & CONTACTO -->
            <tr>
              <td style='padding:18px 32px 28px;'>
                <div style='border-top:1px solid #e1ebed; padding-top:18px; margin-top:8px;'>
                  <h4 style='margin:0 0 8px; font-size:13px; color:#06454a;'>RESPONSABLE TÉCNICO Y COORDINACIÓN:</h4>
                  <p style='margin:0 0 4px; font-size:13px; color:#0d1e24;'><strong>Ing. Sonia Mamani Chino</strong> · Gerente de Laboratorio</p>
                  <p style='margin:0 0 12px; font-size:12.5px; color:#4a686b;'>
                    PACHABOL SRL · Correo: <a href='mailto:laboratorio@pachabol.com' style='color:#16b7c1; text-decoration:none;'>laboratorio@pachabol.com</a> · La Paz - Bolivia
                  </p>

                  <table width='100%' style='margin-top:14px;'>
                    <tr>
                      <td align='center'>
                        <a href='https://api.whatsapp.com/send?phone=59176358189&text=" . urlencode("Hola Ing. Sonia, tengo la cotización N° {$codigo} y deseo coordinar el servicio.") . "' style='background:#168d08; color:#ffffff; font-size:13px; font-weight:700; text-decoration:none; padding:12px 26px; border-radius:999px; display:inline-block; box-shadow:0 4px 12px rgba(22,141,8,0.3);'>
                          💬 Coordinar por WhatsApp (+591 76358189)
                        </a>
                      </td>
                    </tr>
                  </table>
                </div>
              </td>
            </tr>

            <!-- FOOTER LEGAL -->
            <tr>
              <td style='background:#f8fafb; padding:18px 32px; border-top:1px solid #e1ebed; text-align:center; font-size:11.5px; color:#9db0b8;'>
                Este documento es emitido automáticamente por el sistema PachaLab Pachabol.<br>
                Remitente: <strong>notificaciones@pachabol.com</strong> · Todos los derechos reservados &copy; " . date('Y') . " PACHABOL SRL.
              </td>
            </tr>

          </table>
        </body>
        </html>";
    }
}

@extends('layouts.app')

@section('title', 'Cotizador Online Alquiler de Equipos | PachaLab')

@section('content')
<!-- SUBPAGE HERO -->
<section class="subpage-hero">
  <div class="subpage-hero-inner">
    <nav class="breadcrumb-nav" aria-label="Breadcrumb">
      <a href="{{ route('home') }}"><i data-lucide="home"></i> Inicio</a>
      <span>/</span>
      <a href="{{ route('home') }}#cotizar">Cotización</a>
      <span>/</span>
      <span class="current">Alquiler de Equipos</span>
    </nav>
    <div class="hero-pill-badge">
      <i data-lucide="wrench"></i> Cotización Referencial Online · Emisión Inmediata de PDF
    </div>
    <h1>Cotizador <span>Alquiler de Equipos</span></h1>
    <p class="lead">
      Selecciona los instrumentos de medición ambiental y ocupacional que necesitas, indica el número de días de alquiler
      y genera al instante tu cotización referencial oficial en PDF con tarifas y especificaciones técnicas.
    </p>
  </div>
</section>

<!-- MAIN CALCULATOR -->
<section class="quote-page-container">
  <div class="quote-calculator-card">
    <!-- DATOS DE LA INSTITUCIÓN O CLIENTE -->
    <div class="calc-section-title">
      <i data-lucide="building-2"></i>
      <span>1. Datos del Solicitante / Empresa</span>
    </div>

    <div class="client-form-grid">
      <div class="quote-input-group">
        <label for="institucion">Empresa o Institución</label>
        <input type="text" id="institucion" name="institucion" placeholder="Ej. Constructora Andina SA">
      </div>
      <div class="quote-input-group">
        <label for="responsable">Responsable <span class="req">*</span></label>
        <input type="text" id="responsable" name="responsable" placeholder="Ej. Ing. Roberto Gómez" required>
      </div>
      <div class="quote-input-group">
        <label for="departamento">Departamento o Ciudad <span class="req">*</span></label>
        <input type="text" id="departamento" name="departamento" placeholder="Ej. Santa Cruz / La Paz" required>
      </div>
      <div class="quote-input-group">
        <label for="cargo">Cargo del Solicitante <small style="color: var(--muted); font-weight: normal;">(Opcional)</small></label>
        <input type="text" id="cargo" name="cargo" placeholder="Ej. Coordinador de Proyecto">
      </div>
      <div class="quote-input-group">
        <label for="telefono">Teléfono / Celular <span class="req">*</span></label>
        <input type="tel" id="telefono" name="telefono" placeholder="Ej. 76358189" required>
      </div>
      <div class="quote-input-group">
        <label for="correo">Correo Electrónico <span class="req">*</span></label>
        <input type="email" id="correo" name="correo" placeholder="contacto@empresa.com" required>
      </div>
    </div>

    <!-- TABLA DE EQUIPOS -->
    <div class="calc-section-title">
      <i data-lucide="box"></i>
      <span>2. Selección de Equipos e Instrumentos</span>
    </div>

    <div class="calc-table-responsive">
      <table class="calc-table" id="tabla-cotizacion-equipos">
        <thead>
          <tr>
            <th style="width: 28%;">EQUIPO</th>
            <th style="width: 25%;">CARACTERÍSTICAS</th>
            <th style="width: 12%;" class="text-center">CÓDIGO</th>
            <th style="width: 10%;" class="text-center">DÍAS</th>
            <th style="width: 10%;" class="text-right">P/U (Bs)</th>
            <th style="width: 11%;" class="text-right">SUBTOTAL</th>
            <th style="width: 4%;" class="text-center"></th>
          </tr>
        </thead>
        <tbody id="calc-tbody">
          <!-- Filas dinámicas -->
        </tbody>
      </table>
    </div>

    <!-- BARRA INFERIOR DE TOTAL Y ACCIONES -->
    <div class="calc-bottom-bar">
      <div class="calc-table-actions">
        <button type="button" class="btn-add-item" id="btn-add-item">
          <i data-lucide="plus-circle"></i>
          <span>Agregar Equipo</span>
        </button>
      </div>

      <div class="calc-total-box">
        <span class="total-label">TOTAL ESTIMADO:</span>
        <span class="total-amount" id="calc-total">0.00</span>
        <span class="total-currency">Bs</span>
      </div>
    </div>

    <!-- BOTÓN GENERAR PDF -->
    <div style="display: flex; justify-content: flex-end;">
      <button type="button" class="btn-generate-pdf" id="btn-generate-pdf">
        <i data-lucide="file-down"></i>
        <span>Generar Cotización en PDF</span>
        <i data-lucide="arrow-right"></i>
      </button>
    </div>

    <!-- TÉRMINOS Y CONDICIONES -->
    <div class="quote-terms-box">
      <strong>Términos y Condiciones de Alquiler:</strong> Esta cotización es de carácter referencial con validez de 3 días calendario.
      Los instrumentos se entregan con certificados de calibración vigentes, accesorios y capacitación operativa.
      Para reservar equipos y coordinar entregas, comuníquese al WhatsApp 76358189 o escriba a laboratorio@pachabol.com.
    </div>
  </div>
</section>

<!-- TEMPLATE DE FILA DE EQUIPOS -->
<template id="calc-row-template">
  <tr class="fila-servicio">
    <td>
      <select class="item-select equipo" required>
        <option value="">Seleccionar equipo...</option>
        <option value="Anemómetro Extech" data-caracteristicas="Marca: EXTECH · Modelo: AN100" data-codigo="07-ANE-EXT" data-precio="300.00">Anemómetro Digital · Extech AN100</option>
        <option value="Anemómetro Laserliner" data-caracteristicas="Marca: LASERLINER · Modelo: AirflowTest-Master" data-codigo="06-ANE-LAS" data-precio="300.00">Anemómetro · Laserliner AirflowTest</option>
        <option value="Luxómetro PCE" data-caracteristicas="Marca: PCE · Modelo: PCE-174" data-codigo="01-LUX-PCE" data-precio="300.00">Luxómetro con registro · PCE-174</option>
        <option value="Luxómetro Laserliner" data-caracteristicas="Marca: LASERLINER · Modelo: Lux Test Master" data-codigo="02-LUX-LAS" data-precio="300.00">Luxómetro · Laserliner Lux Test Master</option>
        <option value="Sonómetro Trotec" data-caracteristicas="Marca: TROTEC · Modelo: SL400" data-codigo="04-SON-TRO" data-precio="300.00">Sonómetro Integrador · Trotec SL400</option>
        <option value="Sonómetro Laserliner" data-caracteristicas="Marca: LASERLINER · Modelo: SoundTestMaster" data-codigo="03-SON-LAS" data-precio="300.00">Sonómetro · Laserliner SoundTestMaster</option>
        <option value="Contador de Partículas" data-caracteristicas="Marca: TEMTOP · Modelo: LKC-1000 2ND" data-codigo="09-PAR-TEM" data-precio="300.00">Contador de Partículas · Temtop LKC-1000</option>
        <option value="Detector Multigases" data-caracteristicas="Marca: BOSEAN · Modelo: BH–45" data-codigo="11-GAS-BOS" data-precio="400.00">Detector Multigases (LEL, O2, H2S, CO) · Bosean</option>
        <option value="Medidor Calidad de Aire" data-caracteristicas="Marca: VSON · Modelo: WP6930S" data-codigo="10-AIR-VSO" data-precio="250.00">Monitor Calidad de Aire Multifuncional · VSON</option>
        <option value="Opacímetro" data-caracteristicas="Marca: BRAIN BEE · Modelo: OPA-300" data-codigo="13-DIS-ING" data-precio="500.00">Opacímetro Diésel · Brain Bee OPA-300</option>
        <option value="Termohigrómetro" data-caracteristicas="Marca: TROTEC · Modelo: TC100" data-codigo="08-TER-TRO" data-precio="400.00">Termohigrómetro · Trotec TC100</option>
        <option value="Dosímetro Ocupacional" data-caracteristicas="Marca: CASTLE · Modelo: GA113" data-codigo="05-DOS-CAS" data-precio="350.00">Dosímetro Personal · Castle GA113</option>
        <option value="Medidor de CO2" data-caracteristicas="Marca: CO2 Meter · Modelo: CO2+CO METER" data-codigo="12-CO2-CO2" data-precio="200.00">Medidor de CO2 y CO · CO2 Meter</option>
        <option value="Distanciómetro 60MT" data-caracteristicas="Marca: INGCO · Modelo: 60MT" data-codigo="14-DIS-ING" data-precio="50.00">Distanciómetro Láser 60M · Ingco</option>
        <option value="Distanciómetro LS-P" data-caracteristicas="Marca: Duka · Modelo: LS - P" data-codigo="15-DIS-DUK" data-precio="50.00">Distanciómetro Compacto · Duka LS-P</option>
        <option value="Proyectora Epson" data-caracteristicas="Marca: EPSON" data-codigo="16-PRO-EPS" data-precio="120.00">Proyectora Multimedia · Epson</option>
        <option value="Trípode para Instrumentos" data-caracteristicas="Marca: TOLSEN · Modelo: INSTRUMENT TRIPOD" data-codigo="17-TRI-TOL" data-precio="60.00">Trípode Extensible para Instrumentos · Tolsen</option>
      </select>
    </td>
    <td class="col-caracteristicas">-</td>
    <td class="col-codigo text-center">-</td>
    <td class="text-center">
      <input type="number" class="item-qty dias" min="1" value="1" required>
    </td>
    <td class="col-price text-right">0.00</td>
    <td class="col-subtotal text-right">0.00</td>
    <td class="text-center">
      <button type="button" class="btn-remove-row" title="Eliminar fila">
        <i data-lucide="trash-2"></i>
      </button>
    </td>
  </tr>
</template>
@endsection

@push('scripts')
<script src="{{ asset('js/cotizador.js') }}"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    initCotizador({
      tipo: 'equipos',
      fondoUrl: '{{ asset("images/Cotizacion-vae-bn.jpg") }}',
      empresa: 'PachaLab - Alquiler de Equipos'
    });
  });
</script>
@endpush

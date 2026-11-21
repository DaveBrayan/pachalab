@extends('layouts.app')

@section('title', 'Cotizador Online Monitoreo Ocupacional | PachaLab')

@section('content')
<!-- SUBPAGE HERO -->
<section class="subpage-hero">
  <div class="subpage-hero-inner">
    <nav class="breadcrumb-nav" aria-label="Breadcrumb">
      <a href="{{ route('home') }}"><i data-lucide="home"></i> Inicio</a>
      <span>/</span>
      <a href="{{ route('home') }}#cotizar">Cotización</a>
      <span>/</span>
      <span class="current">Monitoreo Ocupacional</span>
    </nav>
    <div class="hero-pill-badge">
      <i data-lucide="hard-hat"></i> Cotización Referencial Online · Emisión Inmediata de PDF
    </div>
    <h1>Cotizador <span>Monitoreo Ocupacional</span></h1>
    <p class="lead">
      Elige los agentes físicos, químicos, riesgos ergonómicos (NTS 015/23) o estudio de carga de fuego que requiere tu empresa.
      Calcula tu presupuesto estimado y obtén la cotización oficial en PDF al instante.
    </p>
  </div>
</section>

<!-- MAIN CALCULATOR -->
<section class="quote-page-container">
  <div class="quote-calculator-card">
    <!-- DATOS DE LA INSTITUCIÓN O CLIENTE -->
    <div class="calc-section-title">
      <i data-lucide="building-2"></i>
      <span>1. Datos del Cliente / Empresa</span>
    </div>

    <div class="client-form-grid">
      <div class="quote-input-group">
        <label for="institucion">Empresa o Razón Social</label>
        <input type="text" id="institucion" name="institucion" placeholder="Ej. Embotelladora Central SRL">
      </div>
      <div class="quote-input-group">
        <label for="responsable">Responsable <span class="req">*</span></label>
        <input type="text" id="responsable" name="responsable" placeholder="Ej. Lic. Andrea Villarroel" required>
      </div>
      <div class="quote-input-group">
        <label for="departamento">Departamento o Ciudad <span class="req">*</span></label>
        <input type="text" id="departamento" name="departamento" placeholder="Ej. Cochabamba / La Paz" required>
      </div>
      <div class="quote-input-group">
        <label for="cargo">Cargo <span class="req">*</span></label>
        <input type="text" id="cargo" name="cargo" placeholder="Ej. Encargado de Seguridad y Salud (SST)" required>
      </div>
      <div class="quote-input-group">
        <label for="telefono">Teléfono / Celular <span class="req">*</span></label>
        <input type="tel" id="telefono" name="telefono" placeholder="Ej. 76358189" required>
      </div>
      <div class="quote-input-group">
        <label for="correo">Correo Electrónico <span class="req">*</span></label>
        <input type="email" id="correo" name="correo" placeholder="seguridad@empresa.com" required>
      </div>
    </div>

    <!-- TABLA DE PARÁMETROS -->
    <div class="calc-section-title">
      <i data-lucide="shield-alert"></i>
      <span>2. Selección de Ensayos Ocupacionales</span>
    </div>

    <div class="calc-table-responsive">
      <table class="calc-table" id="tabla-cotizacion">
        <thead>
          <tr>
            <th style="width: 32%;">PARÁMETRO / AGENTE</th>
            <th style="width: 25%;">METODOLOGÍA</th>
            <th style="width: 10%;" class="text-center">UNIDAD</th>
            <th style="width: 10%;" class="text-center">CANTIDAD</th>
            <th style="width: 10%;" class="text-right">P/U (Bs)</th>
            <th style="width: 10%;" class="text-right">SUBTOTAL</th>
            <th style="width: 3%;" class="text-center"></th>
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
          <span>Agregar Parámetro</span>
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
      <strong>Términos y Condiciones:</strong> Esta cotización es de carácter referencial y cuenta con una validez de 3 días calendario.
      Los estudios ocupacionales son avalados por profesionales habilitados ante el Ministerio de Trabajo, Empleo y Previsión Social (MTEPS).
      Para confirmar el servicio, comuníquese con el WhatsApp 76358189 o al correo laboratorio@pachabol.com.
    </div>
  </div>
</section>

<!-- TEMPLATE DE FILA OCUPACIONAL -->
<template id="calc-row-template">
  <tr class="fila-servicio">
    <td>
      <select class="item-select parametro" required>
        <option value="">Seleccionar parámetro...</option>
        <option value="Monitoreo de Iluminación" data-metodologia="NTS 001/17" data-unidad="Punto" data-precio="100.00">Monitoreo de Iluminación (NTS 001/17)</option>
        <option value="Ruido - Sonometría" data-metodologia="NTS 002/2017" data-unidad="Punto" data-precio="100.00">Ruido - Sonometría ambiental en puesto (NTS 002/17)</option>
        <option value="Ruido - Dosimetría" data-metodologia="NTS 002/2017" data-unidad="Punto" data-precio="200.00">Ruido - Dosimetría personal de jornada (NTS 002/17)</option>
        <option value="Ruido - Determinación del NPS en Bandas de Octava" data-metodologia="NTS 002/2017" data-unidad="Punto" data-precio="250.00">Ruido - Bandas de Octava para selección de EPP auditivo</option>
        <option value="Monitoreo de Ventilación" data-metodologia="NB 51001-1" data-unidad="Punto" data-precio="200.00">Monitoreo de Ventilación y renovación de aire (NB 51001-1)</option>
        <option value="Monitoreo de Estrés Térmico por Calor" data-metodologia="ISO 7243" data-unidad="Punto" data-precio="250.00">Estrés Térmico por Calor - Índice TGBH (ISO 7243)</option>
        <option value="Monitoreo de Estrés Térmico por Frío" data-metodologia="NTP 462" data-unidad="Punto" data-precio="250.00">Estrés Térmico por Frío y sensación térmica (NTP 462)</option>
        <option value="Monitoreo de Compuestos Orgánicos Volátiles (COVs)" data-metodologia="Celda electroquímica" data-unidad="Punto" data-precio="200.00">Compuestos Orgánicos Volátiles (COVs)</option>
        <option value="Monitoreo de Partículas Suspendidas (PM10, PM2.5 y PST)" data-metodologia="MTA/MA - 014/A11 (modificado)" data-unidad="Punto" data-precio="600.00">Partículas Suspendidas e Inhalables (PM10, PM2.5, PST)</option>
        <option value="Monitoreo de Gases de Inmisión (LEL, CO, O2, H2S)" data-metodologia="Celda electroquímica" data-unidad="Punto" data-precio="200.00">Gases en Espacios Confinados (LEL, CO, O2, H2S)</option>
        <option value="Monitoreo de Calidad del Aire (CO2, CO)" data-metodologia="Celda electroquímica" data-unidad="Punto" data-precio="120.00">Calidad del Aire Interior (CO2 y CO)</option>
        <option value="Monitoreo de HCHO" data-metodologia="Celda electroquímica" data-unidad="Punto" data-precio="100.00">Monitoreo de Formaldehído (HCHO)</option>
        <option value="Monitoreo de Vibración Cuerpo Entero y Mano-Brazo" data-metodologia="ISO 2631-1 e ISO 5349-1" data-unidad="Punto" data-precio="300.00">Vibración Cuerpo Entero y Mano-Brazo</option>
        <option value="Monitoreo de Agua Potable" data-metodologia="NB 512" data-unidad="Punto" data-precio="500.00">Calidad de Agua de Consumo según NB 512</option>
        <option value="Estudio de Ergonomía y Riesgos Disergonómicos" data-metodologia="NTS 015/23" data-unidad="Trabajador" data-precio="100.00">Estudio Ergonómico por Trabajador (NTS 015/23)</option>
        <option value="Estudio de Carga de Fuego" data-metodologia="NB 58002, NB 58005 y SIPPCI" data-unidad="m2" data-precio="3.00">Estudio de Carga de Fuego y Extintores (por m²)</option>
      </select>
    </td>
    <td class="col-metodologia">-</td>
    <td class="col-unidad text-center">-</td>
    <td class="text-center">
      <input type="number" class="item-qty cantidad" min="1" value="1" required>
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
      tipo: 'ocupacional',
      fondoUrl: '{{ asset("images/Cotizacion-fondo-bn.png") }}',
      empresa: 'PachaLab - Monitoreo Ocupacional'
    });
  });
</script>
@endpush

@extends('layouts.app')

@section('title', 'Cotizador Online Monitoreo Ambiental | PachaLab')

@section('content')
<!-- SUBPAGE HERO -->
<section class="subpage-hero">
  <div class="subpage-hero-inner">
    <nav class="breadcrumb-nav" aria-label="Breadcrumb">
      <a href="{{ route('home') }}"><i data-lucide="home"></i> Inicio</a>
      <span>/</span>
      <a href="{{ route('home') }}#cotizar">Cotización</a>
      <span>/</span>
      <span class="current">Monitoreo Ambiental</span>
    </nav>
    <div class="hero-pill-badge">
      <i data-lucide="trees"></i> Cotización Referencial Online · Emisión Inmediata de PDF
    </div>
    <h1>Cotizador <span>Monitoreo Ambiental</span></h1>
    <p class="lead">
      Calcula tu presupuesto estimado para ensayos de calidad de aire (PST, PM10), emisiones de gases, ruido ambiental y calidad de agua.
      Genera y descarga el documento formal en PDF avalado por PACHABOL SRL al instante.
    </p>
  </div>
</section>

<!-- MAIN CALCULATOR -->
<section class="quote-page-container">
  <div class="quote-calculator-card">
    <!-- DATOS DE LA INSTITUCIÓN O CLIENTE -->
    <div class="calc-section-title">
      <i data-lucide="building-2"></i>
      <span>1. Datos del Cliente / Institución</span>
    </div>

    <div class="client-form-grid">
      <div class="quote-input-group">
        <label for="institucion">Institución o Empresa</label>
        <input type="text" id="institucion" name="institucion" placeholder="Ej. Minera San Cristóbal / Constructora ABC">
      </div>
      <div class="quote-input-group">
        <label for="responsable">Responsable <span class="req">*</span></label>
        <input type="text" id="responsable" name="responsable" placeholder="Ej. Ing. Juan Pérez" required>
      </div>
      <div class="quote-input-group">
        <label for="departamento">Departamento o Ciudad <span class="req">*</span></label>
        <input type="text" id="departamento" name="departamento" placeholder="Ej. La Paz / Santa Cruz" required>
      </div>
      <div class="quote-input-group">
        <label for="cargo">Cargo del Solicitante <span class="req">*</span></label>
        <input type="text" id="cargo" name="cargo" placeholder="Ej. Gerente de Medio Ambiente" required>
      </div>
      <div class="quote-input-group">
        <label for="telefono">Teléfono / Celular <span class="req">*</span></label>
        <input type="tel" id="telefono" name="telefono" placeholder="Ej. 76358189" required>
      </div>
      <div class="quote-input-group">
        <label for="correo">Correo Electrónico <span class="req">*</span></label>
        <input type="email" id="correo" name="correo" placeholder="ejemplo@correo.com" required>
      </div>
    </div>

    <!-- TABLA DE PARÁMETROS -->
    <div class="calc-section-title">
      <i data-lucide="clipboard-list"></i>
      <span>2. Selección de Parámetros y Ensayos</span>
    </div>

    <div class="calc-table-responsive">
      <table class="calc-table" id="tabla-cotizacion">
        <thead>
          <tr>
            <th style="width: 32%;">PARÁMETRO</th>
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
      Para programar el servicio en campo y formalizar la orden de servicio, comuníquese con nuestra gerencia técnica de laboratorio al WhatsApp 76358189 o al correo laboratorio@pachabol.com.
    </div>
  </div>
</section>

<!-- TEMPLATE DE FILA AMBIENTAL -->
<template id="calc-row-template">
  <tr class="fila-servicio">
    <td>
      <select class="item-select parametro" required>
        <option value="">Seleccionar parámetro...</option>
        <option value="Calidad de Aire PTS" data-metodologia="Determinación PST en base a la NB 62014" data-unidad="Punto" data-precio="100.00">Calidad de Aire PTS</option>
        <option value="Calidad de Aire PM-10" data-metodologia="NB 62014" data-unidad="Punto" data-precio="600.00">Calidad de Aire PM-10</option>
        <option value="Gases de combustión en fuente fija (CO,NOx y SO2)" data-metodologia="NB 62010" data-unidad="Punto" data-precio="450.00">Gases de combustión en fuente fija (CO,NOx y SO2)</option>
        <option value="Gases de inmisión CO (puntual)" data-metodologia="Celda Electroquímica" data-unidad="Punto" data-precio="170.00">Gases de inmisión CO (puntual)</option>
        <option value="Gases de inmisión NO2 (puntual)" data-metodologia="Celda Electroquímica" data-unidad="Punto" data-precio="170.00">Gases de inmisión NO2 (puntual)</option>
        <option value="Gases de inmisión SO2 (puntual)" data-metodologia="Celda Electroquímica" data-unidad="Punto" data-precio="170.00">Gases de inmisión SO2 (puntual)</option>
        <option value="Opacidad fuente móvil" data-metodologia="NB 62004" data-unidad="Punto" data-precio="200.00">Opacidad fuente móvil</option>
        <option value="Gases de combustión de fuente móvil (HC, CO)" data-metodologia="NB 62003" data-unidad="Punto" data-precio="200.00">Gases de combustión de fuente móvil (HC, CO)</option>
        <option value="Ruido Ambiental de fuente fija" data-metodologia="NB 62006" data-unidad="Punto" data-precio="150.00">Ruido Ambiental de fuente fija</option>
        <option value="Ruido de fuente móvil" data-metodologia="PT-O-02 Ley 1333" data-unidad="Punto" data-precio="80.00">Ruido de fuente móvil</option>
        <option value="Monitoreo de Agua Residual según el RMCH y RASIM" data-metodologia="RMCH y RASIM" data-unidad="Punto" data-precio="1000.00">Monitoreo de Agua Residual según el RMCH y RASIM</option>
        <option value="Monitoreo de Agua Potable según la NB 512" data-metodologia="NB 512" data-unidad="Punto" data-precio="500.00">Monitoreo de Agua Potable según la NB 512</option>
        <option value="Monitoreo de Suelo (Conductividad, Alcalinidad, Salinidad)" data-metodologia="Norma Técnica Suelos" data-unidad="Punto" data-precio="600.00">Monitoreo de Suelo (Conductividad, Alcalinidad, Salinidad)</option>
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
      tipo: 'ambiental',
      fondoUrl: '{{ asset("images/Cotizacion-fondo-bn.png") }}',
      empresa: 'PachaLab - Monitoreo Ambiental'
    });
  });
</script>
@endpush

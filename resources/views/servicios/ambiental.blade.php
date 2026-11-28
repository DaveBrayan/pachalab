@extends('layouts.app')

@section('title', 'Monitoreo Ambiental | PachaLab Bolivia')

@section('content')
<!-- SUBPAGE HERO -->
<section class="subpage-hero">
  <div class="subpage-hero-inner">
    <nav class="breadcrumb-nav" aria-label="Breadcrumb">
      <a href="{{ route('home') }}"><i data-lucide="home"></i> Inicio</a>
      <span>/</span>
      <span class="current">Monitoreo Ambiental</span>
    </nav>
    <div class="hero-pill-badge">
      <i data-lucide="leaf"></i> {{ $cms['ambHeroBadge'] ?? 'Gestión Ambiental & Cumplimiento Normativo' }}
    </div>
    <h1>{!! $cms['ambHeroTitle'] ?? 'Monitoreo <span>Ambiental</span>' !!}</h1>
    <p class="lead">
      {{ $cms['ambHeroLead'] ?? 'Realizamos mediciones precisas de calidad de aire, agua, ruido y gases de combustión, asegurando el estricto cumplimiento de normativas ambientales (Ley 1333, RMCH, RASIM) y estándares internacionales.' }}
    </p>
    <div class="subpage-hero-actions">
      <a class="btn btn-green" href="{{ !empty($cms['ambHeroBtnLink']) ? $cms['ambHeroBtnLink'] : route('cotizar.ambiental') }}">
        <i data-lucide="file-text"></i> {{ $cms['ambHeroBtnCotiz'] ?? 'Cotización Referencial Online (PDF)' }} <i data-lucide="arrow-right"></i>
      </a>
      <a class="btn btn-outline" href="https://wa.link/3lf4u6" target="_blank" rel="noopener">
        <i data-lucide="message-square"></i> Consulta Directa WhatsApp
      </a>
    </div>
  </div>
</section>

<!-- SERVICE DETAILS -->
<section class="details-section">
  <div class="section-tagline">Detalles del Servicio</div>
  <h2 class="section-heading-lg">Parámetros y Ensayos Ambientales</h2>
  <p style="color: var(--muted); max-width: 760px; line-height: 1.6;">
    Nuestros laboratorios y especialistas cuentan con metodologías estandarizadas y equipamiento de alta precisión para inspección y análisis.
  </p>

  <div class="details-grid">
    @php
      $ambModulos = $cms['servicios_ambiental_modulos'] ?? null;
      if (is_string($ambModulos)) {
        $ambModulos = json_decode($ambModulos, true);
      }
    @endphp

    @if(!empty($ambModulos) && is_array($ambModulos))
      @foreach($ambModulos as $mod)
        <article class="detail-card spotlight-card tilt-card anim-card">
          <div class="detail-card-num">{{ $mod['num'] ?? ('.' . sprintf('%02d', $loop->iteration)) }}</div>
          <h3>{{ $mod['titulo'] ?? '' }}</h3>
          @if(!empty($mod['subtitulo']))
            <p style="font-size: 0.88rem; color: var(--muted); margin-bottom: 16px;">
              {{ $mod['subtitulo'] }}
            </p>
          @endif
          @if(!empty($mod['items']) && is_array($mod['items']))
            <ul class="detail-card-list">
              @foreach($mod['items'] as $item)
                @if(trim($item) !== '')
                  <li><i data-lucide="check-circle-2"></i> <span>{!! $item !!}</span></li>
                @endif
              @endforeach
            </ul>
          @endif
        </article>
      @endforeach
    @else
      <!-- 01 AGUA -->
      <article class="detail-card spotlight-card tilt-card anim-card">
        <div class="detail-card-num">.01</div>
        <h3>Calidad de Agua</h3>
        <p style="font-size: 0.88rem; color: var(--muted); margin-bottom: 16px;">
          Evaluación integral de fuentes hídricas para industrias, minería, municipios y plantas de tratamiento.
        </p>
        <ul class="detail-card-list">
          <li><i data-lucide="check-circle-2"></i> <span><strong>Aguas Residuales:</strong> Cumplimiento del RMCH y RASIM para descargas.</span></li>
          <li><i data-lucide="check-circle-2"></i> <span><strong>Agua Potable:</strong> Parámetros fisicoquímicos y microbiológicos según NB 512.</span></li>
          <li><i data-lucide="check-circle-2"></i> <span><strong>Suelos:</strong> Conductividad, alcalinidad, salinidad y metales pesados.</span></li>
        </ul>
      </article>

      <!-- 02 GASES DE COMBUSTIÓN -->
      <article class="detail-card spotlight-card tilt-card anim-card">
        <div class="detail-card-num">.02</div>
        <h3>Gases de Combustión</h3>
        <p style="font-size: 0.88rem; color: var(--muted); margin-bottom: 16px;">
          Diagnóstico de emisiones directas para calderas, hornos, generadores y parques automotores.
        </p>
        <ul class="detail-card-list">
          <li><i data-lucide="check-circle-2"></i> <span><strong>Fuentes Fijas:</strong> Medición de CO, NOx y SO2 según NB 62010.</span></li>
          <li><i data-lucide="check-circle-2"></i> <span><strong>Fuentes Móviles:</strong> Monitoreo de HC y CO bajo norma NB 62003.</span></li>
          <li><i data-lucide="check-circle-2"></i> <span><strong>Opacidad:</strong> Ensayos para vehículos diésel según NB 62004.</span></li>
        </ul>
      </article>

      <!-- 03 CALIDAD DE AIRE -->
      <article class="detail-card spotlight-card tilt-card anim-card">
        <div class="detail-card-num">.03</div>
        <h3>Calidad de Aire</h3>
        <p style="font-size: 0.88rem; color: var(--muted); margin-bottom: 16px;">
          Control de partículas e inmisión atmosférica en áreas perimetrales y comunidades de influencia.
        </p>
        <ul class="detail-card-list">
          <li><i data-lucide="check-circle-2"></i> <span><strong>PM-10 y PM-2.5:</strong> Determinación gravimétrica en base a NB 62014.</span></li>
          <li><i data-lucide="check-circle-2"></i> <span><strong>Partículas Suspendidas Totales (PST):</strong> Muestreo de alto volumen.</span></li>
          <li><i data-lucide="check-circle-2"></i> <span><strong>Gases de Inmisión:</strong> CO, NO2 y SO2 puntual con celda electroquímica.</span></li>
        </ul>
      </article>

      <!-- 04 RUIDO AMBIENTAL -->
      <article class="detail-card spotlight-card tilt-card anim-card">
        <div class="detail-card-num">.04</div>
        <h3>Ruido Ambiental</h3>
        <p style="font-size: 0.88rem; color: var(--muted); margin-bottom: 16px;">
          Evaluación de niveles sonoros continuos y fluctuantes para evitar contaminación acústica.
        </p>
        <ul class="detail-card-list">
          <li><i data-lucide="check-circle-2"></i> <span><strong>Fuente Fija:</strong> Monitoreo diurno y nocturno bajo NB 62006.</span></li>
          <li><i data-lucide="check-circle-2"></i> <span><strong>Fuente Móvil:</strong> Mediciones según PT-O-02 Ley 1333.</span></li>
          <li><i data-lucide="check-circle-2"></i> <span><strong>Estudio de Impacto Sonoro:</strong> Mapas de dispersión acústica e informes.</span></li>
        </ul>
      </article>
    @endif
  </div>
</section>

<!-- CALL TO ACTION COTIZACIÓN INTERACTIVA -->
<section style="background: var(--pale); padding: 70px 24px; border-top: 1px solid var(--line); border-bottom: 1px solid var(--line);">
  <div style="max-width: 1000px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 30px;">
    <div>
      <span class="hero-pill-badge"><i data-lucide="zap"></i> Cotizador Online</span>
      <h2 style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 2rem; font-weight: 800; color: var(--dark); margin: 6px 0 10px;">
        Genera tu presupuesto ambiental en segundos
      </h2>
      <p style="color: var(--muted); max-width: 580px; margin: 0;">
        Selecciona los parámetros de agua, aire o ruido que necesitas, calcula el monto estimado y descarga el PDF oficial listo para tu empresa.
      </p>
    </div>
    <div style="display: flex; gap: 14px; flex-wrap: wrap;">
      <a class="btn btn-green" href="{{ route('cotizar.ambiental') }}">
        <i data-lucide="calculator"></i> Abrir Cotizador Ambiental (PDF) <i data-lucide="arrow-right"></i>
      </a>
    </div>
  </div>
</section>

<!-- PREGUNTAS FRECUENTES (FAQS) -->
<section class="details-section">
  <div class="section-tagline">Preguntas Frecuentes</div>
  <h2 class="section-heading-lg">Respuestas Claras a tus Consultas</h2>
  <p style="color: var(--muted); max-width: 750px; line-height: 1.6;">
    En esta sección encontrarás respuestas sobre nuestros servicios de monitoreo ambiental, su validez jurídica y beneficios para tu organización.
  </p>

  <div class="faq-wrap">
    <div class="faq-item is-open">
      <button type="button" class="faq-question">
        <span>¿Por qué es importante el monitoreo ambiental para mi empresa?</span>
        <i data-lucide="chevron-down"></i>
      </button>
      <div class="faq-answer">
        El monitoreo ambiental es indispensable para garantizar el cumplimiento de la Ley del Medio Ambiente N° 1333 y sus reglamentos sectoriales. Permite identificar impactos, evitar sanciones y multas de la Autoridad Ambiental Competente (AAC), y certificar la sostenibilidad y responsabilidad social de tus operaciones ante clientes e inversionistas.
      </div>
    </div>

    <div class="faq-item">
      <button type="button" class="faq-question">
        <span>¿Qué normativas y acreditaciones respaldan sus estudios?</span>
        <i data-lucide="chevron-down"></i>
      </button>
      <div class="faq-answer">
        PachaLab cuenta con registro en el Ministerio de Medio Ambiente y Agua (MMAyA). Todos nuestros estudios se realizan bajo Normas Bolivianas (NB 62014, NB 62010, NB 62006, NB 512), reglamentos RMCH y RASIM, utilizando equipos con certificados de calibración vigentes y trazabilidad metrológica internacional.
      </div>
    </div>

    <div class="faq-item">
      <button type="button" class="faq-question">
        <span>¿Cómo y en qué plazo se entregan los resultados?</span>
        <i data-lucide="chevron-down"></i>
      </button>
      <div class="faq-answer">
        Entregamos un Informe Técnico de Ensayo completo que incluye memorias de cálculo, certificados de calibración de los equipos empleados, comparación estricta contra los límites máximos permisibles de la ley y recomendaciones técnicas. Los plazos varían entre 5 y 10 días hábiles según la cantidad de parámetros.
      </div>
    </div>

    <div class="faq-item">
      <button type="button" class="faq-question">
        <span>¿Tienen cobertura en toda Bolivia?</span>
        <i data-lucide="chevron-down"></i>
      </button>
      <div class="faq-answer">
        Sí, nuestro equipo técnico y brigadas de campo se desplazan a cualquier departamento, municipio, campamento minero o parque industrial en Bolivia (La Paz, Santa Cruz, Cochabamba, Oruro, Potosí, Chuquisaca, Tarija, Beni y Pando).
      </div>
    </div>
  </div>
</section>
@endsection

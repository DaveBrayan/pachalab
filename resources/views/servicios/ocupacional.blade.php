@extends('layouts.app')

@section('title', 'Monitoreo Ocupacional | PachaLab Bolivia')

@section('content')
<!-- SUBPAGE HERO -->
<section class="subpage-hero">
  <div class="subpage-hero-inner">
    <nav class="breadcrumb-nav" aria-label="Breadcrumb">
      <a href="{{ route('home') }}"><i data-lucide="home"></i> Inicio</a>
      <span>/</span>
      <span class="current">Monitoreo Ocupacional</span>
    </nav>
    <div class="hero-pill-badge">
      <i data-lucide="hard-hat"></i> {{ $cms['ocpHeroBadge'] ?? 'Seguridad y Salud en el Trabajo (SST) · MTEPS' }}
    </div>
    <h1>{!! $cms['ocpHeroTitle'] ?? 'Monitoreo <span>Ocupacional</span>' !!}</h1>
    <p class="lead">
      {{ $cms['ocpHeroLead'] ?? 'Evaluación técnica de agentes físicos, químicos, ergonómicos y psicosociales en puestos de trabajo para proteger la salud de tus colaboradores y cumplir la Ley General de Higiene y Seguridad Ocupacional y normas NTS del Ministerio de Trabajo.' }}
    </p>
    <div class="subpage-hero-actions">
      <a class="btn btn-green" href="{{ !empty($cms['ocpHeroBtnLink']) ? $cms['ocpHeroBtnLink'] : route('cotizar.ocupacional') }}">
        <i data-lucide="file-check"></i> {{ $cms['ocpHeroBtnCotiz'] ?? 'Cotización Referencial Online (PDF)' }} <i data-lucide="arrow-right"></i>
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
  <h2 class="section-heading-lg">Evaluación de Agentes y Factores de Riesgo</h2>
  <p style="color: var(--muted); max-width: 760px; line-height: 1.6;">
    Medimos las condiciones laborales con instrumentos calibrados de última generación para emitir diagnósticos confiables y recomendaciones preventivas.
  </p>

  <div class="details-grid">
    @php
      $ocpModulos = $cms['servicios_ocupacional_modulos'] ?? null;
      if (is_string($ocpModulos)) {
        $ocpModulos = json_decode($ocpModulos, true);
      }
    @endphp

    @if(!empty($ocpModulos) && is_array($ocpModulos))
      @foreach($ocpModulos as $mod)
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
      <!-- 01 AGENTES FÍSICOS -->
      <article class="detail-card spotlight-card tilt-card anim-card">
        <div class="detail-card-num">.01</div>
        <h3>Agentes Físicos</h3>
        <p style="font-size: 0.88rem; color: var(--muted); margin-bottom: 16px;">
          Control de factores ambientales que pueden generar fatiga, hipoacusia o accidentes laborales.
        </p>
        <ul class="detail-card-list">
          <li><i data-lucide="check-circle-2"></i> <span><strong>Iluminación:</strong> Luxometría en puestos y áreas bajo norma NTS 001/17.</span></li>
          <li><i data-lucide="check-circle-2"></i> <span><strong>Ruido Ocupacional:</strong> Sonometría y Dosimetría según NTS 002/2017.</span></li>
          <li><i data-lucide="check-circle-2"></i> <span><strong>Ventilación:</strong> Caudales y renovación de aire según NB 51001-1.</span></li>
          <li><i data-lucide="check-circle-2"></i> <span><strong>Estrés Térmico:</strong> Confort por calor (ISO 7243) y frío (NTP 462).</span></li>
          <li><i data-lucide="check-circle-2"></i> <span><strong>Vibración:</strong> Mano-brazo y cuerpo entero (ISO 5349 e ISO 2631).</span></li>
        </ul>
      </article>

      <!-- 02 AGENTES DISERGONÓMICOS -->
      <article class="detail-card spotlight-card tilt-card anim-card">
        <div class="detail-card-num">.02</div>
        <h3>Riesgos Disergonómicos</h3>
        <p style="font-size: 0.88rem; color: var(--muted); margin-bottom: 16px;">
          Prevención de trastornos musculoesqueléticos en puestos de planta, almacén y oficinas administrativas.
        </p>
        <ul class="detail-card-list">
          <li><i data-lucide="check-circle-2"></i> <span><strong>Manipulación de Cargas:</strong> Ecuación NIOSH y tablas especializadas.</span></li>
          <li><i data-lucide="check-circle-2"></i> <span><strong>Posturas Inadecuadas:</strong> Métodos ergonómicos REBA, RULA y OWAS.</span></li>
          <li><i data-lucide="check-circle-2"></i> <span><strong>Norma NTS 015/23:</strong> Estudio ergonómico integral por puesto y trabajador.</span></li>
          <li><i data-lucide="check-circle-2"></i> <span><strong>Trabajo en Oficina:</strong> Evaluación de pantallas (PVD), sillas y periféricos.</span></li>
        </ul>
      </article>

      <!-- 03 AGENTES QUÍMICOS -->
      <article class="detail-card spotlight-card tilt-card anim-card">
        <div class="detail-card-num">.03</div>
        <h3>Agentes Químicos</h3>
        <p style="font-size: 0.88rem; color: var(--muted); margin-bottom: 16px;">
          Monitoreo de aerosoles, gases y vapores que puedan inhalar los trabajadores en áreas operativas.
        </p>
        <ul class="detail-card-list">
          <li><i data-lucide="check-circle-2"></i> <span><strong>Polvo Ocupacional:</strong> Fracción respirable e inhalable (PST, PM10).</span></li>
          <li><i data-lucide="check-circle-2"></i> <span><strong>Compuestos Orgánicos Volátiles (COVs):</strong> Vapores y solventes.</span></li>
          <li><i data-lucide="check-circle-2"></i> <span><strong>Formaldehído (HCHO):</strong> Detección con equipos electroquímicos.</span></li>
          <li><i data-lucide="check-circle-2"></i> <span><strong>Calidad de Aire Interior:</strong> Concentración de CO2 y monóxido de carbono (CO).</span></li>
          <li><i data-lucide="check-circle-2"></i> <span><strong>Gases Peligrosos:</strong> Explosividad (LEL), O2, CO y H2S.</span></li>
        </ul>
      </article>

      <!-- 04 AGENTES PSICOSOCIALES -->
      <article class="detail-card spotlight-card tilt-card anim-card">
        <div class="detail-card-num">.04</div>
        <h3>Factores Psicosociales</h3>
        <p style="font-size: 0.88rem; color: var(--muted); margin-bottom: 16px;">
          Diagnóstico de condiciones de la organización del trabajo que influyen en el bienestar mental y productividad.
        </p>
        <ul class="detail-card-list">
          <li><i data-lucide="check-circle-2"></i> <span><strong>Carga Mental y Estrés:</strong> Cuestionarios estandarizados validados.</span></li>
          <li><i data-lucide="check-circle-2"></i> <span><strong>Factores de Riesgo:</strong> Demandas del trabajo, control y liderazgo.</span></li>
          <li><i data-lucide="check-circle-2"></i> <span><strong>Planes de Intervención:</strong> Estrategias para comités mixtos de higiene y seguridad.</span></li>
        </ul>
      </article>

      <!-- 05 RIESGO DE INCENDIO & SIPPCI -->
      <article class="detail-card spotlight-card tilt-card anim-card">
        <div class="detail-card-num">.05</div>
        <h3>Carga de Fuego & SIPPCI</h3>
        <p style="font-size: 0.88rem; color: var(--muted); margin-bottom: 16px;">
          Ingeniería contra incendios para proteger infraestructura y cumplir requerimientos de Bomberos y el MTEPS.
        </p>
        <ul class="detail-card-list">
          <li><i data-lucide="check-circle-2"></i> <span><strong>Estudio de Carga de Fuego:</strong> Según normas NB 58002 y NB 58005.</span></li>
          <li><i data-lucide="check-circle-2"></i> <span><strong>Dotación de Extintores:</strong> Cálculo de potencial extintor y distribución.</span></li>
          <li><i data-lucide="check-circle-2"></i> <span><strong>Certificación SIPPCI:</strong> Elaboración de carpetas y trámites ante Bomberos.</span></li>
          <li><i data-lucide="check-circle-2"></i> <span><strong>Planes de Emergencia:</strong> Rutas de evacuación y brigadas de rescate.</span></li>
        </ul>
      </article>
    @endif
  </div>
</section>

<!-- CALL TO ACTION COTIZACIÓN INTERACTIVA -->
<section style="background: var(--pale); padding: 70px 24px; border-top: 1px solid var(--line); border-bottom: 1px solid var(--line);">
  <div style="max-width: 1000px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 30px;">
    <div>
      <span class="hero-pill-badge"><i data-lucide="calculator"></i> Cotizador Online</span>
      <h2 style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 2rem; font-weight: 800; color: var(--dark); margin: 6px 0 10px;">
        Cotiza tu monitoreo ocupacional al instante
      </h2>
      <p style="color: var(--muted); max-width: 580px; margin: 0;">
        Personaliza los puestos de trabajo o puntos a medir (iluminación, ruido, ergonomía, estrés térmico o carga de fuego) y descarga tu documento oficial en PDF.
      </p>
    </div>
    <div style="display: flex; gap: 14px; flex-wrap: wrap;">
      <a class="btn btn-green" href="{{ route('cotizar.ocupacional') }}">
        <i data-lucide="file-check"></i> Abrir Cotizador Ocupacional (PDF) <i data-lucide="arrow-right"></i>
      </a>
    </div>
  </div>
</section>

<!-- PREGUNTAS FRECUENTES (FAQS) -->
<section class="details-section">
  <div class="section-tagline">Preguntas Frecuentes</div>
  <h2 class="section-heading-lg">Consultas sobre Seguridad y Salud en el Trabajo</h2>
  <p style="color: var(--muted); max-width: 750px; line-height: 1.6;">
    Información esencial sobre la normativa boliviana de seguridad industrial y los requisitos del Ministerio de Trabajo.
  </p>

  <div class="faq-wrap">
    <div class="faq-item is-open">
      <button type="button" class="faq-question">
        <span>¿Cada cuánto tiempo se debe realizar el monitoreo ocupacional?</span>
        <i data-lucide="chevron-down"></i>
      </button>
      <div class="faq-answer">
        Por normativa del Ministerio de Trabajo, Empleo y Previsión Social (MTEPS), los monitoreos ocupacionales deben actualizarse de manera periódica, generalmente una vez al año (anual) o cada vez que se modifiquen los procesos productivos, la maquinaria o las instalaciones de la empresa.
      </div>
    </div>

    <div class="faq-item">
      <button type="button" class="faq-question">
        <span>¿Qué validez legal tienen los informes de PachaLab?</span>
        <i data-lucide="chevron-down"></i>
      </button>
      <div class="faq-answer">
        Nuestros informes cuentan con firma de profesionales habilitados y registrados en el MTEPS (Registro Nacional de Profesionales en Higiene, Seguridad Ocupacional y Bienestar). Son documentos con plena validez legal para auditorías del Ministerio de Trabajo, fiscalizaciones de la CNS/Cajas de Salud e inspecciones del SIPPCI.
      </div>
    </div>

    <div class="faq-item">
      <button type="button" class="faq-question">
        <span>¿Cuál es la diferencia entre Sonometría y Dosimetría de ruido?</span>
        <i data-lucide="chevron-down"></i>
      </button>
      <div class="faq-answer">
        La <strong>sonometría</strong> mide los niveles de presión sonora instantáneos o continuos en un punto estático del ambiente de trabajo. La <strong>dosimetría</strong>, en cambio, utiliza un dosímetro colocado en el trabajador durante su jornada laboral completa (8 horas) para determinar la dosis acumulada de ruido recibida en función del límite máximo permitido de 85 dBA.
      </div>
    </div>

    <div class="faq-item">
      <button type="button" class="faq-question">
        <span>¿Qué incluye el estudio de Carga de Fuego y Extintores?</span>
        <i data-lucide="chevron-down"></i>
      </button>
      <div class="faq-answer">
        El estudio contempla el inventario de materiales combustibles por sector de incendio, el cálculo del calor liberado en megacalorías por metro cuadrado (Mcal/m2), el dimensionamiento y ubicación óptima de los extintores y la elaboración de la memoria descriptiva requerida para la certificación del SIPPCI (Bomberos).
      </div>
    </div>
  </div>
</section>
@endsection

@extends('layouts.app')

@section('title', 'Alquiler de Equipos Certificados | PachaLab Bolivia')

@section('content')
<!-- SUBPAGE HERO -->
<section class="subpage-hero">
  <div class="subpage-hero-inner">
    <nav class="breadcrumb-nav" aria-label="Breadcrumb">
      <a href="{{ route('home') }}"><i data-lucide="home"></i> Inicio</a>
      <span>/</span>
      <span class="current">Alquiler de Equipos</span>
    </nav>
    <div class="hero-pill-badge">
      <i data-lucide="gauge"></i> Equipos con Calibración Certificada
    </div>
    <h1>Alquiler de <span>Equipos</span></h1>
    <p class="lead">
      Amplía tus capacidades técnicas. Ponemos a tu disposición instrumentos de medición ambiental y ocupacional
      de marcas líderes a nivel mundial (Trotec, Extech, Temtop, PCE, Laserliner, Bosean), calibrados y listos para campo.
    </p>
    <div class="subpage-hero-actions">
      <a class="btn btn-green" href="{{ route('cotizar.equipos') }}">
        <i data-lucide="wrench"></i> Cotizador Online de Alquiler (PDF) <i data-lucide="arrow-right"></i>
      </a>
      <a class="btn btn-outline" href="https://wa.link/3lf4u6" target="_blank" rel="noopener">
        <i data-lucide="message-square"></i> Consultar Disponibilidad Inmediata
      </a>
    </div>
  </div>
</section>

<!-- SERVICE DETAILS -->
<section class="details-section">
  <div class="section-tagline">Detalles del Servicio</div>
  <h2 class="section-heading-lg">Garantía, Respaldo y Trazabilidad Metrológica</h2>
  <p style="color: var(--muted); max-width: 760px; line-height: 1.6;">
    Alquilar un equipo con PachaLab te asegura mediciones confiables y respaldo profesional en cada etapa de tu proyecto.
  </p>

  <div class="details-grid">
    <!-- 01 CALIBRACIÓN -->
    <article class="detail-card spotlight-card tilt-card anim-card">
      <div class="detail-card-num">.01</div>
      <h3>Calibración Vigente</h3>
      <p style="font-size: 0.88rem; color: var(--muted); margin-bottom: 16px;">
        Entregamos cada instrumento con su respectivo certificado de calibración actualizado y trazable.
      </p>
      <ul class="detail-card-list">
        <li><i data-lucide="check-circle-2"></i> <span>Certificados reconocidos por autoridades ambientales y laborales.</span></li>
        <li><i data-lucide="check-circle-2"></i> <span>Mantenimiento preventivo e inspección antes de cada entrega.</span></li>
        <li><i data-lucide="check-circle-2"></i> <span>Baterías, accesorios y cables completos en maletín de transporte rígido.</span></li>
      </ul>
    </article>

    <!-- 02 CAPACITACIÓN -->
    <article class="detail-card spotlight-card tilt-card anim-card">
      <div class="detail-card-num">.02</div>
      <h3>Inducción Técnica</h3>
      <p style="font-size: 0.88rem; color: var(--muted); margin-bottom: 16px;">
        Te explicamos cómo configurar, operar y registrar datos correctamente con cada dispositivo.
      </p>
      <ul class="detail-card-list">
        <li><i data-lucide="check-circle-2"></i> <span>Capacitación presencial o virtual al momento de retirar el equipo.</span></li>
        <li><i data-lucide="check-circle-2"></i> <span>Manuales de usuario en español y guía rápida de medición.</span></li>
        <li><i data-lucide="check-circle-2"></i> <span>Soporte telefónico durante la realización de tus ensayos.</span></li>
      </ul>
    </article>

    <!-- 03 MODALIDADES -->
    <article class="detail-card spotlight-card tilt-card anim-card">
      <div class="detail-card-num">.03</div>
      <h3>Modalidades Flexibles</h3>
      <p style="font-size: 0.88rem; color: var(--muted); margin-bottom: 16px;">
        Opciones adaptadas a la duración y presupuesto de consultorías, auditorías o proyectos anuales.
      </p>
      <ul class="detail-card-list">
        <li><i data-lucide="check-circle-2"></i> <span>Alquiler por día, semana completa o mes con tarifas preferenciales.</span></li>
        <li><i data-lucide="check-circle-2"></i> <span>Tarifas preferenciales para alquileres prolongados o proyectos de larga duración.</span></li>
        <li><i data-lucide="check-circle-2"></i> <span>Despachos y envíos seguros a todos los departamentos de Bolivia.</span></li>
      </ul>
    </article>
  </div>
</section>

<!-- CATÁLOGO DE EQUIPOS CON IMÁGENES -->
<section style="background: #fafdf9; padding: 70px 24px; border-top: 1px solid var(--line); border-bottom: 1px solid var(--line);">
  <div style="max-width: 1200px; margin: 0 auto;">
    <div style="text-align: center; max-width: 700px; margin: 0 auto 40px;">
      <span class="hero-pill-badge"><i data-lucide="box"></i> Catálogo de Instrumentos</span>
      <h2 style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 2.2rem; font-weight: 800; color: var(--dark); margin: 8px 0;">
        Equipos Disponibles para Alquiler Inmediato
      </h2>
      <p style="color: var(--muted); font-size: 0.95rem;">
        Conoce parte de nuestra flota instrumental para mediciones ambientales y de seguridad industrial.
      </p>
    </div>

    <div class="equipos-gallery">
      <!-- 1. ANEMOMETRO -->
      <article class="equipo-card spotlight-card tilt-card">
        <div class="equipo-media">
          <img src="{{ asset('images/equipos/Anemometro-724x1024.jpg') }}" alt="Anemómetro Extech / Laserliner" loading="lazy">
          <span class="equipo-code-badge">07-ANE-EXT</span>
        </div>
        <div class="equipo-body">
          <h4>Anemómetro Digital</h4>
          <span class="equipo-spec">EXTECH AN100 / LASERLINER AirflowTest · Medición de flujo, velocidad de aire y temperatura.</span>
          <div class="equipo-footer">
            <span class="equipo-price">300.00 Bs <small>/ día</small></span>
            <a class="equipo-btn-cotizar" href="{{ route('cotizar.equipos') }}">
              Cotizar <i data-lucide="arrow-right"></i>
            </a>
          </div>
        </div>
      </article>

      <!-- 2. SONOMETRO -->
      <article class="equipo-card spotlight-card tilt-card">
        <div class="equipo-media">
          <img src="{{ asset('images/equipos/Sonometro-724x1024.jpg') }}" alt="Sonómetro Trotec / Laserliner" loading="lazy">
          <span class="equipo-code-badge">04-SON-TRO</span>
        </div>
        <div class="equipo-body">
          <h4>Sonómetro Integrador</h4>
          <span class="equipo-spec">TROTEC SL400 / LASERLINER SoundTest · Clase 2, ponderación A y C, registro dBA/dBC continuo.</span>
          <div class="equipo-footer">
            <span class="equipo-price">300.00 Bs <small>/ día</small></span>
            <a class="equipo-btn-cotizar" href="{{ route('cotizar.equipos') }}">
              Cotizar <i data-lucide="arrow-right"></i>
            </a>
          </div>
        </div>
      </article>

      <!-- 3. CONTADOR DE PARTICULAS -->
      <article class="equipo-card spotlight-card tilt-card">
        <div class="equipo-media">
          <img src="{{ asset('images/equipos/Contador-de-Particulas-724x1024.jpg') }}" alt="Contador de Partículas Temtop" loading="lazy">
          <span class="equipo-code-badge">09-PAR-TEM</span>
        </div>
        <div class="equipo-body">
          <h4>Contador de Partículas</h4>
          <span class="equipo-spec">TEMTOP LKC-1000 2ND · Detección láser de PM2.5, PM10, partículas suspendidas y calidad de aire.</span>
          <div class="equipo-footer">
            <span class="equipo-price">300.00 Bs <small>/ día</small></span>
            <a class="equipo-btn-cotizar" href="{{ route('cotizar.equipos') }}">
              Cotizar <i data-lucide="arrow-right"></i>
            </a>
          </div>
        </div>
      </article>

      <!-- 4. DETECTOR MULTIGASES -->
      <article class="equipo-card spotlight-card tilt-card">
        <div class="equipo-media">
          <img src="{{ asset('images/equipos/Detector-de-Multigases-724x1024.jpg') }}" alt="Detector Multigases Bosean" loading="lazy">
          <span class="equipo-code-badge">11-GAS-BOS</span>
        </div>
        <div class="equipo-body">
          <h4>Detector Multigases (4 en 1)</h4>
          <span class="equipo-spec">BOSEAN BH–45 · Monitoreo continuo de LEL (explosividad), O2, H2S y Monóxido de Carbono (CO).</span>
          <div class="equipo-footer">
            <span class="equipo-price">400.00 Bs <small>/ día</small></span>
            <a class="equipo-btn-cotizar" href="{{ route('cotizar.equipos') }}">
              Cotizar <i data-lucide="arrow-right"></i>
            </a>
          </div>
        </div>
      </article>

      <!-- 5. LUXOMETRO -->
      <article class="equipo-card spotlight-card tilt-card">
        <div class="equipo-media">
          <img src="{{ asset('images/equipos/Luxometro_-724x1024.jpg') }}" alt="Luxómetro PCE / Laserliner" loading="lazy">
          <span class="equipo-code-badge">01-LUX-PCE</span>
        </div>
        <div class="equipo-body">
          <h4>Luxómetro de Precisión</h4>
          <span class="equipo-spec">PCE-174 / LASERLINER Lux Test · Sensor remoto fotométrico para cumplimiento de NTS 001/17.</span>
          <div class="equipo-footer">
            <span class="equipo-price">300.00 Bs <small>/ día</small></span>
            <a class="equipo-btn-cotizar" href="{{ route('cotizar.equipos') }}">
              Cotizar <i data-lucide="arrow-right"></i>
            </a>
          </div>
        </div>
      </article>

      <!-- 6. TERMOHIGRÓMETRO -->
      <article class="equipo-card spotlight-card tilt-card">
        <div class="equipo-media">
          <img src="{{ asset('images/equipos/Termohigrometro--724x1024.jpg') }}" alt="Termohigrómetro Trotec" loading="lazy">
          <span class="equipo-code-badge">08-TER-TRO</span>
        </div>
        <div class="equipo-body">
          <h4>Termohigrómetro Profesional</h4>
          <span class="equipo-spec">TROTEC TC100 · Medición de temperatura ambiente, humedad relativa % y punto de rocío.</span>
          <div class="equipo-footer">
            <span class="equipo-price">400.00 Bs <small>/ día</small></span>
            <a class="equipo-btn-cotizar" href="{{ route('cotizar.equipos') }}">
              Cotizar <i data-lucide="arrow-right"></i>
            </a>
          </div>
        </div>
      </article>

      <!-- 7. OPACÍMETRO -->
      <article class="equipo-card spotlight-card tilt-card">
        <div class="equipo-media">
          <img src="{{ asset('images/equipos/Opacimetro-724x1024.jpg') }}" alt="Opacímetro Brain Bee" loading="lazy">
          <span class="equipo-code-badge">13-DIS-ING</span>
        </div>
        <div class="equipo-body">
          <h4>Opacímetro para Diésel</h4>
          <span class="equipo-spec">BRAIN BEE OPA-300 · Módulo de humo y opacidad de gases de escape según NB 62004.</span>
          <div class="equipo-footer">
            <span class="equipo-price">500.00 Bs <small>/ día</small></span>
            <a class="equipo-btn-cotizar" href="{{ route('cotizar.equipos') }}">
              Cotizar <i data-lucide="arrow-right"></i>
            </a>
          </div>
        </div>
      </article>

      <!-- 8. MEDIDOR DE CO2 / CO -->
      <article class="equipo-card spotlight-card tilt-card">
        <div class="equipo-media">
          <img src="{{ asset('images/equipos/Medidor-portatil-de-gases-CO2-724x1024.jpg') }}" alt="Medidor de CO2 y CO" loading="lazy">
          <span class="equipo-code-badge">12-CO2-CO2</span>
        </div>
        <div class="equipo-body">
          <h4>Medidor de CO2 / Calidad Aire</h4>
          <span class="equipo-spec">CO2 Meter · Detector NDIR con registro continuo para ambientes cerrados y oficinas.</span>
          <div class="equipo-footer">
            <span class="equipo-price">200.00 Bs <small>/ día</small></span>
            <a class="equipo-btn-cotizar" href="{{ route('cotizar.equipos') }}">
              Cotizar <i data-lucide="arrow-right"></i>
            </a>
          </div>
        </div>
      </article>

      <!-- 9. DISTANCIÓMETRO -->
      <article class="equipo-card spotlight-card tilt-card">
        <div class="equipo-media">
          <img src="{{ asset('images/equipos/Distanciometro-laser-724x1024.jpg') }}" alt="Distanciómetro Láser" loading="lazy">
          <span class="equipo-code-badge">14-DIS-ING</span>
        </div>
        <div class="equipo-body">
          <h4>Distanciómetro Láser 60M</h4>
          <span class="equipo-spec">INGCO 60MT / DUKA LS-P · Cálculo de áreas, volúmenes y alturas para estudios de ventilación.</span>
          <div class="equipo-footer">
            <span class="equipo-price">50.00 Bs <small>/ día</small></span>
            <a class="equipo-btn-cotizar" href="{{ route('cotizar.equipos') }}">
              Cotizar <i data-lucide="arrow-right"></i>
            </a>
          </div>
        </div>
      </article>

      <!-- 10. TRÍPODE -->
      <article class="equipo-card spotlight-card tilt-card">
        <div class="equipo-media">
          <img src="{{ asset('images/equipos/Tripode-para-instrumentos-724x1024.jpg') }}" alt="Trípode para instrumentos" loading="lazy">
          <span class="equipo-code-badge">17-TRI-TOL</span>
        </div>
        <div class="equipo-body">
          <h4>Trípode para Instrumentos</h4>
          <span class="equipo-spec">TOLSEN Instrument Tripod · Soporte extensible y estable con rosca estándar para sonómetros.</span>
          <div class="equipo-footer">
            <span class="equipo-price">60.00 Bs <small>/ día</small></span>
            <a class="equipo-btn-cotizar" href="{{ route('cotizar.equipos') }}">
              Cotizar <i data-lucide="arrow-right"></i>
            </a>
          </div>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- PREGUNTAS FRECUENTES (FAQS) -->
<section class="details-section">
  <div class="section-tagline">Preguntas Frecuentes</div>
  <h2 class="section-heading-lg">¿Cómo Funciona el Alquiler de Equipos?</h2>
  <p style="color: var(--muted); max-width: 750px; line-height: 1.6;">
    Resolvemos tus dudas sobre requisitos, plazos y condiciones para disponer de nuestros equipos.
  </p>

  <div class="faq-wrap">
    <div class="faq-item is-open">
      <button type="button" class="faq-question">
        <span>¿Cuál es el proceso para alquilar un equipo?</span>
        <i data-lucide="chevron-down"></i>
      </button>
      <div class="faq-answer">
        1. Utiliza nuestro cotizador online para seleccionar los equipos y días requeridos, generando tu PDF referencial.<br>
        2. Nuestro equipo confirma la disponibilidad y te envía el contrato de alquiler.<br>
        3. Se firma el acuerdo y se coordina la entrega junto a la inducción técnica y certificado de calibración.
      </div>
    </div>

    <div class="faq-item">
      <button type="button" class="faq-question">
        <span>¿Qué incluye el servicio de alquiler?</span>
        <i data-lucide="chevron-down"></i>
      </button>
      <div class="faq-answer">
        El servicio incluye el instrumento en óptimas condiciones de funcionamiento, maletín de transporte rígido, accesorios operativos necesarios, copia de su certificado de calibración vigente y una breve capacitación práctica para su manejo.
      </div>
    </div>

    <div class="faq-item">
      <button type="button" class="faq-question">
        <span>¿Hacen envíos a otros departamentos de Bolivia?</span>
        <i data-lucide="chevron-down"></i>
      </button>
      <div class="faq-answer">
        Sí, enviamos equipos debidamente embalados y asegurados a través de transporte expreso o aéreo a cualquier departamento de Bolivia (Santa Cruz, Cochabamba, Oruro, Potosí, Tarija, Sucre, etc.).
      </div>
    </div>

    <div class="faq-item">
      <button type="button" class="faq-question">
        <span>¿Qué sucede si un equipo sufre un daño o avería?</span>
        <i data-lucide="chevron-down"></i>
      </button>
      <div class="faq-answer">
        El cliente se compromete mediante contrato a hacer un uso adecuado y bajo las especificaciones técnicas del fabricante. En caso de daño por mal uso o siniestro, el arrendatario asume los costos de reparación o reposición según las cláusulas estipuladas.
      </div>
    </div>
  </div>
</section>
@endsection

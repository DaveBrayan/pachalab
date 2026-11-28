<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#168d08">
  <title>PachaLab | Especialistas en Monitoreo Ambiental y Ocupacional</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
  <link rel="stylesheet" href="{{ asset('css/pachalab-pages.css') }}">
</head>

<body>
  <div class="scroll-progress" id="scrollProgress" aria-hidden="true"></div>
  <div class="page">
    <header class="top-shell" id="inicio">
      @include('partials.navbar')

      <section class="hero">
        <div class="hero-copy">
          <div class="eyebrow"><i data-lucide="sprout"></i> {{ $cms['home_hero_eyebrow'] ?? 'Bienvenidos a PachaLab' }}</div>
          <h1>{!! nl2br(e($cms['home_hero_title'] ?? "Especialistas en\nMonitoreo Ambiental\ny Ocupacional")) !!}</h1>
          <p>{{ $cms['home_hero_desc'] ?? 'La seguridad de tus proyectos comienza con datos confiables. Confía en PachaLab para obtener resultados precisos y confiables, asegurando el cumplimiento normativo.' }}</p>
          <div class="hero-actions">
            <a class="btn btn-green" href="{{ $cms['home_hero_btn1_link'] ?? route('cotizar.ahora') }}">
              <i data-lucide="calculator"></i> {{ $cms['home_hero_btn1_text'] ?? 'Cotizar ahora' }} <i data-lucide="arrow-right"></i>
            </a>
            <a class="btn btn-outline" href="{{ $cms['home_hero_btn2_link'] ?? '#quienes-somos' }}">
              <i data-lucide="play" style="color:#198c0b"></i> {{ $cms['home_hero_btn2_text'] ?? '¿Quiénes somos?' }}
            </a>
          </div>
        </div>
        <div class="hero-visual">
          <img src="{{ asset($cms['home_hero_img'] ?? 'images/hero.png') }}" alt="Especialista ambiental de PachaLab">
        </div>
      </section>
    </header>

    <main>
      <section class="section" id="quienes-somos">
        <div class="about-grid">
          <div class="about-copy anim-left">
            <div class="section-kicker">{{ $cms['home_about_kicker'] ?? $cms['homeAboutKicker'] ?? 'PACHABOL SRL' }}</div>
            <h2>{{ $cms['home_about_title'] ?? $cms['homeAboutTitle'] ?? '¿Quiénes somos?' }}</h2>
            <p>{{ $cms['home_about_desc'] ?? $cms['homeAboutDesc'] ?? 'PachaLab es parte de la consultora internacional PACHABOL SRL que cuenta con los más altos estándares de calidad exigidos por nuestros clientes: instituciones, empresas, industrias y otros. Nuestra experiencia y compromiso nos posicionan como referentes en monitoreo ambiental, ocupacional y en el suministro de equipos especializados.' }}</p>
            <span class="about-badge"><i data-lucide="badge-check"></i> {{ $cms['home_about_badge'] ?? $cms['homeAboutBadge'] ?? 'Estándares de calidad y trazabilidad nacional e internacional' }}</span>
          </div>
          <div class="certs-box anim-right">
            <div class="certs-head">
              <h3 class="certs-title"><span><i data-lucide="shield-check"></i></span> Certificaciones y Acreditaciones</h3>
              <span class="certs-status">Respaldo Oficial</span>
            </div>
            <div class="certs-grid">
              <div class="cert-item spotlight-card tilt-card anim-card">
                <div class="cert-top">
                  <span class="cert-dot"><i data-lucide="check"></i></span>
                  <span class="cert-code">01 · MMAyA</span>
                </div>
                <span class="cert-text">{{ $cms['home_cert1'] ?? $cms['homeCert1'] ?? 'Consultores Ambientales categoría “C” con registro en el Ministerio de Producción Sostenible, Medio Ambiente y Agua.' }}</span>
              </div>
              <div class="cert-item spotlight-card tilt-card anim-card">
                <div class="cert-top">
                  <span class="cert-dot"><i data-lucide="check"></i></span>
                  <span class="cert-code">02 · MTEPS</span>
                </div>
                <span class="cert-text">{{ $cms['home_cert2'] ?? $cms['homeCert2'] ?? 'Profesionales en Seguridad Ocupacional categoría “A” con registro en el Ministerio de Trabajo, Empleo y Previsión Social.' }}</span>
              </div>
              <div class="cert-item spotlight-card tilt-card anim-card cert-item-wide">
                <div class="cert-top">
                  <span class="cert-dot"><i data-lucide="check"></i></span>
                  <span class="cert-code">03 · Equipo Técnico</span>
                </div>
                <span class="cert-text">{{ $cms['home_cert3'] ?? $cms['homeCert3'] ?? 'Personal técnico con amplia experiencia y capacitación constante.' }}</span>
              </div>
            </div>
          </div>
        </div>

        <div class="section-divider"></div>

        <div class="services-wrap" id="servicios">
          <div class="section-head">
            <div class="section-kicker anim-up">Nuestros Servicios</div>
            <h2 class="split-heading">Servicios</h2>
            <p class="anim-up">Brindamos soluciones integrales en monitoreo ambiental y ocupacional, con equipos certificados y personal
              especializado.</p>
          </div>

          <div class="services">
            <article class="service spotlight-card anim-card tilt-card" id="servicio-ambiental">
              <div class="service-media">
                <img src="{{ asset('images/monitoreo-ambiental.jpg') }}"
                  alt="Especialista realizando monitoreo ambiental en campo" loading="lazy">
                <span class="service-chip">Aire · Agua · Ruido</span>
                <div class="service-icon"><i data-lucide="trees"></i></div>
              </div>
              <div class="service-body">
                <div class="service-top-meta">
                  <span class="service-tag">Gestión Ambiental</span>
                  <span class="service-num">01</span>
                </div>
                <h3>Monitoreo Ambiental</h3>
                <p>Evaluamos calidad de aire, agua y ruido para cumplir normativas ambientales.</p>
                <div class="service-specs">
                  <span>Aire</span>
                  <span>Agua</span>
                  <span>Ruido</span>
                </div>
                <a class="more" href="{{ route('servicios.ambiental') }}">
                  Más Información <span><i data-lucide="chevron-right"></i></span>
                </a>
              </div>
            </article>
            <article class="service spotlight-card anim-card tilt-card" id="servicio-ocupacional">
              <div class="service-media">
                <img src="{{ asset('images/monitoreo-ocupacional.jpg') }}"
                  alt="Ingeniera realizando monitoreo ocupacional en planta industrial" loading="lazy">
                <span class="service-chip">Salud Ocupacional</span>
                <div class="service-icon"><i data-lucide="hard-hat"></i></div>
              </div>
              <div class="service-body">
                <div class="service-top-meta">
                  <span class="service-tag">Seguridad Industrial</span>
                  <span class="service-num">02</span>
                </div>
                <h3>Monitoreo Ocupacional</h3>
                <p>Medimos agentes físicos y químicos que afectan la salud en el trabajo.</p>
                <div class="service-specs">
                  <span>Agentes Físicos</span>
                  <span>Químicos</span>
                  <span>SST</span>
                </div>
                <a class="more" href="{{ route('servicios.ocupacional') }}">
                  Más Información <span><i data-lucide="chevron-right"></i></span>
                </a>
              </div>
            </article>
            <article class="service spotlight-card anim-card tilt-card" id="servicio-equipos">
              <div class="service-media">
                <img src="{{ asset('images/venta-equipos.jpg') }}"
                  alt="Equipos calibrados de medición ambiental y ocupacional" loading="lazy">
                <span class="service-chip">Calibración Certificada</span>
                <div class="service-icon"><i data-lucide="gauge"></i></div>
              </div>
              <div class="service-body">
                <div class="service-top-meta">
                  <span class="service-tag">Equipamiento Técnico</span>
                  <span class="service-num">03</span>
                </div>
                <h3>Alquiler de Equipos</h3>
                <p>Ofrecemos equipos calibrados para medición ambiental y ocupacional.</p>
                <div class="service-specs">
                  <span>Alquiler</span>
                  <span>Calibrados</span>
                  <span>Por Día/Mes</span>
                </div>
                <a class="more" href="{{ route('servicios.equipos') }}">
                  Más Información <span><i data-lucide="chevron-right"></i></span>
                </a>
              </div>
            </article>
          </div>

          <div class="service-banner anim-up">
            <div class="service-banner-copy">
              <b><i data-lucide="phone-call"></i></b>
              <div>
                <strong>¿Necesitas un servicio?</strong>
                <span>Contáctanos ahora por WhatsApp y recibe asesoramiento inmediato para tu empresa.</span>
              </div>
            </div>
            <a class="btn btn-green" href="https://wa.link/3lf4u6" target="_blank" rel="noopener">
              Contáctanos ahora · 76358189 <i data-lucide="arrow-right"></i>
            </a>
          </div>
        </div>
      </section>

      <section class="commit" id="compromiso">
        <div class="commit-particles" id="commitParticles" aria-hidden="true"></div>
        <div class="commit-copy anim-left">
          <div class="pill"><i data-lucide="sprout"></i> {{ $cms['commit_pill'] ?? $cms['commitPill'] ?? 'Nuestro Compromiso' }}</div>
          <h2 class="split-heading">{{ $cms['commit_title'] ?? $cms['commitTitle'] ?? 'Calidad, respaldo y resultados confiables' }}</h2>
          <p>{{ $cms['commit_desc'] ?? $cms['commitDesc'] ?? 'Acompañamos a instituciones, empresas e industrias en todo el país con datos precisos y cumplimiento normativo garantizado.' }}</p>
          <a class="btn btn-lime" href="{{ $cms['commit_btn_link'] ?? $cms['commitBtnLink'] ?? '#cotizar' }}">{{ $cms['commit_btn_text'] ?? $cms['commitBtnText'] ?? 'Cotiza en Línea' }} <i data-lucide="arrow-right"></i></a>
        </div>
        <div class="stats">
          <div class="stat spotlight-card anim-card tilt-card">
            <div class="ico"><i data-lucide="trophy"></i></div>
            <strong data-count="100" data-prefix="+">{{ $cms['commit_stat1_val'] ?? $cms['commitStat1Val'] ?? '+100' }}</strong>
            <small>{{ $cms['commit_stat1_lbl'] ?? $cms['commitStat1Lbl'] ?? 'Casos de Éxito Completados' }}</small>
          </div>
          <div class="stat spotlight-card anim-card tilt-card">
            <div class="ico"><i data-lucide="shield-check"></i></div>
            <strong data-count="100" data-suffix="%">{{ $cms['commit_stat2_val'] ?? $cms['commitStat2Val'] ?? '100%' }}</strong>
            <small>{{ $cms['commit_stat2_lbl'] ?? $cms['commitStat2Lbl'] ?? 'Calidad del Servicio' }}</small>
          </div>
          <div class="stat spotlight-card anim-card tilt-card">
            <div class="ico"><i data-lucide="heart-handshake"></i></div>
            <strong data-count="50" data-prefix="+">{{ $cms['commit_stat3_val'] ?? $cms['commitStat3Val'] ?? '+50' }}</strong>
            <small>{{ $cms['commit_stat3_lbl'] ?? $cms['commitStat3Lbl'] ?? 'Confianza de Nuestros Clientes' }}</small>
          </div>
        </div>
        <div class="commit-visual anim-right" aria-label="Globo 3D interactivo de cobertura PachaLab">
          <div class="commit-aura" aria-hidden="true"></div>
          <div class="orbit-ring" aria-hidden="true"></div>
          <div class="orbit-ring-2" aria-hidden="true"></div>
          <canvas id="commitGlobe" width="300" height="300"></canvas>
          <div class="commit-float-badge"><span></span> {{ $cms['commit_badge_text'] ?? $cms['commitBadgeText'] ?? 'Cobertura Nacional · Bolivia' }}</div>
        </div>
      </section>

      <section class="process" id="cotizar">
        <div class="section-head">
          <div class="section-kicker anim-up">{{ $cms['process_kicker'] ?? $cms['processKicker'] ?? 'Cotiza en Línea' }}</div>
          <h2 class="split-heading">{{ $cms['process_title'] ?? $cms['processTitle'] ?? 'Solicita tu presupuesto rápido y sin compromiso' }}</h2>
          <p class="anim-up">{{ $cms['process_desc'] ?? $cms['processDesc'] ?? 'Completa el formulario detallando los servicios que necesitas y recibe un presupuesto inmediato listo para descargar.' }}</p>
        </div>

        <div class="steps">
          <article class="step spotlight-card anim-card tilt-card">
            <span class="step-ghost-num">01</span>
            <div class="step-top">
              <span class="step-pill">Paso 01</span>
              <span class="step-icon"><i data-lucide="clock-3"></i></span>
            </div>
            <div>
              <h3>{{ $cms['step1_title'] ?? $cms['step1Title'] ?? 'Respuesta en menos de 24 horas' }}</h3>
              <p>{{ $cms['step1_desc'] ?? $cms['step1Desc'] ?? 'Atención ágil y oportuna para tus requerimientos técnicos.' }}</p>
            </div>
          </article>
          <article class="step spotlight-card anim-card tilt-card">
            <span class="step-ghost-num">02</span>
            <div class="step-top">
              <span class="step-pill">Paso 02</span>
              <span class="step-icon"><i data-lucide="message-circle-check"></i></span>
            </div>
            <div>
              <h3>{{ $cms['step2_title'] ?? $cms['step2Title'] ?? 'Asesoría gratuita' }}</h3>
              <p>{{ $cms['step2_desc'] ?? $cms['step2Desc'] ?? 'Orientación especializada para definir el alcance de tu proyecto.' }}</p>
            </div>
          </article>
          <article class="step spotlight-card anim-card tilt-card">
            <span class="step-ghost-num">03</span>
            <div class="step-top">
              <span class="step-pill">Paso 03</span>
              <span class="step-icon"><i data-lucide="map-pinned"></i></span>
            </div>
            <div>
              <h3>{{ $cms['step3_title'] ?? $cms['step3Title'] ?? 'Servicio en todo el país' }}</h3>
              <p>{{ $cms['step3_desc'] ?? $cms['step3Desc'] ?? 'Cobertura nacional con equipos calibrados y personal certificado.' }}</p>
            </div>
          </article>
        </div>

        <div class="quote-panel anim-up">
          <div class="quote-select">
            <span class="quote-badge"><i data-lucide="sparkles"></i> Configurador de Presupuesto</span>
            <h3>Elige el tipo de cotización</h3>
            <p>Selecciona la modalidad de presupuesto y el servicio que necesitas para agilizar tu solicitud.</p>
            <div class="quote-types" role="tablist" aria-label="Tipo de cotización">
              <button type="button" class="quote-pill active" data-quote-type="Referencial">
                <i data-lucide="zap"></i> Referencial
              </button>
              <button type="button" class="quote-pill" data-quote-type="Personalizada">
                <i data-lucide="sliders-horizontal"></i> Personalizada
              </button>
            </div>
            <div class="quote-mode-hint" id="quoteModeHint">
              <i data-lucide="check-circle-2"></i>
              <span>Modo Referencial: estimación rápida lista para descargar.</span>
            </div>
          </div>
          <div class="quote-actions" id="quoteActionsReferencial">
            <a class="quote-action spotlight-card anim-card tilt-card" href="{{ route('cotizar.ambiental') }}" data-quote-service="Monitoreo Ambiental">
              <div class="quote-action-icon"><i data-lucide="trees"></i></div>
              <div>
                <strong>Cotizar Monitoreo Ambiental</strong>
                <small>Aire, agua y ruido ambiental (PDF)</small>
              </div>
              <div class="quote-action-cta">Abrir cotizador <span><i data-lucide="arrow-right"></i></span></div>
            </a>
            <a class="quote-action spotlight-card anim-card tilt-card" href="{{ route('cotizar.ocupacional') }}" data-quote-service="Monitoreo Ocupacional">
              <div class="quote-action-icon"><i data-lucide="hard-hat"></i></div>
              <div>
                <strong>Cotizar Monitoreo Ocupacional</strong>
                <small>Agentes físicos y químicos SST (PDF)</small>
              </div>
              <div class="quote-action-cta">Abrir cotizador <span><i data-lucide="arrow-right"></i></span></div>
            </a>
            <a class="quote-action spotlight-card anim-card tilt-card" href="{{ route('cotizar.equipos') }}" data-quote-service="Alquiler de Equipos">
              <div class="quote-action-icon"><i data-lucide="wrench"></i></div>
              <div>
                <strong>Cotizar Alquiler de Equipos</strong>
                <small>Equipos certificados y calibrados (PDF)</small>
              </div>
              <div class="quote-action-cta">Abrir cotizador <span><i data-lucide="arrow-right"></i></span></div>
            </a>
          </div>
        </div>
      </section>

      <section class="feedback-bar anim-up" aria-label="Sugerencias de mejora">
        <div class="feedback-copy">
          <div class="feedback-icon"><i data-lucide="file-text"></i></div>
          <div>
            <h3>{{ $cms['feedback_title'] ?? $cms['feedbackTitle'] ?? 'Sugerencias de mejora' }}</h3>
            <p>{{ $cms['feedback_desc'] ?? $cms['feedbackDesc'] ?? 'Queremos ofrecerte siempre el mejor servicio. Si deseas enviarnos una queja o sugerencia sobre la atención recibida, descarga el formulario y compártenos tus comentarios.' }}</p>
          </div>
        </div>
        <a class="btn btn-green"
          href="{{ $cms['feedback_pdf_url'] ?? $cms['feedbackPdfUrl'] ?? 'https://pachalab.pachabol.com/wp-content/uploads/2025/10/Sugerencias-de-mejora.pdf' }}" target="_blank"
          rel="noopener"><i data-lucide="file-down"></i> {{ $cms['feedback_btn_text'] ?? $cms['feedbackBtnText'] ?? 'Descargar formulario' }} <i data-lucide="arrow-right"></i></a>
      </section>

      <!-- SECCIÓN CONTACTO / COTIZACIÓN PERSONALIZADA (OCULTA EN MODO REFERENCIAL) -->
      <section class="contact is-hidden" id="contacto">
        <div class="contact-copy anim-left">
          <div class="pill"><i data-lucide="mail"></i> {{ $cms['contact_pill'] ?? $cms['contactPill'] ?? 'Contáctanos' }}</div>
          <h2>{!! nl2br(e($cms['contact_title'] ?? $cms['contactTitle'] ?? "¿Necesitas un servicio?\nContáctanos ahora")) !!}</h2>
          <p>{{ $cms['contact_desc'] ?? $cms['contactDesc'] ?? 'La seguridad de tus proyectos comienza con datos confiables. Solicita tu cotización personalizada para proyectos a medida, estudios complejos o licitaciones.' }}</p>
          <a class="btn btn-lime" href="{{ $cms['contact_wa_link'] ?? $cms['contactWaLink'] ?? 'https://wa.link/3lf4u6' }}" target="_blank" rel="noopener">
            <i data-lucide="message-square"></i> WhatsApp {{ $cms['contact_wa'] ?? $cms['contactWa'] ?? '76358189' }} <i data-lucide="arrow-right"></i>
          </a>
        </div>
        <div class="contact-info anim-up">
          <a href="{{ $cms['contact_wa_link'] ?? $cms['contactWaLink'] ?? 'https://wa.link/3lf4u6' }}" target="_blank" rel="noopener">
            <b><i data-lucide="phone"></i></b><span>{{ $cms['contact_wa'] ?? $cms['contactWa'] ?? '76358189 (WhatsApp)' }}</span>
          </a>
          <a href="mailto:{{ $cms['contact_email'] ?? $cms['contactEmail'] ?? 'laboratorio@pachabol.com' }}">
            <b><i data-lucide="mail"></i></b><span>{{ $cms['contact_email'] ?? $cms['contactEmail'] ?? 'laboratorio@pachabol.com' }}</span>
          </a>
          <a href="https://www.facebook.com/pachaconsultingbolivia" target="_blank" rel="noopener">
            <b><i data-lucide="share-2"></i></b><span>{{ $cms['contact_fb'] ?? $cms['contactFb'] ?? 'Facebook · Pacha Consulting Bolivia' }}</span>
          </a>
        </div>
        <form class="contact-form anim-right" id="quoteForm">
          <div class="form-row">
            <input required id="quoteNameInput" placeholder="Nombre completo *" aria-label="Nombre">
            <input required id="quoteEmailInput" type="email" placeholder="Correo electrónico *" aria-label="Correo">
          </div>
          <div class="form-row">
            <input required id="quotePhoneInput" type="tel" placeholder="WhatsApp / Celular *" aria-label="Teléfono">
            <input id="quoteCompanyInput" placeholder="Empresa o Institución (Opcional)" aria-label="Empresa">
          </div>
          <div class="form-row">
            <select id="quoteServiceInput" aria-label="Servicio">
              <option value="Monitoreo Ambiental">Monitoreo Ambiental</option>
              <option value="Monitoreo Ocupacional">Monitoreo Ocupacional</option>
              <option value="Alquiler de Equipos">Alquiler de Equipos</option>
              <option value="Servicio Integral">Servicio Integral</option>
            </select>
            <input type="hidden" id="quoteTypeInput" value="Personalizada">
          </div>
          <textarea required id="quoteMsgInput" placeholder="Describe detalladamente los servicios solicitados, ubicación del proyecto o requerimientos específicos..." aria-label="Tu mensaje"></textarea>
          <button type="submit"><i data-lucide="send"></i> Solicitar Presupuesto Personalizado</button>
        </form>
      </section>
    </main>

    @include('partials.footer')
  </div>

  <script src="https://unpkg.com/lucide@0.468.0/dist/umd/lucide.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/lenis@1.1.18/dist/lenis.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/gsap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/ScrollTrigger.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/split-type@0.3.4/umd/index.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vanilla-tilt@1.8.1/dist/vanilla-tilt.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@tsparticles/slim@3/tsparticles.slim.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
  <script src="{{ asset('js/home.js') }}" defer></script>
  <script type="module" src="{{ asset('js/home-globe.js') }}"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const sToggle = document.getElementById('drawerServiciosToggle');
      const sMenu = document.getElementById('drawerServiciosSubmenu');
      const sChev = document.getElementById('drawerServiciosChevron');
      if (sToggle && sMenu) {
        sToggle.addEventListener('click', function() {
          const isOpen = sMenu.classList.toggle('is-open');
          if (sChev) sChev.style.transform = isOpen ? 'rotate(180deg)' : 'rotate(0deg)';
        });
      }

      const cToggle = document.getElementById('drawerCotizacionToggle');
      const cMenu = document.getElementById('drawerCotizacionSubmenu');
      const cChev = document.getElementById('drawerCotizacionChevron');
      if (cToggle && cMenu) {
        cToggle.addEventListener('click', function() {
          const isOpen = cMenu.classList.toggle('is-open');
          if (cChev) cChev.style.transform = isOpen ? 'rotate(180deg)' : 'rotate(0deg)';
        });
      }
    });
  </script>
</body>

</html>

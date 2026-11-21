(function() {
  'use strict';

  // 1. Initialize Lucide Icons
  if (window.lucide) {
    lucide.createIcons();
  }

  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const finePointer = window.matchMedia('(hover: hover) and (pointer: fine)').matches;

  // 2. Throttled Single-Delegate Pointermove for Spotlight Cards (60fps)
  if (!reduceMotion && finePointer) {
    let spotlightRaf = null;
    document.addEventListener('pointermove', function(e) {
      if (spotlightRaf) return;
      spotlightRaf = requestAnimationFrame(function() {
        spotlightRaf = null;
        const card = e.target.closest('.spotlight-card');
        if (card) {
          const rect = card.getBoundingClientRect();
          card.style.setProperty('--mx', (e.clientX - rect.left) + 'px');
          card.style.setProperty('--my', (e.clientY - rect.top) + 'px');
        }
      });
    }, { passive: true });

    // Initialize VanillaTilt with performance-friendly settings
    if (window.VanillaTilt) {
      VanillaTilt.init(document.querySelectorAll('.tilt-card'), {
        max: 6,
        speed: 600,
        glare: true,
        'max-glare': 0.16,
        scale: 1.015,
        gyroscope: false
      });
    }
  }

  // 3. Scroll Progress & Sticky Navigation Handler
  const progressBar = document.getElementById('scrollProgress');
  const mainNav = document.getElementById('mainNav');
  const navLinks = [...document.querySelectorAll('.navlinks a, .drawer-link')];
  let ticking = false;

  function updateScrollUI() {
    const scrollTop = window.scrollY;
    if (progressBar) {
      const maxScroll = Math.max(document.documentElement.scrollHeight - window.innerHeight, 1);
      const ratio = Math.min(Math.max(scrollTop / maxScroll, 0), 1);
      progressBar.style.transform = 'scaleX(' + ratio + ')';
    }
    if (mainNav) {
      if (scrollTop > 45) {
        if (!mainNav.classList.contains('is-sticky')) mainNav.classList.add('is-sticky');
      } else {
        if (mainNav.classList.contains('is-sticky')) mainNav.classList.remove('is-sticky');
      }
    }
    ticking = false;
  }

  // 4. Section Spy with IntersectionObserver (Zero layout thrashing)
  const trackedSections = ['#inicio', '#quienes-somos', '#contacto']
    .map(function(sel) { return document.querySelector(sel); }).filter(Boolean);

  if ('IntersectionObserver' in window && trackedSections.length) {
    const sectionObserver = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
        if (entry.isIntersecting) {
          const id = '#' + entry.target.id;
          navLinks.forEach(function(a) {
            a.classList.toggle('active', a.getAttribute('href') === id);
          });
        }
      });
    }, {
      rootMargin: '-20% 0px -55% 0px',
      threshold: 0
    });
    trackedSections.forEach(function(sec) { sectionObserver.observe(sec); });
  }

  // 5. GSAP + Lenis Smooth Scroll Integration (60fps)
  let lenisInstance = null;

  if (!reduceMotion && window.gsap && window.ScrollTrigger) {
    gsap.registerPlugin(ScrollTrigger);

    if (window.Lenis) {
      lenisInstance = new Lenis({
        duration: 1.1,
        easing: function(t) { return Math.min(1, 1.001 - Math.pow(2, -10 * t)); },
        smoothWheel: true,
        touchMultiplier: 1.5
      });

      lenisInstance.on('scroll', function() {
        ScrollTrigger.update();
        if (!ticking) {
          requestAnimationFrame(updateScrollUI);
          ticking = true;
        }
      });

      gsap.ticker.add(function(time) {
        lenisInstance.raf(time * 1000);
      });
      gsap.ticker.lagSmoothing(0);
    } else {
      window.addEventListener('scroll', function() {
        if (!ticking) {
          requestAnimationFrame(updateScrollUI);
          ticking = true;
        }
      }, { passive: true });
    }

    // Hero Entry Timeline
    const heroTl = gsap.timeline({ defaults: { ease: 'power3.out' } });
    heroTl
      .from('.nav .brand', { y: -18, autoAlpha: 0, duration: 0.65, clearProps: 'all' })
      .from('.navlinks a', { y: -14, autoAlpha: 0, duration: 0.5, stagger: 0.05, clearProps: 'all' }, '-=0.45')
      .from('.nav-actions > *', { scale: 0.88, autoAlpha: 0, duration: 0.55, stagger: 0.08, ease: 'back.out(1.6)', clearProps: 'all' }, '-=0.35')
      .from('.eyebrow', { y: 20, autoAlpha: 0, duration: 0.6, clearProps: 'all' }, '-=0.4')
      .from('.hero h1', { y: 34, autoAlpha: 0, duration: 0.8, clearProps: 'all' }, '-=0.42')
      .from('.hero p', { y: 24, autoAlpha: 0, duration: 0.7, clearProps: 'all' }, '-=0.55')
      .from('.hero-actions .btn', { y: 20, autoAlpha: 0, duration: 0.6, stagger: 0.12, clearProps: 'all' }, '-=0.5')
      .from('.hero-visual', { x: 42, scale: 0.96, autoAlpha: 0, duration: 0.95, clearProps: 'all' }, '-=0.75');

    // SplitType Headings Stagger
    if (window.SplitType) {
      document.querySelectorAll('.split-heading').forEach(function(heading) {
        const split = new SplitType(heading, { types: 'words' });
        if (split.words && split.words.length) {
          gsap.set(split.words, { autoAlpha: 0, y: 24 });
          ScrollTrigger.create({
            trigger: heading,
            start: 'top 92%',
            once: true,
            onEnter: function() {
              gsap.to(split.words, {
                autoAlpha: 1,
                y: 0,
                duration: 0.7,
                stagger: 0.04,
                ease: 'power3.out',
                clearProps: 'transform,opacity,visibility'
              });
            }
          });
        }
      });
    }

    // Scroll Batch Animations
    gsap.set('.anim-up', { autoAlpha: 0, y: 32 });
    gsap.set('.anim-left', { autoAlpha: 0, x: -36 });
    gsap.set('.anim-right', { autoAlpha: 0, x: 36 });
    gsap.set('.anim-card', { autoAlpha: 0, y: 36, scale: 0.94 });

    ScrollTrigger.batch('.anim-up', {
      start: 'top 92%',
      once: true,
      onEnter: function(batch) {
        gsap.to(batch, {
          autoAlpha: 1,
          y: 0,
          duration: 0.75,
          stagger: 0.08,
          ease: 'power3.out',
          clearProps: 'transform,opacity,visibility'
        });
      }
    });

    ScrollTrigger.batch('.anim-left', {
      start: 'top 92%',
      once: true,
      onEnter: function(batch) {
        gsap.to(batch, {
          autoAlpha: 1,
          x: 0,
          duration: 0.8,
          stagger: 0.1,
          ease: 'power3.out',
          clearProps: 'transform,opacity,visibility'
        });
      }
    });

    ScrollTrigger.batch('.anim-right', {
      start: 'top 92%',
      once: true,
      onEnter: function(batch) {
        gsap.to(batch, {
          autoAlpha: 1,
          x: 0,
          duration: 0.8,
          stagger: 0.1,
          ease: 'power3.out',
          clearProps: 'transform,opacity,visibility'
        });
      }
    });

    ScrollTrigger.batch('.anim-card', {
      start: 'top 92%',
      once: true,
      onEnter: function(batch) {
        gsap.to(batch, {
          autoAlpha: 1,
          y: 0,
          scale: 1,
          duration: 0.75,
          stagger: 0.09,
          ease: 'back.out(1.2)',
          clearProps: 'transform,opacity,visibility'
        });
      }
    });

    // Metric Counters
    ScrollTrigger.create({
      trigger: '#compromiso',
      start: 'top 85%',
      once: true,
      onEnter: function() {
        document.querySelectorAll('#compromiso [data-count]').forEach(function(el) {
          const target = Number(el.dataset.count || 0);
          const prefix = el.dataset.prefix || '';
          const suffix = el.dataset.suffix || '';
          const counter = { val: 0 };
          gsap.to(counter, {
            val: target,
            duration: 1.3,
            ease: 'power2.out',
            onUpdate: function() {
              el.textContent = prefix + Math.round(counter.val) + suffix;
            }
          });
        });
      }
    });

    window.addEventListener('load', function() { ScrollTrigger.refresh(); });
  } else {
    window.addEventListener('scroll', function() {
      if (!ticking) {
        requestAnimationFrame(updateScrollUI);
        ticking = true;
      }
    }, { passive: true });
  }

  updateScrollUI();

  // 6. tsParticles Background Optimization (Subtle, 60fps)
  if (!reduceMotion && window.loadSlim && window.tsParticles) {
    (async function() {
      try {
        await loadSlim(tsParticles);
        await tsParticles.load({
          id: 'commitParticles',
          options: {
            fullScreen: { enable: false },
            fpsLimit: 60,
            pauseOnBlur: true,
            background: { color: 'transparent' },
            interactivity: {
              events: {
                onHover: { enable: finePointer, mode: 'grab' }
              },
              modes: {
                grab: { distance: 110, links: { opacity: 0.35 } }
              }
            },
            particles: {
              number: { value: 26, density: { enable: true } },
              color: { value: ['#a4ed16', '#5be347', '#dfffe0'] },
              links: {
                enable: true,
                color: '#6ce34f',
                distance: 100,
                opacity: 0.18,
                width: 1
              },
              move: { enable: true, speed: 0.6, outModes: { default: 'out' } },
              opacity: { value: { min: 0.2, max: 0.6 } },
              size: { value: { min: 1.2, max: 2.8 } }
            },
            detectRetina: false
          }
        });
      } catch (err) {}
    })();
  }

  // 7. Navigation Drawer (Mobile)
  const navToggle = document.getElementById('navToggle');
  const navDrawer = document.getElementById('navDrawer');
  const navBackdrop = document.getElementById('navBackdrop');
  const navDrawerClose = document.getElementById('navDrawerClose');

  function openNavDrawer() {
    if (!navDrawer || !navBackdrop) return;
    navDrawer.classList.add('is-open');
    navBackdrop.classList.add('is-open');
    if (navToggle) {
      navToggle.classList.add('is-active');
      navToggle.setAttribute('aria-expanded', 'true');
    }
    navDrawer.setAttribute('aria-hidden', 'false');
    document.body.classList.add('menu-open');
  }

  function closeNavDrawer() {
    if (!navDrawer || !navBackdrop) return;
    navDrawer.classList.remove('is-open');
    navBackdrop.classList.remove('is-open');
    if (navToggle) {
      navToggle.classList.remove('is-active');
      navToggle.setAttribute('aria-expanded', 'false');
    }
    navDrawer.setAttribute('aria-hidden', 'true');
    document.body.classList.remove('menu-open');
  }

  if (navToggle) {
    navToggle.addEventListener('click', function() {
      const isOpen = navDrawer && navDrawer.classList.contains('is-open');
      isOpen ? closeNavDrawer() : openNavDrawer();
    });
  }
  if (navDrawerClose) navDrawerClose.addEventListener('click', closeNavDrawer);
  if (navBackdrop) navBackdrop.addEventListener('click', closeNavDrawer);
  window.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeNavDrawer();
  });

  // Smooth Anchor Clicking with Offset
  document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
    anchor.addEventListener('click', function(e) {
      const href = anchor.getAttribute('href');
      if (!href || href === '#') return;
      const targetEl = document.querySelector(href);
      if (targetEl) {
        closeNavDrawer();
        if (lenisInstance) {
          e.preventDefault();
          lenisInstance.scrollTo(targetEl, { offset: -78 });
        }
      }
    });
  });

  navLinks.forEach(function(link) {
    link.addEventListener('click', function() {
      navLinks.forEach(function(a) { a.classList.remove('active'); });
      link.classList.add('active');
    });
  });

  // 8. Quote Form & Mode Selector
  const quoteForm = document.getElementById('quoteForm');
  const quoteTypeInput = document.getElementById('quoteTypeInput');
  const quoteServiceInput = document.getElementById('quoteServiceInput');
  const quoteModeHint = document.getElementById('quoteModeHint');
  const modeDescriptions = {
    Referencial: 'Modo Referencial: estimación rápida lista para descargar.',
    Personalizada: 'Modo Personalizada: presupuesto técnico adaptado a tu proyecto y ubicación.'
  };

  function pulseForm() {
    if (!quoteForm) return;
    quoteForm.classList.remove('form-highlight');
    void quoteForm.offsetWidth;
    quoteForm.classList.add('form-highlight');
  }

  document.querySelectorAll('.quote-pill').forEach(function(btn) {
    btn.addEventListener('click', function() {
      document.querySelectorAll('.quote-pill').forEach(function(b) { b.classList.remove('active'); });
      btn.classList.add('active');
      const mode = btn.dataset.quoteType;
      if (quoteTypeInput) quoteTypeInput.value = mode;
      if (quoteModeHint) {
        const span = quoteModeHint.querySelector('span');
        if (span) span.textContent = modeDescriptions[mode] || '';
      }
      pulseForm();
    });
  });

  document.querySelectorAll('[data-quote-service]').forEach(function(link) {
    link.addEventListener('click', function() {
      if (quoteServiceInput) quoteServiceInput.value = link.dataset.quoteService;
      pulseForm();
    });
  });

  if (quoteForm) {
    quoteForm.addEventListener('submit', function(event) {
      event.preventDefault();
      const type = quoteTypeInput ? quoteTypeInput.value : 'Referencial';
      const service = quoteServiceInput ? quoteServiceInput.value : 'Monitoreo Ambiental';
      if (window.Swal) {
        Swal.fire({
          icon: 'success',
          title: '¡Solicitud lista!',
          html: 'Tu cotización <b>' + type + '</b> para <b>' + service + '</b> está lista para enviarse.',
          confirmButtonText: 'Entendido',
          confirmButtonColor: '#168d08'
        });
      } else {
        alert('¡Gracias! Tu solicitud de cotización (' + type + ' - ' + service + ') está lista para enviarse.');
      }
    });
  }
})();
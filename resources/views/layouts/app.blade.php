<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#168d08">
  <title>@yield('title', 'PachaLab | Especialistas en Monitoreo Ambiental y Ocupacional')</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
  <link rel="stylesheet" href="{{ asset('css/pachalab-pages.css') }}">
  @stack('styles')
</head>

<body>
  <div class="scroll-progress" id="scrollProgress" aria-hidden="true"></div>
  <div class="page">
    <header class="subpage-nav-header">
      @include('partials.navbar')
    </header>

    <main>
      @yield('content')
    </main>

    @include('partials.footer')
  </div>

  <script src="https://unpkg.com/lucide@0.468.0/dist/umd/lucide.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/lenis@1.1.18/dist/lenis.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/gsap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/ScrollTrigger.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/split-type@0.3.4/umd/index.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vanilla-tilt@1.8.1/dist/vanilla-tilt.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
  <script src="{{ asset('js/home.js') }}"></script>

  <script>
    // Submenu toggles in mobile drawer
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

      // Accordion for FAQs
      document.querySelectorAll('.faq-question').forEach(function(btn) {
        btn.addEventListener('click', function() {
          const item = this.closest('.faq-item');
          if (item) item.classList.toggle('is-open');
        });
      });
    });
  </script>

  @stack('scripts')
</body>

</html>

<div class="nav-wrapper">
  <nav class="nav" id="mainNav">
    <a class="brand" href="{{ route('home') }}">
      <span class="brand-mark"><i data-lucide="leaf"></i></span>
      <span>Pacha<span>Lab</span><small>Soluciones que cuidan tu entorno</small></span>
    </a>

    <div class="navlinks" id="navLinks">
      <a class="{{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
        <i data-lucide="home"></i><span>Inicio</span>
      </a>

      <a href="{{ route('home') }}#quienes-somos">
        <i data-lucide="shield-check"></i><span>Quiénes Somos</span>
      </a>

      <!-- MENÚ DESPLEGABLE SERVICIOS -->
      <div class="nav-dropdown-item">
        <button type="button" class="nav-dropdown-trigger {{ request()->is('monitoreo-*') || request()->is('venta-y-alquiler*') ? 'active' : '' }}">
          <i data-lucide="layers"></i>
          <span>Servicios</span>
          <i data-lucide="chevron-down" class="chevron-icon"></i>
        </button>
        <div class="nav-dropdown-menu">
          <a class="nav-dropdown-link" href="{{ route('servicios.ambiental') }}">
            <span class="nav-dropdown-icon"><i data-lucide="trees"></i></span>
            <span class="nav-dropdown-text">
              <strong>Monitoreo Ambiental</strong>
              <small>Calidad de aire, agua, ruido y emisiones</small>
            </span>
          </a>
          <a class="nav-dropdown-link" href="{{ route('servicios.ocupacional') }}">
            <span class="nav-dropdown-icon"><i data-lucide="hard-hat"></i></span>
            <span class="nav-dropdown-text">
              <strong>Monitoreo Ocupacional</strong>
              <small>Agentes físicos, químicos y ergonomía SST</small>
            </span>
          </a>
          <a class="nav-dropdown-link" href="{{ route('servicios.equipos') }}">
            <span class="nav-dropdown-icon"><i data-lucide="gauge"></i></span>
            <span class="nav-dropdown-text">
              <strong>Venta y Alquiler de Equipos</strong>
              <small>Instrumentos certificados y calibrados</small>
            </span>
          </a>
        </div>
      </div>

      <!-- APARTADO ESPECIAL DE COTIZACIÓN -->
      <div class="nav-dropdown-item">
        <button type="button" class="nav-dropdown-trigger {{ request()->is('cotiz*') ? 'active' : '' }}">
          <i data-lucide="calculator"></i>
          <span>Cotización</span>
          <i data-lucide="chevron-down" class="chevron-icon"></i>
        </button>
        <div class="nav-dropdown-menu">
          <a class="nav-dropdown-link" href="{{ route('cotizar.ahora') }}">
            <span class="nav-dropdown-icon" style="background: rgba(164, 237, 22, 0.2); color: #095b12;">
              <i data-lucide="send"></i>
            </span>
            <span class="nav-dropdown-text">
              <strong>Cotizar Ahora</strong>
              <small>Formulario general y atención directa</small>
            </span>
          </a>

          <div class="nav-dropdown-divider"></div>

          <a class="nav-dropdown-link" href="{{ route('cotizar.ambiental') }}">
            <span class="nav-dropdown-icon"><i data-lucide="file-text"></i></span>
            <span class="nav-dropdown-text">
              <strong>Cotizador Ambiental Online</strong>
              <small>Presupuesto referencial con descarga en PDF</small>
            </span>
          </a>

          <a class="nav-dropdown-link" href="{{ route('cotizar.ocupacional') }}">
            <span class="nav-dropdown-icon"><i data-lucide="file-check"></i></span>
            <span class="nav-dropdown-text">
              <strong>Cotizador Ocupacional Online</strong>
              <small>Cálculo de agentes SST con PDF</small>
            </span>
          </a>

          <a class="nav-dropdown-link" href="{{ route('cotizar.equipos') }}">
            <span class="nav-dropdown-icon"><i data-lucide="wrench"></i></span>
            <span class="nav-dropdown-text">
              <strong>Cotizador Equipos Online</strong>
              <small>Tarifas por día con descarga en PDF</small>
            </span>
          </a>
        </div>
      </div>

      <a href="{{ route('home') }}#contacto">
        <i data-lucide="phone"></i><span>Contactos</span>
      </a>
    </div>

    <div class="nav-actions">
      <a class="btn btn-green nav-cta" href="{{ route('cotizar.ahora') }}">
        <i data-lucide="calculator"></i>
        <span>Cotizar ahora</span>
        <i data-lucide="arrow-right"></i>
      </a>
      <button type="button" class="nav-toggle" id="navToggle" aria-label="Abrir menú de navegación" aria-expanded="false" aria-controls="navDrawer">
        <span class="nav-toggle-bar"></span>
        <span class="nav-toggle-bar"></span>
        <span class="nav-toggle-bar"></span>
      </button>
    </div>
  </nav>
</div>

<!-- MOBILE NAVIGATION DRAWER & BACKDROP -->
<div class="nav-backdrop" id="navBackdrop" aria-hidden="true"></div>
<aside class="nav-drawer" id="navDrawer" aria-label="Menú móvil" aria-hidden="true">
  <div class="nav-drawer-header">
    <a class="brand" href="{{ route('home') }}">
      <span class="brand-mark"><i data-lucide="leaf"></i></span>
      <span>Pacha<span>Lab</span><small>Menú principal</small></span>
    </a>
    <button type="button" class="nav-drawer-close" id="navDrawerClose" aria-label="Cerrar menú">
      <i data-lucide="x"></i>
    </button>
  </div>

  <div class="nav-drawer-links">
    <a class="drawer-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
      <span class="drawer-link-icon"><i data-lucide="home"></i></span>
      <span class="drawer-link-text">
        <strong>Inicio</strong>
        <small>Portada principal</small>
      </span>
      <i data-lucide="chevron-right" class="drawer-chevron"></i>
    </a>

    <a class="drawer-link" href="{{ route('home') }}#quienes-somos">
      <span class="drawer-link-icon"><i data-lucide="shield-check"></i></span>
      <span class="drawer-link-text">
        <strong>Quiénes Somos</strong>
        <small>PACHABOL SRL y acreditaciones</small>
      </span>
      <i data-lucide="chevron-right" class="drawer-chevron"></i>
    </a>

    <!-- SERVICIOS MÓVIL CON ACORDEÓN -->
    <button type="button" class="drawer-accordion-btn" id="drawerServiciosToggle">
      <span style="display: flex; align-items: center; gap: 12px;">
        <span class="drawer-link-icon"><i data-lucide="layers"></i></span>
        <span style="text-align: left;">
          <strong>Servicios</strong><br>
          <small style="color: var(--muted); font-size: 0.75rem;">Nuestras áreas especializadas</small>
        </span>
      </span>
      <i data-lucide="chevron-down" id="drawerServiciosChevron"></i>
    </button>
    <div class="drawer-submenu" id="drawerServiciosSubmenu">
      <a class="drawer-sublink" href="{{ route('servicios.ambiental') }}">
        <i data-lucide="trees"></i> Monitoreo Ambiental
      </a>
      <a class="drawer-sublink" href="{{ route('servicios.ocupacional') }}">
        <i data-lucide="hard-hat"></i> Monitoreo Ocupacional
      </a>
      <a class="drawer-sublink" href="{{ route('servicios.equipos') }}">
        <i data-lucide="gauge"></i> Venta y Alquiler de Equipos
      </a>
    </div>

    <!-- APARTADO DE COTIZACIÓN MÓVIL CON ACORDEÓN -->
    <button type="button" class="drawer-accordion-btn" id="drawerCotizacionToggle" style="background: rgba(22, 141, 8, 0.05);">
      <span style="display: flex; align-items: center; gap: 12px;">
        <span class="drawer-link-icon" style="color: var(--green);"><i data-lucide="calculator"></i></span>
        <span style="text-align: left;">
          <strong style="color: var(--green-dark);">Cotización</strong><br>
          <small style="color: var(--muted); font-size: 0.75rem;">Formulario y cotizadores online</small>
        </span>
      </span>
      <i data-lucide="chevron-down" id="drawerCotizacionChevron"></i>
    </button>
    <div class="drawer-submenu is-open" id="drawerCotizacionSubmenu">
      <a class="drawer-sublink {{ request()->routeIs('cotizar.ahora') ? 'active' : '' }}" href="{{ route('cotizar.ahora') }}">
        <i data-lucide="send"></i> Cotizar Ahora (General)
      </a>
      <a class="drawer-sublink {{ request()->routeIs('cotizar.ambiental') ? 'active' : '' }}" href="{{ route('cotizar.ambiental') }}">
        <i data-lucide="file-text"></i> Monitoreo Ambiental (PDF)
      </a>
      <a class="drawer-sublink {{ request()->routeIs('cotizar.ocupacional') ? 'active' : '' }}" href="{{ route('cotizar.ocupacional') }}">
        <i data-lucide="file-check"></i> Monitoreo Ocupacional (PDF)
      </a>
      <a class="drawer-sublink {{ request()->routeIs('cotizar.equipos') ? 'active' : '' }}" href="{{ route('cotizar.equipos') }}">
        <i data-lucide="wrench"></i> Venta y Alquiler Equipos (PDF)
      </a>
    </div>

    <a class="drawer-link" href="{{ route('home') }}#contacto">
      <span class="drawer-link-icon"><i data-lucide="phone"></i></span>
      <span class="drawer-link-text">
        <strong>Contactos</strong>
        <small>Atención técnica y cotizaciones</small>
      </span>
      <i data-lucide="chevron-right" class="drawer-chevron"></i>
    </a>
  </div>

  <div class="nav-drawer-footer">
    <a class="btn btn-green w-full" href="{{ route('cotizar.ahora') }}">
      <i data-lucide="calculator"></i>
      <span>Cotizar ahora</span>
      <i data-lucide="arrow-right"></i>
    </a>
    <div class="nav-drawer-contact">
      <a href="https://wa.link/3lf4u6" target="_blank" rel="noopener">
        <i data-lucide="message-square"></i> WhatsApp: 76358189
      </a>
      <a href="mailto:laboratorio@pachabol.com">
        <i data-lucide="mail"></i> laboratorio@pachabol.com
      </a>
    </div>
  </div>
</aside>

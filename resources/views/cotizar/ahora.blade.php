@extends('layouts.app')

@section('title', 'Cotizar Ahora | PachaLab Bolivia')

@section('content')
<!-- SUBPAGE HERO -->
<section class="subpage-hero">
  <div class="subpage-hero-inner">
    <nav class="breadcrumb-nav" aria-label="Breadcrumb">
      <a href="{{ route('home') }}"><i data-lucide="home"></i> Inicio</a>
      <span>/</span>
      <a href="{{ route('home') }}#cotizar">Cotización</a>
      <span>/</span>
      <span class="current">Cotizar Ahora</span>
    </nav>
    <div class="hero-pill-badge">
      <i data-lucide="calculator"></i> Formulario General de Cotización
    </div>
    <h1>Cotizar <span>Ahora</span></h1>
    <p class="lead">
      Cuéntanos los requerimientos de tu empresa o proyecto. Completa los datos a continuación y nos pondremos en contacto
      de inmediato con una propuesta técnica y económica adaptada a tus necesidades.
    </p>
  </div>
</section>

<!-- MAIN CONTENT -->
<section class="quote-page-container">
  <div class="general-quote-wrap">
    <!-- FORMULARIO GENERAL -->
    <div class="quote-calculator-card">
      <div class="calc-section-title">
        <i data-lucide="mail"></i>
        <span>Datos del Requerimiento</span>
      </div>

      <form id="generalQuoteForm" onsubmit="return handleGeneralQuote(event)">
        <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
          <div class="quote-input-group">
            <label for="first_name">Nombre <span class="req">*</span></label>
            <input type="text" id="first_name" name="first_name" placeholder="Ej. Carlos" required>
          </div>
          <div class="quote-input-group">
            <label for="last_name">Apellido <span class="req">*</span></label>
            <input type="text" id="last_name" name="last_name" placeholder="Ej. Mendoza" required>
          </div>
        </div>

        <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
          <div class="quote-input-group">
            <label for="correo">Correo Electrónico <span class="req">*</span></label>
            <input type="email" id="correo" name="correo" placeholder="ejemplo@empresa.com" required>
          </div>
          <div class="quote-input-group">
            <label for="whatsapp">WhatsApp / Teléfono <span class="req">*</span></label>
            <input type="tel" id="whatsapp" name="whatsapp" placeholder="Ej. 76358189" pattern="[0-9]{8}" title="Debe contener 8 dígitos numéricos" required>
          </div>
        </div>

        <div class="quote-input-group" style="margin-bottom: 16px;">
          <label for="empresa">Empresa o Institución <small style="color: var(--muted);">(Opcional)</small></label>
          <input type="text" id="empresa" name="empresa" placeholder="Nombre de la empresa o consultora">
        </div>

        <div class="quote-input-group" style="margin-bottom: 16px;">
          <label for="servicio">Servicio Solicitado <span class="req">*</span></label>
          <select id="servicio" name="servicio" required>
            <option value="Monitoreo Ambiental">Monitoreo Ambiental (Aire, Agua, Ruido, Gases)</option>
            <option value="Monitoreo Ocupacional">Monitoreo Ocupacional (Iluminación, Ruido SST, Ergonomía)</option>
            <option value="Alquiler de Equipos">Alquiler de Equipos Certificados</option>
            <option value="Estudio Integral de Seguridad y Medio Ambiente">Estudio Integral de Seguridad y Medio Ambiente</option>
          </select>
        </div>

        <div class="quote-input-group" style="margin-bottom: 24px;">
          <label for="detalles">Detalles del Servicio o Parámetros Requeridos <span class="req">*</span></label>
          <textarea id="detalles" name="detalles" rows="4" placeholder="Describe brevemente el alcance: número de puntos, ubicación geográfica, tipo de industria o fechas tentativas..." required></textarea>
        </div>

        <button type="submit" class="btn btn-green w-full" style="justify-content: center; padding: 15px 24px; font-size: 1rem;">
          <i data-lucide="send"></i>
          <span>Enviar Solicitud por WhatsApp</span>
          <i data-lucide="arrow-right"></i>
        </button>
      </form>
    </div>

    <!-- SIDEBAR: COTIZADORES ONLINE PERSONALIZADOS CON PDF -->
    <div style="display: flex; flex-direction: column; gap: 24px;">
      <div class="quote-sidebar-card">
        <span class="hero-pill-badge" style="background: rgba(164, 237, 22, 0.2); color: var(--lime); border-color: rgba(164, 237, 22, 0.3);">
          <i data-lucide="zap"></i> ¿Prefieres una cotización inmediata?
        </span>
        <h3>Cotizadores Online con Descarga de PDF</h3>
        <p>
          Si conoces los parámetros específicos o necesitas un presupuesto referencial oficial en formato PDF para presentar a gerencia,
          utiliza nuestros cotizadores interactivos personalizados:
        </p>

        <div class="quote-sidebar-links">
          <a class="quote-sidebar-btn" href="{{ route('cotizar.ambiental') }}">
            <span style="display: flex; align-items: center; gap: 10px;">
              <i data-lucide="trees" style="color: var(--lime);"></i>
              <span>Cotizador Monitoreo Ambiental</span>
            </span>
            <i data-lucide="arrow-right"></i>
          </a>

          <a class="quote-sidebar-btn" href="{{ route('cotizar.ocupacional') }}">
            <span style="display: flex; align-items: center; gap: 10px;">
              <i data-lucide="hard-hat" style="color: var(--lime);"></i>
              <span>Cotizador Monitoreo Ocupacional</span>
            </span>
            <i data-lucide="arrow-right"></i>
          </a>

          <a class="quote-sidebar-btn" href="{{ route('cotizar.equipos') }}">
            <span style="display: flex; align-items: center; gap: 10px;">
              <i data-lucide="gauge" style="color: var(--lime);"></i>
              <span>Cotizador Alquiler de Equipos</span>
            </span>
            <i data-lucide="arrow-right"></i>
          </a>
        </div>
      </div>

      <!-- TARJETA CONTACTO DIRECTO -->
      <div style="background: #ffffff; border: 1px solid var(--line); border-radius: 20px; padding: 26px; box-shadow: 0 4px 18px rgba(0,0,0,0.04);">
        <h4 style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.15rem; font-weight: 800; color: var(--dark); margin: 0 0 12px;">
          ¿Tienes una licitación o pliego técnico?
        </h4>
        <p style="font-size: 0.88rem; color: var(--muted); line-height: 1.5; margin-bottom: 16px;">
          Envíanos tus especificaciones y términos de referencia (TDR) directamente a nuestro correo institucional para una propuesta a medida.
        </p>
        <a href="mailto:laboratorio@pachabol.com" style="display: flex; align-items: center; gap: 8px; font-weight: 700; color: var(--green); text-decoration: none;">
          <i data-lucide="mail"></i> laboratorio@pachabol.com
        </a>
      </div>
    </div>
  </div>
</section>
@endsection

@push('scripts')
<script>
  function handleGeneralQuote(e) {
    e.preventDefault();
    const firstName = document.getElementById("first_name").value.trim();
    const lastName = document.getElementById("last_name").value.trim();
    const correo = document.getElementById("correo").value.trim();
    const whatsapp = document.getElementById("whatsapp").value.trim();
    const empresa = document.getElementById("empresa").value.trim() || "No especificada";
    const servicio = document.getElementById("servicio").value;
    const detalles = document.getElementById("detalles").value.trim();

    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!emailPattern.test(correo)) {
      Swal.fire({ icon: 'warning', title: 'Correo inválido', text: 'Por favor, ingresa un correo electrónico válido.' });
      return false;
    }

    const whatsappPattern = /^[0-9]{8}$/;
    if (!whatsappPattern.test(whatsapp)) {
      Swal.fire({ icon: 'warning', title: 'Número inválido', text: 'Por favor, introduce un número de WhatsApp boliviano de 8 dígitos.' });
      return false;
    }

    const textoMensaje = `*COTIZACIÓN GENERAL DE SERVICIOS*\n\n` +
      `*Nombre:* ${firstName} ${lastName}\n` +
      `*Correo:* ${correo}\n` +
      `*Celular:* ${whatsapp}\n` +
      `*Empresa:* ${empresa}\n\n` +
      `*Servicio Solicitado:* ${servicio}\n\n` +
      `*Detalles del Requerimiento:*\n${detalles}`;

    const isMobile = /iPhone|Android|iPad/i.test(navigator.userAgent);
    const baseUrl = isMobile ? "https://api.whatsapp.com/send?phone=" : "https://web.whatsapp.com/send?phone=";
    const whatsappUrl = `${baseUrl}59176358189&text=${encodeURIComponent(textoMensaje)}`;

    // Enviar notificación por correo desde notificaciones@pachabol.com
    fetch('/api/cotizaciones/enviar', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
      body: JSON.stringify({
        cliente_nombre: `${firstName} ${lastName}`,
        cliente_email: correo,
        cliente_telefono: whatsapp,
        cliente_empresa: empresa,
        tipo_cotizacion: servicio,
        detalles: detalles,
        total: 'A convenir según requerimiento'
      })
    }).catch(err => console.warn('Notificación por correo:', err));

    Swal.fire({
      icon: 'success',
      title: '¡Solicitud Registrada!',
      html: `<p>Se ha enviado un correo de confirmación a <strong>${correo}</strong>.</p>
             <p style="font-size:0.9rem; color:#4a686b; margin-top:8px;">Ahora se abrirá WhatsApp para coordinar directamente con nuestro equipo técnico.</p>`,
      confirmButtonColor: '#168d08',
      confirmButtonText: '<i data-lucide="message-square"></i> Abrir WhatsApp'
    }).then(() => {
      window.open(whatsappUrl, '_blank');
    });

    return false;
  }
</script>
@endpush

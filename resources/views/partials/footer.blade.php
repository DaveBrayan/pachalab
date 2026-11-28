<footer class="footer">
  <div class="footer-grid anim-up">
    <div class="footer-brand">
      <a class="brand" href="{{ route('home') }}">
        <span class="brand-mark"><i data-lucide="leaf"></i></span>
        <span>Pacha<span>Lab</span><small>PACHABOL SRL</small></span>
      </a>
      <p>{{ $cms['footer_desc'] ?? 'La seguridad de tus proyectos comienza con datos confiables. Confía en PachaLab para obtener resultados precisos y confiables, asegurando el cumplimiento normativo nacional e internacional.' }}</p>
    </div>
    <div>
      <h4>Menú y Servicios</h4>
      <div class="footer-menu">
        <a href="{{ route('home') }}">Inicio</a>
        <a href="{{ route('home') }}#quienes-somos">Quiénes Somos</a>
        <a href="{{ route('servicios.ambiental') }}">Monitoreo Ambiental</a>
        <a href="{{ route('servicios.ocupacional') }}">Monitoreo Ocupacional</a>
        <a href="{{ route('servicios.equipos') }}">Alquiler de Equipos</a>
        <a href="{{ route('home') }}#contacto">Contactos</a>
      </div>
    </div>
    <div>
      <h4>Cotizaciones Online</h4>
      <div class="footer-menu">
        <a href="{{ route('cotizar.ahora') }}">Cotizar Ahora (General)</a>
        <a href="{{ route('cotizar.ambiental') }}">Cotizador Ambiental (PDF)</a>
        <a href="{{ route('cotizar.ocupacional') }}">Cotizador Ocupacional (PDF)</a>
        <a href="{{ route('cotizar.equipos') }}">Cotizador Alquiler de Equipos (PDF)</a>
      </div>
    </div>
    <div>
      <h4>Contáctanos</h4>
      <div class="footer-contact">
        <a href="mailto:{{ $cms['contact_email'] ?? 'laboratorio@pachabol.com' }}"><i data-lucide="mail"></i> {{ $cms['contact_email'] ?? 'laboratorio@pachabol.com' }}</a>
        <a href="{{ $cms['contact_wa_link'] ?? 'https://wa.link/3lf4u6' }}" target="_blank" rel="noopener"><i data-lucide="phone"></i> {{ $cms['contact_wa'] ?? '76358189 (WhatsApp)' }}</a>
        <a href="https://www.facebook.com/pachaconsultingbolivia" target="_blank" rel="noopener"><i data-lucide="share-2"></i> {{ $cms['contact_fb'] ?? 'Facebook · Pacha Consulting' }}</a>
        <span style="font-size: 0.85rem; color: #a5b9b3; margin-top: 6px; display: block;">
          {{ $cms['contact_address'] ?? 'Av. Raúl Salmón #26, Edif. Victoria, P. Baja Of. 7 · La Paz - Bolivia' }}
        </span>
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <span>{{ $cms['footer_copy'] ?? '© ' . date('Y') . ' PachaLab — PACHABOL SRL. Todos los derechos reservados.' }}</span>
    <span>{{ $cms['footer_subline'] ?? 'Monitoreo Ambiental · Monitoreo Ocupacional · Alquiler de Equipos' }}</span>
  </div>
</footer>

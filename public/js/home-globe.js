import createGlobe from 'https://cdn.jsdelivr.net/npm/cobe@2.0.1/+esm';

(function() {
  'use strict';
  const canvas = document.getElementById('commitGlobe');
  if (!canvas) return;

  const globeReduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  let phi = 4.55;
  const theta = 0.24;
  let pointerInteracting = null;
  let pointerOffset = 0;
  let width = Math.max(canvas.clientWidth || 260, 220);
  let isGlobeVisible = false;
  let globeRafId = null;

  let globe = null;
  try {
    globe = createGlobe(canvas, {
      devicePixelRatio: Math.min(window.devicePixelRatio || 1, 2),
      width: width,
      height: width,
      phi: phi,
      theta: theta,
      dark: 1,
      diffuse: 1.5,
      scale: 1.05,
      mapSamples: 12000,
      mapBrightness: 7,
      mapBaseBrightness: 0.08,
      baseColor: [0.09, 0.36, 0.16],
      markerColor: [0.68, 0.96, 0.12],
      glowColor: [0.16, 0.68, 0.22],
      arcColor: [0.64, 0.94, 0.14],
      arcWidth: 0.55,
      arcHeight: 0.26,
      markers: [
        { location: [-16.4897, -68.1193], size: 0.085 },
        { location: [-17.7833, -63.1821], size: 0.095 },
        { location: [-17.3935, -66.1570], size: 0.08 },
        { location: [-21.5355, -64.7296], size: 0.065 },
        { location: [-19.5836, -65.7531], size: 0.065 }
      ],
      arcs: [
        { from: [-16.4897, -68.1193], to: [-17.7833, -63.1821] },
        { from: [-17.3935, -66.1570], to: [-17.7833, -63.1821] },
        { from: [-16.4897, -68.1193], to: [-21.5355, -64.7296] },
        { from: [-17.7833, -63.1821], to: [-12.0464, -77.0428] }
      ]
    });
  } catch (err) {
    return;
  }

  canvas.addEventListener('pointerdown', function(e) {
    pointerInteracting = e.clientX - pointerOffset;
    canvas.style.cursor = 'grabbing';
  });
  window.addEventListener('pointerup', function() {
    pointerInteracting = null;
    canvas.style.cursor = 'grab';
  });
  window.addEventListener('pointermove', function(e) {
    if (pointerInteracting !== null) {
      pointerOffset = e.clientX - pointerInteracting;
    }
  });

  if (window.ResizeObserver) {
    const ro = new ResizeObserver(function() {
      const w = Math.max(canvas.clientWidth || 260, 220);
      if (Math.abs(w - width) > 4 && globe) {
        width = w;
        globe.update({ width: w, height: w });
      }
    });
    ro.observe(canvas);
  }

  // 60FPS Optimization: Only animate when visible in viewport
  function animateGlobe() {
    if (!isGlobeVisible) {
      globeRafId = null;
      return;
    }
    if (!globeReduceMotion && pointerInteracting === null) {
      phi += 0.0045;
    }
    if (globe) {
      globe.update({ phi: phi + pointerOffset * 0.008, theta: theta });
    }
    globeRafId = requestAnimationFrame(animateGlobe);
  }

  if ('IntersectionObserver' in window) {
    const globeObserver = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
        isGlobeVisible = entry.isIntersecting;
        if (isGlobeVisible && !globeRafId) {
          globeRafId = requestAnimationFrame(animateGlobe);
        } else if (!isGlobeVisible && globeRafId) {
          cancelAnimationFrame(globeRafId);
          globeRafId = null;
        }
      });
    }, { rootMargin: '120px' });
    globeObserver.observe(canvas);
  } else {
    isGlobeVisible = true;
    globeRafId = requestAnimationFrame(animateGlobe);
  }
})();
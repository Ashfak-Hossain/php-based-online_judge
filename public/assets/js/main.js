document.addEventListener('DOMContentLoaded', () => {
  const baseMeta = document.querySelector('meta[name="base-url"]');
  const BASE = baseMeta ? baseMeta.content : '';

  if (window.lucide && typeof lucide.createIcons === 'function') {
    try {
      lucide.createIcons();
    } catch (e) {
      console.error('Error initializing lucide icons:', e);
    }
  }

  if (document.querySelector("form[data-module='problem-create']")) {
    import((BASE || '') + '/assets/js/pages/problem-create.js')
      .then((module) => {
        if (module && typeof module.init === 'function') {
          module.init();
        }
      })
      .catch((err) => {
        console.error('Error loading problem-create module:', err);
      });
  }
});

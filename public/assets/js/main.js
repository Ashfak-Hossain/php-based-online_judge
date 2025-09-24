document.addEventListener('DOMContentLoaded', async () => {
  const baseMetaTag = document.querySelector('meta[name="base-url"]');
  const baseUrl = baseMetaTag ? baseMetaTag.content : '';

  //! debug
  console.log('Document ready. Initializing modules...');

  if (window.lucide && typeof window.lucide.createIcons === 'function') {
    try {
      window.lucide.createIcons();
    } catch (e) {
      console.error('Error initializing lucide icons:', e);
    }
  }

  const problemCreateForm = document.querySelector("form[data-module='problem-create']");
  if (problemCreateForm) {
    try {
      const module = await import((baseUrl || '') + '/assets/js/pages/problem-create.js');
      if (typeof module.init === 'function') {
        module.init();
      } else {
        console.error('[problem-create] Module loaded but missing init() function.');
      }
    } catch (error) {
      console.error('[problem-create] Failed to load module:', error);
    }
  }
});

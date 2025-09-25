document.addEventListener('DOMContentLoaded', async () => {
  const baseUrl = document.querySelector('meta[name="base-url"]')?.content || '';

  //! debug
  console.log('Document ready. Initializing modules...');

  if (window.lucide && typeof window.lucide.createIcons === 'function') {
    try {
      window.lucide.createIcons();
    } catch (e) {
      console.error('Error initializing lucide icons:', e);
    }
  }

  try {
    const createProblemModule = await import(
      (baseUrl || '') + '/assets/js/pages/problem-create.js'
    );
    const deleteProblemModule = await import(
      (baseUrl || '') + '/assets/js/pages/problem-delete.js'
    );

    deleteProblemModule.init();
    createProblemModule.init();
  } catch (error) {
    console.error('[problem-create] Failed to load module:', error);
  }
});

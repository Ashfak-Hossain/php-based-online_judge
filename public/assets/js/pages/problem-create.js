import { postForm } from '../helpers/ajax.js';
import { showToast } from '../helpers/toast.js';

export function init() {
  const form = document.querySelector("form[data-module = 'problem-create']");
  if (!form) return;

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const submitBtn = form.querySelector('button[type="submit"]');
    submitBtn.disabled = true;

    try {
      const baseMeta = document.querySelector("meta[name='base-url']");
      const base = baseMeta ? baseMeta.content : '';
      const action = form.getAttribute('action') || base + '/admin/problems/create';

      const res = await postForm(action, form);

      if (res.ok && res.data && res.data.success) {
        showToast(res.data.message || 'Problem created successfully', 'success');
        form.reset();
      } else {
        const msg = res.data && res.data.message ? res.data.message : 'Failed to create problem';
        showToast(msg, 'error');
      }
    } catch (error) {
      console.error(error);
      showToast(error.message || 'Network error', 'error');
    } finally {
      submitBtn.disabled = false;
    }
  });
}

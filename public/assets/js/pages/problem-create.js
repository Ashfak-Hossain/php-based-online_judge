import { postForm } from '../helpers/ajax.js';
import { showToast } from '../helpers/toast.js';

export function init() {
  const form = document.querySelector('form[data-module="problem-create"]');
  if (!form) {
    console.warn('Problem form not found');
    return;
  }

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const submitBtn = form.querySelector('button[type="submit"]');
    submitBtn.disabled = true;

    try {
      const baseMeta = document.querySelector("meta[name='base-url']");
      const base = baseMeta ? baseMeta.content : '';
      const action = form.getAttribute('action') || base + '/admin/problems/create';

      const res = await postForm(action, form);
      console.log(res);

      if (res.ok && res.data && res.data.success) {
        showToast(res.data.message || 'Problem created successfully', 'success');
        form.reset();
      } else {
        if (res.data && res.data.errors) {
          form.querySelectorAll('.error-text').forEach((el) => el.remove());
          for (const [field, message] of Object.entries(res.data.errors)) {
            const input = form.querySelector(`[name="${field}"]`);
            if (input) {
              let errorEl = input.nextElementSibling;
              if (!errorEl || !errorEl.classList.contains('error-text')) {
                errorEl = document.createElement('p');
                errorEl.className = 'error-text text-red-500 text-xs mt-1';
                input.insertAdjacentElement('afterend', errorEl);
              }
              errorEl.textContent = message;
            }
          }
          showToast('Please fix the highlighted errors and try again.', 'error');
        } else {
          showToast(
            res.data && res.data.message ? res.data.message : 'Failed to create problem',
            'error'
          );
        }
      }
    } catch (error) {
      console.error(error);
      showToast(error.message || 'Network error', 'error');
    } finally {
      submitBtn.disabled = false;
    }
  });
}

// {
//     "ok": true,
//     "status": 200,
//     "data": {
//         "success": true,
//         "message": "Problem created successfully",
//         "problemId": "25",
//         "errors": {}
//     }
// }

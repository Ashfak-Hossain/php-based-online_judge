import { showToast } from '../helpers/toast.js';

export function init() {
  document.querySelectorAll('.delete-btn').forEach((btn) => {
    btn.addEventListener('click', async (e) => {
      e.preventDefault();
      if (!confirm('Are you sure you want to delete this problem? This action cannot be undone.'))
        return;
      xw;
      const problemId = btn.dataset.id;
      try {
        const base = document.querySelector("meta[name='base-url']").content || '';

        const res = await fetch(`${base}/admin/problems/delete/${problemId}`, {
          method: 'POST',
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-Token': document.querySelector("meta[name='csrf-token']").content,
          },
        });
        const data = await res.json();
        if (data.success) {
          showToast('Problem deleted successfully', 'success');
          btn.closest('tr').remove();
        } else {
          showToast('Error deleting problem: ' + data.message);
        }
      } catch (error) {
        showToast('Error deleting problem: ' + error.message);
        console.error('Error deleting problem:', error);
      }
    });
  });
}

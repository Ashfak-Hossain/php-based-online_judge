export function initProblemSubmit() {
  const form = document.getElementById('problem-submit-form');
  if (!form) return;

  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const code = form.querySelector('#code').value.trim();
    const language = form.querySelector('#language').value;
    const problemId = form.dataset.problemId;

    if (!code) {
      showToast('error', 'Please enter your code before submitting.');
      return;
    }

    try {
      const res = await fetch(`${BASE_URL}/problems/${problemId}/submit`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-Token': document.querySelector("meta[name='csrf-token']").content,
        },
        body: JSON.stringify({ code, language }),
      });

      const data = await res.json();

      if (data.success) {
        showToast('success', data.message || 'Submission received successfully.');
        form.querySelector('#code').value = '';
      } else {
        showToast('error', data.message || 'Failed to submit code.');
      }
    } catch (err) {
      console.error(err);
      showToast('error', 'An error occurred while submitting your code.');
    }
  });
}

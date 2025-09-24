export async function postForm(url, form) {
  const formData = form instanceof HTMLFormElement ? new FormData(form) : form;
  const headers = {
    'X-Requested-With': 'XMLHttpRequest',
  };

  const csrfMeta = document.querySelector('meta[name="csrf-token"]')?.content;
  if (csrfMeta) {
    headers['X-CSRF-Token'] = csrfMeta;
  }

  try {
    const response = await fetch(url, {
      method: 'POST',
      body: formData,
      headers,
      credentials: 'same-origin',
    });

    let data;
    const contentType = response.headers.get('Content-Type') || '';
    if (contentType.includes('application/json')) {
      try {
        data = await response.json();
      } catch (e) {
        data = { success: false, message: 'Invalid JSON response' };
      }
    } else {
      data = { success: response.ok, message: await response.text() };
    }

    if (!data.errors) data.errors = {};

    return { ok: response.ok, status: response.status, data };
  } catch (err) {
    return {
      ok: false,
      status: 0,
      data: { success: false, message: err.message, errors: {} },
    };
  }
}

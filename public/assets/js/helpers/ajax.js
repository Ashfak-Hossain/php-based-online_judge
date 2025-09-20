export async function postForm(url, form) {
  const formData = form instanceof HTMLFormElement ? new FormData(form) : form;
  const headers = {
    'X-Requested-With': 'XMLHttpRequest',
  };
  const csrfMeta = document.querySelector('meta[name="csrf-token"]');
  if (csrfMeta && csrfMeta.content) {
    headers['X-CSRF-Token'] = csrfMeta.content;
  }

  const response = await fetch(url, {
    method: 'POST',
    body: formData,
    headers,
    credentials: 'same-origin',
  });

  let data = null;
  const contentType = response.headers.get('Content-Type') || '';
  if (contentType.includes('application/json')) {
    data = await response.json();
  } else {
    data = {
      success: response.ok,
      message: await response.text(),
    };
  }
  return {
    ok: response.ok,
    status: response.status,
    data,
  };
}

export function showToast(message, type = 'info') {
  const bg =
    type === 'success'
      ? 'linear-gradient(90deg,#16a34a,#059669)'
      : type === 'error'
      ? 'linear-gradient(90deg,#ef4444,#dc2626)'
      : type === 'info'
      ? 'linear-gradient(90deg,#2563eb,#1d4ed8)'
      : 'linear-gradient(90deg,#6b7280,#4b5563)';

  if (typeof Toastify !== 'undefined') {
    Toastify({
      text: message,
      duration: 4000,
      gravity: 'top',
      position: 'right',
      backgroundColor: bg,
      close: true,
    }).showToast();
  } else {
    alert(message);
  }
}

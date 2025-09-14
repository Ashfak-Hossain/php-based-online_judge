<?php

function showToast($message, $type = 'success')
{
  $color = match ($type) {
    'success' => 'linear-gradient(to right, #00b09b, #96c93d)',
    'error' => 'linear-gradient(to right, #ff5f6d, #ffc371)',
    'info' => 'linear-gradient(to right, #2193b0, #6dd5ed)',
    'default' => 'linear-gradient(to right, #2193b0, #6dd5ed)',
  };

  echo "<script>
  document.addEventListener('DOMContentLoaded', function() {
    Toastify({
      text: " . json_encode($message) . ",
      duration: 3000,
      close: true,
      gravity: 'top',
      position: 'right',
      backgroundColor: '$color',
      stopOnFocus: true
    }).showToast();
  });
</script>";
}

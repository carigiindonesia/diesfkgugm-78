<!-- Client-side Security Protections -->
<script>
(function() {
  'use strict';

  // Disable right-click context menu
  document.addEventListener('contextmenu', function(e) {
    e.preventDefault();
    return false;
  });

  // Disable common keyboard shortcuts for inspect element and view source
  document.addEventListener('keydown', function(e) {
    // F12
    if (e.key === 'F12') {
      e.preventDefault();
      return false;
    }
    // Ctrl+Shift+I (Inspect), Ctrl+Shift+J (Console), Ctrl+Shift+C (Element picker)
    if (e.ctrlKey && e.shiftKey && ['I','i','J','j','C','c'].includes(e.key)) {
      e.preventDefault();
      return false;
    }
    // Ctrl+U (View Source)
    if (e.ctrlKey && (e.key === 'u' || e.key === 'U')) {
      e.preventDefault();
      return false;
    }
    // Ctrl+S (Save page)
    if (e.ctrlKey && (e.key === 's' || e.key === 'S') && !e.shiftKey) {
      e.preventDefault();
      return false;
    }
    // Ctrl+P (Print — can be used to save as PDF)
    if (e.ctrlKey && (e.key === 'p' || e.key === 'P')) {
      e.preventDefault();
      return false;
    }
    // PrintScreen
    if (e.key === 'PrintScreen') {
      e.preventDefault();
      document.body.style.filter = 'blur(20px)';
      setTimeout(function() { document.body.style.filter = 'none'; }, 1500);
      return false;
    }
  });

  // Blur page when window loses focus (screenshot attempt detection)
  document.addEventListener('visibilitychange', function() {
    if (document.visibilityState === 'hidden') {
      document.body.setAttribute('data-protected', 'true');
    } else {
      document.body.removeAttribute('data-protected');
    }
  });

  // Disable drag for images
  document.addEventListener('dragstart', function(e) {
    if (e.target.tagName === 'IMG') {
      e.preventDefault();
    }
  });

  // Disable text selection on sensitive areas
  document.addEventListener('selectstart', function(e) {
    var target = e.target;
    // Allow selection in form inputs
    if (target.tagName === 'INPUT' || target.tagName === 'TEXTAREA' || target.tagName === 'SELECT') {
      return true;
    }
    // Allow selection in elements with data-allow-select
    if (target.closest('[data-allow-select]')) {
      return true;
    }
  });
})();
</script>
<style>
  /* Prevent content copying via CSS */
  body {
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    -webkit-touch-callout: none;
  }

  /* Allow selection in form fields */
  input, textarea, select, [data-allow-select] {
    -webkit-user-select: text;
    -moz-user-select: text;
    -ms-user-select: text;
    user-select: text;
  }

  /* Prevent image saving */
  img {
    pointer-events: none;
    -webkit-user-drag: none;
    user-drag: none;
  }

  /* Hide content during print */
  @media print {
    body {
      display: none !important;
    }
  }
</style>

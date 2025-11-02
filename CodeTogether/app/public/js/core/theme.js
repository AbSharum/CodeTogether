(function () {
  const root = document.documentElement;

  // Apply theme to the <html> tag
  function applyTheme(theme) {
    root.setAttribute('data-theme', theme);
    console.log('[theme.js] Applied theme:', theme);
  }

  // Toggle between light/dark
  function toggleTheme() {
    const current = root.getAttribute('data-theme') || 'light';
    const next = current === 'light' ? 'dark' : 'light';
    applyTheme(next);
  }


  // Initialize from the PHP session (injected in HTML tag)
  const initial = root.getAttribute('data-theme') || 'light';
  applyTheme(initial);

  // Handle navbar toggle click
  document.addEventListener('click', e => {
    const btn = e.target.closest('#themeToggle');
    if (btn) toggleTheme();
  });
})();

(function () {
  const rainAttr = document.documentElement.getAttribute('data-rain');
  const enabled = rainAttr === 'on';
  if (!enabled) return;

  const canvas = document.getElementById('matrix-canvas');
  if (!canvas) return;
  const ctx = canvas.getContext('2d');
  if (!ctx) return;

  let fontSize = 16, columns, drops = [], rafId = null;
  const chars = (function () {
    const kat = 'アイウエオカキクケコキャキュキョサシスセソシャシュショタチツテトチャチュチョナニヌネノニャニュニョハヒフヘホヒャヒュヒョマミムメモミャミュミョヤユエヨラリルレロリャリュリョワヰヱヲ';
    const lat = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const num = '1234567890';
    const sym = '!@#$%^&*()<>?+=-_: ';
    return (kat + lat + num + sym).split('');
  })();

  function getThemeColors() {
    const isLight = document.documentElement.getAttribute('data-theme') === 'light';
    return {
      background: isLight ? 'rgba(255,255,255,0.1)' : 'rgba(0,0,0,0.07)',
      text: isLight ? '#0c5c3c' : '#00FF00',
    };
  }

  function resize() {
    if (rafId) cancelAnimationFrame(rafId);
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
    columns = Math.floor(canvas.width / fontSize);
    drops.length = columns;
    const maxRows = Math.floor(canvas.height / fontSize);
    for (let i = 0; i < columns; i++) drops[i] = Math.floor(Math.random() * maxRows * -1);
    rafId = requestAnimationFrame(loop);
  }

  function draw() {
    const { background, text } = getThemeColors();
    ctx.fillStyle = background;
    ctx.fillRect(0, 0, canvas.width, canvas.height);
    ctx.fillStyle = text;
    ctx.font = `${fontSize}px monospace`;

    for (let i = 0; i < drops.length; i++) {
      const char = chars[Math.floor(Math.random() * chars.length)];
      ctx.fillText(char, i * fontSize, drops[i] * fontSize);
      if (drops[i] * fontSize > canvas.height) drops[i] = 0;
      drops[i]++;
    }
  }

  let lastTime = 0;
  const interval = 45;

  function loop(timestamp) {
    rafId = requestAnimationFrame(loop);
    const delta = timestamp - lastTime;
    if (delta < interval) return;
    lastTime = timestamp;
    draw();
  }

  window.addEventListener('resize', resize);
  resize();

  const observer = new MutationObserver(() => draw());
  observer.observe(document.documentElement, { attributes: true, attributeFilter: ['data-theme'] });
})();

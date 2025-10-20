const canvas = document.getElementById('matrix-canvas');
    const context = canvas.getContext('2d');

    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
    /* setting characters */
    const katakana = 'アイウエオカキクケコキャキュキョサシスセソシャシュショタチツテトチャチュチョナニヌネノニャニュニョハヒフヘホヒャヒュヒョマミムメモミャミュミョヤユエヨラリルレロリャリュリョワヰヱヲ';
    const latin = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const numbers = '1234567890';
    const symbols = '!@#$%^&*()<>?+=-_:';
    const alphabet = katakana + latin + numbers + symbols;
    const characters = alphabet.split('');

    const fontSize = 16;
    const columns = Math.floor(canvas.width / fontSize);
    const drops = [];

    for(let i = 0; i < columns; i++){
        drops[i] = 1;
    }
    /* main animation loopy loop */
    const draw = () => {
    /* fade affect */
    context.fillStyle = 'rgba(0, 0, 0, 0.05)';
    context.fillRect(0,0, canvas.width, canvas.height);

    context.fillStyle = '#0F0';
    context.font = '${fontSize}px monospace';

    for(let i = 0; i < drops.length; i++){
        const text = characters[Math.floor(Math.random() * characters.length)];
        context.fillText(text, i * fontSize,drops[i] * fontSize);

        if(drops[i] * fontSize > canvas.height && Math.random() > 0.975){
            drops[i] = 0;
        }
        drops[i]++;
        }
    };

    setInterval(draw, 105);

    window.addEventListener('resize', () => {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
        const columns = Math.floor(canvas.width / fontSize);
        drops.length = columns;
        for(let i = 0; i < columns; i++){
            if(drops[i] === undefined){
                drops[i] = 1;
            }
        }
    });
    // Use requestAnimationFrame for a smoother animation loop
    function animate() {
        draw();
        requestAnimationFrame(animate);
    }

    window.onload = function() {
        animate();
    };
        
const canvas = document.getElementById('matrix-canvas');
const context = canvas.getContext('2d');

const setCanvasSize = () => {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
    const columns = Math.floor(canvas.width / fontSize);
    const newDrops = [];
    for(let i = 0; i < columns; i++){
        newDrops[i] = drops && drops[i] !== undefined ? drops[i] : 1;
    }
    drops = newDrops;
}

let fontSize = 16;
let columns;
let drops = [];
let animationFrameId;

/* setting characters */
const katakana = 'アイウエオカキクケコキャキュキョサシスセソシャシュショタチツテトチャチュチョナニヌネノニャニュニョハヒフヘホヒャヒュヒョマミムメモミャミュミョヤユエヨラリルレロリャリュリョワヰヱヲ';
const latin = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
const numbers = '1234567890';
const symbols = '!@#$%^&*()<>?+=-_:';
const alphabet = katakana + latin + numbers + symbols;
const characters = alphabet.split('');


setCanvasSize();

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

//using requestAnimationFrame for smoother animation transition
const interval = 35;
let lastTime = 0;

function animation(timestamp){
    animationFrameId = requestAnimationFrame(animate);
    const elapsed = timestamp - lastTime;

    if(elapsed > interval){
        lastTime = timestamp - (elapsed % interval);
        draw();
    }
}
 window.addEventListener('resize', setCanvasSize);

 window.onload = function() {
    if (animationFrameId){
        this.cancelAnimationFrame(animationFrameId);
    }
    animate(0);
};

function showPass(){
    const x = document.getElementById("password");
    if(x.type === "password"){
        x.type = "text";
    }else{
        x.type = "password";
    }
}
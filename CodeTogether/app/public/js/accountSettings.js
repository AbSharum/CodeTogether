document.addEventListener('DOMContentLoaded', () => {
    // Get the canvas element and its 2D context
    const canvas = document.getElementById('matrix-canvas');
    const context = canvas.getContext('2d');

    // Check for context support
    if (!context) {
        console.error("Canvas context not supported or not found.");
        return;
    }

    let fontSize = 16;
    let columns;
    let drops = [];
    let animationFrameId = null;

    let isRaining = localStorage.getItem('matrixRainEnabled') === 'false' ? false : true;

    // Character sequence for the pattern effect, repeated for variation
    const katakana = 'アイウエオカキクケコキャキュキョサシスセソシャシュショタチツテトチャチュチョナニヌネノニャニュニョハヒフヘホヒャヒュヒョマミムメモミャミュミョヤユエヨラリルレロリャリュリョワヰヱヲ';
    const latin = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const numbers = '1234567890';
    const symbols = '!@#$%^&*()<>?+=-_:';
    const alphabet = katakana + latin + numbers + symbols;
    const characters = alphabet.split('');

    // logic for starting rain
    const startRain = () => {
        if(animationFrameId === null){
            isRaining = true;
            localStorage.setItem('matrixRainEnabled', 'true');
            lastTime = 0;
            animationFrameId = requestAnimationFrame(animate);
        }
    };

    // logic for ending the rain
    const stopRain = () => {
        if(animationFrameId) {
            cancelAnimationFrame(animationFrameId);
        }
        animationFrameId = null;
        isRaining = false;
        localStorage.setItem('matrixRainEnabled','false');
        context.fillStyle = 'black';
        context.fillRect(0,0,canvas.width, canvas.height);
    };

    // Function to set canvas size and recalculate drops
    const setCanvasSize = () => {
        const wasRaining = isRaining;
        // Cancel any existing animation frame to restart smoothly
        if (animationFrameId) {
            cancelAnimationFrame(animationFrameId);
            animationFrameId = null;
        }

        // Set canvas dimensions to viewport size
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
        columns = Math.floor(canvas.width / fontSize);

        // Re-initialize or resize the drops array
        if (drops.length !== columns) {
            drops.length = columns;

            const maxRows = Math.floor(canvas.height / fontSize); 

            for(let i = 0; i < columns; i++){
                // Initialize drops at a random vertical position (y-index)
                // Starts drops randomly *off* the top of the screen for staggered flow
                drops[i] = Math.floor(Math.random() * maxRows * -1); 
            }
        }

        if(wasRaining){
            startRain();
        }else{
            context.fillStyle = 'black';
            context.fillRect(0,0, canvas.width, canvas.height);
        }
    };

    /* main animation drawing function */
    const draw = () => {
        // Fading effect: Draw a semi-transparent black rectangle over the previous frame
        context.fillStyle = 'rgba(0, 0, 0, 0.07)';
        context.fillRect(0, 0, canvas.width, canvas.height);

        context.fillStyle = '#0F0'; // Green text color
        context.font = `${fontSize}px monospace`; 

        for (let i = 0; i < drops.length; i++) {
            // Use the drop's vertical position (drops[i]) modulo sequence length to pick the character
            const charIndex = Math.floor(Math.random() * characters.length);
            const text = characters[charIndex];

            // Draw the character
            context.fillText(text, i * fontSize, drops[i] * fontSize);

            // Check if the drop has fallen off the screen
            if (drops[i] * fontSize > canvas.height) {
                // Reset to 0 immediately to ensure a continuous, gapless flow
                drops[i] = 0;
            }
                    
            // Increment the drop position
            drops[i]++;
        }
    };

    // Using requestAnimationFrame for smoother animation transition
    const interval = 60; // Speed control (in milliseconds), about 16.6 FPS
    let lastTime = 0;

    function animate(timestamp) {

        if(!isRaining){
            animationFrameId = null;
            return;
        }

        animationFrameId = requestAnimationFrame(animate);
        const elapsed = timestamp - lastTime;
        // Control the update rate using the 'interval'
        if (elapsed > interval) {
            // Adjust lastTime to keep the animation synced despite frame drops
            lastTime = timestamp - (elapsed % interval);
            draw();
        }
    }
            
    // Set up initial size and start the loop once the DOM is ready
    setCanvasSize();

    // Handle resize events to keep the canvas full-screen and responsive
    window.addEventListener('resize', setCanvasSize);

    // eventlistener for toggle of the rain
    const rainToggle = document.getElementById('rainToggle');
    if(rainToggle){
        rainToggle.checked = isRaining;

        if(isRaining){
            startRain();
        }else{
            stopRain();
        }

        rainToggle.addEventListener('change', () => {
            if(rainToggle.checked) {
                startRain();
            }else{
                stopRain();
            }
        });
    }
});

    const deleteModal = document.getElementById("deleteModal");
    const usernameModal = document.getElementById("UsernameModal");
    const emailModal = document.getElementById("emailModal");
    const passwordModal = document.getElementById("passwordModal");

    const deleteBtn = document.getElementById("delete");
    const usernameBtn = document.getElementById("changeUsername");
    const emailBtn = document.getElementById("changeEmail");
    const passwordBtn = document.getElementById("changePassword");

    const deleteClose = document.getElementsByClassName("dClose")[0];
    const usernameClose = document.getElementsByClassName("uClose")[0];
    const emailClose = document.getElementsByClassName("eClose")[0];
    const passwordClose = document.getElementsByClassName("pClose")[0];

    // Array of all modal objects for easy iteration and centralized window click handling
    const allModals = [
        { button: deleteBtn, modal: deleteModal, close: deleteClose },
        { button: usernameBtn, modal: usernameModal, close: usernameClose },
        { button: emailBtn, modal: emailModal, close: emailClose },
        { button: passwordBtn, modal: passwordModal, close: passwordClose }
    ].filter(item => item.button && item.modal && item.close); // Filter out any elements that might not be found

    // 2. Attach separate listeners for opening and closing each modal
    allModals.forEach(item => {
        // Open modal on button click
        item.button.onclick = function() {
            item.modal.style.display = "block";
        };

        // Close modal on 'x' span click
        item.close.onclick = function() {
            item.modal.style.display = "none";
        };
    });


    // 3. Update the outside click listener to check all modals
    window.onclick = function(event) {
        allModals.forEach(item => {
            if (event.target === item.modal) {
                item.modal.style.display = "none";
            }
        });
    };

    function showPassAndConf(){
        var x = document.getElementById("password");
        var y = document.getElementById("ChangePassword");
        if(x.type === "password"){
            x.type = "text";
            y.type = "text";
        }else{
            x.type = "password";
            y.type = "password";
        }
    }

    // Get the current page's filename 
    const currentPathParts = window.location.pathname.split('/');
    const currentFileName = currentPathParts[currentPathParts.length - 1].toLowerCase();

    // 2. Select all navigation links
    const navLinks = document.querySelectorAll('.navbar-nav .nav-item a');

    navLinks.forEach(link => {
        // 3. Get the filename from the link's href
        const linkHref = link.getAttribute('href') || '';
        const linkPathParts = linkHref.split('/');
        const linkFileName = linkPathParts[linkPathParts.length - 1].toLowerCase();

        // 4. Check if the link's filename matches the current page's filename
        if (linkFileName && linkFileName === currentFileName) {
        // 5. Hide the parent <li> element (the nav-item)
            const parentItem = link.closest('.nav-item');
            if (parentItem) {
                parentItem.classList.add('d-none');
            }
        }
    });



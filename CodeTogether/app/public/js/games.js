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

            // Character sequence for the pattern effect, repeated for variation
            const katakana = 'アイウエオカキクケコキャキュキョサシスセソシャシュショタチツテトチャチュチョナニヌネノニャニュニョハヒフヘホヒャヒュヒョマミムメモミャミュミョヤユエヨラリルレロリャリュリョワヰヱヲ';
            const latin = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            const numbers = '1234567890';
            const symbols = '!@#$%^&*()<>?+=-_:';
            const alphabet = katakana + latin + numbers + symbols;
            const characters = alphabet.split('');

            // Function to set canvas size and recalculate drops
            const setCanvasSize = () => {
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
                
                lastTime = 0; // Reset timer
                // Start the animation loop
                animationFrameId = requestAnimationFrame(animate); 
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

            //coundown timer logic
const timerElement = document.getElementById('countdown-timer');
    let totalSeconds = 15 * 60; // 15 minutes in seconds
    let countdownInterval = null;
    let isTimerRunning = false;

    function updateCountdown() {
        const minutes = Math.floor(totalSeconds / 60);
        const seconds = totalSeconds % 60;

        // Format for display (e.g., "05" instead of "5")
        const formattedMinutes = String(minutes).padStart(2, '0');
        const formattedSeconds = String(seconds).padStart(2, '0');

        timerElement.textContent = `${formattedMinutes}:${formattedSeconds}`;

        if (totalSeconds <= 0) {
            clearInterval(countdownInterval);
            timerElement.textContent = "Time's Up!";
            timerElement.classList.add('timer-end');
            showWinnerPopup('Team B'); // this needs some back end love 
        } else {
            totalSeconds--;
        }
    }

    function startTimer(){
        if(isTimerRunning) return;

        isTimerRunning = true;
        updateCountdown();
        countdownInterval = setInterval(updateCountdown, 1000);

        //makes the timer appearnace indicate it is active/non-clickable
        timerElement.ELEMENT_NODE.style.cursor = 'default';
        timerElement.ELEMENT_NODE.style.boxShadow = 'none';
    }
    // backend love needed here too for the actual winner
    function showWinnerPopup(winnerName) {
        if (typeof bootstrap === 'undefined' || !bootstrap.Modal) {
            console.error("Bootstrap's Modal functionality is not available.");
            return;
        }

        const winnerModalElement = document.getElementById('winnerModal');
        const winningTeamNameElement = document.getElementById('winningTeamName');

        if (winnerModalElement && winningTeamNameElement) {
            winningTeamNameElement.textContent = winnerName + ' Wins!';

            let textColor = '#fff';
            // Set specific colors based on the winning team
            if (winnerName.includes('A')) {
                // Team A color (Red - danger)
                textColor = '#dc3545';
            } else if (winnerName.includes('B')) {
                // Team B color (Blue - primary)
                textColor = '#0d6efd';
            }

            winningTeamNameElement.style.color = textColor;
            winningTeamNameElement.style.textShadow = `0 0 10px ${textColor}`;

            const winnerModal = new bootstrap.Modal(winnerModalElement);
            winnerModal.show();
        }
    }

    // Call updateCountdown immediately to show initial time
    updateCountdown(); 

    timerElement.addEventListener('click', startTimer);
});

 
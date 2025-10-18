document.addEventListener('DOMContentLoaded', () => {
            const canvas = document.getElementById('matrix-canvas');
            const context = canvas.getContext('2d');

            if (!context) {
                console.error("Canvas context not supported or not found.");
                return;
            }

            let fontSize = 16;
            let drops = [];
            let animationFrameId = null;

            // Rich character set for the classic Matrix look
            const alphabet = '404Error';
            const characters = alphabet.split('');
            const sequenceLength = characters.length; 
            
            // Interval for character updates (60ms = ~16.6 FPS)
            const interval = 60; 
            let lastTime = 0; 
            
            /* main animation loop function */
            const draw = () => {
                // Fading effect for the trails
                context.fillStyle = 'rgba(0, 0, 0, 0.07)';
                context.fillRect(0,0, canvas.width, canvas.height);

                context.fillStyle = '#0F0'; // Green text color
                context.font = `${fontSize}px monospace`; 

                for(let i = 0; i < drops.length; i++){
                    // Pick a random character
                    const charIndex = Math.floor(Math.random() * sequenceLength);
                    const text = characters[charIndex]; 

                    // Draw the character
                    context.fillText(text, i * fontSize, drops[i] * fontSize);

                    // Check if the drop has fallen off the screen
                    // If it has and a random check passes (0.975 probability of resetting), reset it
                    if(drops[i] * fontSize > canvas.height && Math.random() > 0.975){
                        drops[i] = 0;
                    }
                    // Move the drop down one row
                    drops[i]++;
                }
            };

            /* requestAnimationFrame loop */
            const animate = (timestamp) => {
                // Schedule the next frame
                animationFrameId = requestAnimationFrame(animate); 
                
                const elapsed = timestamp - lastTime;

                // Only draw if enough time has passed based on the interval
                if (elapsed > interval) {
                    // Compensate for the time overshoot
                    lastTime = timestamp - (elapsed % interval); 
                    draw();
                }
            }

            /* Resizing and Initialization */
            const setCanvasSize = () => {
                // Cancel any existing loop before resizing/resetting
                if (animationFrameId) {
                    cancelAnimationFrame(animationFrameId);
                    animationFrameId = null;
                }

                // Set canvas dimensions to viewport size
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;

                const columns = Math.floor(canvas.width / fontSize);

                // Re-initialize or resize drops array if column count changes
                if(drops.length !== columns){
                    drops.length = columns;

                    const maxRows = Math.floor(canvas.height / fontSize);
                    for(let i = 0; i < columns; i++){
                        // Initialize drops to start randomly *above* the screen for immediate flow
                        drops[i] = Math.floor(Math.random() * maxRows * -1); 
                    }
                }
                
                lastTime = 0; // Reset timer
                // Start the animation loop
                animationFrameId = requestAnimationFrame(animate); 
            }

            // Start everything when the DOM is ready
            setCanvasSize();

            // Handle resize events
            window.addEventListener('resize', setCanvasSize);
        });
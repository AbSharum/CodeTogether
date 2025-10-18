const canvas = document.getElementById('matrix-canvas');
        const context = canvas.getContext('2d');

        let fontSize = 16;
        let columns;
        let drops = [];
        let animationFrameId;

        // Custom character sequence for the pattern effect, SPACE CHARACTER REMOVED
        const fixedChars = "404ERROR"; 
        const charSequence = fixedChars.split('');
        const sequenceLength = charSequence.length;

        // Function to set canvas size and recalculate drops
        const setCanvasSize = () => {
            // Cancel any existing animation frame to restart smoothly
            if (animationFrameId) {
                cancelAnimationFrame(animationFrameId);
            }

            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            columns = Math.floor(canvas.width / fontSize);
            
            // Re-initialize or resize the drops array
            if (drops.length !== columns) {
                drops.length = columns;
                // Determine the maximum number of rows
                const maxRows = Math.floor(canvas.height / fontSize); 

                for(let i = 0; i < columns; i++){
                    // Initialize drops at a random vertical position (y-index) for staggered start
                    // This is key to breaking up horizontal synchronization
                    if (drops[i] === undefined) {
                        drops[i] = Math.floor(Math.random() * maxRows); 
                    }
                }
            }
            
            // Restart the animation loop
            animate(0); // Pass 0 for initial timestamp
        }

        /* main animation loop */
        const draw = () => {
            /* Fade alpha remains crisp for short trails */
            context.fillStyle = 'rgba(0, 0, 0, 0.07)';
            context.fillRect(0,0, canvas.width, canvas.height);

            context.fillStyle = '#0F0';
            context.font = `${fontSize}px monospace`;

            for(let i = 0; i < drops.length; i++){
                // Use the vertical position (drops[i]) modulo the sequence length to pick a character
                const charIndex = (drops[i]) % sequenceLength;
                const text = charSequence[charIndex];

                // Draw the character
                context.fillText(text, i * fontSize, drops[i] * fontSize);

                // Check if the drop has fallen off the screen
                if(drops[i] * fontSize > canvas.height){
                    // Reset to 0 immediately to ensure a continuous, gapless flow
                    drops[i] = 0;
                }
                
                // Increment the drop position
                drops[i]++;
            }
        };

        // Use requestAnimationFrame for smoother animation transition
        const interval = 60; // Speed control (in milliseconds)
        let lastTime = 0;

        function animate(timestamp) {
            animationFrameId = requestAnimationFrame(animate);
            const elapsed = timestamp - lastTime;

            // Control the update rate using the 'interval'
            if (elapsed > interval) {
                lastTime = timestamp - (elapsed % interval);
                draw();
            }
        }

        // Initial setup on load
        window.onload = function() {
            setCanvasSize();
        };

        // Adjust size on window resize
        window.addEventListener('resize', setCanvasSize);
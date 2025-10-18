document.getElementById('registration').addEventListener('submit',function(event){
    // gets the values inputed in password and confirm password locations
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    const passwordPattern = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/';
    // checks thats passwords match.
    if (password !== confirmPassword) {
        event.preventDefault(); // Stop form submission
        // Custom, non-alert message box for password mismatch
        const cardBody = document.querySelector('.card-body');
                
        let messageBox = document.getElementById('passwordMismatchAlert');
        if (!messageBox) {
            messageBox = document.createElement('div');
            messageBox.id = 'passwordMismatchAlert';
            messageBox.className = 'alert alert-danger mt-3';
            messageBox.role = 'alert';
            cardBody.insertBefore(messageBox, cardBody.firstChild);
        }
        messageBox.textContent = 'Password does not meet requirements.\nMust contain at least one number, one uppercase, and one lowercase letter, and be at least 8 characters long.';
                
        // Clear the message after 5 seconds
        setTimeout(() => {
            messageBox.remove();
        }, 5000);
    }
});
function showPassAndConf(){
    var x = document.getElementById("password");
    var y = document.getElementById("confirmPassword");
    if(x.type === "password"){
        x.type = "text";
        y.type = "text";
    }else{
        x.type = "password";
        y.type = "password";
    }
}

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
        });

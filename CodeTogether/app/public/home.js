// JavaScript for the Editable "About Me" Section
        document.addEventListener('DOMContentLoaded', () => {
            const contentDiv = document.getElementById('aboutMeContent');
            const editorTextarea = document.getElementById('aboutMeEditor');
            const editSaveBtn = document.getElementById('editSaveBtn');
            let isEditing = false;

            // Initialize the editor's content with the current view content
            editorTextarea.value = contentDiv.innerText.trim();

            editSaveBtn.addEventListener('click', () => {
                if (!isEditing) {
                    // Switch to Edit Mode
                    contentDiv.style.display = 'none';
                    editorTextarea.value = contentDiv.innerText.trim(); // Load current text
                    editorTextarea.style.display = 'block';
                    editSaveBtn.textContent = 'Save';
                    editSaveBtn.classList.remove('btn-outline-info');
                    editSaveBtn.classList.add('btn-success');
                    isEditing = true;
                    editorTextarea.focus();
                } else {
                    // Switch to View Mode and "Save"
                    const newContent = editorTextarea.value.trim();

                    // --- PHP/Database Integration Point --- send 'newContent' to a PHP endpoint (e.g., update_bio.php) for database persistence.
                    console.log('--- SAVING BIO ---');
                    console.log('Sending new bio to server for user: ', newContent);
                    // fetch('update_bio.php', { method: 'POST', body: JSON.stringify({ bio: newContent }) })
                    // .then(response => response.json())
                    // .then(data => { console.log('Save success:', data); });
                    // ------------------------------------

                    contentDiv.innerText = newContent;
                    contentDiv.style.display = 'block';
                    editorTextarea.style.display = 'none';
                    editSaveBtn.textContent = 'Edit';
                    editSaveBtn.classList.remove('btn-success');
                    editSaveBtn.classList.add('btn-outline-info');
                    isEditing = false;
                }
            });

            // Note: The click events for stat-item and PHP integration points remain the same as before.
            console.log('Homepage layout initialized with 3 columns and editable bio.');

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

            setInterval(draw, 35);

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
        });
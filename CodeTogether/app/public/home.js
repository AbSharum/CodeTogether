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

// --- CHAT BOX FUNCTIONALITY ---
    const chatBox = document.getElementById('chatBox');
    const chatHeader = document.getElementById('chatHeader');
    const chatCloseBtn = document.getElementById('chatCloseBtn');
    const chatFriendName = document.getElementById('chatFriendName');
    const chatOpenBtns = document.querySelectorAll('.chat-open-btn');

    // 1. Open Chat Box Logic
    chatOpenBtns.forEach(button => {
        button.addEventListener('click', (event) => {
            // Stop the friend-item click from propagating, if it had one.
            event.stopPropagation();

            const friendName = button.getAttribute('data-friend-name');
            chatFriendName.textContent = `Chatting with: ${friendName}`;
            chatBox.style.display = 'flex'; // Show the chat box
            // Set initial position if not set (or reset to default for mobile)
            if (window.innerWidth > 450) {
                chatBox.style.bottom = '20px';
                chatBox.style.right = '20px';
                chatBox.style.left = 'unset';
            }
        });
    });

    // 2. Close Chat Box Logic
    chatCloseBtn.addEventListener('click', () => {
        chatBox.style.display = 'none';
    });

    // 3. Drag Functionality
    let isDragging = false;
    let currentX, currentY, initialX, initialY, xOffset = 0, yOffset = 0;

    const dragStart = (e) => {
        // Only allow dragging on desktop/larger screens to avoid mobile conflicts
        if (window.innerWidth <= 450) return;

        e.preventDefault(); // Prevent default drag behavior
        initialX = e.clientX || e.touches[0].clientX;
        initialY = e.clientY || e.touches[0].clientY;

        isDragging = true;
        chatHeader.style.cursor = 'grabbing';
        chatBox.classList.add('dragging'); // Optional class for visual feedback
    };

    const dragEnd = () => {
        isDragging = false;
        chatHeader.style.cursor = 'grab';
        chatBox.classList.remove('dragging');
        // Store current offset for next drag
        xOffset = parseInt(chatBox.style.left) || 0;
        yOffset = parseInt(chatBox.style.top) || 0;
    };

    const drag = (e) => {
        if (!isDragging) return;

        e.preventDefault();
        currentX = e.clientX || e.touches[0].clientX;
        currentY = e.clientY || e.touches[0].clientY;

        const dx = currentX - initialX;
        const dy = currentY - initialY;

        // Use 'top' and 'left' for positioning during drag
        chatBox.style.left = (chatBox.offsetLeft + dx) + 'px';
        chatBox.style.top = (chatBox.offsetTop + dy) + 'px';

        // Update initial values for smooth movement
        initialX = currentX;
        initialY = currentY;
    };

    // Attach mouse and touch listeners to the chat header
    chatHeader.addEventListener('mousedown', dragStart);
    document.addEventListener('mouseup', dragEnd);
    document.addEventListener('mousemove', drag);

    chatHeader.addEventListener('touchstart', dragStart);
    document.addEventListener('touchend', dragEnd);
    document.addEventListener('touchmove', drag);
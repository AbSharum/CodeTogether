function onStatusChange({ userID, status }) {
    const friendItem = document.querySelector(`.friend-item[data-friend-id='${userID}']`);
    if (!friendItem) return;

    const statusEl = friendItem.querySelector('small');
    const avatarEl = friendItem.querySelector('img');
    if (!statusEl || !avatarEl) return;

    // Default: offline
    let statusClass = 'text-danger';
    let text = 'Offline';
    let color = 'd9534f';

    if (status === 'online') {
        statusClass = 'text-success';
        text = 'Online';
        color = '5cb85c';
    } else if (status === 'away') {
        statusClass = 'text-warning';
        text = 'Away';
        color = 'f0ad4e';
    }

    // Update status text and color
    statusEl.textContent = text;
    statusEl.className = statusClass;

    // Update avatar color (rebuild the placeholder URL)
    const initial = avatarEl.src.split('text=')[1]?.[0] || 'U';
    avatarEl.src = `https://placehold.co/40x40/${color}/ffffff?text=${initial}`;
}

// JavaScript for the Editable "About Me" Section
// Simplified About Me Form (no toggle, uses normal form submission)
document.addEventListener('DOMContentLoaded', () => {
    const editorTextarea = document.getElementById('aboutMeEditor');
    const form = editorTextarea?.closest('form');

    if (!editorTextarea || !form) {
        console.warn("About Me form not found — skipping setup.");
        return;
    }

    // Optional client-side validation
    form.addEventListener('submit', (e) => {
        const aboutMe = editorTextarea.value.trim();

        if (aboutMe.length > 5000) {
            e.preventDefault();
            alert("Your About Me is too long. Please keep it under 5000 characters.");
        } else {
            console.log("Submitting About Me form:", aboutMe);
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

    for (let i = 0; i < columns; i++) {
        drops[i] = 1;
    }
    /* main animation loopy loop */
    const draw = () => {
        /* fade affect */
        context.fillStyle = 'rgba(0, 0, 0, 0.05)';
        context.fillRect(0, 0, canvas.width, canvas.height);

        context.fillStyle = '#0F0';
        context.font = '${fontSize}px monospace';

        for (let i = 0; i < drops.length; i++) {
            const text = characters[Math.floor(Math.random() * characters.length)];
            context.fillText(text, i * fontSize, drops[i] * fontSize);

            if (drops[i] * fontSize > canvas.height && Math.random() > 0.975) {
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
        for (let i = 0; i < columns; i++) {
            if (drops[i] === undefined) {
                drops[i] = 1;
            }
        }
    });
    // Use requestAnimationFrame for a smoother animation loop
    function animate() {
        draw();
        requestAnimationFrame(animate);
    }

    window.onload = function () {
        animate();
    };
});

// --- CHAT BOX FUNCTIONALITY ---
const chatBox = document.getElementById('chatBox');
const chatHeader = document.getElementById('chatHeader');
const chatCloseBtn = document.getElementById('chatCloseBtn');
const chatFriendName = document.getElementById('chatFriendName');
const chatOpenBtns = document.querySelectorAll('.chat-open-btn');
const chatInput = document.getElementById('chatInput');
const chatSendBtn = document.getElementById('chatSendBtn');
const chatBody = document.getElementById('chatBody');

const scrollToBottom = () => {
    chatBody.scrollTop = chatBody.scrollHeight;
};

const sendMessage = () => {
    const messageText = chatInput.value.trim();

    if (messageText !== "") {
        // 1. Create a new message element
        const messageElement = document.createElement('div');
        messageElement.classList.add('message', 'sent'); // 'sent' class applies the green styling
        messageElement.textContent = messageText;

        // 2. Append the message to the chat body
        chatBody.appendChild(messageElement);

        // 3. Clear the input field
        chatInput.value = '';

        // 4. Scroll to the new message
        scrollToBottom();

        // 5. Placeholder for sending to a server (e.g., using Firestore)
        console.log(`Sending message to ${chatFriendName.textContent.replace('Chatting with: ', '')}: ${messageText}`);
    }
    // Always focus on the input after sending/trying to send
    chatInput.focus();
};
// Event listeners for sending the message
chatSendBtn.addEventListener('click', sendMessage);
chatInput.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') {
        e.preventDefault(); // Prevents the default action (like form submission, though not in a form here)
        sendMessage();
    }
});
// End new messaging functionality

// 1. Open Chat Box Logic
chatOpenBtns.forEach(button => {
    button.addEventListener('click', (event) => {
        // Stop the friend-item click from propagating, if it had one.
        event.stopPropagation();

        const friendName = button.getAttribute('data-friend-name');
        chatFriendName.textContent = `Transmitting: ${friendName}`;
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
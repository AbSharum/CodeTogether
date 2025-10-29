document.addEventListener("DOMContentLoaded", () => {

  const chatArea = document.getElementById("messageArea");
  const chatHeader = document.getElementById("chatHeader");
  const chatMessages = document.getElementById("chatMessages");
  const chatForm = document.getElementById("messageForm");
  const chatInput = document.getElementById("messageInput");
  const friendButtons = document.querySelectorAll(".chat-open-btn");

  console.log("Found chat buttons:", friendButtons.length);

  let currentFriendId = null;
  let lastMessageTime = null;
  let pollInterval = null;
  async function loadMessages(friendId) {
    try {
      const res = await fetch(
        `index.php?action=getMessages&friend_id=${friendId}&since=${encodeURIComponent(lastMessageTime ?? "")}`
      );
      if (!res.ok) throw new Error("HTTP " + res.status);

      const messages = await res.json();

      if (messages.length > 0) {
        messages.forEach((msg) => {
          const div = document.createElement("div");
          div.classList.add("p-2", "mb-2", "rounded");
          div.style.backgroundColor = msg.isSender ? "#4a9468" : "#444";
          div.innerHTML = `
            <strong>${msg.username}</strong><br>
            <span>${msg.content}</span><br>
            <small class="text-muted">${msg.sent_at}</small>
          `;
          chatMessages.appendChild(div);
        });

        chatMessages.scrollTop = chatMessages.scrollHeight;
        lastMessageTime = messages[messages.length - 1].sent_at;
      }
    } catch (err) {
      console.error("Polling error:", err);
    }
  }

  friendButtons.forEach((btn) => {
    btn.addEventListener("click", async () => {
      console.log("Chat button clicked:", btn.dataset.friendId);if (messages.length > 0) {
        messages.forEach((msg) => {
          const div = document.createElement("div");
          div.classList.add("p-2", "mb-2", "rounded");
          div.style.backgroundColor = msg.isSender ? "#4a9468" : "#444";
          div.innerHTML = `
            <strong>${msg.username}</strong><br>
            <span>${msg.content}</span><br>
            <small class="text-muted">${msg.sent_at}</small>
          `;
          chatMessages.appendChild(div);
        });

        chatMessages.scrollTop = chatMessages.scrollHeight;
        lastMessageTime = messages[messages.length - 1].sent_at;
      }

      clearInterval(pollInterval);
      chatMessages.innerHTML = '<p class="text-secondary">Loading...</p>';
      lastMessageTime = null;

      currentFriendId = btn.dataset.friendId;
      const friendName = btn
        .closest(".friend-item")
        .querySelector(".fw-bold").textContent;

      chatHeader.textContent = `Chatting with ${friendName}`;
      chatArea.style.display = "block";
      chatForm.style.display = "flex";

      await loadMessages(currentFriendId);

      pollInterval = setInterval(() => {
        if (currentFriendId) loadMessages(currentFriendId);
      }, 2000);
    });
  });

  chatForm.addEventListener("submit", async (e) => {
    e.preventDefault();
    const message = chatInput.value.trim();
    if (!message || !currentFriendId) return;

    try {
      const res = await fetch("index.php?action=sendMessage", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ recipient_id: currentFriendId, message }),
      });

      const result = await res.json();

      if (result.success) {
        chatInput.value = "";
        await loadMessages(currentFriendId);
      } else {
        alert("Failed to send message");
      }
    } catch (err) {
      console.error("Send message error:", err);
    }
  });
});

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

      for (let i = 0; i < columns; i++) {
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



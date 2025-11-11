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
          const rawTime = msg.sent_at;
          const div = document.createElement("div");
          const datePart = new Date(rawTime).toLocaleDateString('en-US', {
            weekday: 'long', 
            month: 'long',
            day: 'numeric'
          });

          const timePart = new Date(rawTime).toLocaleTimeString('en-US', {
            hour: 'numeric',  
            minute: '2-digit',
            hour12: true,
            timeZone: 'America/Chicago'
          });

          const displayTime = `${datePart} ${timePart}`;
          div.classList.add("p-2", "mb-2", "rounded");
          div.style.backgroundColor = msg.isSender ? "#4a9468" : "#444";
          div.innerHTML = `
          <strong>${msg.username}</strong><br>
          <span>${msg.content}</span><br>
          <small class="text-white">${displayTime}</small>`;
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
      console.log("Chat button clicked:", btn.dataset.friendId);

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
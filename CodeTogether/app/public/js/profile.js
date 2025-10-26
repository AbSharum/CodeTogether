fetch('/controllers/ProfileController.php')
  .then(res => res.json())
  .then(data => {
    document.getElementById('username').textContent = data.username;
  });


document.addEventListener('DOMContentLoaded', () => {

  // --- used to detect ?user_id= in the URL (For checking out other people's pages!) ---
  const urlParams = new URLSearchParams(window.location.search);
  const userId = urlParams.get('user_id');
  const profileUrl = userId
    ? `/controllers/ProfileController.php?user_id=${encodeURIComponent(userId)}`
    : '/controllers/ProfileController.php';

  // --- Initial username fetch ---
  fetch(profileUrl)
    .then(res => res.json())
    .then(data => {
      const usernameElem = document.getElementById('username');
      if (usernameElem) usernameElem.textContent = data.username || 'Unknown';
    })
    .catch(err => console.error('Error loading username:', err));

  // --- Function to load profile ---
  async function loadProfile() {
    try {
      const res = await fetch(profileUrl);
      const data = await res.json();

      const bioElem = document.getElementById('bio');
      if (bioElem && data.bio !== undefined) bioElem.value = data.bio;

      const profilePic = document.getElementById('profilePic');
      if (profilePic && data.profilePic) profilePic.src = data.profilePic;

      const postsDiv = document.getElementById('posts');
      if (postsDiv && Array.isArray(data.posts)) {
        postsDiv.innerHTML = data.posts
          .slice()
          .reverse()
          .map(p => `<div class="post">${p.time}: ${p.content}</div>`)
          .join('');
      }

      const followersDiv = document.getElementById('followers');
      if (followersDiv && data.followers !== undefined)
        followersDiv.textContent = data.followers;

      const followingDiv = document.getElementById('following');
      if (followingDiv && data.following !== undefined)
        followingDiv.textContent = data.following;
    } catch (err) {
      console.error('Error loading profile:', err);
    }
  }

  // --- Event handlers for updating logged-in user only ---
  const saveBioBtn = document.getElementById('saveBio');
  if (saveBioBtn) {
    saveBioBtn.addEventListener('click', async () => {
      const bioElem = document.getElementById('bio');
      if (!bioElem) return;
      const formData = new FormData();
      formData.append('bio', bioElem.value);
      await fetch('profile.php', { method: 'POST', body: formData });
      showSpeech('Bio updated! Very impressive, master~', true);
      loadProfile();
    });
  }

  const picForm = document.getElementById('picForm');
  if (picForm) {
    picForm.addEventListener('submit', async e => {
      e.preventDefault();
      const formData = new FormData(picForm);
      await fetch('profile.php', { method: 'POST', body: formData });
      showSpeech('Such a charming picture, master~', true);
      loadProfile();
    });
  }

  const postForm = document.getElementById('postForm');
  if (postForm) {
    postForm.addEventListener('submit', async e => {
      e.preventDefault();
      const newPost = document.getElementById('newPost');
      if (!newPost) return;
      const content = newPost.value.trim();
      if (!content) return;
      const formData = new FormData();
      formData.append('newPost', content);
      await fetch('profile.php', { method: 'POST', body: formData });
      newPost.value = '';
      showSpeech('Another post? You\'re unstoppable!', true);
      loadProfile();
    });
  }

  loadProfile();


  
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
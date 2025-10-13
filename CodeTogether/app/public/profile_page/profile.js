document.addEventListener('DOMContentLoaded', () => {
  const bubble = document.getElementById('speech');
  const maidForm = document.getElementById('maidForm');
  const maidImg = document.getElementById('maid');
  const maidInput = document.getElementById('maidInput');

  let autoActive = true;
  const fallback = [
    'Don’t forget to hydrate, master~',
    'Your followers crave your wisdom.',
    'Another post could make you famous… or infamous.',
    'Careful, too much scrolling might melt your brain.',
    'I’m just a humble maid, but I think you look cool today.'
  ];

  function positionBubble() {
    if (!bubble || !maidImg) return;
    const rect = maidImg.getBoundingClientRect();
    bubble.style.bottom = `${window.innerHeight - rect.top + 20}px`;
    bubble.style.right = `${window.innerWidth - rect.right + 160}px`;
  }

  let bubbleTimer = null;

  function showSpeech(text, override = false) {
    if (!bubble) return;
    bubble.textContent = text;
    positionBubble();
    bubble.style.opacity = 1;

    if (bubbleTimer) {
      clearTimeout(bubbleTimer);
      bubbleTimer = null;
    }

    let duration;
    if (override) {
      duration = Math.min(6000 + text.length * 80, 20000);
      autoActive = false;
    } else {
      duration = 10000;
    }

    bubbleTimer = setTimeout(() => {
      bubble.style.opacity = 0;
      if (override) setTimeout(() => (autoActive = true), 5000);
    }, duration);
  }

  function cycleMaid() {
    if (autoActive) {
      const line = fallback[Math.floor(Math.random() * fallback.length)];
      showSpeech(line);
    }
  }
  setInterval(cycleMaid, 10000);

  const menu = document.getElementById('personalityMenu');
  const openMenuBtn = document.getElementById('openMenuBtn');
  const saveBtn = document.getElementById('savePersonality');
  const closeBtn = document.getElementById('closeMenu');
  const select = document.getElementById('personalitySelect');
  let currentPersonality = localStorage.getItem('maidPersonality') || 'maid';

  const personalityImages = {
    maid: 'images/maid.webp',
    butler: 'images/butler.webp',
    scientist: 'images/scientist.webp',
    gamer: 'images/gamer.webp'
  };

  function updateMaidImage() {
    if (!maidImg) return;
    const src = personalityImages[currentPersonality] || 'images/maid.webp';
    maidImg.src = src;
  }

  select.value = currentPersonality;
  updateMaidImage();

  function toggleMenu(show) {
    menu.style.display = show ? 'block' : 'none';
  }

  if (openMenuBtn) openMenuBtn.addEventListener('click', () => toggleMenu(true));
  if (closeBtn) closeBtn.addEventListener('click', () => toggleMenu(false));

  if (saveBtn) {
    saveBtn.addEventListener('click', () => {
      currentPersonality = select.value;
      localStorage.setItem('maidPersonality', currentPersonality);
      updateMaidImage();
      showSpeech(`Switched to ${currentPersonality} mode.`, true);
      toggleMenu(false);
    });
  }

  async function askMaid(question) {
    try {
      const res = await fetch('maid.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ event: 'userChat', question, personality: currentPersonality })
      });
      const raw = await res.text();
      const data = JSON.parse(raw);

      if (data.choices && data.choices[0].message.content) {
        return data.choices[0].message.content.trim();
      } else if (data.reply) {
        return data.reply;
      }
    } catch (err) {
      console.error('Maid API error:', err);
    }
    return 'Sorry master, I could not reach the library of wisdom.';
  }

  if (maidForm) {
    maidForm.addEventListener('submit', async e => {
      e.preventDefault();
      const question = maidInput.value.trim();
      if (!question) return;
      showSpeech('Thinking...', true);
      const reply = await askMaid(question);
      showSpeech(reply, true);
      maidInput.value = '';
    });
  }

  if (maidImg) {
    maidImg.addEventListener('click', () => {
      showSpeech('Eek! You clicked me, master!', true);
    });
  }

  window.addEventListener('resize', positionBubble);
  positionBubble();

  async function loadProfile() {
    try {
      const res = await fetch('profile.php');
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

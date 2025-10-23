fetch('/controllers/ProfileController.php')
  .then(res => res.json())
  .then(data => {
    document.getElementById('username').textContent = data.username;
  });


document.addEventListener('DOMContentLoaded', () => {


  async function loadProfile() {
    try {
      const res = await fetch('/controllers/ProfileController.php');

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

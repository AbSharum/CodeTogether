
document.addEventListener('DOMContentLoaded', () => {
  const urlParams = new URLSearchParams(window.location.search);
  //console.error('urlParams = ', urlParams);
  const userId = urlParams.get('user_id');
  //console.error('userId = ', userId);
  //const profileUrl = userId
  //  ? `/controllers/ProfileController.php?user_id=${encodeURIComponent(userId)}`
  //  : '/controllers/ProfileController.php';
  const profileUrl = userId
    ? `/index.php?action=profile&user_id=${encodeURIComponent(userId)}`
    : '/index.php?action=profile';

  console.error('profileUrl = ', profileUrl);
 

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

      const friendsDiv = document.getElementById('friends');
      if (friendsDiv) {
        friendsDiv.textContent = data.friends || 0;
      }
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



<!-- Loading Screen -->
<div id="loading-screen">
  <div class="spinner"></div>
  <div class="gif-container">
    <img src="/public/images/loading.gif" alt="Loading..." class="loading-gif">
    <div class="blur-glow"></div>
  </div>
</div>

<style>
  #loading-screen {
    position: fixed;
    inset: 0;
    background: black;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 1;
    transition: opacity 0.8s ease;
    z-index: 9999;
  }

  #loading-screen.fade-out {
    opacity: 0;
    pointer-events: none;
  }

  .gif-container {
    position: absolute;
    top: 30%; 
    left: 50%;
    transform: translate(-50%, -50%);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    z-index: 3;
  }

  .loading-gif {
    width: 25vw;
    max-width: 300px;
    min-width: 120px;
    height: auto;
    object-fit: contain;
    z-index: 4;
  }

  .blur-glow {
    position: absolute;
    width: 35vw; 
    max-width: 420px;
    height: 35vw;
    max-height: 420px;
    border-radius: 50%;
    filter: blur(30px);
    background: radial-gradient(circle, rgba(0, 255, 0, 0.6), transparent 70%);
    animation: pulse 1.8s ease-in-out infinite;
    z-index: 1;
  }


  @keyframes pulse {
    0%, 100% {
      transform: scale(1);
      opacity: 0.7;
    }
    50% {
      transform: scale(1.2);
      opacity: 1;
    }
  }

  .spinner {
    width: 60px;
    height: 60px;
    border: 6px solid rgba(0, 255, 0, 0.2);
    border-top-color: limegreen;
    border-radius: 50%;
    animation: spin 1s linear infinite;
  }

  @keyframes spin {
    to {
      transform: rotate(360deg);
    }
  }
</style>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const loader = document.getElementById("loading-screen");
    setTimeout(() => loader.classList.add("fade-out"), 400);
  });

  // Smooth transition for navbar links
  document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll("a.nav-fade").forEach(link => {
      link.addEventListener("click", e => {
        const loader = document.getElementById("loading-screen");
        e.preventDefault();
        loader.classList.remove("fade-out");
        setTimeout(() => window.location.href = link.href, 300);
      });
    });
  });
</script>

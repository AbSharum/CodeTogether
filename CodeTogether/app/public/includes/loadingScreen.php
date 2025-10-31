<!-- Loading Screen -->
<div id="loading-screen">
  <div class="spinner"></div>
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


document.addEventListener("DOMContentLoaded", () => {
    const loader = document.getElementById("loading-screen");
    setTimeout(() => loader.classList.add("fade-out"), 400);
});

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll("a.nav-fade").forEach(link => {
        link.addEventListener("click", e => {
        //Skip dropdown toggles or empty links, was not working well without this lol
        if (link.getAttribute("href") === "#" || link.hasAttribute("data-bs-toggle")) return;

        const loader = document.getElementById("loading-screen");
        e.preventDefault();
        loader.classList.remove("fade-out");
        setTimeout(() => (window.location.href = link.href), 300);
        });
    });
});

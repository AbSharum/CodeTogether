document.addEventListener("DOMContentLoaded", async () => {
    const input = document.getElementById("contents");
    const dropdown = document.createElement("div");
    dropdown.id = "mentionDropdown";
    dropdown.className = "mention-dropdown";
    input.parentNode.appendChild(dropdown);

    let friends = [];

    // Fetch friend list from the controller
    try {
        const res = await fetch("index.php?action=addPost&ajax=friends");
        friends = await res.json();
    } catch (err) {
        console.error("Failed to load friends list", err);
    }

    function showDropdown(matches) {
        dropdown.innerHTML = "";
        if (matches.length === 0) {
            dropdown.style.display = "none";
            return;
        }

        matches.forEach(name => {
            const item = document.createElement("div");
            item.textContent = name;
            item.onclick = () => selectMention(name);
            dropdown.appendChild(item);
        });

        dropdown.style.display = "block";
    }

    function hideDropdown() {
        dropdown.style.display = "none";
    }

    function selectMention(name) {
        const start = input.selectionStart;
        const before = input.value.slice(0, start);
        const after = input.value.slice(start);

        const atIndex = before.lastIndexOf("@");
        input.value = before.slice(0, atIndex + 1) + name + " " + after;

        hideDropdown();
    }

    input.addEventListener("input", () => {
        const cursor = input.selectionStart;
        const text = input.value.slice(0, cursor);
        const atIndex = text.lastIndexOf("@");

        if (atIndex === -1) {
            hideDropdown();
            return;
        }

        const query = text.slice(atIndex + 1).toLowerCase();

        const matches = friends.filter(u =>
            u.toLowerCase().startsWith(query)
        );

        showDropdown(matches);
    });

    document.addEventListener("click", e => {
        if (e.target !== dropdown && e.target !== input)
            hideDropdown();
    });
});

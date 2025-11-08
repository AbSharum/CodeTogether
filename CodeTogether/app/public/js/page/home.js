function onStatusChange({ userID, status }) {
    const friendItem = document.querySelector(`.friend-item[data-friend-id='${userID}']`);
    if (!friendItem) return;

    const statusEl = friendItem.querySelector('small');
    const avatarEl = friendItem.querySelector('img');
    if (!statusEl || !avatarEl) return;

    // Default: offline
    let statusClass = 'text-danger';
    let text = 'Offline';
    let color = 'd9534f';

    if (status === 'online') {
        statusClass = 'text-success';
        text = 'Online';
        color = '5cb85c';
    } else if (status === 'away') {
        statusClass = 'text-warning';
        text = 'Away';
        color = 'f0ad4e';
    }

    // Update status text and color
    statusEl.textContent = text;
    statusEl.className = statusClass;

    // Update avatar color (rebuild the placeholder URL)
    const initial = avatarEl.src.split('text=')[1]?.[0] || 'U';
    avatarEl.src = `https://placehold.co/40x40/${color}/ffffff?text=${initial}`;
}

// JavaScript for the Editable "About Me" Section
// Simplified About Me Form (no toggle, uses normal form submission)
document.addEventListener('DOMContentLoaded', () => {
    const editorTextarea = document.getElementById('aboutMeEditor');
    const form = editorTextarea?.closest('form');

    if (!editorTextarea || !form) {
        console.warn("About Me form not found — skipping setup.");
        return;
    }

    // Optional client-side validation
    form.addEventListener('submit', (e) => {
        const aboutMe = editorTextarea.value.trim();

        if (aboutMe.length > 5000) {
            e.preventDefault();
            alert("Your About Me is too long. Please keep it under 5000 characters.");
        } else {
            console.log("Submitting About Me form:", aboutMe);
        }

    });

    // Note: The click events for stat-item and PHP integration points remain the same as before.
    console.log('Homepage layout initialized with 3 columns and editable bio.');

});
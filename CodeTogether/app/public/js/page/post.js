document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.edit-post-btn').forEach(btn => {
        btn.addEventListener('click', () => {
        const id = btn.dataset.postId;
        document.getElementById(`post-content-${id}`).classList.add('d-none');
        document.getElementById(`edit-form-${id}`).classList.remove('d-none');
        });
    });

    document.querySelectorAll('.cancel-edit').forEach(btn => {
        btn.addEventListener('click', () => {
        const id = btn.dataset.postId;
        document.getElementById(`edit-form-${id}`).classList.add('d-none');
        document.getElementById(`post-content-${id}`).classList.remove('d-none');
        });
    });

    document.querySelectorAll(".like-form").forEach(form => {
        form.addEventListener("submit", async e => {
        e.preventDefault();

        const formData = new FormData(form);
        const heartIcon = form.querySelector("i");
        const likeCount = form.querySelector(".like-count");

        try {
            const res = await fetch(form.action, {
            method: "POST",
            body: formData,
            headers: { "X-Requested-With": "XMLHttpRequest" }
            });

            const data = await res.json();
            if (!data.success) throw new Error("Like failed");

            // Toggle the heart color
            heartIcon.classList.toggle("text-danger", data.liked);
            heartIcon.classList.toggle("text-secondary", !data.liked);

            // Update like count
            likeCount.textContent = data.likes;
        } catch (err) {
            console.error("Like error:", err);
        }
        });
    });
});
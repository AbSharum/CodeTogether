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
});
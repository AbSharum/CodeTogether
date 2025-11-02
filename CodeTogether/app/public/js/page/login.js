function togglePassword() {
    const field = document.getElementById('password');
    field.type = field.type === 'password' ? 'text' : 'password';
}
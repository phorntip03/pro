// assets/js/reset-password.js
document.addEventListener('DOMContentLoaded', function () {
    window.togglePassword = function(id, btn) {
        const input = document.getElementById(id);
        const icon = btn.querySelector('i');

        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("bi-eye");
            icon.classList.add("bi-eye-slash");
            btn.setAttribute("title", "ซ่อนรหัสผ่าน");
        } else {
            input.type = "password";
            icon.classList.remove("bi-eye-slash");
            icon.classList.add("bi-eye");
            btn.setAttribute("title", "ดูรหัสผ่าน");
        }
    };
});

function validateForm() {
    let fullName = document.getElementById('fullName').value.trim();
    let emailInput = document.getElementById('email').value.trim();
    let passwordInput = document.getElementById('password').value.trim();
    let confirmPasswordInput = document.getElementById('confirmPassword').value.trim();


    document.getElementById('name-error').innerText = '';
    document.getElementById('email-error').innerText = '';
    document.getElementById('password-error').innerText = '';
    document.getElementById('confirm-password-error').innerText = '';

    let isValid = true;

    let fullnameRegex = /^[A-Z][a-z]*( [A-Z][a-z]*)*$/; 
    if (!fullName || !fullnameRegex.test(fullName)) {
        document.getElementById('name-error').innerText = 'Please enter a valid full name (e.g., John Doe)';
        isValid = false;
    }

    let emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/; 
    if (!emailInput || !emailRegex.test(emailInput)) {
        document.getElementById('email-error').innerText = 'Please enter a valid email address';
        isValid = false;
    }

    let passwordRegex = /^(?=.*[A-Z])(?=.*\d).{8,}$/; 
    if (!passwordInput || !passwordRegex.test(passwordInput)) {
        document.getElementById('password-error').innerText =
            'Password must be at least 8 characters long, contain one uppercase letter, and one digit';
        isValid = false;
    }
    if (confirmPasswordInput !== passwordInput) {
        document.getElementById('confirm-password-error').innerText = 'Passwords do not match';
        isValid = false;
    }
    return isValid;
}

document.addEventListener("DOMContentLoaded", () => {
    const menuBtn = document.querySelector("#menu-btn");
    const sidebar = document.querySelector(".sidebar");
    const closeBtn = document.querySelector(".close-btn");

    menuBtn.addEventListener("click", () => {
        sidebar.classList.add("active");
    });

    closeBtn.addEventListener("click", () => {
        sidebar.classList.remove("active");
    });
});
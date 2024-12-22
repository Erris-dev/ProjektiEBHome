function validateLogin(){
    let usernameInput = document.getElementById('username').value;
    let passwordInput = document.getElementById('password').value;

    document.getElementById('username-error').innerText='';
    document.getElementById('password-error').innerText='';

    let usernameRegex = /^[A-Z][a-z]*$/;

    if(!usernameInput || !usernameRegex.test(usernameInput)){
        document.getElementById('username-error').innerText='Error: Please enter a valid username!';
        return false;
    }

    let passwordRegex = /^(?=.*[A-Z])(?=.*\d).{8,}$/;

    if(!passwordInput || !passwordRegex.test(passwordInput)){
        document.getElementById('password-error').innerText='Error:Please enter a valid password!';
        return false;
    }
    return true;
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
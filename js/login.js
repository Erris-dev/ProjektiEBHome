function validateLogin(){
    let emailInput = document.getElementById('email').value;
    let passwordInput = document.getElementById('password').value;

    document.getElementById('email-error').innerText='';
    document.getElementById('password-error').innerText='';

    let emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    if(!emailInput || !emailRegex.test(emailInput)){
        document.getElementById('email-error').innerText='Error: Please enter a valid email!';
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
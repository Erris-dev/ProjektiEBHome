const form = document.getElementById('form');
const firstName = document.getElementById('firstname');
const lastName = document.getElementById('lastname');
const email = document.getElementById('email');
const password = document.getElementById('password');
const confirmPassword = document.getElementById('confirmPassword');

    
    form.addEventListener('submit', function(event) {
        event.preventDefault(); 
        
        
        document.querySelectorAll('.error').forEach(function(element) {
            element.textContent = '';
        });

        let isValid = true;

        
        if (!firstName.value.trim() || !lastName.value.trim()) {
            document.getElementById('name-error').textContent = 'Both first and last names are required.';
            isValid = false;
        }

        
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!email.value.trim() || !emailPattern.test(email.value.trim())) {
            document.getElementById('email-error').textContent = 'Please enter a valid email address.';
            isValid = false;
        }

        
        if (!password.value.trim() || password.value.length < 8) {
            document.getElementById('password-error').textContent = 'Password must be at least 6 characters long.';
            isValid = false;
        }

        
        if (password.value !== confirmPassword.value) {
            document.getElementById('confirm-password-error').textContent = 'Passwords do not match.';
            isValid = false;
        }

        if (isValid) {
            alert('Form submitted successfully!');
        }
    });



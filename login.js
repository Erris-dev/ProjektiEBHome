const form = document.getElementById('form');
const username = document.getElementById('username');
const password = document.getElementById('password');

   
    form.addEventListener('submit', function(event) {
        event.preventDefault(); 

        
        document.querySelectorAll('.error').forEach(function(element) {
            element.textContent = '';
        });

        let isValid = true;

        if (!username.value.trim()) {
            document.getElementById('username-error').textContent = 'Username is required.';
            isValid = false;
        }

        if (!password.value.trim()) {
            document.getElementById('password-error').textContent = 'Password is required.';
            isValid = false;
        } else if (password.value.length < 8) {
            document.getElementById('password-error').textContent = 'Password must be at least 8 characters long.';
            isValid = false;
        }

        if (isValid) {
            alert('Login successful!');
        }
    });
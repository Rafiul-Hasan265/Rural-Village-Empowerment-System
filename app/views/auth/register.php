<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration-AgriLand Ecosystem</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../../asset/css/auth/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/asset/css/auth/style.css">
</head>
<body>
    <div class="floating-shape shape-1"></div>
    <div class="floating-shape shape-2"></div>
    <div class="floating-shape shape-3"></div>
    <div class="floating-shape shape-4"></div>

    <div class="container">
        <div class="glass-card">
            <a href="index.php?url=home" class="logo">
                <div class="logo-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                </div>
                <span>AgriLand Ecosystem</span>
            </a>

            <div class="form-header">
                <h2>Create an Account</h2>
                <p>Already have an account? <a href="index.php?url=login">Sign in</a></p>
            </div>

            <form id="regForm" action="index.php?url=process_register" method="POST">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" name="full_name" id="name" placeholder="Enter your full name" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" placeholder="you@example.com" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" name="phone" id="phone" placeholder="01XXXXXXXXX" required>
                    </div>

                    <div class="form-group">
                        <label for="district">District</label>
                        <input type="text" name="district" id="district" placeholder="e.g. Bogura" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="password-wrapper">
                        <input type="password" name="password" id="password" placeholder="Min 6 characters" required>
                        <button type="button" class="toggle-password" onclick="togglePass('password', 'eye1')">
                            <svg id="eye1" width="18" height="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <div class="password-wrapper">
                        <input type="password" id="confirm_password" placeholder="Repeat your password" required>
                        <button type="button" class="toggle-password" onclick="togglePass('confirm_password', 'eye2')">
                            <svg id="eye2" width="18" height="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </button>
                    </div>
                    <span id="matchError" class="error-msg-text">Password does not match.</span>
                </div>

                <div class="form-group">
                    <label for="role">I am a</label>
                    <select name="role" id="role">
                        <option value="landowner">Landowner</option>
                        <option value="farmer">Farmer</option>
                        <option value="company">Equipment Renter Company</option>
                    </select>
                </div>

                <button type="submit">Create Account</button>
            </form>

            <p class="terms">
                By registering, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
            </p>
            </div>
    </div>

    <script>
        function togglePass(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
            } else {
                input.type = 'password';
                icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
            }
        }

        // Task 2: JS Validation
        document.getElementById('regForm').onsubmit = function() {
            const name = document.getElementById('name').value;
            const pass = document.getElementById('password').value;
            const confirmPass = document.getElementById('confirm_password').value;
            const matchError = document.getElementById('matchError');
            
            matchError.style.display = 'none';

            if (name.length < 3) {
                alert("Name must be at least 3 characters.");
                return false;
            }
            if (pass.length < 6) {
                alert("Password must be at least 6 characters.");
                return false;
            }
            if (pass !== confirmPass) {
                matchError.style.display = 'block';
                return false;
            }
            return true;
        };

        function closeModal(id) {
            document.getElementById(id).style.display = 'none';
        }
    </script>

    <?php if(isset($_SESSION['reg_success'])): ?>
    <div id="successModal" class="modal-wrapper">
        <div class="modal-box">
            <div class="icon-circle success-bg">✓</div>
            <h2>Registration Successful!</h2>
            <p>Your account has been created. You can now login.</p>
            <button onclick="window.location.href='index.php?url=login'" class="modal-btn">Go to Login</button>
        </div>
    </div>
    <?php unset($_SESSION['reg_success']); endif; ?>

    <?php if(isset($_SESSION['reg_error_email'])): ?>
    <div id="errorModal" class="modal-wrapper">
        <div class="modal-box">
            <div class="icon-circle error-bg">✕</div>
            <h2 style="color: #dc3545;">Registration Failed!</h2>
            <p><?php echo $_SESSION['reg_error_email']; ?></p>
            <button onclick="closeModal('errorModal')" class="modal-btn" style="background: #dc3545;">Try Again</button>
        </div>
    </div>
    <?php unset($_SESSION['reg_error_email']); endif; ?>

</body>
</html>
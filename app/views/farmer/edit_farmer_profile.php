<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Agri-Service</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-green: #2d5a3d;
            --primary-dark: #1a3322;
            --accent-green: #4caf50;
            --light-green: #e8f5e9;
            --white: #ffffff;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-500: #6b7280;
            --gray-700: #374151;
            --gray-900: #111827;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #f0f7f0 0%, #e8f5e9 50%, #f5f5f5 100%);
            min-height: 100vh;
            color: var(--gray-900);
            line-height: 1.6;
        }

        /* Header */
        .header {
            background: var(--white);
            border-bottom: 1px solid var(--gray-200);
            padding: 16px 40px;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: var(--shadow-sm);
        }

        .header-content {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            cursor: pointer;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-green), var(--accent-green));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-icon svg {
            width: 24px;
            height: 24px;
            fill: var(--white);
        }

        .logo-text {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary-dark);
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: var(--white);
            color: var(--primary-green);
            border: 2px solid var(--primary-green);
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            background: var(--primary-green);
            color: var(--white);
        }

        .back-btn svg {
            width: 18px;
            height: 18px;
            fill: currentColor;
        }

        /* Main Content */
        .main-content {
            max-width: 600px;
            margin: 0 auto;
            padding: 40px 24px 60px;
        }

        /* Page Title */
        .page-title {
            text-align: center;
            margin-bottom: 32px;
        }

        .page-title h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 8px;
        }

        .page-title p {
            color: var(--gray-500);
            font-size: 0.95rem;
        }

        /* Form Card */
        .form-card {
            background: var(--white);
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            overflow: hidden;
        }

        .form-header {
            background: linear-gradient(135deg, var(--primary-green), var(--primary-dark));
            padding: 24px;
            text-align: center;
        }

        .form-header-icon {
            width: 64px;
            height: 64px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
        }

        .form-header-icon svg {
            width: 32px;
            height: 32px;
            fill: var(--white);
        }

        .form-header h2 {
            color: var(--white);
            font-size: 1.25rem;
            font-weight: 600;
        }

        .form-body {
            padding: 32px;
        }

        /* Form Sections */
        .form-section {
            margin-bottom: 28px;
        }

        .form-section:last-child {
            margin-bottom: 0;
        }

        .section-title {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--primary-green);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 16px;
            padding-bottom: 8px;
            border-bottom: 2px solid var(--light-green);
        }

        /* Form Groups */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group:last-child {
            margin-bottom: 0;
        }

        .form-group label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--gray-700);
            margin-bottom: 8px;
        }

        .form-group label .required {
            color: #ef4444;
            margin-left: 2px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper svg {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            fill: var(--gray-500);
            pointer-events: none;
            transition: fill 0.3s ease;
        }

        .form-group input {
            width: 100%;
            padding: 14px 14px 14px 44px;
            font-size: 0.95rem;
            font-family: inherit;
            color: var(--gray-900);
            background: var(--gray-50);
            border: 2px solid var(--gray-200);
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .form-group input:hover {
            border-color: var(--gray-300);
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary-green);
            background: var(--white);
            box-shadow: 0 0 0 4px rgba(45, 90, 61, 0.1);
        }

        .form-group input:focus + svg,
        .input-wrapper:focus-within svg {
            fill: var(--primary-green);
        }

        .form-group input::placeholder {
            color: var(--gray-500);
        }

        /* Input with suffix */
        .input-with-suffix {
            position: relative;
        }

        .input-with-suffix input {
            padding-right: 50px;
        }

        .input-suffix {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--gray-500);
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            padding: 16px 24px;
            font-size: 1rem;
            font-weight: 600;
            font-family: inherit;
            color: var(--white);
            background: linear-gradient(135deg, var(--primary-green), var(--accent-green));
            border: none;
            border-radius: 10px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 24px;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-md);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-xl);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-submit svg {
            width: 20px;
            height: 20px;
            fill: currentColor;
        }

        /* Success Popup */
        .popup {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background: linear-gradient(135deg, var(--accent-green), var(--primary-green));
            color: var(--white);
            padding: 16px 24px;
            border-radius: 12px;
            box-shadow: var(--shadow-xl);
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideIn 0.5s ease-out, fadeOut 0.5s ease-in 2.5s forwards;
        }

        .popup svg {
            width: 24px;
            height: 24px;
            fill: currentColor;
            flex-shrink: 0;
        }

        .popup-text {
            font-weight: 500;
        }

        @keyframes slideIn {
            from {
                transform: translateY(100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }
            to {
                opacity: 0;
                visibility: hidden;
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .header {
                padding: 12px 16px;
            }

            .logo-text {
                font-size: 1.1rem;
            }

            .back-btn span {
                display: none;
            }

            .back-btn {
                padding: 10px;
            }

            .main-content {
                padding: 24px 16px 40px;
            }

            .page-title h1 {
                font-size: 1.5rem;
            }

            .form-body {
                padding: 24px 20px;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }
        }

        @media (max-width: 480px) {
            .logo-icon {
                width: 36px;
                height: 36px;
            }

            .logo-icon svg {
                width: 20px;
                height: 20px;
            }

            .form-header {
                padding: 20px;
            }

            .form-header-icon {
                width: 56px;
                height: 56px;
            }

            .form-header-icon svg {
                width: 28px;
                height: 28px;
            }

            .form-header h2 {
                font-size: 1.1rem;
            }

            .form-group input {
                padding: 12px 12px 12px 40px;
                font-size: 0.9rem;
            }

            .input-wrapper svg {
                width: 16px;
                height: 16px;
                left: 12px;
            }

            .btn-submit {
                padding: 14px 20px;
                font-size: 0.95rem;
            }

            .popup {
                bottom: 16px;
                right: 16px;
                left: 16px;
                padding: 14px 18px;
            }
        }
    </style>
</head>
<body>

<?php if(isset($_GET['status']) && $_GET['status'] == 'success'): ?>
    <div class="popup" id="msgPopup">
        <svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
        <span class="popup-text">Profile Updated Successfully!</span>
    </div>
    <script>setTimeout(() => { document.getElementById('msgPopup').style.display = 'none'; }, 3000);</script>
<?php endif; ?>

<!-- Header -->
<header class="header">
    <div class="header-content">
        <a href="#" class="logo">
            <div class="logo-icon">
                <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
            </div>
            <span class="logo-text">Agri-Service</span>
        </a>
        <a href="index.php?url=farmer_dashboard" class="back-btn">
            <svg viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
            <span>Back to Dashboard</span>
        </a>
    </div>
</header>

<!-- Main Content -->
<main class="main-content">
    <div class="page-title">
        <h1>Edit Your Profile</h1>
        <p>Update your personal information and work details</p>
    </div>

    <div class="form-card">
        <div class="form-header">
            <div class="form-header-icon">
                <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
            </div>
            <h2>Profile Information</h2>
        </div>

        <div class="form-body">
            <form action="index.php?url=process_farmer_update" method="POST">
                
                <!-- Personal Information Section -->
                <div class="form-section">
                    <h3 class="section-title">Personal Information</h3>
                    
                    <div class="form-group">
                        <label>Full Name <span class="required">*</span></label>
                        <div class="input-wrapper">
                            <input type="text" name="full_name" value="<?php echo $user['full_name']; ?>" placeholder="Enter your full name" required>
                            <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Email <span class="required">*</span></label>
                            <div class="input-wrapper">
                                <input type="email" name="email" value="<?php echo $user['email']; ?>" placeholder="your@email.com" required>
                                <svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Phone <span class="required">*</span></label>
                            <div class="input-wrapper">
                                <input type="text" name="phone" value="<?php echo $user['phone']; ?>" placeholder="01XXXXXXXXX" required>
                                <svg viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>District <span class="required">*</span></label>
                        <div class="input-wrapper">
                            <input type="text" name="district" value="<?php echo $user['district']; ?>" placeholder="Enter your district" required>
                            <svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                        </div>
                    </div>
                </div>

                <!-- Work Details Section -->
                <div class="form-section">
                    <h3 class="section-title">Work Details</h3>

                    <div class="form-group">
                        <label>Skills <span class="required">*</span></label>
                        <div class="input-wrapper">
                            <input type="text" name="skills" value="<?php echo $farmer['skills']; ?>" placeholder="e.g., Harvesting, Plowing, Irrigation" required>
                            <svg viewBox="0 0 24 24"><path d="M22.7 19l-9.1-9.1c.9-2.3.4-5-1.5-6.9-2-2-5-2.4-7.4-1.3L9 6 6 9 1.6 4.7C.4 7.1.9 10.1 2.9 12.1c1.9 1.9 4.6 2.4 6.9 1.5l9.1 9.1c.4.4 1 .4 1.4 0l2.3-2.3c.5-.4.5-1.1.1-1.4z"/></svg>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Experience <span class="required">*</span></label>
                            <div class="input-wrapper input-with-suffix">
                                <input type="number" name="experience" value="<?php echo $farmer['experience_years']; ?>" placeholder="0" min="0" required>
                                <svg viewBox="0 0 24 24"><path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                                <span class="input-suffix">Years</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Daily Wage <span class="required">*</span></label>
                            <div class="input-wrapper input-with-suffix">
                                <input type="number" name="wage" value="<?php echo $farmer['daily_wage']; ?>" placeholder="0" min="0" required>
                                <svg viewBox="0 0 24 24"><path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/></svg>
                                <span class="input-suffix">BDT</span>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                    Update Profile
                </button>
            </form>
        </div>
    </div>
</main>

<script>
    // Add input focus animations
    document.querySelectorAll('.form-group input').forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
        });
    });
</script>

</body>
</html>

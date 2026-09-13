<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Agri-Service</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/asset/css/home/style.css">
</head>
<body>

    <header>
        <div class="logo">
            <a href="index.php?url=home">
              <div class="logo-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
              </div>
              <h2><span> AgriLand-Ecosystem</span></h2>
            </a>
        </div>
        <nav class="nav-links">
            <a href="index.php?url=home">Home</a>
            <a href="index.php?url=register">Registration</a>
            <a href="index.php?url=login">Login</a>
        </nav>
    </header>

    <section class="hero">
        <div class="hero-content">
            <span class="hero-badge">Digital Agriculture Platform</span>
            <h1>Modernizing Agriculture <br><span>in Your District</span></h1>
            <p>
                A comprehensive digital platform bridging Landowners, Farmers, and Machinery Companies. 
                Simplifying agricultural production with a one-stop shop for labor and equipment.
            </p>
            <div class="hero-buttons">
                <a href="index.php?url=register" class="btn btn-main">
                    Get Started
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
                <a href="#who-we-serve" class="btn btn-secondary">Learn More</a>
            </div>
        </div>
    </section>

    <section class="purposes" id="who-we-serve">
        <div class="section-header">
            <h2>Who We Serve</h2>
            <p>Connecting every stakeholder in the agricultural ecosystem</p>
        </div>
        <div class="cards-container">
            <div class="card">
                <div class="card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                </div>
                <h3>For Landowners</h3>
                <p>Easily find and hire skilled farmers in your specific district. Browse profiles and manage your hire requests in one place.</p>
            </div>
            <div class="card">
                <div class="card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                <h3>For Farmers</h3>
                <p>Set your availability, showcase your skills, and get hired by landowners nearby. Boost your income with consistent work.</p>
            </div>
            <div class="card">
                <div class="card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                    </svg>
                </div>
                <h3>For Companies</h3>
                <p>List your agricultural machinery like tractors and harvesters for rent or sale. Manage your inventory and track orders digitally.</p>
            </div>
        </div> 
    </section>

    <footer>
        <div class="footer-content">
            <div class="footer-brand">
                <h3>AgriLand-Ecosystem</h3>
                <p>Empowering agricultural communities with digital solutions for a sustainable future.</p>
            </div>
            <div class="contact-info">
                <h4>Contact Us</h4>
                <p>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                        <polyline points="22,6 12,13 2,6"/>
                    </svg>
                    admin@agriservice.com
                </p>
                <p>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72"/>
                    </svg>
                    +880 1896229708
                </p>
                <p>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                    Bashundhara R/A, Dhaka, Bangladesh
                </p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 AgriLand-Ecosystem. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>

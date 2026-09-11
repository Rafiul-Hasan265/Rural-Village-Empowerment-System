<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landowner Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #166534;
            --primary-light: #22c55e;
            --primary-bg: #f0fdf4;
            --accent: #ea580c;
            --accent-light: #fb923c;
            --accent-bg: #fff7ed;
            --dark: #1e293b;
            --gray-600: #475569;
            --gray-200: #e2e8f0;
            --gray-100: #f1f5f9;
            --white: #ffffff;
        }

        body { 
            font-family: 'Plus Jakarta Sans', Arial, sans-serif; 
            color: var(--dark);
            min-height: 100vh;
            background: 
                linear-gradient(rgba(241, 245, 249, 0.88), rgba(241, 245, 249, 0.88)),
                url('/real-farming-background.jpg') center/cover fixed;
        }

        /* ========== NAVBAR ========== */
        .navbar {
            background: var(--white);
            padding: 0 40px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 15px rgba(0,0,0,0.06);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .nav-logo {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
        }

        .nav-title {
            font-size: 22px;
            font-weight: 800;
            color: var(--dark);
        }

        .nav-title span { color: var(--primary); }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .btn-cart {
            position: relative;
            background: var(--gray-100);
            padding: 10px 18px;
            border-radius: 10px;
            text-decoration: none;
            color: var(--dark);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-cart:hover {
            background: var(--primary-bg);
            color: var(--primary);
        }

        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--accent);
            color: white;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 20px;
            min-width: 20px;
            text-align: center;
        }

        .btn-logout {
            background: #fef2f2;
            color: #dc2626;
            padding: 10px 18px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-logout:hover {
            background: #dc2626;
            color: white;
        }

        .btn-update {
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            color: var(--dark);
            padding: 10px 18px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 700;
            font-family: inherit;
            transition: all 0.2s;
        }

        .btn-update:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        }

        /* ========== HERO SECTION ========== */
        .hero {
            position: relative;
            height: 350px;
            background: url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80') center/cover no-repeat;
            display: flex;
            align-items: flex-end;
            padding: 50px 40px;
        }

        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(30, 41, 59, 0.9) 0%, rgba(30, 41, 59, 0.4) 50%, transparent 100%);
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .hero-title {
            color: white;
            font-size: 42px;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .hero-subtitle {
            color: rgba(255,255,255,0.8);
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .hero-location {
            background: rgba(34, 197, 94, 0.25);
            padding: 6px 14px;
            border-radius: 20px;
            color: #86efac;
            font-weight: 600;
        }

        /* ========== MAIN CONTENT ========== */
        .main-content {
            max-width: 1300px;
            margin: 0 auto;
            padding: 40px;
        }

        /* ========== SERVICE SECTION HEADERS ========== */
        .section-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin: 40px 0 24px;
            padding: 20px 24px;
            border-radius: 16px;
        }

        .section-header.farmer {
            background: linear-gradient(135deg, var(--primary-bg), #dcfce7);
            border-left: 5px solid var(--primary);
        }

        .section-header.equipment {
            background: linear-gradient(135deg, var(--accent-bg), #fed7aa);
            border-left: 5px solid var(--accent);
        }

        .section-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
        }

        .section-icon.farmer { background: linear-gradient(135deg, var(--primary), var(--primary-light)); }
        .section-icon.equipment { background: linear-gradient(135deg, var(--accent), var(--accent-light)); }

        .section-title {
            font-size: 24px;
            font-weight: 800;
        }

        .section-header.farmer .section-title { color: var(--primary); }
        .section-header.equipment .section-title { color: var(--accent); }

        /* ========== UPDATE FORM ========== */
        #updateFormSection {
            background: white;
            padding: 28px;
            border-radius: 16px;
            margin: 20px 0;
            border: 1px solid var(--gray-200);
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        #updateFormSection h3 {
            margin-bottom: 20px;
            color: var(--dark);
            font-size: 20px;
        }

        #updateFormSection label {
            font-weight: 600;
            color: var(--gray-600);
            font-size: 14px;
        }

        #updateFormSection input {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--gray-200);
            border-radius: 10px;
            font-family: inherit;
            font-size: 14px;
            margin-top: 6px;
            transition: border-color 0.2s;
        }

        #updateFormSection input:focus {
            outline: none;
            border-color: var(--primary);
        }

        #updateFormSection button[type="submit"] {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 700;
            font-family: inherit;
            margin-right: 10px;
        }

        #updateFormSection button[type="button"] {
            background: var(--gray-100);
            color: var(--gray-600);
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 700;
            font-family: inherit;
        }

        /* ========== TABLES ========== */
        .table-card {
            background: var(--white);
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.04);
            border: 1px solid var(--gray-200);
        }

        .table-card h3 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 20px;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        table { 
            width: 100%; 
            border-collapse: collapse; 
            background: var(--white);
            border-radius: 12px;
            overflow: hidden;
        }

        th { 
            background: var(--gray-100);
            padding: 14px 16px;
            text-align: left;
            font-size: 12px;
            font-weight: 700;
            color: var(--gray-600);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td { 
            padding: 16px;
            border-top: 1px solid var(--gray-200);
            font-size: 14px;
        }

        tr:hover td { background: var(--gray-100); }

        .status-available {
            background: var(--primary-bg);
            color: var(--primary);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        .status-busy {
            background: #fef2f2;
            color: #dc2626;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        .status-pending {
            color: #d97706;
            font-weight: 700;
        }

        .status-accepted {
            color: var(--primary);
            font-weight: 700;
        }

        .status-rejected {
            color: #dc2626;
            font-weight: 700;
        }

        .status-progress {
            color: #2563eb;
            font-weight: 700;
        }

        .btn-hire { 
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white; 
            padding: 8px 16px; 
            text-decoration: none; 
            border-radius: 8px; 
            font-size: 13px;
            font-weight: 600;
            margin-left: 10px;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
            font-family: inherit;
        }

        .btn-hire:hover { 
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(22, 101, 52, 0.3);
        }

        /* ========== INSTRUMENT CARDS ========== */
        .card-container { 
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 24px; 
            margin-top: 20px; 
        }

        .card { 
            background: var(--white);
            border: 1px solid var(--gray-200); 
            padding: 24px; 
            border-radius: 16px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.04);
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--accent), var(--accent-light));
            opacity: 0;
            transition: opacity 0.3s;
        }

        .card:hover {
            border-color: var(--accent);
            transform: translateY(-6px);
            box-shadow: 0 12px 30px rgba(234, 88, 12, 0.12);
        }

        .card:hover::before { opacity: 1; }

        .card h4 {
            font-size: 18px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 12px;
        }

        .card p {
            font-size: 14px;
            color: var(--gray-600);
            margin: 8px 0;
        }

        .card p strong { color: var(--accent); }

        .card .price-box {
            background: var(--gray-100);
            padding: 14px;
            border-radius: 10px;
            margin: 16px 0;
        }

        .card .price-rent {
            color: var(--primary);
            font-weight: 700;
            font-size: 15px;
        }

        .card .price-buy {
            color: #2563eb;
            font-weight: 700;
            font-size: 15px;
        }

        .btn-add-cart {
            background: linear-gradient(135deg, var(--accent), var(--accent-light));
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 10px;
            display: inline-block;
            text-align: center;
            font-weight: 700;
            font-size: 14px;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
            font-family: inherit;
        }

        .btn-add-cart:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(234, 88, 12, 0.35);
        }

        /* ========== MESSAGE BOX ========== */
        #msg-box {
            padding: 16px 20px;
            margin-bottom: 24px;
            border-radius: 12px;
            text-align: center;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        #msg-box a {
            color: #2563eb;
            font-weight: 700;
        }

        .msg-success {
            background: #dcfce7;
            color: var(--primary);
            border: 1px solid #bbf7d0;
        }

        .msg-exists {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }

        .empty-message {
            text-align: center;
            padding: 40px;
            color: var(--gray-600);
            font-size: 15px;
        }

        hr { display: none; }

        /* ========== HIRE CONFIRMATION POPUP ========== */
        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            padding: 20px;
        }

        .popup-overlay.active {
            display: flex;
        }

        .popup-box {
            background: var(--white);
            border-radius: 16px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
            max-width: 420px;
            width: 100%;
            animation: popupSlideIn 0.3s ease-out;
            overflow: hidden;
        }

        @keyframes popupSlideIn {
            from {
                transform: scale(0.9) translateY(-20px);
                opacity: 0;
            }
            to {
                transform: scale(1) translateY(0);
                opacity: 1;
            }
        }

        .popup-header {
            padding: 28px 28px 0;
            text-align: center;
        }

        .popup-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
            background: var(--primary-bg);
        }

        .popup-icon svg {
            width: 32px;
            height: 32px;
            fill: var(--primary);
        }

        .popup-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .popup-message {
            color: var(--gray-600);
            font-size: 0.95rem;
            line-height: 1.6;
            padding: 0 28px 28px;
            text-align: center;
        }

        .popup-farmer-info {
            background: var(--gray-100);
            padding: 16px;
            border-radius: 12px;
            margin: 0 28px 20px;
            text-align: left;
        }

        .popup-farmer-info p {
            margin: 6px 0;
            font-size: 14px;
            color: var(--gray-600);
        }

        .popup-farmer-info p strong {
            color: var(--dark);
        }

        .popup-actions {
            display: flex;
            border-top: 1px solid var(--gray-200);
        }

        .popup-btn {
            flex: 1;
            padding: 18px;
            border: none;
            font-size: 0.95rem;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .popup-btn-cancel {
            background: var(--gray-100);
            color: var(--gray-600);
        }

        .popup-btn-cancel:hover {
            background: var(--gray-200);
        }

        .popup-btn-confirm {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: var(--white);
        }

        .popup-btn-confirm:hover {
            opacity: 0.9;
        }

        /* ========== UPDATE PROFILE MODAL ========== */
        .update-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            padding: 20px;
        }

        .update-modal-overlay.active {
            display: flex;
        }

        .update-modal-box {
            background: var(--white);
            border-radius: 16px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
            max-width: 450px;
            width: 100%;
            animation: updateModalSlideIn 0.3s ease-out;
            overflow: hidden;
        }

        @keyframes updateModalSlideIn {
            from {
                transform: scale(0.9) translateY(-20px);
                opacity: 0;
            }
            to {
                transform: scale(1) translateY(0);
                opacity: 1;
            }
        }

        .update-modal-header {
            padding: 32px 24px 24px;
            text-align: center;
        }

        .update-modal-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
        }

        .update-modal-icon svg {
            width: 36px;
            height: 36px;
            fill: #f59e0b;
        }

        .update-modal-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .update-modal-message {
            color: var(--gray-600);
            font-size: 0.95rem;
            line-height: 1.6;
            padding: 0 24px 24px;
            text-align: center;
        }

        .update-modal-details {
            background: var(--gray-100);
            margin: 0 24px 24px;
            padding: 16px;
            border-radius: 10px;
            font-size: 0.875rem;
            color: var(--gray-700);
        }

        .update-modal-detail-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .update-modal-detail-item:last-child {
            margin-bottom: 0;
        }

        .update-modal-detail-label {
            font-weight: 500;
            color: var(--gray-600);
        }

        .update-modal-detail-value {
            color: var(--dark);
            font-weight: 600;
        }

        .update-modal-actions {
            display: flex;
            border-top: 1px solid var(--gray-200);
        }

        .update-modal-btn {
            flex: 1;
            padding: 16px 24px;
            border: none;
            font-size: 0.95rem;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            text-align: center;
        }

        .update-modal-btn-cancel {
            background: var(--gray-100);
            color: var(--gray-700);
            border-right: 1px solid var(--gray-200);
        }

        .update-modal-btn-cancel:hover {
            background: var(--gray-200);
        }

        .update-modal-btn-confirm {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: var(--white);
        }

        .update-modal-btn-confirm:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <div class="nav-brand">
        <div class="nav-logo">🌾</div>
        <div class="nav-title"><span>AgriLand-Ecosystem</span></div>
    </div>
    <div class="nav-right">
        <a href="index.php?url=view_cart" class="btn-cart">
            🛒 My Cart
            <span class="cart-badge"><?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?></span>
        </a>
        <button onclick="toggleUpdateForm()" class="btn-update">Update My Info</button>
        <a href="index.php?url=logout" class="btn-logout">Logout</a>
    </div>
</nav>

<!-- HERO SECTION -->
<section class="hero">
    <div class="hero-content">
        <h1 class="hero-title">Welcome, <?php echo $_SESSION['user_name']; ?></h1>
        <p class="hero-subtitle">
            <span class="hero-location">📍 <?php echo $_SESSION['user_district']; ?></span>
            Manage your farm workers and equipment rentals
        </p>
    </div>
</section>

<div class="main-content">

    <!-- UPDATE FORM -->
    <div id="updateFormSection" style="display: none;">
        <h3>Update Profile Information</h3>
        <form id="updateProfileForm" action="index.php?url=update_landowner_profile" method="POST">
            <div style="margin-bottom: 14px;">
                <label>Full Name:</label>
                <input type="text" name="full_name" id="updateFullName" value="<?php echo $_SESSION['user_name']; ?>" required>
            </div>
            <div style="margin-bottom: 14px;">
                <label>Email:</label>
                <input type="email" name="email" id="updateEmail" value="<?php echo $_SESSION['user_email'] ?? ''; ?>" required>
            </div>
            <div style="margin-bottom: 14px;">
                <label>District:</label>
                <input type="text" name="district" id="updateDistrict" value="<?php echo $_SESSION['user_district']; ?>" required>
            </div>
            <div style="margin-bottom: 20px;">
                <label>Phone Number:</label>
                <input type="text" name="phone" id="updatePhone" value="<?php echo $_SESSION['user_phone'] ?? ''; ?>" required>
            </div>
            <button type="button" onclick="showUpdateModal()">Save Changes</button>
            <button type="button" onclick="toggleUpdateForm()">Cancel</button>
        </form>
    </div>

    <!-- ==================== FARMER HIRING SECTION ==================== -->
    <div class="section-header farmer">
        <div class="section-icon farmer">👨‍🌾</div>
        <h2 class="section-title">Farmer Hiring</h2>
    </div>

    <!-- Available Farmers -->
    <div class="table-card">
        <h3>🌿 Available Farmers in your District</h3>
        <?php if(!empty($farmers)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>District</th>
                        <th>Skills</th>
                        <th>Daily Wage</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($farmers as $farmer): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($farmer['full_name']); ?></strong></td>
                            <td><?php echo htmlspecialchars($farmer['email']); ?></td>
                            <td><?php echo htmlspecialchars($farmer['district']); ?></td>
                            <td><?php echo $farmer['skills'] ?? 'N/A'; ?></td>
                            <td><strong>৳<?php echo $farmer['daily_wage'] ?? '0'; ?></strong></td>
                            <td>
                                <?php if($farmer['availability_status'] == 'available'): ?>
                                    <span class="status-available">Available</span>
                                    <button type="button" class="btn-hire" onclick="showHirePopup('<?php echo $farmer['id']; ?>', '<?php echo htmlspecialchars($farmer['full_name'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($farmer['email'], ENT_QUOTES); ?>', '<?php echo $farmer['daily_wage'] ?? '0'; ?>', '<?php echo $farmer['skills'] ?? 'N/A'; ?>')">Hire</button>
                                <?php else: ?>
                                    <span class="status-busy">Busy</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="empty-message">No farmers found in your district.</p>
        <?php endif; ?>
    </div>

    <!-- Currently Working -->
    <div class="table-card">
        <h3>👷 Currently Working Under You</h3>
        <table>
            <thead>
                <tr>
                    <th>Farmer Name</th>
                    <th>Email</th>
                    <th>Daily Wage</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($workingFarmers)): ?>
                    <?php foreach($workingFarmers as $worker): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($worker['full_name']); ?></strong></td>
                            <td><?php echo htmlspecialchars($worker['email']); ?></td>
                            <td><strong>৳<?php echo $worker['daily_wage'] ?? 'N/A'; ?></strong></td>
                            <td><span class="status-progress">Working</span></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4" class="empty-message">No active workers found at the moment.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Hire Requests -->
    <div class="table-card">
        <h3>📋 My Hire Requests Status</h3>
        <?php if(!empty($myRequests)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Farmer Name</th>
                        <th>District</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($myRequests as $res): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($res['farmer_name']); ?></strong></td>
                            <td><?php echo htmlspecialchars($res['district']); ?></td>
                            <td>
                                <span class="status-<?php echo $res['status']; ?>">
                                    <?php echo ucfirst($res['status']); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="empty-message">You haven't sent any hire requests yet.</p>
        <?php endif; ?>
    </div>

    <!-- ==================== EQUIPMENT RENTING SECTION ==================== -->
    <div class="section-header equipment">
        <div class="section-icon equipment">🚜</div>
        <h2 class="section-title">Equipment Renting</h2>
    </div>

    <!-- Message Box -->
    <?php if(isset($_GET['status'])): ?>
        <div id="msg-box" class="<?php echo ($_GET['status'] == 'success') ? 'msg-success' : 'msg-exists'; ?>">
            <?php
                if($_GET['status'] == 'success') echo "✅ Item successfully added to your cart!";
                if($_GET['status'] == 'exists') echo "ℹ️ Item is already in your cart!";
            ?>
            <a href="index.php?url=view_cart">View Cart</a>
        </div>
        <script>
            setTimeout(function() {
                document.getElementById('msg-box').style.display = 'none';
            }, 3000);
        </script>
    <?php endif; ?>

    <!-- Instruments Grid -->
    <?php if(!empty($instruments)): ?>
        <div class="card-container">
            <?php foreach($instruments as $item): ?>
                <div class="card">
                    <h4><?php echo htmlspecialchars($item['name']); ?></h4>
                    <p><strong>Provider:</strong> <?php echo htmlspecialchars($item['company_name']); ?></p>
                    <p><strong>Category:</strong> <?php echo htmlspecialchars($item['category']); ?></p>
                    <div class="price-box">
                        <p class="price-rent">Rent: ৳<?php echo number_format($item['rental_price'], 2); ?> /day</p>
                        <p class="price-buy">Buy: ৳<?php echo number_format($item['selling_price'], 2); ?></p>
                    </div>
                    <button type="button" class="btn-add-cart" onclick="addToCart(<?php echo $item['id']; ?>, this)">Add to Cart</button>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="empty-message">No instruments available at the moment.</p>
    <?php endif; ?>

</div>

<!-- Hire Confirmation Popup -->
<div class="popup-overlay" id="hirePopup">
    <div class="popup-box">
        <div class="popup-header">
            <div class="popup-icon">
                <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
            </div>
            <h3 class="popup-title">Confirm Hire Request</h3>
        </div>
        <div class="popup-farmer-info" id="popupFarmerInfo">
            <p><strong>Name:</strong> <span id="popupFarmerName"></span></p>
            <p><strong>Email:</strong> <span id="popupFarmerEmail"></span></p>
            <p><strong>Daily Wage:</strong> ৳<span id="popupFarmerWage"></span></p>
            <p><strong>Skills:</strong> <span id="popupFarmerSkills"></span></p>
        </div>
        <p class="popup-message">Are you sure you want to send a hire request to this farmer? They will be notified and can accept or reject your request.</p>
        <div class="popup-actions">
            <button type="button" class="popup-btn popup-btn-cancel" onclick="closeHirePopup()">Cancel</button>
            <a href="#" class="popup-btn popup-btn-confirm" id="popupConfirmBtn">Send Request</a>
        </div>
    </div>
</div>

<!-- Update Profile Modal -->
<div class="update-modal-overlay" id="updateProfileModal">
    <div class="update-modal-box">
        <div class="update-modal-header">
            <div class="update-modal-icon">
                <svg viewBox="0 0 24 24"><path d="M16.6915026,12.4744748 L3.50612381,13.2599618 C3.19218622,13.2599618 3.03521743,13.4170592 3.03521743,13.5741566 L1.15159189,20.0151496 C0.8376543,20.8006365 0.99,21.89 1.77946707,22.52 C2.41,22.99 3.50612381,23.1 4.13399899,22.8429026 L21.714504,14.0454487 C22.6563168,13.5741566 23.1272231,12.6315722 22.9702544,11.6889879 L4.13399899,1.16687741 C3.34915502,0.9097800428 2.40734225,1.02349812 1.77946707,1.4947902 C0.994623095,2.13114695 0.837654326,3.22 1.15159189,3.95669182 L3.03521743,10.3976849 C3.03521743,10.5547823 3.34915502,10.7118796 3.50612381,10.7118796 L16.6915026,11.4973666 C16.6915026,11.4973666 17.1624089,11.4973666 17.1624089,11.0260745 L17.1624089,12.4744748 C17.1624089,12.4744748 17.1624089,12.4744748 16.6915026,12.4744748 Z"/></svg>
            </div>
            <h3 class="update-modal-title">Update Your Profile</h3>
        </div>
        <p class="update-modal-message">Review your information before saving changes. Make sure all details are correct.</p>
        <div class="update-modal-details">
            <div class="update-modal-detail-item">
                <span class="update-modal-detail-label">Full Name:</span>
                <span class="update-modal-detail-value" id="modalFullName"></span>
            </div>
            <div class="update-modal-detail-item">
                <span class="update-modal-detail-label">Email:</span>
                <span class="update-modal-detail-value" id="modalEmail"></span>
            </div>
            <div class="update-modal-detail-item">
                <span class="update-modal-detail-label">District:</span>
                <span class="update-modal-detail-value" id="modalDistrict"></span>
            </div>
            <div class="update-modal-detail-item">
                <span class="update-modal-detail-label">Phone:</span>
                <span class="update-modal-detail-value" id="modalPhone"></span>
            </div>
        </div>
        <div class="update-modal-actions">
            <button type="button" class="update-modal-btn update-modal-btn-cancel" onclick="closeUpdateModal()">Cancel</button>
            <button type="button" class="update-modal-btn update-modal-btn-confirm" onclick="submitUpdateForm()">Save Changes</button>
        </div>
    </div>
</div>

<script>
function toggleUpdateForm() {
    var form = document.getElementById("updateFormSection");
    form.style.display = (form.style.display === "none") ? "block" : "none";
}

// Show Update Modal
function showUpdateModal() {
    var fullName = document.getElementById('updateFullName').value;
    var email = document.getElementById('updateEmail').value;
    var district = document.getElementById('updateDistrict').value;
    var phone = document.getElementById('updatePhone').value;

    document.getElementById('modalFullName').textContent = fullName || 'Not provided';
    document.getElementById('modalEmail').textContent = email || 'Not provided';
    document.getElementById('modalDistrict').textContent = district || 'Not provided';
    document.getElementById('modalPhone').textContent = phone || 'Not provided';

    document.getElementById('updateProfileModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

// Close Update Modal
function closeUpdateModal() {
    document.getElementById('updateProfileModal').classList.remove('active');
    document.body.style.overflow = '';
}

// Submit Update Form
function submitUpdateForm() {
    document.getElementById('updateProfileForm').submit();
}

// Close update modal when clicking outside
document.addEventListener('DOMContentLoaded', function() {
    var updateModal = document.getElementById('updateProfileModal');
    if (updateModal) {
        updateModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeUpdateModal();
            }
        });
    }

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeUpdateModal();
        }
    });
});

// Add to Cart without page scroll
function addToCart(itemId, button) {
    // Create a hidden iframe to handle the navigation without scrolling
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'index.php?url=add_to_cart&id=' + itemId + '&ajax=1', true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            // Redirect with status but preserve scroll position
            var scrollPos = window.scrollY;
            window.location.href = 'index.php?url=landowner_dashboard&status=success&scroll=' + scrollPos;
        }
    };
    xhr.send();
    
    // Fallback: Use regular navigation but with scroll preservation
    var scrollPos = window.scrollY;
    sessionStorage.setItem('scrollPosition', scrollPos);
    window.location.href = 'index.php?url=add_to_cart&id=' + itemId;
}

// Restore scroll position on page load
document.addEventListener('DOMContentLoaded', function() {
    var scrollPos = sessionStorage.getItem('scrollPosition');
    if (scrollPos) {
        window.scrollTo(0, parseInt(scrollPos));
        sessionStorage.removeItem('scrollPosition');
    }
    
    // Also check URL parameter
    var urlParams = new URLSearchParams(window.location.search);
    var scrollParam = urlParams.get('scroll');
    if (scrollParam) {
        window.scrollTo(0, parseInt(scrollParam));
    }
});

// Hire Popup Functions
function showHirePopup(farmerId, farmerName, farmerEmail, farmerWage, farmerSkills) {
    document.getElementById('popupFarmerName').textContent = farmerName;
    document.getElementById('popupFarmerEmail').textContent = farmerEmail;
    document.getElementById('popupFarmerWage').textContent = farmerWage;
    document.getElementById('popupFarmerSkills').textContent = farmerSkills;
    document.getElementById('popupConfirmBtn').href = 'index.php?url=hire_farmer&farmer_id=' + farmerId;
    
    document.getElementById('hirePopup').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeHirePopup() {
    document.getElementById('hirePopup').classList.remove('active');
    document.body.style.overflow = '';
}

// Close popup when clicking outside
document.getElementById('hirePopup').addEventListener('click', function(e) {
    if (e.target === this) {
        closeHirePopup();
    }
});

// Close popup with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeHirePopup();
    }
});
</script>

</body>
</html>

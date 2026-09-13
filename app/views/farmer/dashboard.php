<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer Dashboard - AgriConnect</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
            --warning-bg: #fef3c7;
            --warning-border: #fcd34d;
            --warning-text: #92400e;
            --success: #10b981;
            --danger: #ef4444;
            --orange: #f59e0b;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--gray-50);
            min-height: 100vh;
            color: var(--gray-900);
            line-height: 1.6;
        }

        /* Header */
        .header {
            background: var(--white);
            border-bottom: 1px solid var(--gray-200);
            padding: 0 24px;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .header-content {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 70px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            cursor: pointer;
        }

        .logo-icon {
            width: 42px;
            height: 42px;
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
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--primary-dark);
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-green), var(--accent-green));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-weight: 600;
            font-size: 1rem;
        }

        .user-details {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 600;
            color: var(--gray-900);
            font-size: 0.95rem;
            text-decoration: none;
            transition: color 0.2s;
        }

        .user-name:hover {
            color: var(--primary-green);
        }

        .user-role {
            font-size: 0.8rem;
            color: var(--gray-500);
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            background: var(--white);
            border: 1px solid var(--gray-300);
            border-radius: 8px;
            color: var(--gray-700);
            font-size: 0.9rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
        }

        .logout-btn:hover {
            background: var(--gray-100);
            border-color: var(--gray-400);
        }

        .logout-btn svg {
            width: 18px;
            height: 18px;
        }

        /* Main Content */
        .main-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 32px 24px;
        }

        /* Page Title */
        .page-header {
            margin-bottom: 32px;
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 8px;
        }

        .page-subtitle {
            color: var(--gray-500);
            font-size: 1rem;
        }

        /* Alert Banner */
        .alert-banner {
            background: var(--warning-bg);
            border: 1px solid var(--warning-border);
            border-radius: 12px;
            padding: 20px 24px;
            margin-bottom: 28px;
            display: flex;
            align-items: flex-start;
            gap: 16px;
        }

        .alert-icon {
            width: 24px;
            height: 24px;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .alert-content {
            flex: 1;
        }

        .alert-title {
            font-weight: 600;
            color: var(--warning-text);
            margin-bottom: 4px;
            font-size: 1rem;
        }

        .alert-text {
            color: var(--warning-text);
            font-size: 0.9rem;
            opacity: 0.9;
            margin-bottom: 12px;
        }

        .alert-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            background: var(--warning-text);
            color: var(--white);
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s;
            cursor: pointer;
        }

        .alert-btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        /* Cards */
        .card {
            background: var(--white);
            border-radius: 16px;
            border: 1px solid var(--gray-200);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            margin-bottom: 28px;
            overflow: hidden;
        }

        .card-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .card-icon {
            width: 44px;
            height: 44px;
            background: var(--light-green);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-icon svg {
            width: 22px;
            height: 22px;
            fill: var(--primary-green);
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--gray-900);
        }

        .card-body {
            padding: 24px;
        }

        /* Profile Form */
        .profile-form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--gray-700);
        }

        .form-input {
            padding: 12px 16px;
            border: 1px solid var(--gray-300);
            border-radius: 10px;
            font-size: 0.95rem;
            font-family: inherit;
            color: var(--gray-900);
            background: var(--white);
            transition: all 0.2s;
        }

        .form-input::placeholder {
            color: var(--gray-500);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-green);
            box-shadow: 0 0 0 3px rgba(45, 90, 61, 0.1);
        }

        .submit-btn {
            padding: 12px 28px;
            background: linear-gradient(135deg, var(--primary-green), var(--accent-green));
            color: var(--white);
            border: none;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.2s;
            align-self: flex-end;
            margin-top: 8px;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(45, 90, 61, 0.25);
        }

        /* Table */
        .table-container {
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            background: var(--gray-50);
            padding: 14px 18px;
            text-align: left;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid var(--gray-200);
        }

        .data-table td {
            padding: 18px;
            border-bottom: 1px solid var(--gray-100);
            font-size: 0.95rem;
            color: var(--gray-700);
        }

        .data-table tr:last-child td {
            border-bottom: none;
        }

        .data-table tr:hover {
            background: var(--gray-50);
        }

        /* Status Badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: capitalize;
        }

        .status-pending {
            background: #fef3c7;
            color: #d97706;
        }

        .status-accepted {
            background: #d1fae5;
            color: #059669;
        }

        .status-rejected {
            background: #fee2e2;
            color: #dc2626;
        }

        .status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        /* Action Buttons */
        .action-btns {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
            border: none;
        }

        .btn-accept {
            background: var(--success);
            color: var(--white);
        }

        .btn-accept:hover {
            background: #059669;
            transform: translateY(-1px);
        }

        .btn-reject {
            background: var(--danger);
            color: var(--white);
        }

        .btn-reject:hover {
            background: #dc2626;
            transform: translateY(-1px);
        }

        .btn-done {
            background: var(--gray-100);
            color: var(--gray-500);
            cursor: default;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 24px;
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            background: var(--gray-100);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .empty-icon svg {
            width: 40px;
            height: 40px;
            fill: var(--gray-400);
        }

        .empty-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 8px;
        }

        .empty-text {
            color: var(--gray-500);
            font-size: 0.95rem;
        }

        /* Mobile Menu Button */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            padding: 8px;
            cursor: pointer;
        }

        .mobile-menu-btn svg {
            width: 24px;
            height: 24px;
            fill: var(--gray-700);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .main-content {
                padding: 24px 16px;
            }

            .profile-form {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            .header-content {
                height: 60px;
            }

            .user-details {
                display: none;
            }

            .logout-btn span {
                display: none;
            }

            .logout-btn {
                padding: 10px;
            }

            .page-title {
                font-size: 1.4rem;
            }

            .profile-form {
                grid-template-columns: 1fr;
            }

            .submit-btn {
                width: 100%;
            }

            .card-header {
                padding: 16px 18px;
            }

            .card-body {
                padding: 18px;
            }

            .data-table th,
            .data-table td {
                padding: 12px;
                font-size: 0.85rem;
            }

            .action-btns {
                flex-direction: column;
            }

            .action-btn {
                justify-content: center;
            }

            .alert-banner {
                flex-direction: column;
                gap: 12px;
            }
        }

        @media (max-width: 480px) {
            .header {
                padding: 0 12px;
            }

            .logo-text {
                font-size: 1.2rem;
            }

            .main-content {
                padding: 16px 12px;
            }

            .page-header {
                margin-bottom: 20px;
            }

            .card {
                border-radius: 12px;
            }

            /* Stacked table on mobile */
            .data-table thead {
                display: none;
            }

            .data-table tr {
                display: block;
                margin-bottom: 16px;
                background: var(--white);
                border: 1px solid var(--gray-200);
                border-radius: 12px;
                padding: 16px;
            }

            .data-table td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 10px 0;
                border-bottom: 1px solid var(--gray-100);
            }

            .data-table td:last-child {
                border-bottom: none;
                padding-top: 16px;
            }

            .data-table td::before {
                content: attr(data-label);
                font-weight: 600;
                color: var(--gray-500);
                font-size: 0.8rem;
                text-transform: uppercase;
            }

            .action-btns {
                width: 100%;
            }
        }
        .modal-overlay{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.45);
    display:none;
    align-items:center;
    justify-content:center;
    z-index:999;
}
.modal-box{
    background:#fff;
    border-radius:16px;
    padding:24px;
    max-width:420px;
    width:90%;
}
.modal-actions{
    display:flex;
    gap:12px;
    justify-content:center;
    margin-top:20px;
}

    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <a href="index.php?url=farmer_dashboard" class="logo">
                <div class="logo-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
              </div>
                <span class="logo-text">AgriLand-Ecosystem</span>
            </a>

            <div class="header-right">
                <div class="user-info">
                    <div class="user-avatar">
                        <?php echo strtoupper(substr($_SESSION['user_name'], 0, 1)); ?>
                    </div>
                    <div class="user-details">
                        <a href="index.php?url=edit_farmer_profile" class="user-name"><?php echo $_SESSION['user_name']; ?></a>
                        <span class="user-role">Farmer</span>
                    </div>
                </div>
                <a href="index.php?url=logout" class="logout-btn">
                    <!-- <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"> -->
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    <span>Logout</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Farmer Dashboard</h1>
            <p class="page-subtitle">Manage your profile and view hire requests from landowners</p>
        </div>

        <!-- Busy Status Alert -->
        <?php if (isset($farmerData['availability_status']) && $farmerData['availability_status'] == 'busy'): ?>
        <div class="alert-banner">
            <svg class="alert-icon" viewBox="0 0 24 24" fill="#d97706">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
            </svg>
            <div class="alert-content">
                <div class="alert-title">Status: Currently Busy</div>
                <p class="alert-text">You won't appear in the available farmers list until you complete your current task.</p>
                <button class="alert-btn" onclick="openModal('available')">
    Set as Available
</button>

            </div>
        </div>
        <?php endif; ?>

        <!-- Profile Card -->
        <div class="card">
            <div class="card-header">
                <div class="card-icon">
                    <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                </div>
                <h2 class="card-title">Professional Skills & Daily Wage</h2>
            </div>
            <div class="card-body">
                <form action="index.php?url=update_farmer_profile" method="POST" class="profile-form">
                    <div class="form-group">
                        <label class="form-label">Skills</label>
                        <input type="text" name="skills" class="form-input" placeholder="e.g. Rice Cultivation, Plowing, Harvesting" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Experience (Years)</label>
                        <input type="number" name="experience" class="form-input" placeholder="Enter years of experience" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Daily Wage (৳)</label>
                        <input type="number" name="wage" class="form-input" placeholder="Enter daily wage amount" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="submit-btn">Save Profile</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Hire Requests Card -->
        <div class="card">
            <div class="card-header">
                <div class="card-icon">
                    <svg viewBox="0 0 24 24"><path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                </div>
                <h2 class="card-title">Hire Requests from Landowners</h2>
            </div>
            <div class="card-body">
                <?php if(!empty($requests)): ?>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Landowner Name</th>
                                <th>District</th>
                                <th>Date</th>
                                <th>Contact</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($requests as $req): ?>
                            <tr>
                                <td data-label="Landowner"><?php echo $req['landowner_name']; ?></td>
                                <td data-label="District"><?php echo $req['district']; ?></td>
                                <td data-label="Date"><?php echo $req['request_date']; ?></td>
                                <td data-label="Contact"><?php echo $req['landowner_phone']; ?></td>
                                <td data-label="Status">
                                    <span class="status-badge status-<?php echo $req['status']; ?>">
                                        <span class="status-dot"></span>
                                        <?php echo ucfirst($req['status']); ?>
                                    </span>
                                </td>
                                <td data-label="Action">
                                    <?php if($req['status'] == 'pending'): ?>
                                    <div class="action-btns">
                                        <button class="action-btn btn-accept"
                                            onclick="openModal('accept', <?php echo $req['id']; ?>)">
                                            Accept
                                        </button>

                                        <button class="action-btn btn-reject"
        onclick="openModal('reject', <?php echo $req['id']; ?>)">
    Reject
</button>

                                    </div>
                                    <?php else: ?>
                                    <span class="action-btn btn-done">Completed</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg viewBox="0 0 24 24"><path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm0 4c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm6 12H6v-1.4c0-2 4-3.1 6-3.1s6 1.1 6 3.1V19z"/></svg>
                    </div>
                    <h3 class="empty-title">No Hire Requests Yet</h3>
                    <p class="empty-text">When landowners send you hire requests, they will appear here.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
<div class="modal-overlay" id="modalOverlay">
    <div class="modal-box">
        <h3 id="modalTitle"></h3>
        <p id="modalText"></p>

        <div class="modal-actions">
            <button class="action-btn btn-done" onclick="closeModal()">Cancel</button>
            <a id="modalConfirmBtn" class="action-btn btn-accept">Confirm</a>
        </div>
    </div>
</div>

    <script>
        // Add smooth hover effects
        document.querySelectorAll('.action-btn').forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });
            btn.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
        const overlay=document.getElementById('modalOverlay');
const title=document.getElementById('modalTitle');
const text=document.getElementById('modalText');
const confirmBtn=document.getElementById('modalConfirmBtn');

function openModal(type,id=null){
    overlay.style.display='flex';

    if(type==='accept'){
        title.innerText='Accept Request';
        text.innerText='Do you want to accept this hire request?';
        confirmBtn.href=`index.php?url=process_request&request_id=${id}&action=accepted`;
        confirmBtn.className='action-btn btn-accept';
    }

    if(type==='reject'){
        title.innerText='Reject Request';
        text.innerText='Are you sure you want to reject this request?';
        confirmBtn.href=`index.php?url=process_request&request_id=${id}&action=rejected`;
        confirmBtn.className='action-btn btn-reject';
    }

    if(type==='available'){
        title.innerText='Set Available';
        text.innerText='You will be visible to landowners again.';
        confirmBtn.href='index.php?url=set_available';
        confirmBtn.className='action-btn btn-accept';
    }
}

function closeModal(){
    overlay.style.display='none';
}

    </script>
    
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            min-height: 100vh;
        }

        /* Header */
        .header {
            background: linear-gradient(135deg, #053c12 0%, #053c12 100%);
            color: #fff;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .header h1 {
            font-size: 24px;
            font-weight: 600;
        }

        .logout-btn {
            background: #fff;
            color: #04480a;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: #e8e8e8;
            transform: translateY(-2px);
        }

        /* Main Content */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        /* Stats Cards */
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .stat-icon.landowner { background: #e3f2fd; color: #1976d2; }
        .stat-icon.farmer { background: #e8f5e9; color: #388e3c; }
        .stat-icon.company { background: #f3e5f5; color: #7b1fa2; }

        .stat-info h3 {
            font-size: 28px;
            color: #333;
        }

        .stat-info p {
            color: #666;
            font-size: 14px;
        }

        /* Table Section */
        .table-section {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-bottom: 25px;
            overflow: hidden;
        }

        .table-header {
            padding: 20px 25px;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .table-header.landowner { border-left: 4px solid #1976d2; }
        .table-header.farmer { border-left: 4px solid #388e3c; }
        .table-header.company { border-left: 4px solid #7b1fa2; }

        .table-header h3 {
            font-size: 18px;
            color: #333;
            font-weight: 600;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 15px 20px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background: #f8f9fa;
            color: #555;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            color: #333;
            font-size: 14px;
        }

        tr:hover {
            background: #f8f9fa;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .btn-delete {
            background: #ffebee;
            color: #c62828;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 13px;
            transition: all 0.3s ease;
            display: inline-block;
            cursor: pointer;
            border: none;
        }

        .btn-delete:hover {
            background: #c62828;
            color: #fff;
        }

        /* Modal */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal {
            background: #fff;
            border-radius: 16px;
            padding: 30px;
            max-width: 400px;
            width: 90%;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            animation: modalSlide 0.3s ease;
        }

        @keyframes modalSlide {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-icon {
            width: 70px;
            height: 70px;
            background: #ffebee;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 32px;
        }

        .modal h2 {
            color: #333;
            font-size: 22px;
            margin-bottom: 10px;
        }

        .modal p {
            color: #666;
            font-size: 15px;
            margin-bottom: 25px;
            line-height: 1.5;
        }

        .modal-buttons {
            display: flex;
            gap: 12px;
            justify-content: center;
        }

        .btn-cancel {
            background: #f0f0f0;
            color: #333;
            padding: 12px 24px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-cancel:hover {
            background: #e0e0e0;
        }

        .btn-confirm-delete {
            background: #c62828;
            color: #fff;
            padding: 12px 24px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-confirm-delete:hover {
            background: #b71c1c;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
                padding: 15px;
            }

            .header h1 {
                font-size: 20px;
            }

            .container {
                padding: 15px 10px;
            }

            .stat-card {
                padding: 20px;
            }

            .table-header {
                padding: 15px;
            }

            .table-header h3 {
                font-size: 16px;
            }

            th, td {
                padding: 12px 15px;
                font-size: 13px;
            }

            .modal {
                padding: 25px 20px;
                margin: 15px;
            }

            .modal-buttons {
                flex-direction: column;
            }

            .btn-cancel, .btn-confirm-delete {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            th, td {
                padding: 10px 12px;
                font-size: 12px;
            }

            .btn-delete {
                padding: 6px 12px;
                font-size: 12px;
            }
        }
        
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>AgriLand-Ecosystem</h1>
        <a href="index.php?url=logout" class="logout-btn">Logout</a>
    </div>

    <div class="container">

        <!-- Admin User Management -->
        <div class="table-section" style="margin-bottom:30px;">
            <div class="table-header" style="border-left:4px solid #053c12; flex-wrap:wrap;">
                <h3>Admin &amp; User Management</h3>
            </div>

            <div style="padding:25px;">
                <h3 style="margin-bottom:15px;color:#333;">Add Admin / User</h3>

                <?php
                    $adminStatus = $_GET['status'] ?? '';
                    $statusMessages = [
                        'added' => ['Account added successfully.', '#e8f5e9', '#2e7d32'],
                        'deleted' => ['Account deleted successfully.', '#e8f5e9', '#2e7d32'],
                        'email_exists' => ['This email is already registered.', '#fff3e0', '#e65100'],
                        'invalid_input' => ['Please fill all required fields correctly.', '#ffebee', '#c62828'],
                        'invalid_role' => ['Invalid account role.', '#ffebee', '#c62828'],
                        'cannot_delete_self' => ['You cannot delete your own admin account.', '#fff3e0', '#e65100'],
                        'error' => ['Operation failed. Please try again.', '#ffebee', '#c62828']
                    ];
                    if (isset($statusMessages[$adminStatus])):
                        [$msg, $bg, $fg] = $statusMessages[$adminStatus];
                ?>
                    <div style="background:<?= $bg ?>;color:<?= $fg ?>;padding:12px 15px;border-radius:8px;margin-bottom:18px;font-weight:600;">
                        <?= htmlspecialchars($msg) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="index.php?url=add_user"
                      style="display:grid;grid-template-columns:repeat(auto-fit,minmax(210px,1fr));gap:14px;align-items:end;">
                    <div>
                        <label style="display:block;margin-bottom:6px;font-weight:600;">Full Name *</label>
                        <input type="text" name="full_name" required
                               style="width:100%;padding:11px;border:1px solid #ddd;border-radius:7px;">
                    </div>
                    <div>
                        <label style="display:block;margin-bottom:6px;font-weight:600;">Email *</label>
                        <input type="email" name="email" required
                               style="width:100%;padding:11px;border:1px solid #ddd;border-radius:7px;">
                    </div>
                    <div>
                        <label style="display:block;margin-bottom:6px;font-weight:600;">Password *</label>
                        <input type="password" name="password" required minlength="6"
                               style="width:100%;padding:11px;border:1px solid #ddd;border-radius:7px;">
                    </div>
                    <div>
                        <label style="display:block;margin-bottom:6px;font-weight:600;">Role *</label>
                        <select name="role" required
                                style="width:100%;padding:11px;border:1px solid #ddd;border-radius:7px;background:#fff;">
                            <option value="admin">Admin</option>
                            <option value="landowner">Landowner</option>
                            <option value="farmer">Farmer</option>
                            <option value="company">Company</option>
                        </select>
                    </div>
                    <div>
                        <label style="display:block;margin-bottom:6px;font-weight:600;">District *</label>
                        <input type="text" name="district" required
                               style="width:100%;padding:11px;border:1px solid #ddd;border-radius:7px;">
                    </div>
                    <div>
                        <label style="display:block;margin-bottom:6px;font-weight:600;">Phone</label>
                        <input type="text" name="phone"
                               style="width:100%;padding:11px;border:1px solid #ddd;border-radius:7px;">
                    </div>
                    <div>
                        <button type="submit"
                                style="width:100%;padding:12px 18px;background:#053c12;color:#fff;border:0;border-radius:7px;font-weight:700;cursor:pointer;">
                            + Add Account
                        </button>
                    </div>
                </form>
            </div>

            <!-- All Accounts -->
            <div class="table-wrapper">
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>District</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    <?php foreach($allUsers as $u): ?>
                    <tr>
                        <td><?= (int)$u['id'] ?></td>
                        <td><?= htmlspecialchars($u['full_name']) ?></td>
                        <td><?= htmlspecialchars($u['email']) ?></td>
                        <td><?= htmlspecialchars(ucfirst($u['role'])) ?></td>
                        <td><?= htmlspecialchars($u['district']) ?></td>
                        <td><?= htmlspecialchars($u['status'] ?? 'active') ?></td>
                        <td>
                            <?php if ((int)$u['id'] !== (int)($_SESSION['user_id'] ?? 0)): ?>
                                <a class="btn-delete" style="text-decoration:none;"
                                   href="index.php?url=toggle_user_status&id=<?= (int)$u['id'] ?>&status=<?= (($u['status'] ?? 'active') === 'active') ? 'inactive' : 'active' ?>">
                                   <?= (($u['status'] ?? 'active') === 'active') ? 'Deactivate' : 'Activate' ?>
                                </a>
                                <button class="btn-delete"
                                        onclick="openModal('<?= htmlspecialchars($u['full_name'], ENT_QUOTES) ?>', '<?= htmlspecialchars(ucfirst($u['role']), ENT_QUOTES) ?>', '<?= (int)$u['id'] ?>')">
                                    Delete
                                </button>
                            <?php else: ?>
                                <span style="color:#777;font-weight:600;">Current account</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats">
            <div class="stat-card">
                <div class="stat-icon landowner">&#127968;</div>
                <div class="stat-info">
                    <h3><?php echo count($landowners); ?></h3>
                    <p>Total Landowners</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon farmer">&#127793;</div>
                <div class="stat-info">
                    <h3><?php echo count($farmers); ?></h3>
                    <p>Total Farmers</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon company">&#127970;</div>
                <div class="stat-info">
                    <h3><?php echo count($companies); ?></h3>
                    <p>Total Companies</p>
                </div>
            </div>
        </div>

        <!-- Landowners Table -->
        <div class="table-section">
            <div class="table-header landowner">
                <h3>1. Landowners List</h3>
            </div>
            <div class="table-wrapper">
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>District</th>
                        <th>Action</th>
                    </tr>
                    <?php foreach($landowners as $l): ?>
                    <tr>
                        <td><?= $l['id'] ?></td>
                        <td><?= $l['full_name'] ?></td>
                        <td><?= $l['email'] ?></td>
                        <td><?= $l['district'] ?></td>
                        <td>
                            <a class="btn-delete" style="text-decoration:none;" href="index.php?url=toggle_user_status&id=<?= $l['id'] ?>&status=<?= (($l['status'] ?? 'active') === 'active') ? 'inactive' : 'active' ?>">
<?= (($l['status'] ?? 'active') === 'active') ? 'Deactivate' : 'Activate' ?></a>
<button class="btn-delete" onclick="openModal('<?= htmlspecialchars($l['full_name'], ENT_QUOTES) ?>', 'Landowner', '<?= $l['id'] ?>')">Delete</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>

        <!-- Farmers Table -->
        <div class="table-section">
            <div class="table-header farmer">
                <h3>2. Farmers List</h3>
            </div>
            <div class="table-wrapper">
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Skills</th>
                        <th>Wage</th>
                        <th>Experience</th>
                        <th>Action</th>
                    </tr>
                    <?php foreach($farmers as $f): ?>
                    <tr>
                        <td><?= $f['id'] ?></td>
                        <td><?= $f['full_name'] ?></td>
                        <td><?= $f['email'] ?></td>
                        <td><?= $f['skills'] ?></td>
                        <td>৳<?= $f['daily_wage'] ?></td>
                        <td><?= $f['experience_years'] ?> Yrs</td>
                        <td>
                            <a class="btn-delete" style="text-decoration:none;" href="index.php?url=toggle_user_status&id=<?= $f['id'] ?>&status=<?= (($f['status'] ?? 'active') === 'active') ? 'inactive' : 'active' ?>">
<?= (($f['status'] ?? 'active') === 'active') ? 'Deactivate' : 'Activate' ?></a>
<button class="btn-delete" onclick="openModal('<?= htmlspecialchars($f['full_name'], ENT_QUOTES) ?>', 'Farmer', '<?= $f['id'] ?>')">Delete</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>

        <!-- Companies Table -->
        <div class="table-section">
            <div class="table-header company">
                <h3>3. Company List</h3>
            </div>
            <div class="table-wrapper">
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                    <?php foreach($companies as $c): ?>
                    <tr>
                        <td><?= $c['id'] ?></td>
                        <td><?= $c['full_name'] ?></td>
                        <td><?= $c['email'] ?></td>
                        <td>
                            <a class="btn-delete" style="text-decoration:none;" href="index.php?url=toggle_user_status&id=<?= $c['id'] ?>&status=<?= (($c['status'] ?? 'active') === 'active') ? 'inactive' : 'active' ?>">
<?= (($c['status'] ?? 'active') === 'active') ? 'Deactivate' : 'Activate' ?></a>
<button class="btn-delete" onclick="openModal('<?= htmlspecialchars($c['full_name'], ENT_QUOTES) ?>', 'Company', '<?= $c['id'] ?>')">Delete</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal-overlay" id="deleteModal">
        <div class="modal">
            <div class="modal-icon">&#9888;</div>
            <h2>Confirm Delete</h2>
            <p>Are you sure you want to delete <strong id="userName"></strong> (<span id="userType"></span>)? This action cannot be undone.</p>
            <div class="modal-buttons">
                <button class="btn-cancel" onclick="closeModal()">Cancel</button>
                <a id="confirmDeleteBtn" href="#" class="btn-confirm-delete">Delete</a>
            </div>
        </div>
    </div>

    <script>
        let deleteUrl = '';

        function openModal(name, type, id) {
            document.getElementById('userName').textContent = name;
            document.getElementById('userType').textContent = type;
            document.getElementById('confirmDeleteBtn').href = 'index.php?url=delete_user&id=' + id;
            document.getElementById('deleteModal').classList.add('active');
        }

        function closeModal() {
            document.getElementById('deleteModal').classList.remove('active');
        }

        // Close modal when clicking outside
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    </script>
</body>
</html>

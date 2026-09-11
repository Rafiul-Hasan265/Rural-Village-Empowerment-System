<!DOCTYPE html>
<html>
<head>
    <title>Company Dashboard - Agri Equipment Rentals</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../../asset/css/company/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/asset/css/company/style.css">
</head>

<body>

<!-- Navbar -->
<nav class="navbar">
    <div class="logo">
        <div class="logo-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/>
            </svg>
        </div>
        <span class="logo-text">AgriLand-Ecosystem</span>
    </div>

    <div class="nav-links">
        <a href="index.php?url=company_dashboard">Dashboard</a>
        <a href="#my-instruments">My Instruments</a>
        <a href="#orders">Orders</a>
        <a href="index.php?url=logout" class="btn-logout">Logout</a>

        <!-- ✅ Added Theme Toggle (missing part) -->
        <button type="button" class="theme-toggle" id="themeToggle" aria-label="Toggle theme">
            <span class="toggle-icon" id="themeIcon">🌙</span>
            <span class="toggle-text" id="themeText">Dark</span>
        </button>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero">
    <h1>Welcome, <?php echo $_SESSION['user_name']; ?></h1>
    <p>Manage your agricultural equipment and rental orders</p>
    <span class="hero-badge">Equipment Rental Company</span>
</section>

<!-- Main Container -->
<div class="main-container">

    <!-- Top Section: Form + Instruments List -->
    <div class="top-section">

        <!-- Post New Machinery Form -->
        <div class="form-section">
            <h3>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="16"/>
                    <line x1="8" y1="12" x2="16" y2="12"/>
                </svg>
                Post New Machinery
            </h3>
            <p class="form-subtitle">Add equipment to your rental inventory</p>

            <form action="index.php?url=add_instrument" method="POST" onsubmit="showAddModal(event)">
                <div class="form-group">
                    <label>Instrument Name</label>
                    <input type="text" name="name" placeholder="e.g. Tractor, Harvester" required>
                </div>

                <div class="form-group">
                    <label>Category</label>
                    <input type="text" name="category" placeholder="e.g. Harvesting, Plowing">
                </div>

                <div class="form-group">
                    <label>Rental Price Per Day (৳)</label>
                    <input type="number" name="rental_price" placeholder="Enter daily rental price" required>
                </div>

                <div class="form-group">
                    <label>Selling Price (৳) - Optional</label>
                    <input type="number" name="selling_price" placeholder="Enter selling price if for sale">
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" placeholder="Describe the machine, its condition, features..."></textarea>
                </div>

                <button type="submit" class="btn-post">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19"/>
                        <line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Post Instrument
                </button>
            </form>
        </div>

        <!-- My Posted Instruments -->
        <div class="list-section" id="my-instruments">
            <h3>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2">
                    <rect x="3" y="3" width="7" height="7"/>
                    <rect x="14" y="3" width="7" height="7"/>
                    <rect x="14" y="14" width="7" height="7"/>
                    <rect x="3" y="14" width="7" height="7"/>
                </svg>
                My Posted Instruments
            </h3>

            <table>
                <thead>
                    <tr>
                        <th>Machine Name</th>
                        <th>Rental Price/Day</th>
                        <th>Buy Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if(!empty($myInstruments)): ?>
                        <?php foreach($myInstruments as $item): ?>
                            <tr>
                                <td>
                                    <span class="instrument-name"><?php echo htmlspecialchars($item['name']); ?></span><br>
                                    <span class="instrument-category"><?php echo htmlspecialchars($item['category']); ?></span>
                                </td>

                                <td><span class="price-tag">৳<?php echo $item['rental_price']; ?></span></td>

                                <td><span class="price-tag">৳<?php echo $item['selling_price'] > 0 ? $item['selling_price'] : 'N/A'; ?></span></td>

                                <td>
                                    <span class="badge <?php echo $item['availability'] == 'available' ? 'badge-available' : 'badge-rented'; ?>">
                                        <?php echo ucfirst($item['availability']); ?>
                                    </span>
                                </td>

                                <td>
                                    <button class="btn-edit" onclick='openEditModal(<?php echo json_encode($item); ?>)'>Edit</button>
                                    <button class="btn-delete" onclick="showDeleteModal(<?php echo $item['id']; ?>)">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="empty-row">No instruments found. Add one now!</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Orders Section -->
    <div class="orders-section" id="orders">

        <!-- Pending Purchase Orders -->
        <div class="section-header purchase">
            <!-- ✅ Added Purchase Icon (missing part) -->
            
            <h2>Pending Purchase Orders</h2>
        </div>

        <table class="orders-table purchase">
            <thead>
                <tr>
                    <th>Instrument Name</th>
                    <th>Landowner Name</th>
                    <th>District</th>
                    <th>Phone Number</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total Price</th>
                    <th style="text-align: center;">Action</th>
                </tr>
            </thead>

            <tbody>
                <?php if(!empty($purchaseOrders)): ?>
                    <?php foreach($purchaseOrders as $order): ?>
                    <tr>
                        <td><?= htmlspecialchars($order['instrument_name']) ?></td>
                        <td><?= htmlspecialchars($order['customer_name']) ?></td>
                        <td><?= htmlspecialchars($order['district']) ?></td>
                        <td><?= htmlspecialchars($order['phone']) ?></td>
                        <td><span class="price-tag"><?= isset($order['quantity']) ? $order['quantity'] : 1 ?></span></td>
                        <td><span class="price-tag">৳<?= number_format($order['purchase_price'], 2) ?></span></td>
                        <td><span class="price-tag" style="color: #0ea5e9; font-size: 1.1em;">৳<?= number_format($order['purchase_price'] * (isset($order['quantity']) ? $order['quantity'] : 1), 2) ?></span></td>
                        <td style="text-align: center;">
                            <button class="btn-done" onclick="showDoneModal(<?= $order['id'] ?>, 'buy')">Done</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="8" class="empty-row">No pending purchase orders.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <br><br>

        <!-- Pending Rental Requests -->
        <div class="section-header rental">
            
            <h2>Pending Rental Requests</h2>
        </div>

        <table class="orders-table rental">
            <thead>
                <tr>
                    <th>Instrument Name</th>
                    <th>Landowner Name</th>
                    <th>District</th>
                    <th>Phone Number</th>
                    <th>Quantity</th>
                    <th>Days</th>
                    <th>Price/Day</th>
                    <th>Total Price</th>
                    <th style="text-align: center;">Action</th>
                </tr>
            </thead>

            <tbody>
                <?php if(!empty($rentalOrders)): ?>
                    <?php foreach($rentalOrders as $rent): ?>
                    <tr>
                        <td><?= htmlspecialchars($rent['instrument_name']) ?></td>
                        <td><?= htmlspecialchars($rent['customer_name']) ?></td>
                        <td><?= htmlspecialchars($rent['district']) ?></td>
                        <td><?= htmlspecialchars($rent['phone']) ?></td>
                        <td><span class="price-tag"><?= isset($rent['quantity']) ? $rent['quantity'] : 1 ?></span></td>
                        <td><span class="price-tag"><?= isset($rent['rental_days']) ? $rent['rental_days'] : 1 ?> days</span></td>
                        <td><span class="price-tag">৳<?= number_format($rent['rental_price'], 2) ?>/day</span></td>
                        <td><span class="price-tag" style="color: #ea580c; font-size: 1.1em;">৳<?= number_format($rent['rental_price'] * (isset($rent['rental_days']) ? $rent['rental_days'] : 1) * (isset($rent['quantity']) ? $rent['quantity'] : 1), 2) ?></span></td>
                        <td style="text-align: center;">
                            <button class="btn-done" onclick="showDoneModal(<?= $rent['id'] ?>, 'rent')">Done</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="9" class="empty-row">No pending rental requests.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h3>Edit Instrument</h3>
        <hr>
        <form action="index.php?url=edit_instrument" method="POST">
            <input type="hidden" name="id" id="edit_id">

            <div class="form-group">
                <label>Name:</label>
                <input type="text" name="name" id="edit_name" required>
            </div>

            <div class="form-group">
                <label>Category:</label>
                <input type="text" name="category" id="edit_cat">
            </div>

            <div class="form-group">
                <label>Rental Price (৳):</label>
                <input type="number" name="rental_price" id="edit_rprice" required>
            </div>

            <div class="form-group">
                <label>Selling Price (৳):</label>
                <input type="number" name="selling_price" id="edit_sprice">
            </div>

            <div class="form-group">
                <label>Description:</label>
                <textarea name="description" id="edit_desc"></textarea>
            </div>

            <button type="submit" class="btn-update">Update Changes</button>
        </form>
    </div>
</div>

<script>
    function openEditModal(item) {
        document.getElementById('edit_id').value = item.id;
        document.getElementById('edit_name').value = item.name;
        document.getElementById('edit_cat').value = item.category;
        document.getElementById('edit_rprice').value = item.rental_price;
        document.getElementById('edit_sprice').value = item.selling_price;
        document.getElementById('edit_desc').value = item.description;

        document.getElementById('editModal').classList.add('show');
    }

    function closeModal() {
        document.getElementById('editModal').classList.remove('show');
    }

    window.onclick = function(event) {
        let modal = document.getElementById('editModal');
        if (event.target == modal) {
            modal.classList.remove('show');
        }
    }

    // Delete Modal Functions
    function showDeleteModal(itemId) {
        document.getElementById('deleteConfirmBtn').href = 'index.php?url=delete_instrument&id=' + itemId;
        document.getElementById('deleteModal').classList.add('show');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.remove('show');
    }

    // Add Instrument Modal Functions
    let addFormElement = null;
    function showAddModal(event) {
        event.preventDefault();
        addFormElement = event.target.closest('form');
        document.getElementById('addModal').classList.add('show');
    }

    function closeAddModal() {
        document.getElementById('addModal').classList.remove('show');
    }

    function submitAddForm() {
        if (addFormElement) {
            addFormElement.submit();
        }
    }

    // Done Modal Functions
    function showDoneModal(orderId, type) {
        document.getElementById('doneConfirmBtn').href = 'index.php?url=complete_order&id=' + orderId + '&type=' + type;
        document.getElementById('doneModal').classList.add('show');
    }

    function closeDoneModal() {
        document.getElementById('doneModal').classList.remove('show');
    }

    // Close modals when clicking outside
    window.addEventListener('click', function(event) {
        let deleteModal = document.getElementById('deleteModal');
        let addModal = document.getElementById('addModal');
        let doneModal = document.getElementById('doneModal');

        if (event.target == deleteModal) closeDeleteModal();
        if (event.target == addModal) closeAddModal();
        if (event.target == doneModal) closeDoneModal();
    });
</script>

<!--Added: Dark/Light Theme Switch Script (missing part) -->
<script>
  (function () {
    const root = document.documentElement;
    const btn = document.getElementById("themeToggle");
    const icon = document.getElementById("themeIcon");
    const text = document.getElementById("themeText");

    if (!btn) return;

    // Load saved theme (default LIGHT)
    const saved = localStorage.getItem("theme") || "light";
    setTheme(saved);

    btn.addEventListener("click", () => {
      const current =
        root.getAttribute("data-theme") === "light" ? "light" : "dark";
      const next = current === "light" ? "dark" : "light";
      setTheme(next);
      localStorage.setItem("theme", next);
    });

    function setTheme(mode) {
      if (mode === "light") {
        root.setAttribute("data-theme", "light");
        icon.textContent = "☀️";
        text.textContent = "Light";
      } else {
        root.removeAttribute("data-theme");
        icon.textContent = "🌙";
        text.textContent = "Dark";
      }
    }
  })();
</script>


<!-- Delete Modal -->
<div class="action-modal" id="deleteModal">
    <div class="action-modal-content">
        <div class="action-modal-icon delete">🗑️</div>
        <h3 class="action-modal-title">Delete Instrument</h3>
        <p class="action-modal-message">Are you sure you want to delete this instrument? This action cannot be undone.</p>
        <div class="action-modal-buttons">
            <button class="modal-btn-cancel" onclick="closeDeleteModal()">Cancel</button>
            <a href="#" class="modal-btn-confirm delete" id="deleteConfirmBtn">Delete</a>
        </div>
    </div>
</div>

<!-- Add Instrument Modal -->
<div class="action-modal" id="addModal">
    <div class="action-modal-content">
        <div class="action-modal-icon add">✓</div>
        <h3 class="action-modal-title">Confirm Add Instrument</h3>
        <p class="action-modal-message">Add this new instrument to your rental inventory?</p>
        <div class="action-modal-buttons">
            <button class="modal-btn-cancel" onclick="closeAddModal()">Cancel</button>
            <button class="modal-btn-confirm add" onclick="submitAddForm()">Add Instrument</button>
        </div>
    </div>
</div>

<!-- Done Modal -->
<div class="action-modal" id="doneModal">
    <div class="action-modal-content">
        <div class="action-modal-icon done">✓</div>
        <h3 class="action-modal-title">Mark as Done</h3>
        <p class="action-modal-message">Mark this order as completed?</p>
        <div class="action-modal-buttons">
            <button class="modal-btn-cancel" onclick="closeDoneModal()">Cancel</button>
            <a href="#" class="modal-btn-confirm done" id="doneConfirmBtn">Mark Done</a>
        </div>
    </div>
</div>

</body>
</html>

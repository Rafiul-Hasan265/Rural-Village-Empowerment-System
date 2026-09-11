<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart - Agri Service</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f0f4f0 0%, #e8f0e8 100%);
            min-height: 100vh;
        }

        .cart-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            max-width: 1400px;
            margin: 0 auto;
            background: #fff;
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.08);
        }

        /* Header */
        .cart-header {
            background: linear-gradient(135deg, #1a472a 0%, #2d5a3d 50%, #1a472a 100%);
            padding: 30px 40px;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 15px;
        }

        .cart-header-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .cart-icon {
            width: 56px;
            height: 56px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
        }

        .cart-icon svg {
            width: 28px;
            height: 28px;
            fill: #fff;
        }

        .cart-header h2 {
            font-size: 1.7rem;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .cart-count-badge {
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 18px;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: 500;
            backdrop-filter: blur(10px);
        }

        /* Table Container with Scroll */
        .table-wrapper {
            flex: 1;
            overflow-y: auto;
            padding: 30px;
            background: #fafbfa;
        }

        .table-wrapper::-webkit-scrollbar {
            width: 10px;
        }

        .table-wrapper::-webkit-scrollbar-track {
            background: #e8e8e8;
            border-radius: 5px;
        }

        .table-wrapper::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #1a472a, #2d5a3d);
            border-radius: 5px;
        }

        .table-wrapper::-webkit-scrollbar-thumb:hover {
            background: #143d23;
        }

        /* Table Styling */
        .cart-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        }

        .cart-table thead th {
            background: linear-gradient(135deg, #1a472a 0%, #2d5a3d 100%);
            color: #fff;
            padding: 18px 20px;
            text-align: left;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .cart-table thead th:first-child {
            border-radius: 16px 0 0 0;
        }

        .cart-table thead th:last-child {
            border-radius: 0 16px 0 0;
        }

        .cart-table tbody tr {
            transition: all 0.2s ease;
        }

        .cart-table tbody tr:hover {
            background: #f8faf8;
        }

        .cart-table tbody td {
            padding: 20px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }

        .cart-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Instrument Details Cell - No image */
        .instrument-info h4 {
            font-size: 1.1rem;
            color: #1a1a1a;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .instrument-category {
            font-size: 0.75rem;
            color: #666;
            background: #e8f0e8;
            padding: 4px 12px;
            border-radius: 20px;
            display: inline-block;
        }

        /* Provider Cell */
        .provider-name {
            font-weight: 600;
            color: #1a472a;
            font-size: 0.95rem;
        }

        /* Pricing Cell */
        .pricing-info {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .price-row {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .price-main {
            font-weight: 700;
            font-size: 1rem;
        }

        .price-main.rent {
            color: #e65100;
        }

        .price-main.buy {
            color: #1565c0;
        }

        .price-breakdown {
            font-size: 0.75rem;
            color: #888;
        }

        /* Quantity Controls */
        .qty-controls {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .btn-qty {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            font-weight: 700;
            color: #fff;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-minus {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
        }

        .btn-minus:hover {
            background: linear-gradient(135deg, #c0392b, #a93226);
            transform: scale(1.1);
        }

        .btn-plus {
            background: linear-gradient(135deg, #27ae60, #1e8449);
        }

        .btn-plus:hover {
            background: linear-gradient(135deg, #1e8449, #196f3d);
            transform: scale(1.1);
        }

        .qty-badge {
            background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
            color: #1a472a;
            padding: 8px 20px;
            border-radius: 25px;
            font-weight: 700;
            font-size: 1.1rem;
            min-width: 50px;
            text-align: center;
            border: 2px solid #a5d6a7;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 8px;
            min-width: 140px;
        }

        .btn-row {
            display: flex;
            gap: 6px;
        }

        .btn {
            padding: 10px 16px;
            border: none;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            flex: 1;
        }

        .btn-rent {
            background: linear-gradient(135deg, #ff9800, #f57c00);
            color: #fff;
        }

        .btn-rent:hover {
            background: linear-gradient(135deg, #f57c00, #ef6c00);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 152, 0, 0.4);
        }

        .btn-buy {
            background: linear-gradient(135deg, #1a472a, #2d5a3d);
            color: #fff;
        }

        .btn-buy:hover {
            background: linear-gradient(135deg, #143d23, #1a472a);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(26, 71, 42, 0.4);
        }

        .btn-remove {
            background: transparent;
            color: #dc3545;
            border: 1.5px solid #dc3545;
            font-size: 0.8rem;
            padding: 8px 12px;
        }

        .btn-remove:hover {
            background: #dc3545;
            color: #fff;
        }

        /* Total Row */
        .cart-table tfoot tr {
            background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
        }

        .cart-table tfoot td {
            padding: 24px 20px;
            font-weight: 700;
            border-top: 3px solid #1a472a;
        }

        .summary-label {
            font-size: 1.1rem;
            color: #1a472a;
        }

        .summary-totals {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .total-item {
            font-size: 1.05rem;
        }

        .total-item.rent {
            color: #e65100;
        }

        .total-item.buy {
            color: #1565c0;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 100px 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: #fafbfa;
        }

        .empty-icon {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #e8f0e8, #d4e6d4);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
        }

        .empty-icon svg {
            width: 60px;
            height: 60px;
            stroke: #1a472a;
            opacity: 0.6;
        }

        .empty-state h3 {
            font-size: 1.6rem;
            color: #333;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #777;
            font-size: 1rem;
            margin-bottom: 30px;
        }

        .btn-browse {
            background: linear-gradient(135deg, #1a472a, #2d5a3d);
            color: #fff;
            padding: 14px 30px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.2s ease;
        }

        .btn-browse:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(26, 71, 42, 0.4);
        }

        /* Footer */
        .cart-footer {
            padding: 24px 40px;
            border-top: 2px solid #e8e8e8;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
            background: #fff;
        }

        .back-link {
            color: #1a472a;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.2s ease;
        }

        .back-link:hover {
            color: #143d23;
            gap: 14px;
        }

        .back-link svg {
            width: 20px;
            height: 20px;
        }

        .footer-note {
            font-size: 0.85rem;
            color: #888;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .footer-note svg {
            width: 16px;
            height: 16px;
            fill: #888;
        }

        /* Buy Confirmation Modal */
        .buy-modal-overlay {
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
            z-index: 2000;
            padding: 20px;
        }

        .buy-modal-overlay.active {
            display: flex;
        }

        .buy-modal-box {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
            max-width: 450px;
            width: 100%;
            animation: buyModalSlideIn 0.3s ease-out;
            overflow: hidden;
        }

        @keyframes buyModalSlideIn {
            from {
                transform: scale(0.9) translateY(-20px);
                opacity: 0;
            }
            to {
                transform: scale(1) translateY(0);
                opacity: 1;
            }
        }

        .buy-modal-header {
            padding: 32px 24px 24px;
            text-align: center;
        }

        .buy-modal-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
        }

        .buy-modal-icon svg {
            width: 36px;
            height: 36px;
            fill: #1a472a;
        }

        .buy-modal-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
        }

        .buy-modal-message {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.6;
            padding: 0 24px 24px;
            text-align: center;
        }

        .buy-modal-details {
            background: #f8f8f8;
            margin: 0 24px 24px;
            padding: 16px;
            border-radius: 10px;
            font-size: 0.875rem;
            color: #555;
        }

        .buy-modal-detail-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .buy-modal-detail-item:last-child {
            margin-bottom: 0;
        }

        .buy-modal-detail-label {
            font-weight: 500;
            color: #666;
        }

        .buy-modal-detail-value {
            color: #1565c0;
            font-weight: 700;
        }

        .buy-modal-actions {
            display: flex;
            border-top: 1px solid #e8e8e8;
        }

        .buy-modal-btn {
            flex: 1;
            padding: 16px 24px;
            border: none;
            font-size: 0.95rem;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            text-align: center;
        }

        .buy-modal-btn-cancel {
            background: #f0f0f0;
            color: #666;
            border-right: 1px solid #e8e8e8;
        }

        .buy-modal-btn-cancel:hover {
            background: #e8e8e8;
        }

        .buy-modal-btn-confirm {
            background: linear-gradient(135deg, #1a472a, #2d5a3d);
            color: #fff;
        }

        .buy-modal-btn-confirm:hover {
            opacity: 0.9;
            box-shadow: 0 4px 12px rgba(26, 71, 42, 0.3);
        }

        /* Remove Confirmation Modal */
        .remove-modal-overlay {
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
            z-index: 2000;
            padding: 20px;
        }

        .remove-modal-overlay.active {
            display: flex;
        }

        .remove-modal-box {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
            max-width: 450px;
            width: 100%;
            animation: removeModalSlideIn 0.3s ease-out;
            overflow: hidden;
        }

        @keyframes removeModalSlideIn {
            from {
                transform: scale(0.9) translateY(-20px);
                opacity: 0;
            }
            to {
                transform: scale(1) translateY(0);
                opacity: 1;
            }
        }

        .remove-modal-header {
            padding: 32px 24px 24px;
            text-align: center;
        }

        .remove-modal-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
        }

        .remove-modal-icon svg {
            width: 36px;
            height: 36px;
            fill: #dc2626;
        }

        .remove-modal-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
        }

        .remove-modal-message {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.6;
            padding: 0 24px 24px;
            text-align: center;
        }

        .remove-modal-details {
            background: #f8f8f8;
            margin: 0 24px 24px;
            padding: 16px;
            border-radius: 10px;
            font-size: 0.875rem;
            color: #555;
        }

        .remove-modal-detail-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .remove-modal-detail-item:last-child {
            margin-bottom: 0;
        }

        .remove-modal-detail-label {
            font-weight: 500;
            color: #666;
        }

        .remove-modal-detail-value {
            color: #dc2626;
            font-weight: 700;
        }

        .remove-modal-actions {
            display: flex;
            border-top: 1px solid #e8e8e8;
        }

        .remove-modal-btn {
            flex: 1;
            padding: 16px 24px;
            border: none;
            font-size: 0.95rem;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            text-align: center;
        }

        .remove-modal-btn-cancel {
            background: #f0f0f0;
            color: #666;
            border-right: 1px solid #e8e8e8;
        }

        .remove-modal-btn-cancel:hover {
            background: #e8e8e8;
        }

        .remove-modal-btn-confirm {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            color: #fff;
        }

        .remove-modal-btn-confirm:hover {
            opacity: 0.9;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }

        /* Mobile Cards View */
        .mobile-cards {
            display: none;
        }

        .mobile-card {
            background: #fff;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 16px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
            border: 1px solid #eee;
        }

        /* Mobile card header without image */
        .mobile-card-header {
            margin-bottom: 16px;
            padding-bottom: 16px;
            border-bottom: 1px solid #eee;
        }

        .mobile-card-info h4 {
            font-size: 1.1rem;
            color: #1a1a1a;
            margin-bottom: 8px;
        }

        .mobile-card-info .category {
            font-size: 0.75rem;
            color: #666;
            background: #e8f0e8;
            padding: 4px 10px;
            border-radius: 15px;
            display: inline-block;
            margin-bottom: 8px;
        }

        .mobile-card-info .provider {
            font-size: 0.85rem;
            color: #555;
        }

        .mobile-card-info .provider span {
            font-weight: 600;
            color: #1a472a;
        }

        .mobile-card-pricing {
            display: flex;
            gap: 12px;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }

        .mobile-price-box {
            flex: 1;
            min-width: 140px;
            padding: 12px;
            border-radius: 10px;
        }

        .mobile-price-box.rent {
            background: #fff3e0;
        }

        .mobile-price-box.buy {
            background: #e3f2fd;
        }

        .mobile-price-box .label {
            font-size: 0.75rem;
            color: #666;
            margin-bottom: 4px;
        }

        .mobile-price-box .amount {
            font-size: 1.1rem;
            font-weight: 700;
        }

        .mobile-price-box.rent .amount {
            color: #e65100;
        }

        .mobile-price-box.buy .amount {
            color: #1565c0;
        }

        .mobile-price-box .breakdown {
            font-size: 0.7rem;
            color: #888;
            margin-top: 2px;
        }

        .mobile-card-qty {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            margin-bottom: 16px;
            padding: 12px;
            background: #f8f8f8;
            border-radius: 10px;
        }

        .mobile-card-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .mobile-card-actions .btn-row {
            display: flex;
            gap: 10px;
        }

        .mobile-card-actions .btn {
            flex: 1;
            padding: 12px;
        }

        .mobile-card-actions .btn-remove {
            width: 100%;
        }

        /* Mobile Summary Card */
        .mobile-summary {
            background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
            border-radius: 16px;
            padding: 20px;
            margin-top: 10px;
            border: 2px solid #1a472a;
        }

        .mobile-summary h4 {
            font-size: 1.1rem;
            color: #1a472a;
            margin-bottom: 12px;
        }

        .mobile-summary .totals {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .mobile-summary .total-item {
            font-size: 1rem;
            font-weight: 600;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .cart-header {
                padding: 24px 30px;
            }

            .table-wrapper {
                padding: 24px;
            }

            .cart-table thead th,
            .cart-table tbody td {
                padding: 16px 14px;
            }

            .action-buttons {
                min-width: 120px;
            }

            .btn {
                padding: 8px 12px;
                font-size: 0.8rem;
            }
        }

        @media (max-width: 900px) {
            /* Hide table, show cards */
            .table-wrapper {
                display: none;
            }

            .mobile-cards {
                display: block;
                flex: 1;
                overflow-y: auto;
                padding: 20px;
                background: #fafbfa;
            }

            .mobile-cards::-webkit-scrollbar {
                width: 8px;
            }

            .mobile-cards::-webkit-scrollbar-track {
                background: #e8e8e8;
                border-radius: 4px;
            }

            .mobile-cards::-webkit-scrollbar-thumb {
                background: #1a472a;
                border-radius: 4px;
            }

            .cart-header {
                padding: 20px;
            }

            .cart-header h2 {
                font-size: 1.4rem;
            }

            .cart-icon {
                width: 48px;
                height: 48px;
            }

            .cart-icon svg {
                width: 24px;
                height: 24px;
            }

            .cart-footer {
                padding: 20px;
                flex-direction: column;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .cart-header {
                padding: 16px;
            }

            .cart-header h2 {
                font-size: 1.2rem;
            }

            .cart-count-badge {
                font-size: 0.8rem;
                padding: 6px 14px;
            }

            .mobile-cards {
                padding: 14px;
            }

            .mobile-card {
                padding: 16px;
            }

            .mobile-card-info h4 {
                font-size: 1rem;
            }

            .mobile-price-box {
                min-width: 100%;
            }

            .btn-qty {
                width: 32px;
                height: 32px;
            }

            .qty-badge {
                padding: 6px 16px;
                font-size: 1rem;
            }

            .cart-footer {
                padding: 14px;
            }

            .back-link {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>

<div class="cart-container">
    <!-- Header -->
    <div class="cart-header">
        <div class="cart-header-left">
            <div class="cart-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/>
                </svg>
            </div>
            <h2>My Selection Cart</h2>
        </div>
        <?php if(!empty($cartItems)): ?>
        <span class="cart-count-badge"><?php echo count($cartItems); ?> item<?php echo count($cartItems) > 1 ? 's' : ''; ?> in cart</span>
        <?php endif; ?>
    </div>

    <?php if(!empty($cartItems)): ?>
    <!-- Desktop Table View -->
    <div class="table-wrapper">
        <table class="cart-table">
            <thead>
                <tr>
                    <th style="width: 28%;">Instrument Details</th>
                    <th style="width: 15%;">Service Provider</th>
                    <th style="width: 22%;">Pricing Info (Total)</th>
                    <th style="width: 15%; text-align: center;">Quantity</th>
                    <th style="width: 20%; text-align: center;">Decision</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $grand_total_rent = 0;
                $grand_total_buy = 0;

                foreach($cartItems as $item): 
                    $qty = $_SESSION['cart'][$item['id']]; 
                    
                    $sub_total_rent = $item['rental_price'] * $qty;
                    $sub_total_buy = $item['selling_price'] * $qty;

                    $grand_total_rent += $sub_total_rent;
                    $grand_total_buy += $sub_total_buy;
                ?>
                <tr>
                    <!-- Removed image, showing only text info -->
                    <td>
                        <div class="instrument-info">
                            <h4><?php echo htmlspecialchars($item['name']); ?></h4>
                            <span class="instrument-category"><?php echo htmlspecialchars($item['category']); ?></span>
                        </div>
                    </td>
                    <td>
                        <span class="provider-name"><?php echo htmlspecialchars($item['company_name']); ?></span>
                    </td>
                    <td>
                        <div class="pricing-info">
                            <div class="price-row">
                                <span class="price-main rent">Rent: ৳<?php echo number_format($sub_total_rent, 2); ?></span>
                                <span class="price-breakdown">(৳<?php echo number_format($item['rental_price'], 2); ?> × <?php echo $qty; ?>)</span>
                            </div>
                            <div class="price-row">
                                <span class="price-main buy">Buy: ৳<?php echo number_format($sub_total_buy, 2); ?></span>
                                <span class="price-breakdown">(৳<?php echo number_format($item['selling_price'], 2); ?> × <?php echo $qty; ?>)</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="qty-controls">
                            <a href="index.php?url=decrease_qty&id=<?php echo $item['id']; ?>" class="btn-qty btn-minus" title="Decrease">−</a>
                            <span class="qty-badge"><?php echo $qty; ?></span>
                            <a href="index.php?url=increase_qty&id=<?php echo $item['id']; ?>" class="btn-qty btn-plus" title="Increase">+</a>
                        </div>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <div class="btn-row">
                                <a href="index.php?url=rent_details&id=<?php echo $item['id']; ?>" class="btn btn-rent">Rent</a>
                                <button type="button" onclick="showBuyModal('<?php echo $item['id']; ?>', '<?php echo htmlspecialchars($item['name'], ENT_QUOTES); ?>', '<?php echo number_format($sub_total_buy, 2); ?>')" class="btn btn-buy">Buy</button>
                                <button type="button" onclick="showRemoveModal('<?php echo $item['id']; ?>', '<?php echo htmlspecialchars($item['name'], ENT_QUOTES); ?>')" class="btn btn-remove">Remove</button>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" style="text-align: right;">
                        <span class="summary-label">Cart Summary:</span>
                    </td>
                    <td colspan="3">
                        <div class="summary-totals">
                            <span class="total-item rent">Total Rent Amount: ৳<?php echo number_format($grand_total_rent, 2); ?></span>
                            <span class="total-item buy">Total Buy Amount: ৳<?php echo number_format($grand_total_buy, 2); ?></span>
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Mobile Cards View -->
    <div class="mobile-cards">
        <?php 
        $grand_total_rent_mobile = 0;
        $grand_total_buy_mobile = 0;

        foreach($cartItems as $item): 
            $qty = $_SESSION['cart'][$item['id']]; 
            
            $sub_total_rent = $item['rental_price'] * $qty;
            $sub_total_buy = $item['selling_price'] * $qty;

            $grand_total_rent_mobile += $sub_total_rent;
            $grand_total_buy_mobile += $sub_total_buy;
        ?>
        <div class="mobile-card">
            <!-- Removed image from mobile card header -->
            <div class="mobile-card-header">
                <div class="mobile-card-info">
                    <h4><?php echo htmlspecialchars($item['name']); ?></h4>
                    <span class="category"><?php echo htmlspecialchars($item['category']); ?></span>
                    <p class="provider">By <span><?php echo htmlspecialchars($item['company_name']); ?></span></p>
                </div>
            </div>
            
            <div class="mobile-card-pricing">
                <div class="mobile-price-box rent">
                    <div class="label">Rent Price</div>
                    <div class="amount">৳<?php echo number_format($sub_total_rent, 2); ?></div>
                    <div class="breakdown">৳<?php echo number_format($item['rental_price'], 2); ?> × <?php echo $qty; ?></div>
                </div>
                <div class="mobile-price-box buy">
                    <div class="label">Buy Price</div>
                    <div class="amount">৳<?php echo number_format($sub_total_buy, 2); ?></div>
                    <div class="breakdown">৳<?php echo number_format($item['selling_price'], 2); ?> × <?php echo $qty; ?></div>
                </div>
            </div>

            <div class="mobile-card-qty">
                <a href="index.php?url=decrease_qty&id=<?php echo $item['id']; ?>" class="btn-qty btn-minus">−</a>
                <span class="qty-badge"><?php echo $qty; ?></span>
                <a href="index.php?url=increase_qty&id=<?php echo $item['id']; ?>" class="btn-qty btn-plus">+</a>
            </div>

            <div class="mobile-card-actions">
                <div class="btn-row">
                    <a href="index.php?url=rent_details&id=<?php echo $item['id']; ?>" class="btn btn-rent">Rent</a>
                    <button type="button" onclick="showBuyModal('<?php echo $item['id']; ?>', '<?php echo htmlspecialchars($item['name'], ENT_QUOTES); ?>', '<?php echo number_format($sub_total_buy, 2); ?>')" class="btn btn-buy">Buy</button>
                </div>
                <button type="button" onclick="showRemoveModal('<?php echo $item['id']; ?>', '<?php echo htmlspecialchars($item['name'], ENT_QUOTES); ?>')" class="btn btn-remove">Remove All</button>
            </div>
        </div>
        <?php endforeach; ?>

        <!-- Mobile Summary -->
        <div class="mobile-summary">
            <h4>Cart Summary</h4>
            <div class="totals">
                <span class="total-item rent">Total Rent: ৳<?php echo number_format($grand_total_rent_mobile, 2); ?></span>
                <span class="total-item buy">Total Buy: ৳<?php echo number_format($grand_total_buy_mobile, 2); ?></span>
            </div>
        </div>
        
    </div>

    <?php else: ?>
    <!-- Empty State -->
    <div class="empty-state">
        <div class="empty-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="9" cy="21" r="1"></circle>
                <circle cx="20" cy="21" r="1"></circle>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
            </svg>
        </div>
        <h3>Your cart is empty!</h3>
        <p>Looks like you haven't added any machinery yet.</p>
        <a href="index.php?url=landowner_dashboard" class="btn-browse">Browse Marketplace</a>
    </div>
    <?php endif; ?>

    <!-- Footer -->
<div class="cart-footer">
    <?php if(!empty($cartItems)): ?>
        <a href="index.php?url=landowner_dashboard" class="back-link">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back to Dashboard
        </a>

        <span class="footer-note">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </svg>
            * All prices are calculated based on your selected quantity.
        </span>
    <?php endif; ?>
</div>
</div>

<!-- Buy Confirmation Modal -->
<div class="buy-modal-overlay" id="buyModal">
    <div class="buy-modal-box">
        <div class="buy-modal-header">
            <div class="buy-modal-icon">
                <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
            </div>
            <h3 class="buy-modal-title">Confirm Purchase</h3>
        </div>
        <p class="buy-modal-message">Please review the details below before confirming your purchase.</p>
        <div class="buy-modal-details">
            <div class="buy-modal-detail-item">
                <span class="buy-modal-detail-label">Item:</span>
                <span class="buy-modal-detail-value" id="buyItemName"></span>
            </div>
            <div class="buy-modal-detail-item">
                <span class="buy-modal-detail-label">Purchase Price:</span>
                <span class="buy-modal-detail-value">৳<span id="buyItemPrice"></span></span>
            </div>
        </div>
        <div class="buy-modal-actions">
            <button type="button" class="buy-modal-btn buy-modal-btn-cancel" onclick="closeBuyModal()">Cancel</button>
            <a href="#" class="buy-modal-btn buy-modal-btn-confirm" id="buyConfirmBtn">Proceed to Buy</a>
        </div>
    </div>
</div>

<!-- Remove Confirmation Modal -->
<div class="remove-modal-overlay" id="removeModal">
    <div class="remove-modal-box">
        <div class="remove-modal-header">
            <div class="remove-modal-icon">
                <svg viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
            </div>
            <h3 class="remove-modal-title">Remove Item</h3>
        </div>
        <p class="remove-modal-message">Are you sure you want to remove this item from your cart? This action cannot be undone.</p>
        <div class="remove-modal-details">
            <div class="remove-modal-detail-item">
                <span class="remove-modal-detail-label">Item:</span>
                <span class="remove-modal-detail-value" id="removeItemName"></span>
            </div>
        </div>
        <div class="remove-modal-actions">
            <button type="button" class="remove-modal-btn remove-modal-btn-cancel" onclick="closeRemoveModal()">Cancel</button>
            <a href="#" class="remove-modal-btn remove-modal-btn-confirm" id="removeConfirmBtn">Remove Item</a>
        </div>
    </div>
</div>

<script>
function showBuyModal(itemId, itemName, itemPrice) {
    document.getElementById('buyItemName').textContent = itemName;
    document.getElementById('buyItemPrice').textContent = itemPrice;
    document.getElementById('buyConfirmBtn').href = 'index.php?url=confirm_buy&id=' + itemId;
    
    document.getElementById('buyModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeBuyModal() {
    document.getElementById('buyModal').classList.remove('active');
    document.body.style.overflow = '';
}

function showRemoveModal(itemId, itemName) {
    document.getElementById('removeItemName').textContent = itemName;
    document.getElementById('removeConfirmBtn').href = 'index.php?url=remove_from_cart&id=' + itemId;
    
    document.getElementById('removeModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeRemoveModal() {
    document.getElementById('removeModal').classList.remove('active');
    document.body.style.overflow = '';
}

// Close modals when clicking outside
document.getElementById('buyModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeBuyModal();
    }
});

document.getElementById('removeModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeRemoveModal();
    }
});

// Close modals with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeBuyModal();
        closeRemoveModal();
    }
});
</script>

</body>
</html>

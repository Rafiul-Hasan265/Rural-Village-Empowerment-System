<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class CartController
{
   
    // ADD
  
    public function add()
    {
        if (isset($_GET['id'])) {

            $id = $_GET['id'];

            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            if (isset($_SESSION['cart'][$id])) {
                $_SESSION['cart'][$id]++;
            } else {
                $_SESSION['cart'][$id] = 1;
            }

            header(
                'location: index.php?url=landowner_dashboard&status=success'
            );

            exit();
        }
    }


  
    // VIEW
  
    public function view()
    {
        $cartItems = [];

        if (
            isset($_SESSION['cart']) &&
            !empty($_SESSION['cart'])
        ) {

            foreach ($_SESSION['cart'] as $id => $quantity) {

                $cartItems[] = [
                    'id' => $id,
                    'name' => 'Instrument ' . $id,
                    'category' => 'Agricultural Instrument',
                    'rental_price' => 0,
                    'selling_price' => 0,
                    'description' => '',
                    'quantity' => $quantity
                ];
            }
        }

        require_once '../app/views/landowner/cart.php';
    }


  
    // REMOVE
  
    public function remove()
    {
        if (isset($_GET['id'])) {

            $id = $_GET['id'];

            unset($_SESSION['cart'][$id]);
        }

        header(
            'location: index.php?url=view_cart'
        );

        exit();
    }


  
    // DECREASE QUANTITY
  
    public function decrease_qty()
    {
        if (isset($_GET['id'])) {

            $id = $_GET['id'];

            if (isset($_SESSION['cart'][$id])) {

                $_SESSION['cart'][$id]--;

                if ($_SESSION['cart'][$id] <= 0) {

                    unset($_SESSION['cart'][$id]);
                }
            }
        }

        header(
            'location: index.php?url=view_cart'
        );

        exit();
    }


  
    // INCREASE QUANTITY
  
    public function increase_qty()
    {
        if (isset($_GET['id'])) {

            $id = $_GET['id'];

            if (isset($_SESSION['cart'][$id])) {

                $_SESSION['cart'][$id]++;
            }
        }

        header(
            'location: index.php?url=view_cart'
        );

        exit();
    }


  
    // RENT DETAILS
  
    public function rentDetails()
    {
        $id = $_GET['id'] ?? '';

        $item = [
            'id' => $id,
            'name' => 'Instrument ' . $id,
            'rental_price' => 0,
            'selling_price' => 0,
            'description' => ''
        ];

        require_once '../app/views/landowner/rent_form.php';
    }


  
    // CONFIRM BUY
  
    public function confirmBuy()
    {
        $id = $_GET['id'] ?? '';

        $quantity =
            isset($_SESSION['cart'][$id])
                ? $_SESSION['cart'][$id]
                : 1;

        // Simple purchase record
        if (!isset($_SESSION['orders'])) {
            $_SESSION['orders'] = [];
        }

        $_SESSION['orders'][] = [
            'id' => $id,
            'user_id' => $_SESSION['user_id'] ?? 0,
            'quantity' => $quantity,
            'type' => 'buy',
            'status' => 'pending'
        ];

        unset($_SESSION['cart'][$id]);

        header(
            'location: index.php?url=view_cart'
        );

        exit();
    }


  
    // PROCESS RENT
  
    public function processRent()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $id = $_POST['instrument_id'] ?? '';

            $quantity =
                (
                    isset($_SESSION['cart'][$id]) &&
                    $_SESSION['cart'][$id] > 0
                )
                ? $_SESSION['cart'][$id]
                : 1;

            if (!isset($_SESSION['rentals'])) {
                $_SESSION['rentals'] = [];
            }

            $_SESSION['rentals'][] = [
                'instrument_id' => $id,
                'user_id' => $_SESSION['user_id'] ?? 0,
                'rental_date' => $_POST['rental_date'] ?? '',
                'quantity' => $quantity,
                'status' => 'pending'
            ];

            unset($_SESSION['cart'][$id]);

            header(
                'location: index.php?url=view_cart'
            );

            exit();
        }
    }
}
?>
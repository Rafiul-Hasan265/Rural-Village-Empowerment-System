<?php
// app/controllers/CartController.php

class CartController {
    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    // add() function update
public function add() {
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        if(!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Jodi item age theke thake quantity barabo, na thakle 1 set korbo
        if(isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]++;
        } else {
            $_SESSION['cart'][$id] = 0;
        }
        header('location: index.php?url=landowner_dashboard&status=success');
    }
}

// view() function update
public function view() {
    require_once '../app/models/UserModel.php';
    $userModel = new UserModel();
    
    $cartItems = [];
    if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        // Shudhu keys (IDs) gulo pathate hobe model-e
        $cartItems = $userModel->getCartDetails(array_keys($_SESSION['cart']));
    }
    require_once '../app/views/landowner/cart.php';
}

// remove() function update
public function remove() {
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        unset($_SESSION['cart'][$id]); // Direct key dhore unset
    }
    header('location: index.php?url=view_cart');
}

// confirmBuy ebong processRent-eo unset($_SESSION['cart'][$key]) er poriborte 
// unset($_SESSION['cart'][$id]) use korben.

// Quantity ekta komanor jonno
public function decrease_qty() {
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        if(isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]--;
            // Jodi quantity 0 hoye jay, tobe cart theke remove kore deya
            if($_SESSION['cart'][$id] <= 0) {
                unset($_SESSION['cart'][$id]);
            }
        }
    }
    header('location: index.php?url=view_cart');
}

// Quantity ekta baranor jonno (already add kora item-er jonno)
public function increase_qty() {
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        if(isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]++;
        }
    }
    header('location: index.php?url=view_cart');
}

    // 2. Buy Logic

    // 3. Rent Logic (Form dekhano)
    public function rentDetails() {
        require_once '../app/models/UserModel.php';
        $userModel = new UserModel();
        $item = $userModel->getInstrumentById($_GET['id']);
        require_once '../app/views/landowner/rent_form.php';
    }

    // Confirm Buy Logic
// Purchase Confirm
public function confirmBuy() {
    require_once '../app/models/UserModel.php';
    $userModel = new UserModel();
    $id = $_GET['id'];
    $item = $userModel->getInstrumentById($id);
    
    // Quantity session theke neya
    $quantity = isset($_SESSION['cart'][$id]) ? $_SESSION['cart'][$id] : 1; 
    
    // Model-er update kora function-ti call kora
    if ($userModel->buyInstrument($id, $_SESSION['user_id'], $item['selling_price'], $quantity)) {
        unset($_SESSION['cart'][$id]);
        header('location: index.php?url=view_cart');
    }
}

// Rent Confirm
public function processRent() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        require_once '../app/models/UserModel.php';
        $userModel = new UserModel();
        $id = $_POST['instrument_id'];
        
        $quantity = (isset($_SESSION['cart'][$id]) && $_SESSION['cart'][$id] > 0) ? $_SESSION['cart'][$id] : 1; 
        
        if ($userModel->saveRentalRequest($id, $_SESSION['user_id'], $_POST['rental_date'], $quantity)) {
            unset($_SESSION['cart'][$id]);
            header('location: index.php?url=view_cart');
        }
    }
}

}
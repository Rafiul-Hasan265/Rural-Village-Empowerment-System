<?php
$scheme = (
    (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    || ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https'
) ? 'https' : 'http';

$host = $_SERVER['HTTP_HOST'] ?? 'localhost';

$scriptDir = rtrim(
    str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/public/index.php')),
    '/'
);

define('BASE_URL', $scheme . '://' . $host . $scriptDir);
// Session start kora jate login info save thake
session_start();

// Core files require kora
require_once '../app/core/Database.php';
require_once '../app/helpers/session_helper.php';

// URL routing logic - Default hobe 'home'
$url = isset($_GET['url']) ? $_GET['url'] : 'home';

switch($url) {
    // --- HOME & AUTH ROUTES ---
    case 'home':
        // Delete the previous echo statements and replace with:
        require_once '../app/views/home.php';
        break;

    case 'register':
        require_once '../app/views/auth/register.php';
        break;

    case 'process_register':
        require_once '../app/controllers/AuthController.php';
        $auth = new AuthController();
        $auth->register();
        break;

    case 'login':
        require_once '../app/views/auth/login.php';
        break;

    case 'process_login':
        require_once '../app/controllers/AuthController.php';
        $auth = new AuthController();
        $auth->login();
        break;

    case 'logout':
        require_once '../app/controllers/AuthController.php';
        $auth = new AuthController();
        $auth->logout();
        break;
    case 'forgot_password':
        require_once '../app/controllers/AuthController.php';
        (new AuthController())->forgotPassword();
        break;

    case 'reset_password':
        require_once '../app/controllers/AuthController.php';
        (new AuthController())->resetPassword();
        break;
    // --- DASHBOARD ROUTES ---
    
    case 'landowner_dashboard':
    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'landowner') {
        require_once '../app/models/UserModel.php';
        $userModel = new UserModel();
        
        $farmers = $userModel->getFarmersByDistrict($_SESSION['user_district']);
        $instruments = $userModel->getAllInstruments(); 
        
        // --- Landowner-er sent requests fetch kora ---
        $myRequests = $userModel->getMySentRequests($_SESSION['user_id']);
        
        // --- EKHTANE NOTUN LINE-TI ADD kora ---
        $workingFarmers = $userModel->getCurrentlyWorkingFarmers($_SESSION['user_id']);
        
        require_once '../app/views/landowner/dashboard.php';
    } else {
        header('location: index.php?url=login');
    }
    break;

    case 'farmer_dashboard':
    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'farmer') {
        require_once '../app/models/UserModel.php';
        $userModel = new UserModel();
        
        // Eikhanei getUserById call hocche
        $farmerData = $userModel->getUserById($_SESSION['user_id']);
        
        $requests = $userModel->getHireRequestsForFarmer($_SESSION['user_id']);
        require_once '../app/views/farmer/dashboard.php';
    } else {
        header('location: index.php?url=login');
    }
    break;

    case 'company_dashboard':
        if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'company') {
            require_once '../app/models/UserModel.php';
            $userModel = new UserModel();
            
            $myInstruments = $userModel->getInstrumentsByCompany($_SESSION['user_id']);
            
            // Alada alada bhabe data fetch kora
            $purchaseOrders = $userModel->getCompanyPurchases($_SESSION['user_id']);
            $rentalOrders = $userModel->getCompanyRentals($_SESSION['user_id']);
            
            require_once '../app/views/company/dashboard.php';
        }
        break;

    case 'add_instrument':
        require_once '../app/controllers/AuthController.php';
        $auth = new AuthController();
        $auth->addInstrument();
        break;

    case 'hire_farmer':
        require_once '../app/controllers/AuthController.php';
        $auth = new AuthController();
        $auth->hireFarmer();
        break;

    case 'process_request':
        require_once '../app/controllers/AuthController.php';
        $auth = new AuthController();
        $auth->handleHireRequest();
        break;

    case 'update_farmer_profile':
        require_once '../app/controllers/AuthController.php';
        $auth = new AuthController();
        $auth->updateFarmerProfile(); // Ei nam ebong Controller-er function nam jeno ek hoy
        break;

    case 'set_available':
        require_once '../app/controllers/AuthController.php';
        $auth = new AuthController();
        $auth->setAvailable();
        break;

    case 'edit_instrument':
    // AuthController file-ti include kora hoyeche kina check korun
        require_once '../app/controllers/AuthController.php'; 
        $auth = new AuthController();
        $auth->editInstrument();
        break;

    case 'delete_instrument':
        // Ekhaneo file-ti include kora proyojon
        require_once '../app/controllers/AuthController.php';
        $auth = new AuthController();
        $auth->deleteInstrument();
        break;

    

    case 'add_to_cart':
        require_once '../app/controllers/CartController.php';
        $cart = new CartController();
        $cart->add();
        break;

    case 'view_cart':
        require_once '../app/controllers/CartController.php';
        $cart = new CartController();
        $cart->view();
        break;


    // public/index.php (Case gulo nicher moto kore update korun)

    case 'remove_from_cart':
        require_once '../app/controllers/CartController.php';
        $cart = new CartController();
        $cart->remove();
        break;

    case 'confirm_buy':
        require_once '../app/controllers/CartController.php';
        $cart = new CartController();
        $cart->confirmBuy();
        break;

    case 'rent_details':
        require_once '../app/controllers/CartController.php';
        $cart = new CartController();
        $cart->rentDetails();
        break;

    case 'process_rent':
        require_once '../app/controllers/CartController.php';
        $cart = new CartController();
        $cart->processRent();
        break;

    case 'complete_order':
        require_once '../app/controllers/AuthController.php';
        $auth = new AuthController();
        $auth->completeOrder();
        break;

    // index.php switch block-er bhitore

    case 'increase_qty':
        require_once '../app/controllers/CartController.php'; // Path check kore niben
        $cartController = new CartController(); // Object toiri kora holo
        $cartController->increase_qty();
        break;

    case 'decrease_qty':
        require_once '../app/controllers/CartController.php';
        $cartController = new CartController(); // Object toiri kora holo
        $cartController->decrease_qty();
        break;

    case 'update_landowner_profile':
    require_once '../app/controllers/AuthController.php';
    $auth = new AuthController();
    $auth->updateLandownerProfile();
    break;
    // index.php te switch case er bhetore add korun
   // --- FARMER PROFILE ROUTES (TASK 1 & 2) ---
    case 'edit_farmer_profile':
        if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'farmer') {
            require_once '../app/controllers/AuthController.php';
            $auth = new AuthController(); // Ekhane $auth use kora hoyeche
            $auth->editFarmerProfile();
        } else {
            header('location: index.php?url=login');
        }
        break;

    case 'process_farmer_update':
        if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'farmer') {
            require_once '../app/controllers/AuthController.php';
            $auth = new AuthController();
            $auth->processFarmerUpdate();
        }
        break; 

    case 'admin_dashboard':
        // Check jodi admin login kora thake
        if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
            require_once '../app/controllers/AuthController.php';
            $auth = new AuthController(); // Ekhane $auth use korun jate error na dey
            $auth->adminDashboard();
        } else {
            header('location: index.php?url=login');
        }
        break;
    case 'delete_user':
        require_once '../app/controllers/AuthController.php';
        $auth = new AuthController();
        $auth->deleteUser(); // Method call nishchit korun
        break;

    case 'add_user':
        require_once '../app/controllers/AuthController.php';
        $auth = new AuthController();
        $auth->addUser();
        break;

    case 'toggle_user_status':
        require_once '../app/controllers/AuthController.php';
        $auth = new AuthController();
        $auth->toggleUserStatus();
        break;
    

    // --- 404 NOT FOUND ---
    default:
        echo "<h1>404 - Page Not Found</h1>";
        echo "<a href='index.php?url=home'>Back to Home</a>";
        break;
}
<?php
require_once '../app/models/UserModel.php';

class AuthController {
    private $userModel;

    public function __construct() {
        // Model initialize kora jate database queries kora jay
        $this->userModel = new UserModel();
    }

    // --- REGISTRATION LOGIC ---
public function register() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $data = [
            'full_name' => htmlspecialchars(trim($_POST['full_name'])),
            'email' => filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL),
            'password' => trim($_POST['password']),
            'role' => $_POST['role'],
            'district' => htmlspecialchars(trim($_POST['district'])),
            'phone' => htmlspecialchars(trim($_POST['phone']))
        ];

        // Public registration cannot create an admin account.
        if (!in_array($data['role'], ['landowner', 'farmer', 'company'], true)) {
            header("Location: index.php?url=register&error=invalid_role");
            exit();
        }

        if (empty($data['email']) || empty($data['password']) || empty($data['full_name']) || empty($data['phone'])) {
            header("Location: index.php?url=register&error=empty");
            exit();
        }

       

        // Check if email already exists
        if($this->userModel->findUserByEmail($data['email'])) {
            // Set a session flag for the error popup
            $_SESSION['reg_error_email'] = "This email is already registered.";
            header('location: index.php?url=register');
            exit();
        }

        if ($this->userModel->register($data)) {
            // SET SESSION FLAG FOR POPUP
            $_SESSION['reg_success'] = true;
            header("Location: index.php?url=register");
            exit();
        }
    }
}

    // --- LOGIN LOGIC ---
    public function login() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        $password = trim($_POST['password']);

        
        // All roles (including admin) are authenticated from the database.
        $loggedInUser = $this->userModel->login($email, $password);

        // --- STEP 2: DATABASE CHECK ---
        if ($loggedInUser) {
            // Session-e data set kora
            $_SESSION['user_id'] = $loggedInUser['id'];
            $_SESSION['user_name'] = $loggedInUser['full_name'];
            $_SESSION['user_role'] = $loggedInUser['role'];
            $_SESSION['user_district'] = $loggedInUser['district'];
            $_SESSION['user_phone'] = $loggedInUser['phone'];
            $_SESSION['user_email'] = $loggedInUser['email'];

            // Role onujayi Redirect (Switch use kora aro clean)
            switch($loggedInUser['role']) {
                case 'landowner':
                    header('location: index.php?url=landowner_dashboard');
                    break;
                case 'farmer':
                    header('location: index.php?url=farmer_dashboard');
                    break;
                case 'company':
                    header('location: index.php?url=company_dashboard');
                    break;
                case 'admin':
                    header('location: index.php?url=admin_dashboard');
                    break;
                default:
                    header('location: index.php?url=login&error=invalid_role');
            }
            exit();
        } else {
            // Login fail hole alert diye redirect kora bhalo, die() kora noy
            echo "<script>alert('Invalid Email or Password!'); window.location.href='index.php?url=login';</script>";
            exit();
        }
    }
}

    //Forget Password Logic
   public function forgotPassword() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        $user = $this->userModel->findUserByEmail($email);

        if ($user) {
            // 1. Generate Token
            $token = bin2hex(random_bytes(50));
            
            // 2. Save to Database
            $this->userModel->setResetToken($email, $token);
            
            
            echo "<script>
                alert('Success! Simulation: Reset link sent to your email. Redirecting you to the reset page now...');
                window.location.href = 'index.php?url=reset_password&token=" . $token . "';
            </script>";
            exit();
        } else {
            echo "<script>alert('Email not found in our system!'); window.location.href='index.php?url=login';</script>";
        }
    }
}
public function resetPassword() {
    // 1. Capture token from the URL
    $token = $_GET['token'] ?? '';

    // 2. Check if user exists with this token
    $user = $this->userModel->findUserByToken($token);

    if (!$user) {
        die("This reset link is invalid or has expired. <a href='index.php?url=login'>Return to Login</a>");
    }

    // 3. Handle the form submission for the NEW password
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $newPass = $_POST['password'];
        $confirmPass = $_POST['confirm_password'];

        if ($newPass === $confirmPass) {
            // Update and clear token so it can't be used again
            $this->userModel->updatePassword($user['id'], $newPass);
            echo "<script>alert('Password updated! You can now login with your new password.'); window.location.href='index.php?url=login';</script>";
        } else {
            echo "<script>alert('Passwords do not match. Please try again.');</script>";
        }
    }

    // 4. Load the view
    require_once '../app/views/auth/reset_password.php';
}

    public function hireFarmer() {
    if (isset($_GET['farmer_id']) && isset($_SESSION['user_id'])) {
        $landowner_id = $_SESSION['user_id'];
        $farmer_id = $_GET['farmer_id'];

        $result = $this->userModel->sendHireRequest($landowner_id, $farmer_id);

        if ($result === "exists") {
            // echo "<script>alert('You have already sent a pending request to this farmer.'); window.location.href='index.php?url=landowner_dashboard';</script>";
            header("Location: index.php?url=landowner_dashboard");
        } elseif ($result) {
            // echo "<script>alert('Hire Request Sent Successfully!'); window.location.href='index.php?url=landowner_dashboard';</script>";
            header("Location: index.php?url=landowner_dashboard");
        } else {
            die("Request failed!");
        }
    }

    }

    public function handleHireRequest() {
    if (isset($_GET['request_id']) && isset($_GET['action'])) {
        $request_id = $_GET['request_id'];
        $action = $_GET['action'];

        // Model use kore hire_requests table-e status update korbo
        if ($this->userModel->updateHireStatus($request_id, $action)) {
            
            if ($action == 'accepted') {
                
                $this->userModel->updateAvailability($_SESSION['user_id'], 'busy');
            }

            
            header("Location: index.php?url=farmer_dashboard");
        } else {
            // Jodi kono karone database error hoy
            die("Error: Action could not be processed.");
        }
    } else {
        // Jodi URL-e proyojoniyo parameter na thake
        header('location: index.php?url=farmer_dashboard');
    }
}

public function updateFarmerProfile() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'farmer') {
        
        $data = [
            'skills' => $_POST['skills'],
            'experience' => $_POST['experience'],
            'wage' => $_POST['wage']
        ];
        
        // Ekhane amra Model-er function-ke call korchi
        if ($this->userModel->updateOrCreateProfile($data)) {
            // echo "<script>alert('Profile updated successfully!'); window.location.href='index.php?url=farmer_dashboard';</script>";
            header("Location: index.php?url=farmer_dashboard&msg=farmer_dasboard");
        } else {
            echo "<script>alert('Failed to update profile!'); window.location.href='index.php?url=farmer_dashboard';</script>";
        }
    }
}

public function setAvailable() {
    if (isset($_SESSION['user_id']) && $_SESSION['user_role'] == 'farmer') {
        if ($this->userModel->makeAvailable($_SESSION['user_id'])) {
            // echo "<script>alert('You are now available for hire!'); window.location.href='index.php?url=farmer_dashboard';</script>";
            header("Location: index.php?url=farmer_dashboard&msg=farmer_dasboard");
        }
    }
}

public function addInstrument() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $data = [
            'name' => $_POST['name'],
            'category' => $_POST['category'],
            'rental_price' => $_POST['rental_price'],
            'selling_price' => $_POST['selling_price'],
            'description' => $_POST['description']
        ];
        
        if ($this->userModel->addInstrument($data)) {
            echo "<script> window.location.href='index.php?url=company_dashboard';</script>";
        }
    }
}

public function editInstrument() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SESSION['user_role'] == 'company') {
        $data = [
            'id' => $_POST['id'],
            'name' => $_POST['name'],
            'category' => $_POST['category'],
            'rental_price' => $_POST['rental_price'],
            'selling_price' => $_POST['selling_price'],
            'description' => $_POST['description']
        ];
        if ($this->userModel->updateInstrument($data)) {
            // echo "<script>alert('Updated successfully!'); window.location.href='index.php?url=company_dashboard';</script>";
            header('location: index.php?url=company_dashboard');
        }
    }
}

public function deleteInstrument() {
    if (isset($_GET['id']) && $_SESSION['user_role'] == 'company') {
        if ($this->userModel->deleteInstrument($_GET['id'], $_SESSION['user_id'])) {
            // echo "<script>alert('Deleted successfully!'); window.location.href='index.php?url=company_dashboard';</script>";
            header('location: index.php?url=company_dashboard');
        }
    }
}

public function completeOrder() {
    if (isset($_GET['id']) && isset($_GET['type']) && $_SESSION['user_role'] == 'company') {
        require_once '../app/models/UserModel.php';
        $userModel = new UserModel();
        
        if ($userModel->markOrderAsDone($_GET['id'], $_GET['type'])) {
            header('location: index.php?url=company_dashboard&msg=completed');
        }
    }
}

public function updateLandownerProfile() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SESSION['user_role'] == 'landowner') {
        $id = $_SESSION['user_id'];
        $data = [
            'full_name' => htmlspecialchars($_POST['full_name']),
            'email'     => filter_var($_POST['email'], FILTER_SANITIZE_EMAIL),
            'district'  => htmlspecialchars($_POST['district']),
            'phone'     => htmlspecialchars($_POST['phone'])
        ];

        if ($this->userModel->updateLandownerProfile($id, $data)) {
            // Update successful hole session-er data-o update kore dei
            $_SESSION['user_name'] = $data['full_name'];
            $_SESSION['user_district'] = $data['district'];
            $_SESSION['user_phone'] = $data['phone'];

            // echo "<script>alert('Profile Updated Successfully!'); window.location.href='index.php?url=landowner_dashboard';</script>";
            header("Location: index.php?url=landowner_dashboard");

        } else {
            echo "<script>alert('Failed to update profile!'); window.location.href='index.php?url=landowner_dashboard';</script>";
        }
    }
}
// Profile Edit Page Load kora
public function editFarmerProfile() {
    $userId = $_SESSION['user_id'];
    
    // Task 1: Fetching data from both tables
    $user = $this->userModel->getUserById($userId); 
    $farmer = $this->userModel->getFarmerData($userId); 

    // View file load kora (Project structure onujayi path check korun)
    require_once '../app/views/farmer/edit_farmer_profile.php';
}

// Update Process kora (Task 2)
public function processFarmerUpdate() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $userId = $_SESSION['user_id'];
        $data = [
            'full_name'  => $_POST['full_name'],
            'email'      => $_POST['email'],
            'district'   => $_POST['district'],
            'phone'      => $_POST['phone'],
            'skills'     => $_POST['skills'],
            'experience' => $_POST['experience'],
            'wage'       => $_POST['wage']
        ];

        $update = $this->userModel->updateFarmerProfile($userId, $data);

        if ($update) {
            // Success hole popuper jonno status pathano
            header("Location: index.php?url=edit_farmer_profile&status=success");
        } else {
            echo "Something went wrong!";
        }
    }
}

public function adminDashboard() {
    // Shudhu admin jate access pay sheta check kora
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
        header('Location: index.php?url=login');
        exit();
    }

    // Model theke data niye asha
    $landowners = $this->userModel->getAllLandowners();
    $farmers = $this->userModel->getAllFarmersWithProfiles();
    $companies = $this->userModel->getAllCompanies();
    $admins = $this->userModel->getAllAdmins();
    $allUsers = $this->userModel->getAllUsers();

    // View load kora (File path thik thakle dashboard show korbe)
    require_once '../app/views/admin/dashboard.php';
}

public function addUser() {
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
        header('Location: index.php?url=login');
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: index.php?url=admin_dashboard');
        exit();
    }

    $role = trim($_POST['role'] ?? '');
    $allowedRoles = ['admin', 'landowner', 'farmer', 'company'];

    if (!in_array($role, $allowedRoles, true)) {
        header('Location: index.php?url=admin_dashboard&status=invalid_role');
        exit();
    }

    $data = [
        'full_name' => trim($_POST['full_name'] ?? ''),
        'email' => filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL),
        'password' => trim($_POST['password'] ?? ''),
        'role' => $role,
        'district' => trim($_POST['district'] ?? ''),
        'phone' => trim($_POST['phone'] ?? '')
    ];

    if ($data['full_name'] === '' || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)
        || $data['password'] === '' || $data['district'] === '') {
        header('Location: index.php?url=admin_dashboard&status=invalid_input');
        exit();
    }

    if ($this->userModel->findUserByEmail($data['email'])) {
        header('Location: index.php?url=admin_dashboard&status=email_exists');
        exit();
    }

    if ($this->userModel->createUserByAdmin($data)) {
        header('Location: index.php?url=admin_dashboard&status=added');
    } else {
        header('Location: index.php?url=admin_dashboard&status=error');
    }
    exit();
}

public function deleteUser() {
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
        header('Location: index.php?url=login');
        exit();
    }

    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    // An admin can delete any other user/admin, but never the currently
    // logged-in account. This prevents accidental self-deletion/logout.
    if ($id <= 0 || $id === (int)($_SESSION['user_id'] ?? 0)) {
        header("Location: index.php?url=admin_dashboard&status=cannot_delete_self");
        exit();
    }

    if ($this->userModel->deleteUser($id)) {
        header("Location: index.php?url=admin_dashboard&status=deleted");
    } else {
        header("Location: index.php?url=admin_dashboard&status=error");
    }
    exit();
}


    public function toggleUserStatus() {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: index.php?url=login');
            exit();
        }

        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $status = isset($_GET['status']) && $_GET['status'] === 'inactive' ? 'inactive' : 'active';

        if ($id > 0 && $this->userModel->updateUserStatus($id, $status)) {
            header("Location: index.php?url=admin_dashboard&status=success");
        } else {
            header("Location: index.php?url=admin_dashboard&status=error");
        }
        exit();
    }


    // --- LOGOUT LOGIC ---
    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_role']);
        unset($_SESSION['user_district']);
        session_destroy();
        header('location: index.php?url=login');
    }
}
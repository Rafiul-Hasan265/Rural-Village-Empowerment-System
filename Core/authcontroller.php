<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class AuthController
{
   
    // REGISTER
   
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $data = [
                'full_name' => htmlspecialchars(trim($_POST['full_name'] ?? '')),
                'email'     => filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL),
                'password'  => trim($_POST['password'] ?? ''),
                'role'      => $_POST['role'] ?? '',
                'district'  => htmlspecialchars(trim($_POST['district'] ?? '')),
                'phone'     => htmlspecialchars(trim($_POST['phone'] ?? ''))
            ];

            if (!in_array($data['role'], ['landowner', 'farmer', 'company'], true)) {
                header("Location: index.php?url=register&error=invalid_role");
                exit();
            }

            if (
                empty($data['email']) ||
                empty($data['password']) ||
                empty($data['full_name']) ||
                empty($data['phone'])
            ) {
                header("Location: index.php?url=register&error=empty");
                exit();
            }

            // Simple session storage
            if (!isset($_SESSION['users'])) {
                $_SESSION['users'] = [];
            }

            // Check email
            foreach ($_SESSION['users'] as $user) {
                if ($user['email'] === $data['email']) {
                    $_SESSION['reg_error_email'] = "This email is already registered.";
                    header("Location: index.php?url=register");
                    exit();
                }
            }

            $data['id'] = count($_SESSION['users']) + 1;

            $_SESSION['users'][] = $data;

            $_SESSION['reg_success'] = true;

            header("Location: index.php?url=register");
            exit();
        }
    }


   
    // LOGIN
   
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $email = filter_var(
                trim($_POST['email'] ?? ''),
                FILTER_SANITIZE_EMAIL
            );

            $password = trim($_POST['password'] ?? '');

            // Default demo admin
            $users = $_SESSION['users'] ?? [];

            $users[] = [
                'id'       => 1,
                'full_name'=> 'Admin',
                'email'    => 'admin@gmail.com',
                'password' => '123456',
                'role'     => 'admin',
                'district' => 'Dhaka',
                'phone'    => '00000000000'
            ];

            $loggedInUser = null;

            foreach ($users as $user) {
                if (
                    $user['email'] === $email &&
                    $user['password'] === $password
                ) {
                    $loggedInUser = $user;
                    break;
                }
            }

            if ($loggedInUser) {

                $_SESSION['user_id']       = $loggedInUser['id'];
                $_SESSION['user_name']     = $loggedInUser['full_name'];
                $_SESSION['user_role']     = $loggedInUser['role'];
                $_SESSION['user_district'] = $loggedInUser['district'];
                $_SESSION['user_phone']    = $loggedInUser['phone'];
                $_SESSION['user_email']    = $loggedInUser['email'];

                switch ($loggedInUser['role']) {

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

                echo "<script>
                    alert('Invalid Email or Password!');
                    window.location.href='index.php?url=login';
                </script>";

                exit();
            }
        }
    }


   
    // FORGOT PASSWORD
   
    public function forgotPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $email = filter_var(
                trim($_POST['email'] ?? ''),
                FILTER_SANITIZE_EMAIL
            );

            $_SESSION['reset_email'] = $email;

            $token = bin2hex(random_bytes(25));

            $_SESSION['reset_token'] = $token;

            echo "<script>
                alert('Reset link created successfully.');
                window.location.href='index.php?url=reset_password&token=$token';
            </script>";

            exit();
        }
    }


   
    // RESET PASSWORD
   
    public function resetPassword()
    {
        $token = $_GET['token'] ?? '';

        if (
            !isset($_SESSION['reset_token']) ||
            $_SESSION['reset_token'] !== $token
        ) {
            die("This reset link is invalid or expired.");
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $newPass = $_POST['password'] ?? '';
            $confirmPass = $_POST['confirm_password'] ?? '';

            if ($newPass === $confirmPass) {

                $_SESSION['new_password'] = $newPass;

                unset($_SESSION['reset_token']);

                echo "<script>
                    alert('Password updated!');
                    window.location.href='index.php?url=login';
                </script>";

                exit();

            } else {

                echo "<script>
                    alert('Passwords do not match.');
                </script>";
            }
        }

        require_once '../app/views/auth/reset_password.php';
    }


   
    // HIRE FARMER
   
    public function hireFarmer()
    {
        if (
            isset($_GET['farmer_id']) &&
            isset($_SESSION['user_id'])
        ) {

            $_SESSION['hire_requests'][] = [
                'landowner_id' => $_SESSION['user_id'],
                'farmer_id'    => $_GET['farmer_id'],
                'status'       => 'pending'
            ];

            header("Location: index.php?url=landowner_dashboard");
            exit();
        }
    }


   
    // HANDLE HIRE REQUEST
   
    public function handleHireRequest()
    {
        if (
            isset($_GET['request_id']) &&
            isset($_GET['action'])
        ) {

            $requestId = (int)$_GET['request_id'];
            $action = $_GET['action'];

            if (isset($_SESSION['hire_requests'][$requestId])) {

                $_SESSION['hire_requests'][$requestId]['status'] = $action;

                if ($action == 'accepted') {
                    $_SESSION['farmer_status'] = 'busy';
                }
            }

            header("Location: index.php?url=farmer_dashboard");
            exit();
        }

        header('location: index.php?url=farmer_dashboard');
        exit();
    }


   
    // UPDATE FARMER PROFILE
   
    public function updateFarmerProfile()
    {
        if (
            $_SERVER['REQUEST_METHOD'] == 'POST' &&
            isset($_SESSION['user_role']) &&
            $_SESSION['user_role'] == 'farmer'
        ) {

            $_SESSION['farmer_profile'] = [
                'skills'     => $_POST['skills'] ?? '',
                'experience' => $_POST['experience'] ?? '',
                'wage'       => $_POST['wage'] ?? ''
            ];

            header("Location: index.php?url=farmer_dashboard&msg=farmer_dasboard");
            exit();
        }
    }


   
    // SET AVAILABLE
   
    public function setAvailable()
    {
        if (
            isset($_SESSION['user_id']) &&
            $_SESSION['user_role'] == 'farmer'
        ) {

            $_SESSION['farmer_status'] = 'available';

            header("Location: index.php?url=farmer_dashboard&msg=farmer_dasboard");
            exit();
        }
    }


   
    // ADD INSTRUMENT
   
    public function addInstrument()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (!isset($_SESSION['instruments'])) {
                $_SESSION['instruments'] = [];
            }

            $id = count($_SESSION['instruments']) + 1;

            $_SESSION['instruments'][$id] = [
                'id'            => $id,
                'name'          => $_POST['name'] ?? '',
                'category'      => $_POST['category'] ?? '',
                'rental_price'  => $_POST['rental_price'] ?? '',
                'selling_price' => $_POST['selling_price'] ?? '',
                'description'   => $_POST['description'] ?? ''
            ];

            header('location: index.php?url=company_dashboard');
            exit();
        }
    }


   
    // EDIT INSTRUMENT
   
    public function editInstrument()
    {
        if (
            $_SERVER['REQUEST_METHOD'] == 'POST' &&
            ($_SESSION['user_role'] ?? '') == 'company'
        ) {

            $id = $_POST['id'] ?? 0;

            if (isset($_SESSION['instruments'][$id])) {

                $_SESSION['instruments'][$id] = [
                    'id'            => $id,
                    'name'          => $_POST['name'] ?? '',
                    'category'      => $_POST['category'] ?? '',
                    'rental_price'  => $_POST['rental_price'] ?? '',
                    'selling_price' => $_POST['selling_price'] ?? '',
                    'description'   => $_POST['description'] ?? ''
                ];
            }

            header('location: index.php?url=company_dashboard');
            exit();
        }
    }


   
    // DELETE INSTRUMENT
   
    public function deleteInstrument()
    {
        if (
            isset($_GET['id']) &&
            ($_SESSION['user_role'] ?? '') == 'company'
        ) {

            $id = $_GET['id'];

            unset($_SESSION['instruments'][$id]);

            header('location: index.php?url=company_dashboard');
            exit();
        }
    }


   
    // COMPLETE ORDER
   
    public function completeOrder()
    {
        if (
            isset($_GET['id']) &&
            isset($_GET['type']) &&
            ($_SESSION['user_role'] ?? '') == 'company'
        ) {

            $_SESSION['completed_orders'][$_GET['id']] = [
                'type' => $_GET['type'],
                'status' => 'completed'
            ];

            header('location: index.php?url=company_dashboard&msg=completed');
            exit();
        }
    }


   
    // UPDATE LANDOWNER PROFILE
   
    public function updateLandownerProfile()
    {
        if (
            $_SERVER['REQUEST_METHOD'] == 'POST' &&
            ($_SESSION['user_role'] ?? '') == 'landowner'
        ) {

            $data = [
                'full_name' => htmlspecialchars($_POST['full_name'] ?? ''),
                'email'     => filter_var(
                    $_POST['email'] ?? '',
                    FILTER_SANITIZE_EMAIL
                ),
                'district'  => htmlspecialchars($_POST['district'] ?? ''),
                'phone'     => htmlspecialchars($_POST['phone'] ?? '')
            ];

            $_SESSION['user_name'] = $data['full_name'];
            $_SESSION['user_email'] = $data['email'];
            $_SESSION['user_district'] = $data['district'];
            $_SESSION['user_phone'] = $data['phone'];

            header("Location: index.php?url=landowner_dashboard");
            exit();
        }
    }


   
    // EDIT FARMER PROFILE
   
    public function editFarmerProfile()
    {
        $user = [
            'full_name' => $_SESSION['user_name'] ?? '',
            'email'     => $_SESSION['user_email'] ?? '',
            'district'  => $_SESSION['user_district'] ?? '',
            'phone'     => $_SESSION['user_phone'] ?? ''
        ];

        $farmer = $_SESSION['farmer_profile'] ?? [
            'skills' => '',
            'experience' => '',
            'wage' => ''
        ];

        require_once '../app/views/farmer/edit_farmer_profile.php';
    }


   
    // PROCESS FARMER UPDATE
   
    public function processFarmerUpdate()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $_SESSION['user_name'] = $_POST['full_name'] ?? '';
            $_SESSION['user_email'] = $_POST['email'] ?? '';
            $_SESSION['user_district'] = $_POST['district'] ?? '';
            $_SESSION['user_phone'] = $_POST['phone'] ?? '';

            $_SESSION['farmer_profile'] = [
                'skills'     => $_POST['skills'] ?? '',
                'experience' => $_POST['experience'] ?? '',
                'wage'       => $_POST['wage'] ?? ''
            ];

            header("Location: index.php?url=edit_farmer_profile&status=success");
            exit();
        }
    }


   
    // ADMIN DASHBOARD
   
    public function adminDashboard()
    {
        if (
            !isset($_SESSION['user_role']) ||
            $_SESSION['user_role'] !== 'admin'
        ) {

            header('Location: index.php?url=login');
            exit();
        }

        $allUsers = $_SESSION['users'] ?? [];

        $landowners = [];
        $farmers = [];
        $companies = [];
        $admins = [];

        foreach ($allUsers as $user) {

            switch ($user['role']) {

                case 'landowner':
                    $landowners[] = $user;
                    break;

                case 'farmer':
                    $farmers[] = $user;
                    break;

                case 'company':
                    $companies[] = $user;
                    break;

                case 'admin':
                    $admins[] = $user;
                    break;
            }
        }

        require_once '../app/views/admin/dashboard.php';
    }


   
    // ADD USER BY ADMIN
   
    public function addUser()
    {
        if (
            !isset($_SESSION['user_role']) ||
            $_SESSION['user_role'] !== 'admin'
        ) {

            header('Location: index.php?url=login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

            header('Location: index.php?url=admin_dashboard');
            exit();
        }

        $role = trim($_POST['role'] ?? '');

        $allowedRoles = [
            'admin',
            'landowner',
            'farmer',
            'company'
        ];

        if (!in_array($role, $allowedRoles, true)) {

            header(
                'Location: index.php?url=admin_dashboard&status=invalid_role'
            );

            exit();
        }

        $data = [
            'id'        => count($_SESSION['users'] ?? []) + 1,
            'full_name' => trim($_POST['full_name'] ?? ''),
            'email'     => filter_var(
                trim($_POST['email'] ?? ''),
                FILTER_SANITIZE_EMAIL
            ),
            'password'  => trim($_POST['password'] ?? ''),
            'role'      => $role,
            'district'  => trim($_POST['district'] ?? ''),
            'phone'     => trim($_POST['phone'] ?? '')
        ];

        if (
            $data['full_name'] === '' ||
            !filter_var($data['email'], FILTER_VALIDATE_EMAIL) ||
            $data['password'] === '' ||
            $data['district'] === ''
        ) {

            header(
                'Location: index.php?url=admin_dashboard&status=invalid_input'
            );

            exit();
        }

        if (!isset($_SESSION['users'])) {
            $_SESSION['users'] = [];
        }

        foreach ($_SESSION['users'] as $user) {

            if ($user['email'] === $data['email']) {

                header(
                    'Location: index.php?url=admin_dashboard&status=email_exists'
                );

                exit();
            }
        }

        $_SESSION['users'][] = $data;

        header(
            'Location: index.php?url=admin_dashboard&status=added'
        );

        exit();
    }


   
    // DELETE USER
   
    public function deleteUser()
    {
        if (
            !isset($_SESSION['user_role']) ||
            $_SESSION['user_role'] !== 'admin'
        ) {

            header('Location: index.php?url=login');
            exit();
        }

        $id = isset($_GET['id'])
            ? (int)$_GET['id']
            : 0;

        if (
            $id <= 0 ||
            $id === (int)($_SESSION['user_id'] ?? 0)
        ) {

            header(
                "Location: index.php?url=admin_dashboard&status=cannot_delete_self"
            );

            exit();
        }

        if (isset($_SESSION['users'])) {

            foreach ($_SESSION['users'] as $key => $user) {

                if ((int)$user['id'] === $id) {

                    unset($_SESSION['users'][$key]);

                    $_SESSION['users'] = array_values(
                        $_SESSION['users']
                    );

                    header(
                        "Location: index.php?url=admin_dashboard&status=deleted"
                    );

                    exit();
                }
            }
        }

        header(
            "Location: index.php?url=admin_dashboard&status=error"
        );

        exit();
    }


   
    // TOGGLE USER STATUS
   
    public function toggleUserStatus()
    {
        if (
            !isset($_SESSION['user_role']) ||
            $_SESSION['user_role'] !== 'admin'
        ) {

            header('Location: index.php?url=login');
            exit();
        }

        $id = isset($_GET['id'])
            ? (int)$_GET['id']
            : 0;

        $status =
            isset($_GET['status']) &&
            $_GET['status'] === 'inactive'
                ? 'inactive'
                : 'active';

        if (isset($_SESSION['users'])) {

            foreach ($_SESSION['users'] as $key => $user) {

                if ((int)$user['id'] === $id) {

                    $_SESSION['users'][$key]['status'] = $status;

                    header(
                        "Location: index.php?url=admin_dashboard&status=success"
                    );

                    exit();
                }
            }
        }

        header(
            "Location: index.php?url=admin_dashboard&status=error"
        );

        exit();
    }


   
    // LOGOUT
   
    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_role']);
        unset($_SESSION['user_district']);
        unset($_SESSION['user_phone']);
        unset($_SESSION['user_email']);

        session_destroy();

        header('location: index.php?url=login');
        exit();
    }
}
?>
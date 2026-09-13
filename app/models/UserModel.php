<?php
require_once '../app/core/Database.php';

class UserModel {
    private $db;

    public function __construct() {
        try {
            $database = new Database();
            $this->db = $database->getConnection();
        } catch (RuntimeException $e) {
            die('<h2>Database is not available</h2><p>' . htmlspecialchars($e->getMessage()) . '</p>');
        }
    }

    // Email check korar jonno (Registration o Login duitar jonnoi lage)
    public function findUserByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // User Register korar logic
    public function register($data) {
        $query = "INSERT INTO users (full_name, email, password, role, district,phone) VALUES (:name, :email, :password, :role, :district,:phone)";
        $stmt = $this->db->prepare($query);

        // Password hash kora (Security-r jonno)
        $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);

        // Bind values
        $stmt->bindParam(':name', $data['full_name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':role', $data['role']);
        $stmt->bindParam(':district', $data['district']);
        $stmt->bindParam(':phone', $data['phone']);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // --- LOGIN LOGIC ---
    public function login($email, $password) {
        // Agey check kori ei email-e kono user ache kina
        $user = $this->findUserByEmail($email);

        if ($user && (!isset($user['status']) || $user['status'] === 'active')) {
            // Password match korche kina check kora (Hash comparison)
            // Note: password_verify function-ti automatically hashed password-er sathe check kore
            if (password_verify($password, $user['password'])) {
                return $user; // Password thik thakle pura user data return korbe
            }
        }
        
        return false; // User na thakle ba password vul hole false jabe
    }
    //Forget Password 
    // 1. Store the reset token for a specific email
    public function setResetToken($email, $token) {
    $query = "UPDATE users SET reset_token = :token WHERE email = :email";
    $stmt = $this->db->prepare($query);
    return $stmt->execute(['token' => $token, 'email' => $email]);
    }

    public function findUserByToken($token) {
        $query = "SELECT * FROM users WHERE reset_token = :token";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['token' => $token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 3. Update the password and clear the token
    public function updatePassword($userId, $newPassword) {
        $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);
        $query = "UPDATE users SET password = :password, reset_token = NULL WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute(['password' => $hashed_password, 'id' => $userId]);
    }

    // app/models/UserModel.php file-e jan

// Shudhu eituku rakhun, purono version-ti delete kore din
public function getFarmersByDistrict($district) {
    $query = "SELECT u.id, u.full_name, u.email, u.district, u.availability_status, 
                     p.skills, p.experience_years, p.daily_wage 
              FROM users u
              LEFT JOIN farmer_profiles p ON u.id = p.user_id 
              WHERE u.role = 'farmer' AND u.district = :district
              AND u.availability_status = 'available'";
    
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':district', $district);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getAllInstruments() {
    // JOIN use kore instruments table er sathe users table connect kora hoyeche
    $query = "SELECT i.*, u.full_name as company_name 
              FROM instruments i 
              JOIN users u ON i.company_id = u.id 
              WHERE i.availability = 'available' 
              ORDER BY i.created_at DESC";
              
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// app/models/UserModel.php

// Company-r nijer post kora instruments fetch kora
public function getInstrumentsByCompany($company_id) {
    $query = "SELECT * FROM instruments WHERE company_id = :c_id ORDER BY created_at DESC";
    $stmt = $this->db->prepare($query);
    $stmt->execute(['c_id' => $company_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Notun instrument add kora
public function addInstrument($data) {
    $query = "INSERT INTO instruments (company_id, name, category, rental_price, selling_price, description, availability) 
              VALUES (:c_id, :name, :cat, :r_price, :s_price, :desc, 'available')";
    
    $stmt = $this->db->prepare($query);
    return $stmt->execute([
        'c_id' => $_SESSION['user_id'],
        'name' => $data['name'],
        'cat' => $data['category'],
        'r_price' => $data['rental_price'],
        's_price' => $data['selling_price'],
        'desc' => $data['description']
    ]);
}

public function sendHireRequest($landowner_id, $farmer_id) {
    // Prothome check kori agey theke 'pending' kono request ache kina
    $checkQuery = "SELECT * FROM hire_requests WHERE landowner_id = :l_id AND farmer_id = :f_id AND status = 'pending'";
    $checkStmt = $this->db->prepare($checkQuery);
    $checkStmt->bindParam(':l_id', $landowner_id);
    $checkStmt->bindParam(':f_id', $farmer_id);
    $checkStmt->execute();

    if ($checkStmt->rowCount() > 0) {
        return "exists"; // Jodi agey theke request thake
    }

    // Jodi na thake, tobe insert hobe
    $query = "INSERT INTO hire_requests (landowner_id, farmer_id) VALUES (:l_id, :f_id)";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':l_id', $landowner_id);
    $stmt->bindParam(':f_id', $farmer_id);
    
    return $stmt->execute();
}

// Farmer-er kache asha requests gulo dekhano
public function getHireRequestsForFarmer($farmer_id) {
    // Task 3: JOIN query-te users.phone add kora hoyeche jate landowner-er phone number pawa jay
    $query = "SELECT hire_requests.*, users.full_name as landowner_name, users.phone as landowner_phone, users.district 
              FROM hire_requests 
              JOIN users ON hire_requests.landowner_id = users.id 
              WHERE hire_requests.farmer_id = :farmer_id 
              ORDER BY request_date DESC";

    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':farmer_id', $farmer_id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Request Accept ba Reject korar logic
public function updateHireStatus($request_id, $status) {
    $query = "UPDATE hire_requests SET status = :status WHERE id = :id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':id', $request_id);
    return $stmt->execute();
}

// Landowner-er pathano request-er list dekhar jonno
public function getMySentRequests($landowner_id) {
    $query = "SELECT hire_requests.*, users.full_name as farmer_name, users.district 
              FROM hire_requests 
              JOIN users ON hire_requests.farmer_id = users.id 
              WHERE hire_requests.landowner_id = :l_id 
              ORDER BY request_date DESC";
              
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':l_id', $landowner_id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// 1. Farmer List fetching with Profile Info


// 2. Farmer Profile Update logic
// AuthController.php file-er bhetore thakbe
// Farmer Profile table-e data Insert ba Update korbe
public function updateOrCreateProfile($data) {
    // Prothome check kori ai farmer-er profile age theke ache kina
    $check = $this->db->prepare("SELECT id FROM farmer_profiles WHERE user_id = :u_id");
    $check->execute(['u_id' => $_SESSION['user_id']]);
    
    if ($check->rowCount() > 0) {
        // Jodi profile thake, tahole UPDATE korbe
        $query = "UPDATE farmer_profiles SET skills = :skills, experience_years = :exp, daily_wage = :wage WHERE user_id = :u_id";
    } else {
        // Jodi profile na thake, tahole INSERT korbe
        $query = "INSERT INTO farmer_profiles (user_id, skills, experience_years, daily_wage) VALUES (:u_id, :skills, :exp, :wage)";
    }
    
    $stmt = $this->db->prepare($query);
    return $stmt->execute([
        'u_id' => $_SESSION['user_id'],
        'skills' => $data['skills'],
        'exp' => $data['experience'],
        'wage' => $data['wage']
    ]);
}

// 3. Status 'Busy' kora
public function updateAvailability($user_id, $status) {
    $query = "UPDATE users SET availability_status = :status WHERE id = :id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':id', $user_id);
    return $stmt->execute();
}

public function makeAvailable($user_id) {
    $query = "UPDATE users SET availability_status = 'available' WHERE id = :id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':id', $user_id);
    return $stmt->execute();
}

// User-er ID diye tar shob details fetch korar function
public function getUserById($id) {
    // Ekhane users table r farmer_profiles table join kora hoyeche
    $query = "SELECT u.*, p.skills, p.experience_years, p.daily_wage 
              FROM users u
              LEFT JOIN farmer_profiles p ON u.id = p.user_id 
              WHERE u.id = :id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Instrument-er details update kora
public function updateInstrument($data) {
    $query = "UPDATE instruments SET name = :name, category = :cat, rental_price = :r_price, 
              selling_price = :s_price, description = :desc WHERE id = :id AND company_id = :c_id";
    $stmt = $this->db->prepare($query);
    return $stmt->execute([
        'id' => $data['id'],
        'c_id' => $_SESSION['user_id'],
        'name' => $data['name'],
        'cat' => $data['category'],
        'r_price' => $data['rental_price'],
        's_price' => $data['selling_price'],
        'desc' => $data['description']
    ]);
}

// Instrument delete kora
// Instrument delete kora (With Foreign Key Handling)
public function deleteInstrument($id, $company_id) {
    try {
        $this->db->beginTransaction();

        
        $stmt1 = $this->db->prepare("DELETE FROM instrument_purchases WHERE instrument_id = :id");
        $stmt1->execute(['id' => $id]);

        
        $stmt2 = $this->db->prepare("DELETE FROM rental_requests WHERE instrument_id = :id");
        $stmt2->execute(['id' => $id]);

        
        $query = "DELETE FROM instruments WHERE id = :id AND company_id = :c_id";
        $stmt3 = $this->db->prepare($query);
        $result = $stmt3->execute(['id' => $id, 'c_id' => $company_id]);

        $this->db->commit();
        return $result;
    } catch (Exception $e) {
        $this->db->rollBack();
        
        return false;
    }
}

public function getCartDetails($ids) {
    if(empty($ids)) return [];
    
    $idList = implode(',', array_map('intval', $ids));
    $query = "SELECT i.*, u.full_name as company_name 
              FROM instruments i 
              JOIN users u ON i.company_id = u.id 
              WHERE i.id IN ($idList)";
    
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Single instrument details ana
// Single instrument fetch kora details-er jonno
public function getInstrumentById($id) {
    $query = "SELECT i.*, u.full_name as company_name 
              FROM instruments i 
              JOIN users u ON i.company_id = u.id 
              WHERE i.id = :id";
    $stmt = $this->db->prepare($query);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// index.php er $userModel->getCompanyPurchases call-er jonno
// UserModel.php er Line 330 er dike buyInstrument function-ti eibhabe update korun:
public function buyInstrument($inst_id, $user_id, $price, $quantity) {
    // Eikhane ami 'landowner_id' bebohar korchi, karon error bolche 'user_id' nai. 
    // Apnar table-e jodi 'buyer_id' thake, tahole landowner_id er jaygay sheta likhun.
    $sql = "INSERT INTO instrument_purchases (instrument_id, landowner_id, purchase_price, quantity, status) 
            VALUES (?, ?, ?, ?, 'pending')";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([$inst_id, $user_id, $price, $quantity]);
}

// Rental request er jonno ek-i bhabe:
public function saveRentalRequest($inst_id, $user_id, $date, $quantity) {
    $sql = "INSERT INTO rental_requests (instrument_id, landowner_id, rental_date, quantity, status) 
            VALUES (?, ?, ?, ?, 'pending')";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([$inst_id, $user_id, $date, $quantity]);
}

// Company Dashboard er data fetch korar somoy JOIN query-tao update korte hobe
// index.php er $userModel->getCompanyPurchases call-er jonno
public function getCompanyPurchases($company_id) {
    // u.district add kora hoyeche ekhane
    $sql = "SELECT p.*, i.name as instrument_name, u.full_name as customer_name, u.phone, u.district 
            FROM instrument_purchases p 
            JOIN instruments i ON p.instrument_id = i.id 
            JOIN users u ON p.landowner_id = u.id 
            WHERE i.company_id = ? AND p.status = 'pending'";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$company_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// index.php er $userModel->getCompanyRentals call-er jonno
public function getCompanyRentals($company_id) {
    // u.district add kora hoyeche ekhane
    $sql = "SELECT r.*, i.name as instrument_name, i.rental_price, u.full_name as customer_name, u.phone, u.district 
            FROM rental_requests r 
            JOIN instruments i ON r.instrument_id = i.id 
            JOIN users u ON r.landowner_id = u.id 
            WHERE i.company_id = ? AND r.status = 'pending'";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$company_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// Order status 'completed' kora
public function markOrderAsDone($id, $type) {
    // Buy hole instrument_purchases, Rent hole rental_requests
    $table = ($type == 'buy') ? 'instrument_purchases' : 'rental_requests';
    
    $query = "UPDATE $table SET status = 'completed' WHERE id = :id";
    $stmt = $this->db->prepare($query);
    return $stmt->execute(['id' => $id]);
}


public function getCurrentlyWorkingFarmers($landowner_id) {
    // Shudhu check korbo accepted requests gulo
    $query = "SELECT farmer_id FROM hire_requests WHERE landowner_id = :l_id AND status = 'accepted'";
    $stmt = $this->db->prepare($query);
    $stmt->execute(['l_id' => $landowner_id]);
    $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($requests)) {
        return [];
    }

    // Farmer ID gulo niye ekta list banai
    $farmerIds = array_column($requests, 'farmer_id');
    $placeholders = implode(',', array_fill(0, count($farmerIds), '?'));

    // Ekhon oi farmer-der details niye ashi jara 'busy' status-e ache
    $query = "SELECT u.full_name, u.email, u.district, p.daily_wage 
              FROM users u 
              LEFT JOIN farmer_profiles p ON u.id = p.user_id 
              WHERE u.id IN ($placeholders) AND u.availability_status = 'busy'";
    
    $stmt = $this->db->prepare($query);
    $stmt->execute($farmerIds);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function getFarmerData($user_id) {
    // Farmers table theke user_id onujayi skills, experience o wage fetch kora
    $query = "SELECT * FROM farmer_profiles WHERE user_id = :user_id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function updateLandownerProfile($id, $data) {
    // ID change korar dorkar nai, shudhu baki info update hobe
    $query = "UPDATE users SET full_name = :name, email = :email, district = :district, phone = :phone WHERE id = :id";
    $stmt = $this->db->prepare($query);
    
    return $stmt->execute([
        'name'     => $data['full_name'],
        'email'    => $data['email'],
        'district' => $data['district'],
        'phone'    => $data['phone'],
        'id'       => $id
    ]);
}
// UserModel.php e ei function-ti add korun
public function updateFarmerProfile($userId, $data) {
    try {
        $this->db->beginTransaction();

        // 1. Users Table Update
        $stmt1 = $this->db->prepare("UPDATE users SET full_name = ?, email = ?, district = ?, phone = ? WHERE id = ?");
        $stmt1->execute([$data['full_name'], $data['email'], $data['district'], $data['phone'], $userId]);

        // 2. Farmers Table Update 
        // NOTE: SQL e column name database onujayi thakte hobe. 
        // Jodi 'experience_years' kaj na kore, tobe 'experience' likhe try korun.
        $stmt2 = $this->db->prepare("UPDATE farmer_profiles SET skills = ?, experience_years = ?, daily_wage = ? WHERE user_id = ?");
        
        $stmt2->execute([
            $data['skills'], 
            $data['experience'], 
            $data['wage'], 
            $userId
        ]);

        $this->db->commit();
        return true;
    } catch (PDOException $e) {
        if ($this->db->inTransaction()) {
            $this->db->rollBack();
        }
        // EI LINE TI TEMPORARY ERROR DEKHAR JONNO:
        die("DATABASE ERROR: " . $e->getMessage()); 
        return false;
    }
}

public function getAllLandowners() {
    $stmt = $this->db->prepare("SELECT * FROM users WHERE role = 'landowner'");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Farmer profiles ebong Users table join kore fetch kora
public function getAllFarmersWithProfiles() {
    // u.email nirdishto bhabe select kora hoyeche
    $query = "SELECT u.id, u.full_name, u.email, u.district, u.phone, 
                     fp.skills, fp.experience_years, fp.daily_wage 
              FROM users u 
              LEFT JOIN farmer_profiles fp ON u.id = fp.user_id 
              WHERE u.role = 'farmer'";
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Shob Company-der fetch kora
public function getAllCompanies() {
    $stmt = $this->db->prepare("SELECT * FROM users WHERE role = 'company'");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}




    // Admin management: fetch every admin account.
    public function getAllAdmins() {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE role = 'admin' ORDER BY id ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Admin management: fetch every account, including admins.
    public function getAllUsers() {
        $stmt = $this->db->prepare("SELECT id, full_name, email, role, district, phone, status, availability_status, created_at
                                   FROM users ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Admin can create an account of any supported role.
    public function createUserByAdmin($data) {
        try {
            $this->db->beginTransaction();

            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

            $stmt = $this->db->prepare(
                "INSERT INTO users
                 (full_name, email, password, role, district, phone, status, availability_status)
                 VALUES (:name, :email, :password, :role, :district, :phone, 'active', 'available')"
            );

            $stmt->execute([
                'name' => $data['full_name'],
                'email' => $data['email'],
                'password' => $hashedPassword,
                'role' => $data['role'],
                'district' => $data['district'],
                'phone' => $data['phone'] !== '' ? $data['phone'] : null
            ]);

            $userId = (int)$this->db->lastInsertId();

            // Give admin-created farmers an empty profile so they can
            // immediately appear in the farmer workflow.
            if ($data['role'] === 'farmer') {
                $profile = $this->db->prepare(
                    "INSERT INTO farmer_profiles (user_id, skills, experience_years, daily_wage)
                     VALUES (:user_id, '', 0, 0)"
                );
                $profile->execute(['user_id' => $userId]);
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            return false;
        }
    }

    // Admin: activate/deactivate a user without deleting their data
    public function updateUserStatus($id, $status) {
        $stmt = $this->db->prepare("UPDATE users SET status = :status WHERE id = :id AND role <> 'admin'");
        return $stmt->execute(['status' => $status, 'id' => (int)$id]);
    }

    public function getUserStatus($id) {
        $stmt = $this->db->prepare("SELECT status FROM users WHERE id = :id");
        $stmt->execute(['id' => (int)$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['status'] ?? null;
    }

public function deleteUser($id) {
    try {
        $this->db->beginTransaction();

        $id = (int)$id;

        // Related records are removed first where the schema does not
        // already provide cascading deletion.
        $this->db->prepare("DELETE FROM farmer_profiles WHERE user_id = :id")
                 ->execute(['id' => $id]);

        $this->db->prepare("DELETE FROM hire_requests WHERE farmer_id = :id OR landowner_id = :id")
                 ->execute(['id' => $id]);

        $this->db->prepare("DELETE FROM instrument_purchases WHERE landowner_id = :id")
                 ->execute(['id' => $id]);

        $this->db->prepare("DELETE FROM rental_requests WHERE landowner_id = :id")
                 ->execute(['id' => $id]);

        // Company instruments and their dependent orders are removed by
        // the foreign-key cascade when the company user is deleted.
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);

        $deleted = $stmt->rowCount() > 0;

        $this->db->commit();
        return $deleted;
    } catch (Exception $e) {
        if ($this->db->inTransaction()) {
            $this->db->rollBack();
        }
        return false;
    }
}


}
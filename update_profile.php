<?php
session_start();

// Initialize response array
$response = [
    'success' => false,
    'message' => 'Unknown error occurred'
];

// Check if user exists in session
if (!isset($_SESSION['user'])) {
    $response['message'] = 'User not found in session';
    echo json_encode($response);
    exit;
}

// Check if action is provided
if (!isset($_POST['action'])) {
    $response['message'] = 'No action specified';
    echo json_encode($response);
    exit;
}

// Handle different actions
$action = $_POST['action'];

if ($action === 'personal_info') {
    // Update personal information
    if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['phone'])) {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        
        // Basic validation
        if (empty($name) || empty($email) || empty($phone)) {
            $response['message'] = 'All fields are required';
            echo json_encode($response);
            exit;
        }
        
        // Email validation
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response['message'] = 'Invalid email format';
            echo json_encode($response);
            exit;
        }
        
        // Update user data in session
        $_SESSION['user']['name'] = $name;
        $_SESSION['user']['email'] = $email;
        $_SESSION['user']['phone'] = $phone;
        
        $response['success'] = true;
        $response['message'] = 'Personal information updated successfully';
    } else {
        $response['message'] = 'Missing required fields';
    }
} elseif ($action === 'security') {
    // Update password
    if (isset($_POST['current_password']) && isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        
        // Basic validation
        if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
            $response['message'] = 'All password fields are required';
            echo json_encode($response);
            exit;
        }
        
        // Check if current password matches
        if ($current_password !== $_SESSION['user']['password']) {
            $response['message'] = 'Current password is incorrect';
            echo json_encode($response);
            exit;
        }
        
        // Check if new passwords match
        if ($new_password !== $confirm_password) {
            $response['message'] = 'New password and confirmation do not match';
            echo json_encode($response);
            exit;
        }
        
        // Password strength validation (optional)
        if (strlen($new_password) < 8) {
            $response['message'] = 'New password must be at least 8 characters long';
            echo json_encode($response);
            exit;
        }
        
        // Update password in session
        $_SESSION['user']['password'] = $new_password;
        
        $response['success'] = true;
        $response['message'] = 'Password updated successfully';
    } else {
        $response['message'] = 'Missing required password fields';
    }
} else {
    $response['message'] = 'Invalid action';
}

// Return JSON response
echo json_encode($response);
?>


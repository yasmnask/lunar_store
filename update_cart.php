<?php
session_start();

// Initialize the cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Check if all required parameters are provided
if (isset($_POST['product_id']) && isset($_POST['action']) && isset($_POST['index'])) {
    $product_id = $_POST['product_id'];
    $action = $_POST['action'];
    $index = (int)$_POST['index'];
    
    // Check if the index exists in the cart
    if (isset($_SESSION['cart'][$index])) {
        // Update quantity based on action
        if ($action === 'increase') {
            $_SESSION['cart'][$index]['quantity']++;
            echo json_encode([
                'success' => true, 
                'message' => 'Quantity increased', 
                'quantity' => $_SESSION['cart'][$index]['quantity']
            ]);
        } elseif ($action === 'decrease') {
            if ($_SESSION['cart'][$index]['quantity'] > 1) {
                $_SESSION['cart'][$index]['quantity']--;
                echo json_encode([
                    'success' => true, 
                    'message' => 'Quantity decreased', 
                    'quantity' => $_SESSION['cart'][$index]['quantity']
                ]);
            } else {
                echo json_encode([
                    'success' => false, 
                    'message' => 'Quantity cannot be less than 1'
                ]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Item not found in cart']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Missing required parameters']);
}
?>


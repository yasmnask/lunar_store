<?php
session_start();

// Initialize the cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Check if index is provided
if (isset($_POST['index'])) {
    $index = (int)$_POST['index'];
    
    // Check if the index exists in the cart
    if (isset($_SESSION['cart'][$index])) {
        // Remove the item from the cart
        array_splice($_SESSION['cart'], $index, 1);
        
        // Return success response
        echo json_encode([
            'success' => true, 
            'message' => 'Item removed from cart', 
            'cart_count' => count($_SESSION['cart'])
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Item not found in cart']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No index provided']);
}
?>


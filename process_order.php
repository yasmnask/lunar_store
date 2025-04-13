<?php
// Only start session if one doesn't already exist
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Initialize orders array in session if it doesn't exist
if (!isset($_SESSION['orders'])) {
    $_SESSION['orders'] = [
        'completed' => [],
        'pending' => []
    ];
}

// Initialize all_orders array in session if it doesn't exist
if (!isset($_SESSION['all_orders'])) {
    $_SESSION['all_orders'] = [];
}

// Function to save order to session
function saveOrder($cart_items, $checkout_data, $order_number, $total_formatted) {
    $payment_method = $checkout_data['payment_method'];
    $order_timing = $checkout_data['user_inputs']['order_timing'];
    
    // Determine order status based on timing
    $status = $order_timing === 'now' ? 'Completed' : 'Pending';
    
    // Create order data structure
    $order = [
        'id' => $order_number,
        'date' => date('Y-m-d'),
        'total' => $total_formatted,
        'status' => $status,
        'payment_method' => $payment_method,
        'items' => []
    ];
    
    // Add items to order
    foreach ($cart_items as $item) {
        $order['items'][] = [
            'name' => $item['name'],
            'description' => $item['description'],
            'price' => $item['price'],
            'period' => isset($item['period']) ? $item['period'] : '',
            'quantity' => $item['quantity'],
            'image' => isset($item['image']) ? $item['image'] : 'https://via.placeholder.com/100x100'
        ];
    }
    
    // Add order to appropriate list based on status
    if ($status === 'Completed') {
        $_SESSION['orders']['completed'][] = $order;
    } else {
        $_SESSION['orders']['pending'][] = $order;
    }
    
    // Also add to all_orders for order details page
    $_SESSION['all_orders'][$order_number] = $order;
    
    return $order;
}

// Function to get all orders
function getAllOrders() {
    $all_orders = [];
    
    if (isset($_SESSION['orders']['completed'])) {
        foreach ($_SESSION['orders']['completed'] as $order) {
            $all_orders[] = $order;
        }
    }
    
    if (isset($_SESSION['orders']['pending'])) {
        foreach ($_SESSION['orders']['pending'] as $order) {
            $all_orders[] = $order;
        }
    }
    
    return $all_orders;
}

// Function to get completed orders
function getCompletedOrders() {
    return isset($_SESSION['orders']['completed']) ? $_SESSION['orders']['completed'] : [];
}

// Function to get pending orders
function getPendingOrders() {
    return isset($_SESSION['orders']['pending']) ? $_SESSION['orders']['pending'] : [];
}

// Function to get order by ID
function getOrderById($order_id) {
    return isset($_SESSION['all_orders'][$order_id]) ? $_SESSION['all_orders'][$order_id] : null;
}

// Function to update order status
function updateOrderStatus($order_id, $new_status) {
    if (!isset($_SESSION['all_orders'][$order_id])) {
        return false;
    }
    
    $order = $_SESSION['all_orders'][$order_id];
    $old_status = $order['status'];
    
    // Update status in all_orders
    $_SESSION['all_orders'][$order_id]['status'] = $new_status;
    
    // Move order between completed and pending arrays
    if ($old_status === 'Pending' && $new_status === 'Completed') {
        // Find and remove from pending
        foreach ($_SESSION['orders']['pending'] as $key => $pending_order) {
            if ($pending_order['id'] === $order_id) {
                unset($_SESSION['orders']['pending'][$key]);
                break;
            }
        }
        
        // Add to completed
        $_SESSION['orders']['completed'][] = $_SESSION['all_orders'][$order_id];
    } 
    else if ($old_status === 'Completed' && $new_status === 'Pending') {
        // Find and remove from completed
        foreach ($_SESSION['orders']['completed'] as $key => $completed_order) {
            if ($completed_order['id'] === $order_id) {
                unset($_SESSION['orders']['completed'][$key]);
                break;
            }
        }
        
        // Add to pending
        $_SESSION['orders']['pending'][] = $_SESSION['all_orders'][$order_id];
    }
    
    return true;
}
?>
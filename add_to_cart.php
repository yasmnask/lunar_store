<?php
session_start();

// Initialize the cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Check if product_id is provided
if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    
    // Sample product data (in a real application, this would come from a database)
    $all_products = [
        // Editing Apps
        101 => [
            'id' => 101,
            'name' => 'Adobe Lightroom Premium',
            'description' => 'Professional photo editing app',
            'price' => 'Rp 75.000',
            'period' => '1 Month',
            'image' => 'https://via.placeholder.com/300x200'
        ],
        102 => [
            'id' => 102,
            'name' => 'Adobe Photoshop Premium',
            'description' => 'Professional image editing software',
            'price' => 'Rp 99.000',
            'period' => '1 Month',
            'image' => 'https://via.placeholder.com/300x200'
        ],
        103 => [
            'id' => 103,
            'name' => 'Canva Pro',
            'description' => 'Design platform for social media & more',
            'price' => 'Rp 65.000',
            'period' => '1 Month',
            'image' => 'https://via.placeholder.com/300x200'
        ],
        104 => [
            'id' => 104,
            'name' => 'Filmora Pro',
            'description' => 'Video editing software',
            'price' => 'Rp 85.000',
            'period' => '1 Month',
            'image' => 'https://via.placeholder.com/300x200'
        ],
        105 => [
            'id' => 105,
            'name' => 'Snapseed Pro',
            'description' => 'Mobile photo editing app',
            'price' => 'Rp 45.000',
            'period' => '1 Month',
            'image' => 'https://via.placeholder.com/300x200'
        ],
        106 => [
            'id' => 106,
            'name' => 'VSCO Premium',
            'description' => 'Photo & video editing with presets',
            'price' => 'Rp 55.000',
            'period' => '1 Month',
            'image' => 'https://via.placeholder.com/300x200'
        ],
        
        // Mobile Legends
        201 => [
            'id' => 201,
            'name' => '86 Diamonds',
            'description' => 'Mobile Legends: Bang Bang',
            'price' => 'Rp 22.000',
            'image' => 'https://via.placeholder.com/300x200'
        ],
        202 => [
            'id' => 202,
            'name' => '172 Diamonds',
            'description' => 'Mobile Legends: Bang Bang',
            'price' => 'Rp 42.000',
            'image' => 'https://via.placeholder.com/300x200'
        ],
        203 => [
            'id' => 203,
            'name' => '257 Diamonds',
            'description' => 'Mobile Legends: Bang Bang',
            'price' => 'Rp 62.000',
            'image' => 'https://via.placeholder.com/300x200'
        ],
        204 => [
            'id' => 204,
            'name' => '344 Diamonds',
            'description' => 'Mobile Legends: Bang Bang',
            'price' => 'Rp 82.000',
            'image' => 'https://via.placeholder.com/300x200'
        ],
        205 => [
            'id' => 205,
            'name' => '429 Diamonds',
            'description' => 'Mobile Legends: Bang Bang',
            'price' => 'Rp 102.000',
            'image' => 'https://via.placeholder.com/300x200'
        ],
        206 => [
            'id' => 206,
            'name' => '514 Diamonds',
            'description' => 'Mobile Legends: Bang Bang',
            'price' => 'Rp 122.000',
            'image' => 'https://via.placeholder.com/300x200'
        ],
        207 => [
            'id' => 207,
            'name' => '706 Diamonds',
            'description' => 'Mobile Legends: Bang Bang',
            'price' => 'Rp 162.000',
            'image' => 'https://via.placeholder.com/300x200'
        ],
        208 => [
            'id' => 208,
            'name' => '878 Diamonds',
            'description' => 'Mobile Legends: Bang Bang',
            'price' => 'Rp 202.000',
            'image' => 'https://via.placeholder.com/300x200'
        ],
        209 => [
            'id' => 209,
            'name' => 'Starlight Member',
            'description' => 'Mobile Legends: Bang Bang',
            'price' => 'Rp 149.000',
            'period' => '1 Month',
            'image' => 'https://via.placeholder.com/300x200'
        ],
        210 => [
            'id' => 210,
            'name' => 'Starlight Member Plus',
            'description' => 'Mobile Legends: Bang Bang',
            'price' => 'Rp 290.000',
            'period' => '1 Month',
            'image' => 'https://via.placeholder.com/300x200'
        ],
        
        // Streaming Apps
        301 => [
            'id' => 301,
            'name' => 'Netflix Premium',
            'description' => 'Streaming service for movies & TV shows',
            'price' => 'Rp 120.000',
            'period' => '1 Month',
            'image' => 'https://via.placeholder.com/300x200'
        ],
        302 => [
            'id' => 302,
            'name' => 'Spotify Premium',
            'description' => 'Music streaming service',
            'price' => 'Rp 55.000',
            'period' => '1 Month',
            'image' => 'https://via.placeholder.com/300x200'
        ],
        303 => [
            'id' => 303,
            'name' => 'Disney+ Hotstar',
            'description' => 'Streaming service for Disney content',
            'price' => 'Rp 39.000',
            'period' => '1 Month',
            'image' => 'https://via.placeholder.com/300x200'
        ],
        
        // Productivity Apps
        401 => [
            'id' => 401,
            'name' => 'Microsoft 365',
            'description' => 'Office suite with Word, Excel, PowerPoint',
            'price' => 'Rp 149.000',
            'period' => '1 Month',
            'image' => 'https://via.placeholder.com/300x200'
        ],
        402 => [
            'id' => 402,
            'name' => 'Notion Premium',
            'description' => 'All-in-one workspace',
            'price' => 'Rp 85.000',
            'period' => '1 Month',
            'image' => 'https://via.placeholder.com/300x200'
        ]
    ];
    
    // Check if the product exists in our data
    if (isset($all_products[$product_id])) {
        $product = $all_products[$product_id];
        
        // Check if the product is already in the cart
        $found = false;
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['id'] == $product_id) {
                // Product already in cart, increase quantity
                $_SESSION['cart'][$key]['quantity']++;
                $found = true;
                break;
            }
        }
        
        // If product not in cart, add it with quantity 1
        if (!$found) {
            $product['quantity'] = 1;
            $_SESSION['cart'][] = $product;
        }
        
        // Return success response
        echo json_encode(['success' => true, 'message' => 'Product added to cart', 'cart_count' => count($_SESSION['cart'])]);
    } else {
        // Product not found
        echo json_encode(['success' => false, 'message' => 'Product not found']);
    }
} else {
    // No product_id provided
    echo json_encode(['success' => false, 'message' => 'No product ID provided']);
}
?>


<?php
session_start();

// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Get cart items from session
$cart_items = $_SESSION['cart'];

// Calculate total
$total = 0;
foreach ($cart_items as $item) {
    // Remove 'Rp ' and '.' from price, then convert to integer
    $price = (int) str_replace(['Rp ', '.'], '', $item['price']);
    $total += $price * $item['quantity'];
}
// Format total back to currency format
$total_formatted = 'Rp ' . number_format($total, 0, ',', '.');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Lunar Store</title>
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#004aad',
                        secondary: '#e4e2dd',
                    }
                }
            }
        }
    </script>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700&family=Righteous&display=swap" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .lunar-text {
            font-family: 'Righteous', cursive;
            color: #004aad;
            letter-spacing: 1px;
        }

        h1 {
            font-family: 'Righteous', cursive;
            letter-spacing: 1px;
        }

        h2 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
        }

        .category-title {
            position: relative;
            display: inline-block;
        }

        .category-title::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 40px;
            height: 3px;
            background-color: #004aad;
        }
    </style>
</head>

<body class="bg-[#e4e2dd] min-h-screen">
    <!-- Navigation Bar -->
    <nav class="bg-white shadow-sm sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="index.php" class="flex-shrink-0 flex items-center">
                        <span class="lunar-text text-xl font-bold">LUNAR</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="catalog.php" class="text-gray-700 hover:text-[#004aad] px-3 py-2 rounded-md text-sm font-medium flex items-center">
                        <i class="fas fa-box mr-1"></i>
                        <span>Catalog</span>
                    </a>
                    <a href="cart.php" class="text-[#004aad] px-3 py-2 rounded-md text-sm font-medium flex items-center">
                        <i class="fas fa-shopping-cart mr-1"></i>
                        <span>Cart</span>
                    </a>
                    <a href="history.php" class="text-gray-700 hover:text-[#004aad] px-3 py-2 rounded-md text-sm font-medium flex items-center">
                        <i class="fas fa-history mr-1"></i>
                        <span>Orders</span>
                    </a>
                    <a href="profile.php" class="text-gray-700 hover:text-[#004aad] px-3 py-2 rounded-md text-sm font-medium flex items-center">
                        <i class="fas fa-user mr-1"></i>
                        <span>Profile</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Cart Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h1 class="lunar-text text-3xl font-bold text-[#004aad]">SHOPPING CART</h1>
            <p class="text-gray-600 mt-2">Review your items and proceed to checkout</p>
        </div>
    </div>

    <!-- Cart Content -->
    <section class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div id="cart-container">
                <?php if (count($cart_items) > 0): ?>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <!-- Cart Items -->
                        <div class="divide-y divide-gray-200" id="cart-items">
                            <?php foreach ($cart_items as $index => $item): ?>
                                <div class="p-6 flex flex-col sm:flex-row" id="item-<?php echo $item['id']; ?>">
                                    <div class="sm:w-24 h-24 flex-shrink-0 overflow-hidden rounded-md">
                                        <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" class="w-full h-full object-cover">
                                    </div>
                                    <div class="sm:ml-6 flex-1 flex flex-col mt-4 sm:mt-0">
                                        <div class="flex justify-between">
                                            <div>
                                                <h3 class="text-lg font-medium text-gray-900"><?php echo $item['name']; ?></h3>
                                                <p class="mt-1 text-sm text-gray-500"><?php echo $item['description']; ?></p>
                                                <?php if (isset($item['period']) && !empty($item['period'])): ?>
                                                    <p class="mt-1 text-xs text-gray-500"><?php echo $item['period']; ?></p>
                                                <?php endif; ?>
                                            </div>
                                            <p class="text-[#004aad] font-bold" id="price-<?php echo $item['id']; ?>" 
                                               data-base-price="<?php echo (int) str_replace(['Rp ', '.'], '', $item['price']); ?>">
                                                <?php 
                                                    $price = (int) str_replace(['Rp ', '.'], '', $item['price']);
                                                    $total_price = $price * $item['quantity'];
                                                    echo 'Rp ' . number_format($total_price, 0, ',', '.');
                                                ?>
                                            </p>
                                        </div>
                                        <div class="flex-1 flex items-end justify-between mt-4">
                                            <div class="flex items-center">
                                                <button onclick="updateQuantity(<?php echo $item['id']; ?>, 'decrease', <?php echo $index; ?>)" class="text-gray-500 hover:text-[#004aad] focus:outline-none">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <span class="mx-3 text-gray-700" id="quantity-<?php echo $item['id']; ?>"><?php echo $item['quantity']; ?></span>
                                                <button onclick="updateQuantity(<?php echo $item['id']; ?>, 'increase', <?php echo $index; ?>)" class="text-gray-500 hover:text-[#004aad] focus:outline-none">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                            <button onclick="removeItem(<?php echo $item['id']; ?>, <?php echo $index; ?>)" class="text-red-500 hover:text-red-700 focus:outline-none">
                                                <i class="fas fa-trash-alt mr-1"></i>
                                                <span>Remove</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Cart Summary -->
                        <div class="bg-gray-50 p-6">
                            <div class="flex justify-between text-base font-medium text-gray-900">
                                <p>Subtotal</p>
                                <p id="subtotal"><?php echo $total_formatted; ?></p>
                            </div>
                            <p class="mt-0.5 text-sm text-gray-500">Shipping and taxes calculated at checkout.</p>
                            <div class="mt-6">
                                <a href="#" onclick="checkout()" class="w-full flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-[#004aad] hover:bg-blue-700">
                                    Checkout
                                </a>
                            </div>
                            <div class="mt-6 flex justify-center text-sm text-center text-gray-500">
                                <p>
                                    or <a href="catalog.php" class="text-[#004aad] font-medium hover:text-blue-700">Continue Shopping<span aria-hidden="true"> &rarr;</span></a>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="bg-white rounded-lg shadow-md p-8 text-center">
                        <div class="text-center mb-6">
                            <i class="fas fa-shopping-cart text-gray-400 text-6xl"></i>
                        </div>
                        <h2 class="text-2xl font-medium text-gray-900 mb-2">Your cart is empty</h2>
                        <p class="text-gray-600 mb-6">Looks like you haven't added any products to your cart yet.</p>
                        <a href="catalog.php" class="inline-block bg-[#004aad] text-white px-6 py-3 rounded-md font-medium hover:bg-blue-700 transition-colors">
                            Browse Products
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white py-8 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex justify-center md:justify-start">
                    <span class="lunar-text text-xl font-bold">LUNAR STORE</span>
                </div>
                <div class="mt-8 md:mt-0">
                    <p class="text-center md:text-right text-gray-600">
                        &copy; <?php echo date('Y'); ?> Lunar Store. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript for cart functionality -->
    <script>
        // Format price to currency format
        function formatPrice(price) {
            return 'Rp ' + price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        // Calculate and update subtotal
        function updateSubtotal() {
            let total = 0;
            document.querySelectorAll('[id^="price-"]').forEach(priceElement => {
                const itemId = priceElement.id.split('-')[1];
                const quantityElement = document.getElementById(`quantity-${itemId}`);
                const basePrice = parseInt(priceElement.getAttribute('data-base-price'));
                const quantity = parseInt(quantityElement.textContent);
                
                total += basePrice * quantity;
            });
            
            document.getElementById('subtotal').textContent = formatPrice(total);
            return total;
        }

        // Update quantity of an item
        function updateQuantity(productId, action, index) {
            // Use fetch API to update the quantity
            fetch('update_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `product_id=${productId}&action=${action}&index=${index}`
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    // Update the displayed quantity
                    const quantityElement = document.getElementById(`quantity-${productId}`);
                    if (quantityElement) {
                        quantityElement.textContent = data.quantity;
                    }
                    
                    // Update the item price display
                    const priceElement = document.getElementById(`price-${productId}`);
                    if (priceElement) {
                        const basePrice = parseInt(priceElement.getAttribute('data-base-price'));
                        const totalItemPrice = basePrice * data.quantity;
                        priceElement.textContent = formatPrice(totalItemPrice);
                    }
                    
                    // Update subtotal
                    updateSubtotal();
                } else {
                    alert('Failed to update quantity: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating quantity');
            });
        }

        // Remove an item from the cart
        function removeItem(productId, index) {
            // Use fetch API to remove the item
            fetch('remove_from_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `index=${index}`
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    // Remove the item from the DOM
                    const itemElement = document.getElementById(`item-${productId}`);
                    if (itemElement) {
                        itemElement.remove();
                    }
                    
                    // Update subtotal
                    updateSubtotal();
                    
                    // Check if cart is empty
                    if (data.cart_count === 0) {
                        // Show empty cart message
                        const cartContainer = document.getElementById('cart-container');
                        cartContainer.innerHTML = `
                            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                                <div class="text-center mb-6">
                                    <i class="fas fa-shopping-cart text-gray-400 text-6xl"></i>
                                </div>
                                <h2 class="text-2xl font-medium text-gray-900 mb-2">Your cart is empty</h2>
                                <p class="text-gray-600 mb-6">Looks like you haven't added any products to your cart yet.</p>
                                <a href="catalog.php" class="inline-block bg-[#004aad] text-white px-6 py-3 rounded-md font-medium hover:bg-blue-700 transition-colors">
                                    Browse Products
                                </a>
                            </div>
                        `;
                    }
                } else {
                    alert('Failed to remove item: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while removing item');
            });
        }

        function checkout() {
            // Here you would typically redirect to checkout page or process
            alert('Proceeding to checkout!');
            // Example redirect
            // window.location.href = 'checkout.php';
        }
    </script>
</body>

</html>


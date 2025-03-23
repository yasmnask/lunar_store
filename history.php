<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History - Lunar Store</title>
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
    <?php
    // Sample order history data
    $orders = [
        [
            'id' => 'ORD-12345',
            'date' => '2023-06-15',
            'status' => 'Completed',
            'total' => 'Rp 261.000',
            'items' => [
                [
                    'name' => 'Netflix Premium',
                    'description' => 'Streaming service for movies & TV shows',
                    'price' => 'Rp 120.000',
                    'period' => '1 Month'
                ],
                [
                    'name' => 'Adobe Photoshop Premium',
                    'description' => 'Professional image editing software',
                    'price' => 'Rp 99.000',
                    'period' => '1 Month'
                ],
                [
                    'name' => '172 Diamonds',
                    'description' => 'Mobile Legends: Bang Bang',
                    'price' => 'Rp 42.000'
                ]
            ]
        ],
        [
            'id' => 'ORD-12344',
            'date' => '2023-05-28',
            'status' => 'Completed',
            'total' => 'Rp 174.000',
            'items' => [
                [
                    'name' => 'Spotify Premium',
                    'description' => 'Music streaming service',
                    'price' => 'Rp 55.000',
                    'period' => '1 Month'
                ],
                [
                    'name' => 'Microsoft 365',
                    'description' => 'Office suite with Word, Excel, PowerPoint',
                    'price' => 'Rp 119.000',
                    'period' => '1 Month'
                ]
            ]
        ],
        [
            'id' => 'ORD-12343',
            'date' => '2023-05-10',
            'status' => 'Completed',
            'total' => 'Rp 84.000',
            'items' => [
                [
                    'name' => '344 Diamonds',
                    'description' => 'Mobile Legends: Bang Bang',
                    'price' => 'Rp 84.000'
                ]
            ]
        ]
    ];
    ?>

    <!-- Navigation Bar -->
    <nav class="bg-white shadow-sm sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="index.php" class="flex-shrink-0 flex items-center">
                        <span class="lunar-text text-xl font-bold">LUNAR STORE</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="catalog.php" class="text-gray-700 hover:text-[#004aad] px-3 py-2 rounded-md text-sm font-medium flex items-center">
                        <i class="fas fa-box mr-1"></i>
                        <span>Catalog</span>
                    </a>
                    <a href="cart.php" class="text-gray-700 hover:text-[#004aad] px-3 py-2 rounded-md text-sm font-medium flex items-center">
                        <i class="fas fa-shopping-cart mr-1"></i>
                        <span>Cart</span>
                    </a>
                    <a href="history.php" class="text-[#004aad] px-3 py-2 rounded-md text-sm font-medium flex items-center">
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

    <!-- Order History Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h1 class="lunar-text text-3xl font-bold text-[#004aad]">ORDER HISTORY</h1>
            <p class="text-gray-600 mt-2">View your past orders and their details</p>
        </div>
    </div>

    <!-- Order History Content -->
    <section class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <?php if (count($orders) > 0): ?>
                <div class="space-y-8">
                    <?php foreach ($orders as $order): ?>
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="p-6 border-b border-gray-200">
                                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                                    <div>
                                        <h2 class="text-xl font-semibold text-gray-900">Order #<?php echo $order['id']; ?></h2>
                                        <p class="text-sm text-gray-600 mt-1">Placed on <?php echo date('F j, Y', strtotime($order['date'])); ?></p>
                                    </div>
                                    <div class="mt-4 sm:mt-0">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                        <?php echo $order['status'] === 'Completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'; ?>">
                                            <?php echo $order['status']; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="px-6 py-4 border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Order Items</h3>
                                <div class="divide-y divide-gray-200">
                                    <?php foreach ($order['items'] as $item): ?>
                                        <div class="py-4 flex justify-between">
                                            <div>
                                                <h4 class="text-base font-medium text-gray-900"><?php echo $item['name']; ?></h4>
                                                <p class="text-sm text-gray-600"><?php echo $item['description']; ?></p>
                                                <?php if (isset($item['period'])): ?>
                                                    <p class="text-xs text-gray-500"><?php echo $item['period']; ?></p>
                                                <?php endif; ?>
                                            </div>
                                            <p class="text-[#004aad] font-medium"><?php echo $item['price']; ?></p>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <div class="px-6 py-4 bg-gray-50">
                                <div class="flex justify-between text-base font-medium text-gray-900">
                                    <p>Total</p>
                                    <p><?php echo $order['total']; ?></p>
                                </div>
                                <div class="mt-4 flex justify-end">
                                    <a href="#" onclick="viewOrderDetails('<?php echo $order['id']; ?>')" class="text-[#004aad] hover:text-blue-700 font-medium">
                                        View Order Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="bg-white rounded-lg shadow-md p-8 text-center">
                    <div class="text-center mb-6">
                        <i class="fas fa-shopping-bag text-gray-400 text-6xl"></i>
                    </div>
                    <h2 class="text-2xl font-medium text-gray-900 mb-2">No orders yet</h2>
                    <p class="text-gray-600 mb-6">You haven't placed any orders yet.</p>
                    <a href="catalog.php" class="inline-block bg-[#004aad] text-white px-6 py-3 rounded-md font-medium hover:bg-blue-700 transition-colors">
                        Browse Products
                    </a>
                </div>
            <?php endif; ?>
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

    <!-- JavaScript for order history functionality -->
    <script>
        function viewOrderDetails(orderId) {
            // Here you would typically redirect to a detailed order page
            alert('Viewing details for order ' + orderId);
            // Example redirect
            // window.location.href = 'order-details.php?id=' + orderId;
        }
    </script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lunar Store - Premium Digital Products</title>
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

    <script type="module" src="https://unpkg.com/@splinetool/viewer@1.9.72/build.spline-viewer.jpg"></script>

    <!-- Font for icons -->
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

        .hero-title {
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
    // Sample data for categories and products
    $categories = [
        [
            'id' => 1,
            'name' => 'Editing Apps',
            'slug' => 'editing-apps',
            'description' => 'Premium photo and video editing applications',
            'image' => 'poster_edit.png'
        ],
        [
            'id' => 2,
            'name' => 'Mobile Legends',
            'slug' => 'mobile-legends',
            'description' => 'Top up diamonds for Mobile Legends',
            'image' => 'poster_ml.png'
        ],
        [
            'id' => 3,
            'name' => 'Streaming Apps',
            'slug' => 'streaming-apps',
            'description' => 'Premium subscriptions for streaming services',
            'image' => 'poster_streaming.png'
        ],
        [
            'id' => 4,
            'name' => 'Education Apps',
            'slug' => 'education-apps',
            'description' => 'Get all the tools to boost your productivity',
            'image' => 'poster_edu.png'
        ]
    ];

    $products = [
        [
            'id' => 1,
            'name' => 'Mobile Legends: 100 Diamonds',
            'description' => 'Top up 100 diamonds for Mobile Legends',
            'price' => 'Rp 25.000',
            'image' => 'https://via.placeholder.com/300x200'
        ],
        [
            'id' => 2,
            'name' => 'Adobe Lightroom Premium',
            'description' => '1 month subscription for Adobe Lightroom',
            'price' => 'Rp 75.000',
            'image' => 'https://via.placeholder.com/300x200'
        ],
        [
            'id' => 3,
            'name' => 'Netflix Premium 1 Month',
            'description' => '1 month subscription for Netflix Premium',
            'price' => 'Rp 120.000',
            'image' => 'https://via.placeholder.com/300x200'
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

    <!-- Hero Section -->
    <section class="py-12 sm:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:flex lg:items-center lg:justify-between">
                <div class="lg:w-1/2">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl">
                        <span class="hero-title text-gray-900">Premium Digital</span>
                        <span class="lunar-text block mt-2 text-[#004aad]">PRODUCTS</span>
                    </h1>
                    <p class="mt-4 text-xl text-gray-600">
                        Get premium apps and game top-ups at the best prices
                    </p>
                    <div class="mt-8">
                        <a href="catalog.php" class="inline-block bg-[#004aad] text-white px-6 py-3 rounded-md font-medium hover:bg-blue-700 transition-colors">
                            Browse Products
                        </a>
                    </div>
                </div>
                <div class="mt-10 lg:mt-0 lg:w-1/2">
                    <div class="relative h-64 sm:h-72 md:h-80 lg:h-96">
                        <!--This is moon animation-->
                        <div class="transform -translate-x-32 -translate-y-72">
                            <dotlottie-player src="https://lottie.host/07e69a38-119f-4261-a8e5-326f33bb2158/RY7A2B3V50.lottie" background="transparent" speed="1" style="width: 1100px; height: 1100px" loop autoplay></dotlottie-player>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 category-title">Categories</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php foreach ($categories as $category): ?>
                    <a href="catalog.php?category=<?php echo $category['slug']; ?>" class="group">
                        <div class="bg-[#e4e2dd] rounded-lg overflow-hidden shadow-md transition-transform group-hover:scale-105">
                            <div class="h-48 relative">
                                <img src="<?php echo $category['image']; ?>" alt="<?php echo $category['name']; ?>" class="object-cover w-full h-full">
                            </div>
                            <div class="p-4">
                                <h3 class="text-lg font-medium text-gray-900"><?php echo $category['name']; ?></h3>
                                <p class="text-sm text-gray-600 mt-1"><?php echo $category['description']; ?></p>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 category-title">Featured Products</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($products as $product): ?>
                    <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                        <div class="h-48 relative">
                            <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="object-cover w-full h-full">
                        </div>
                        <div class="p-4">
                            <h3 class="text-lg font-medium text-gray-900"><?php echo $product['name']; ?></h3>
                            <p class="text-sm text-gray-600 mt-1"><?php echo $product['description']; ?></p>
                            <div class="mt-4 flex items-center justify-between">
                                <span class="text-[#004aad] font-bold"><?php echo $product['price']; ?></span>
                                <button onclick="addToCart(<?php echo $product['id']; ?>)" class="bg-[#004aad] text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700 transition-colors">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="mt-8 text-center">
                <a href="catalog.php" class="inline-block border border-[#004aad] text-[#004aad] px-6 py-3 rounded-md font-medium hover:bg-[#004aad] hover:text-white transition-colors">
                    View All Products
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white py-8">
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
        function addToCart(productId) {
            // Here you would typically use AJAX to add the product to the cart
            alert('Product ' + productId + ' added to cart!');
            // Example AJAX call (commented out)
            /*
            fetch('add_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'product_id=' + productId
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    alert('Product added to cart!');
                } else {
                    alert('Failed to add product to cart.');
                }
            });
            */
        }
    </script>
    <script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module"></script>
</body>

</html>
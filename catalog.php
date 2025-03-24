<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Catalog - Lunar Store</title>
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
    // Get category from URL parameter
    $current_category = isset($_GET['category']) ? $_GET['category'] : '';

    // Sample data for categories
    $categories = [
        'editing-apps' => 'Editing Apps',
        'mobile-legends' => 'Mobile Legends',
        'streaming-apps' => 'Streaming Apps',
        'productivity-apps' => 'Productivity Apps'
    ];

    // Sample data for products
    $editing_apps = [
        [
            'id' => 101,
            'name' => 'Adobe Lightroom Premium',
            'description' => 'Professional photo editing app',
            'price' => 'Rp 75.000',
            'period' => '1 Month',
            'image' => 'https://via.placeholder.com/300x200'
        ],
        [
            'id' => 102,
            'name' => 'Adobe Photoshop Premium',
            'description' => 'Professional image editing software',
            'price' => 'Rp 99.000',
            'period' => '1 Month',
            'image' => 'https://via.placeholder.com/300x200'
        ],
        [
            'id' => 103,
            'name' => 'Canva Pro',
            'description' => 'Design platform for social media & more',
            'price' => 'Rp 65.000',
            'period' => '1 Month',
            'image' => 'https://via.placeholder.com/300x200'
        ],
        [
            'id' => 104,
            'name' => 'Filmora Pro',
            'description' => 'Video editing software',
            'price' => 'Rp 85.000',
            'period' => '1 Month',
            'image' => 'https://via.placeholder.com/300x200'
        ],
        [
            'id' => 105,
            'name' => 'Snapseed Pro',
            'description' => 'Mobile photo editing app',
            'price' => 'Rp 45.000',
            'period' => '1 Month',
            'image' => 'https://via.placeholder.com/300x200'
        ],
        [
            'id' => 106,
            'name' => 'VSCO Premium',
            'description' => 'Photo & video editing with presets',
            'price' => 'Rp 55.000',
            'period' => '1 Month',
            'image' => 'https://via.placeholder.com/300x200'
        ]
    ];

    $mobile_legends = [
        [
            'id' => 201,
            'name' => '86 Diamonds',
            'description' => 'Mobile Legends: Bang Bang',
            'price' => 'Rp 22.000',
            'period' => '',
            'image' => 'https://via.placeholder.com/300x200'
        ],
        [
            'id' => 202,
            'name' => '172 Diamonds',
            'description' => 'Mobile Legends: Bang Bang',
            'price' => 'Rp 42.000',
            'period' => '',
            'image' => 'https://via.placeholder.com/300x200'
        ],
        [
            'id' => 203,
            'name' => '257 Diamonds',
            'description' => 'Mobile Legends: Bang Bang',
            'price' => 'Rp 62.000',
            'period' => '',
            'image' => 'https://via.placeholder.com/300x200'
        ],
        [
            'id' => 204,
            'name' => '344 Diamonds',
            'description' => 'Mobile Legends: Bang Bang',
            'price' => 'Rp 82.000',
            'period' => '',
            'image' => 'https://via.placeholder.com/300x200'
        ],
        [
            'id' => 205,
            'name' => '429 Diamonds',
            'description' => 'Mobile Legends: Bang Bang',
            'price' => 'Rp 102.000',
            'period' => '',
            'image' => 'https://via.placeholder.com/300x200'
        ],
        [
            'id' => 206,
            'name' => '514 Diamonds',
            'description' => 'Mobile Legends: Bang Bang',
            'price' => 'Rp 122.000',
            'period' => '',
            'image' => 'https://via.placeholder.com/300x200'
        ],
        [
            'id' => 207,
            'name' => '706 Diamonds',
            'description' => 'Mobile Legends: Bang Bang',
            'price' => 'Rp 162.000',
            'period' => '',
            'image' => 'https://via.placeholder.com/300x200'
        ],
        [
            'id' => 208,
            'name' => '878 Diamonds',
            'description' => 'Mobile Legends: Bang Bang',
            'price' => 'Rp 202.000',
            'period' => '',
            'image' => 'https://via.placeholder.com/300x200'
        ],
        [
            'id' => 209,
            'name' => 'Starlight Member',
            'description' => 'Mobile Legends: Bang Bang',
            'price' => 'Rp 149.000',
            'period' => '1 Month',
            'image' => 'https://via.placeholder.com/300x200'
        ],
        [
            'id' => 210,
            'name' => 'Starlight Member Plus',
            'description' => 'Mobile Legends: Bang Bang',
            'price' => 'Rp 290.000',
            'period' => '1 Month',
            'image' => 'https://via.placeholder.com/300x200'
        ]
    ];

    $streaming_apps = [
        [
            'id' => 301,
            'name' => 'Netflix Premium',
            'description' => 'Streaming service for movies & TV shows',
            'price' => 'Rp 120.000',
            'period' => '1 Month',
            'image' => 'https://via.placeholder.com/300x200'
        ],
        [
            'id' => 302,
            'name' => 'Spotify Premium',
            'description' => 'Music streaming service',
            'price' => 'Rp 55.000',
            'period' => '1 Month',
            'image' => 'https://via.placeholder.com/300x200'
        ],
        [
            'id' => 303,
            'name' => 'Disney+ Hotstar',
            'description' => 'Streaming service for Disney content',
            'price' => 'Rp 39.000',
            'period' => '1 Month',
            'image' => 'https://via.placeholder.com/300x200'
        ]
    ];

    $productivity_apps = [
        [
            'id' => 401,
            'name' => 'Microsoft 365',
            'description' => 'Office suite with Word, Excel, PowerPoint',
            'price' => 'Rp 149.000',
            'period' => '1 Month',
            'image' => 'https://via.placeholder.com/300x200'
        ],
        [
            'id' => 402,
            'name' => 'Notion Premium',
            'description' => 'All-in-one workspace',
            'price' => 'Rp 85.000',
            'period' => '1 Month',
            'image' => 'https://via.placeholder.com/300x200'
        ]
    ];

    // Determine which products to display based on category
    $products_to_display = [];
    $category_title = 'All Products';

    if ($current_category == 'editing-apps') {
        $products_to_display = $editing_apps;
        $category_title = 'Editing Apps';
    } elseif ($current_category == 'mobile-legends') {
        $products_to_display = $mobile_legends;
        $category_title = 'Mobile Legends';
    } elseif ($current_category == 'streaming-apps') {
        $products_to_display = $streaming_apps;
        $category_title = 'Streaming Apps';
    } elseif ($current_category == 'productivity-apps') {
        $products_to_display = $productivity_apps;
        $category_title = 'Productivity Apps';
    } else {
        // If no category is selected, show all products
        $products_to_display = array_merge($editing_apps, $mobile_legends, $streaming_apps, $productivity_apps);
    }
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
                    <a href="catalog.php" class="text-[#004aad] px-3 py-2 rounded-md text-sm font-medium flex items-center">
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

    <!-- Catalog Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h1 class="lunar-text text-3xl font-bold text-[#004aad]">PRODUCT CATALOG</h1>
            <p class="text-gray-600 mt-2">Browse our collection of premium digital products</p>
        </div>
    </div>

    <!-- Category Filter -->
    <div class="bg-white border-t border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-wrap items-center gap-3">
                <a href="catalog.php" class="<?php echo $current_category == '' ? 'bg-[#004aad] text-white' : 'bg-gray-100 text-gray-800 hover:bg-gray-200'; ?> px-4 py-2 rounded-md text-sm font-medium transition-colors">
                    All Products
                </a>
                <?php foreach ($categories as $slug => $name): ?>
                    <a href="catalog.php?category=<?php echo $slug; ?>" class="<?php echo $current_category == $slug ? 'bg-[#004aad] text-white' : 'bg-gray-100 text-gray-800 hover:bg-gray-200'; ?> px-4 py-2 rounded-md text-sm font-medium transition-colors">
                        <?php echo $name; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Product Catalog -->
    <section class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-8 category-title"><?php echo $category_title; ?></h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php foreach ($products_to_display as $product): ?>
                    <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                        <div class="h-48 relative">
                            <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="object-cover w-full h-full">
                        </div>
                        <div class="p-4">
                            <h3 class="text-lg font-medium text-gray-900"><?php echo $product['name']; ?></h3>
                            <p class="text-sm text-gray-600 mt-1"><?php echo $product['description']; ?></p>
                            <?php if (!empty($product['period'])): ?>
                                <p class="text-xs text-gray-500 mt-1"><?php echo $product['period']; ?></p>
                            <?php endif; ?>
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
        // Use fetch API to add the product to the cart
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
                // You could update a cart counter here if you have one
            } else {
                alert('Failed to add product to cart: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while adding to cart');
        });
    }
    </script>
</body>

</html>


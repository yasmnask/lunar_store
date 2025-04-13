<?php
session_start();

// Check if order ID is provided
if (!isset($_GET['id'])) {
  // Redirect to history page if no order ID is provided
  $_SESSION['error_message'] = "Order ID is missing.";
  header('Location: history.php');
  exit;
}

$order_id = $_GET['id'];

// Initialize orders if not exists in session
if (!isset($_SESSION['all_orders'])) {
  $_SESSION['all_orders'] = [];
  
  // Sample order data (in a real app, this would come from a database)
  $_SESSION['all_orders'] = [
    'ORD-12345678' => [
        'id' => 'ORD-12345678',
        'date' => '2023-06-15',
        'total' => 'Rp 120.000',
        'status' => 'Completed',
        'payment_method' => 'bank_transfer',
        'items' => [
            [
                'name' => 'Netflix Premium',
                'description' => 'Streaming service for movies & TV shows',
                'price' => 'Rp 120.000',
                'period' => '1 Month',
                'quantity' => 1,
                'image' => 'https://via.placeholder.com/100x100'
            ]
        ]
    ],
    'ORD-87654321' => [
        'id' => 'ORD-87654321',
        'date' => '2023-05-20',
        'total' => 'Rp 55.000',
        'status' => 'Completed',
        'payment_method' => 'e_wallet',
        'items' => [
            [
                'name' => 'Spotify Premium',
                'description' => 'Music streaming service',
                'price' => 'Rp 55.000',
                'period' => '1 Month',
                'quantity' => 1,
                'image' => 'https://via.placeholder.com/100x100'
            ]
        ]
    ],
    'ORD-23456789' => [
        'id' => 'ORD-23456789',
        'date' => '2023-06-18',
        'total' => 'Rp 39.000',
        'status' => 'Pending',
        'payment_method' => 'qris',
        'items' => [
            [
                'name' => 'Disney+ Hotstar',
                'description' => 'Streaming service for Disney content',
                'price' => 'Rp 39.000',
                'period' => '1 Month',
                'quantity' => 1,
                'image' => 'https://via.placeholder.com/100x100'
            ]
        ]
    ],
    'ORD-98765432' => [
        'id' => 'ORD-98765432',
        'date' => '2023-06-17',
        'total' => 'Rp 149.000',
        'status' => 'Pending',
        'payment_method' => 'bank_transfer',
        'items' => [
            [
                'name' => 'Microsoft 365',
                'description' => 'Office suite with Word, Excel, PowerPoint',
                'price' => 'Rp 149.000',
                'period' => '1 Month',
                'quantity' => 1,
                'image' => 'https://via.placeholder.com/100x100'
            ]
        ]
    ]
  ];
}

// Check if order exists
if (!isset($_SESSION['all_orders'][$order_id])) {
  // Order not found, redirect to history page
  $_SESSION['error_message'] = "Order not found: $order_id";
  header('Location: history.php');
  exit;
}

// Get order details
$order = $_SESSION['all_orders'][$order_id];

// Define payment methods
$payment_methods = [
  'bank_transfer' => 'Bank Transfer',
  'credit_card' => 'Credit Card',
  'e_wallet' => 'E-Wallet',
  'qris' => 'QRIS'
];

// Bank account information for bank transfers
$bank_accounts = [
  [
      'bank_name' => 'Bank BCA',
      'account_number' => '1234567890',
      'account_name' => 'Lunar Store'
  ],
  [
      'bank_name' => 'Bank Mandiri',
      'account_number' => '0987654321',
      'account_name' => 'Lunar Store'
  ]
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Details - Lunar Store</title>
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
  </style>
</head>

<body class="bg-[#e4e2dd] min-h-screen">
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

  <!-- Order Details Header -->
  <div class="bg-white shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
          <div class="flex items-center">
              <a href="history.php" class="text-gray-500 hover:text-[#004aad] mr-2">
                  <i class="fas fa-arrow-left"></i>
              </a>
              <div>
                  <h1 class="lunar-text text-3xl font-bold text-[#004aad]">ORDER DETAILS</h1>
                  <p class="text-gray-600 mt-2">Order #<?php echo $order['id']; ?></p>
              </div>
          </div>
      </div>
  </div>

  <!-- Order Details Content -->
  <section class="py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="bg-white rounded-lg shadow-md overflow-hidden">
              <div class="p-6 sm:p-8">
                  <!-- Order Status -->
                  <div class="flex justify-between items-center mb-6">
                      <div>
                          <span class="text-sm text-gray-600">Order Date: <?php echo $order['date']; ?></span>
                      </div>
                      <div>
                          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo $order['status'] === 'Completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'; ?>">
                              <?php echo $order['status']; ?>
                          </span>
                      </div>
                  </div>

                  <!-- Order Items -->
                  <div class="border border-gray-200 rounded-lg p-6 mb-6">
                      <h3 class="text-lg font-medium text-gray-900 mb-4">Order Items</h3>
                      
                      <div class="space-y-4">
                          <?php foreach ($order['items'] as $index => $item): ?>
                              <div class="flex items-start py-4 <?php echo $index > 0 ? 'border-t border-gray-200' : ''; ?>">
                                  <div class="flex-shrink-0 w-12 h-12">
                                      <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" class="w-full h-full object-cover rounded">
                                  </div>
                                  <div class="ml-4 flex-1">
                                      <div class="flex justify-between">
                                          <div>
                                              <h4 class="text-sm font-medium text-gray-900"><?php echo $item['name']; ?></h4>
                                              <p class="text-xs text-gray-500"><?php echo $item['description']; ?></p>
                                              <?php if (isset($item['period']) && !empty($item['period'])): ?>
                                                  <p class="text-xs text-gray-500"><?php echo $item['period']; ?></p>
                                              <?php endif; ?>
                                          </div>
                                          <p class="text-sm font-medium text-gray-900">
                                              <?php echo $item['price']; ?> × <?php echo $item['quantity']; ?>
                                          </p>
                                      </div>
                                  </div>
                              </div>
                          <?php endforeach; ?>

                          <!-- Order Summary -->
                          <div class="border-t border-gray-200 pt-4">
                              <div class="flex justify-between">
                                  <span class="text-sm text-gray-600">Payment Method</span>
                                  <span class="text-sm text-gray-900"><?php echo $payment_methods[$order['payment_method']]; ?></span>
                              </div>
                              <div class="flex justify-between mt-2">
                                  <span class="text-sm text-gray-600">Order Status</span>
                                  <span class="text-sm font-medium <?php echo $order['status'] === 'Completed' ? 'text-green-600' : 'text-yellow-600'; ?>">
                                      <?php echo $order['status']; ?>
                                  </span>
                              </div>
                              <div class="flex justify-between mt-2">
                                  <span class="text-sm text-gray-600">Order Date</span>
                                  <span class="text-sm text-gray-900"><?php echo $order['date']; ?></span>
                              </div>
                              <div class="flex justify-between mt-4 pt-4 border-t border-gray-200">
                                  <span class="text-base font-medium text-gray-900">Total</span>
                                  <span class="text-base font-bold text-[#004aad]"><?php echo $order['total']; ?></span>
                              </div>
                          </div>
                      </div>
                  </div>

                  <!-- Payment Information -->
                  <?php if ($order['status'] === 'Pending'): ?>
                      <div class="bg-gray-50 rounded-lg p-6">
                          <h3 class="text-lg font-medium text-gray-900 mb-4">Payment Information</h3>
                          
                          <?php if ($order['payment_method'] === 'bank_transfer'): ?>
                              <div class="space-y-4">
                                  <p class="text-sm text-gray-600">
                                      Please complete your payment by transferring the total amount to one of our bank accounts:
                                  </p>
                                  <?php foreach ($bank_accounts as $account): ?>
                                      <div class="bg-white p-4 rounded border border-gray-200">
                                          <p class="text-sm font-medium text-gray-900"><?php echo $account['bank_name']; ?></p>
                                          <p class="text-sm text-gray-600">Account Number: <?php echo $account['account_number']; ?></p>
                                          <p class="text-sm text-gray-600">Account Name: <?php echo $account['account_name']; ?></p>
                                      </div>
                                  <?php endforeach; ?>
                                  <p class="text-sm text-gray-600">
                                      After completing the payment, your order will be automatically processed once payment is verified.
                                  </p>
                              </div>
                          <?php elseif ($order['payment_method'] === 'qris'): ?>
                              <div class="space-y-4">
                                  <p class="text-sm text-gray-600">
                                      Please scan the QRIS code below to complete your payment:
                                  </p>
                                  <div class="flex justify-center">
                                      <img src="https://via.placeholder.com/200x200?text=QRIS+Code" alt="QRIS Code" class="w-48 h-48">
                                  </div>
                                  <p class="text-sm text-gray-600 text-center">
                                      Your payment will be automatically verified once completed.
                                  </p>
                              </div>
                          <?php else: ?>
                              <p class="text-sm text-gray-600">
                                  Your payment is being processed. Once verified, your order will be completed automatically.
                              </p>
                          <?php endif; ?>
                      </div>
                  <?php endif; ?>

                  <div class="mt-8 flex justify-center">
                      <a href="history.php" class="bg-[#004aad] text-white px-6 py-3 rounded-md font-medium hover:bg-blue-700 transition-colors">
                          Back to Order History
                      </a>
                  </div>
              </div>
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

  <script>
      // Handle any errors
      <?php if (isset($_SESSION['error_message'])): ?>
          alert('<?php echo $_SESSION['error_message']; ?>');
          <?php unset($_SESSION['error_message']); ?>
      <?php endif; ?>
  </script>
</body>

</html>

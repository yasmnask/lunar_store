<?php
session_start();
include 'process_order.php';

// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}

// Handle selected items from cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout_selected'])) {
  if (isset($_POST['selected_items']) && is_array($_POST['selected_items'])) {
      $selected_indices = $_POST['selected_items'];
      $selected_items = [];
      
      foreach ($selected_indices as $index) {
          if (isset($_SESSION['cart'][$index])) {
              $selected_items[] = $_SESSION['cart'][$index];
          }
      }
      
      // Store selected items in session for checkout
      $_SESSION['checkout_items'] = $selected_items;
  } else {
      // No items selected, redirect back to cart
      header('Location: cart.php');
      exit;
  }
} else {
  // If not coming from selection form, use all cart items
  $_SESSION['checkout_items'] = $_SESSION['cart'];
}

// Get checkout items
$cart_items = $_SESSION['checkout_items'];

// If cart is empty, redirect to cart page
if (empty($cart_items)) {
  header('Location: cart.php');
  exit;
}

// Get user profile data for pre-filling email
$user_email = '';
if (isset($_SESSION['user']) && isset($_SESSION['user']['email'])) {
  $user_email = $_SESSION['user']['email'];
}

// Calculate total
$total = 0;
foreach ($cart_items as $item) {
  // Remove 'Rp ' and '.' from price, then convert to integer
  $price = (int) str_replace(['Rp ', '.'], '', $item['price']);
  $total += $price * $item['quantity'];
}
// Format total back to currency format
$total_formatted = 'Rp ' . number_format($total, 0, ',', '.');

// Initialize checkout data in session if it doesn't exist
if (!isset($_SESSION['checkout']) || isset($_POST['checkout_selected'])) {
  $_SESSION['checkout'] = [
      'step' => 1,
      'user_inputs' => [],
      'payment_method' => '',
  ];
}

// Handle form submission for step 1
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['step']) && $_POST['step'] === '1') {
  // Store user inputs in session
  $_SESSION['checkout']['user_inputs'] = $_POST;
  $_SESSION['checkout']['payment_method'] = $_POST['payment_method'];
  $_SESSION['checkout']['step'] = 2;
  
  // Redirect to prevent form resubmission
  header('Location: checkout.php');
  exit;
}

// Handle form submission for step 2
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['step']) && $_POST['step'] === '2') {
  if (isset($_POST['confirm'])) {
      // Process the order
      // Generate order number
      $order_number = 'ORD-' . strtoupper(substr(md5(uniqid()), 0, 8));
      
      // Save order to session
      saveOrder($cart_items, $_SESSION['checkout'], $order_number, $total_formatted);
      
      // Set order success flag
      $_SESSION['order_success'] = true;
      $_SESSION['order_number'] = $order_number;
      
      // Redirect to order confirmation page
      header('Location: order_confirmation.php');
      exit;
  } else if (isset($_POST['cancel'])) {
      // Go back to step 1
      $_SESSION['checkout']['step'] = 1;
      
      // Redirect to prevent form resubmission
      header('Location: checkout.php');
      exit;
  }
}

// Get current step
$current_step = $_SESSION['checkout']['step'];

// Define payment methods
$payment_methods = [
  'bank_transfer' => 'Bank Transfer',
  'credit_card' => 'Credit Card',
  'e_wallet' => 'E-Wallet',
  'qris' => 'QRIS'
];

// Function to determine required fields for each app
function getRequiredFields($appName) {
  $appName = strtolower($appName);
  
  // Basic fields required for all apps
  $fields = [
      'email' => 'Email'
  ];
  
  // Add specific fields based on app
  if (strpos($appName, 'spotify') !== false) {
      $fields['password'] = 'Password';
  } elseif (strpos($appName, 'netflix') !== false) {
      $fields['password'] = 'Password';
      $fields['profile_name'] = 'Profile Name';
  } elseif (strpos($appName, 'adobe') !== false || strpos($appName, 'photoshop') !== false || strpos($appName, 'lightroom') !== false) {
      $fields['password'] = 'Password';
      $fields['adobe_id'] = 'Adobe ID';
  } elseif (strpos($appName, 'microsoft') !== false || strpos($appName, '365') !== false) {
      $fields['password'] = 'Password';
      $fields['microsoft_account'] = 'Microsoft Account';
  } elseif (strpos($appName, 'mobile legends') !== false || strpos($appName, 'diamonds') !== false) {
      $fields['game_id'] = 'Game ID';
      $fields['server_id'] = 'Server ID';
  }
  
  return $fields;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout - Lunar Store</title>
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

  <!-- Checkout Header -->
  <div class="bg-white shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
          <h1 class="lunar-text text-3xl font-bold text-[#004aad]">CHECKOUT</h1>
          <p class="text-gray-600 mt-2">Complete your purchase</p>
      </div>
  </div>

  <!-- Checkout Steps -->
  <div class="bg-white border-t border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
          <div class="flex justify-center">
              <div class="flex items-center">
                  <div class="flex flex-col items-center">
                      <div class="w-10 h-10 rounded-full flex items-center justify-center <?php echo $current_step >= 1 ? 'bg-[#004aad] text-white' : 'bg-gray-200 text-gray-600'; ?>">
                          <span class="text-sm font-medium">1</span>
                      </div>
                      <span class="text-xs mt-1 <?php echo $current_step >= 1 ? 'text-[#004aad] font-medium' : 'text-gray-500'; ?>">Details</span>
                  </div>
                  <div class="w-16 h-1 <?php echo $current_step >= 2 ? 'bg-[#004aad]' : 'bg-gray-200'; ?> mx-2"></div>
                  <div class="flex flex-col items-center">
                      <div class="w-10 h-10 rounded-full flex items-center justify-center <?php echo $current_step >= 2 ? 'bg-[#004aad] text-white' : 'bg-gray-200 text-gray-600'; ?>">
                          <span class="text-sm font-medium">2</span>
                      </div>
                      <span class="text-xs mt-1 <?php echo $current_step >= 2 ? 'text-[#004aad] font-medium' : 'text-gray-500'; ?>">Review</span>
                  </div>
                  <div class="w-16 h-1 <?php echo $current_step >= 3 ? 'bg-[#004aad]' : 'bg-gray-200'; ?> mx-2"></div>
                  <div class="flex flex-col items-center">
                      <div class="w-10 h-10 rounded-full flex items-center justify-center <?php echo $current_step >= 3 ? 'bg-[#004aad] text-white' : 'bg-gray-200 text-gray-600'; ?>">
                          <span class="text-sm font-medium">3</span>
                      </div>
                      <span class="text-xs mt-1 <?php echo $current_step >= 3 ? 'text-[#004aad] font-medium' : 'text-gray-500'; ?>">Payment</span>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <!-- Checkout Content -->
  <section class="py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="lg:grid lg:grid-cols-12 lg:gap-8">
              <!-- Main Content -->
              <div class="lg:col-span-8">
                  <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                      <?php if ($current_step === 1): ?>
                          <!-- Step 1: Enter Details -->
                          <div class="p-6">
                              <h2 class="text-xl font-bold text-gray-900 mb-4">Enter Your Details</h2>
                              <form method="POST" action="checkout.php" id="checkout-form">
                                  <input type="hidden" name="step" value="1">
                                  
                                  <div class="space-y-6">
                                      <?php foreach ($cart_items as $index => $item): ?>
                                          <div class="border-b border-gray-200 pb-6">
                                              <h3 class="text-lg font-medium text-gray-900 mb-3"><?php echo $item['name']; ?></h3>
                                              
                                              <?php 
                                              // Get required fields for this app
                                              $fields = getRequiredFields($item['name']);
                                              
                                              // Display input fields for each required field
                                              foreach ($fields as $field_name => $field_label): 
                                                  $input_name = "item_{$index}_{$field_name}";
                                                  $input_value = isset($_SESSION['checkout']['user_inputs'][$input_name]) ? $_SESSION['checkout']['user_inputs'][$input_name] : '';
                                              ?>
                                                  <div class="mb-3">
                                                      <label for="<?php echo $input_name; ?>" class="block text-sm font-medium text-gray-700 mb-1">
                                                          <?php echo $field_label; ?>
                                                      </label>
                                                      <input 
                                                          type="<?php echo $field_name === 'password' ? 'password' : 'text'; ?>" 
                                                          id="<?php echo $input_name; ?>" 
                                                          name="<?php echo $input_name; ?>" 
                                                          value="<?php echo $field_name === 'email' ? $user_email : $input_value; ?>" 
                                                          class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#004aad] focus:border-[#004aad]"
                                                          required
                                                      >
                                                  </div>
                                              <?php endforeach; ?>
                                          </div>
                                      <?php endforeach; ?>
                                      
                                      <!-- Payment Method Selection -->
                                      <div>
                                          <h3 class="text-lg font-medium text-gray-900 mb-3">Payment Method</h3>
                                          
                                          <?php foreach ($payment_methods as $value => $label): ?>
                                              <div class="mb-2">
                                                  <label class="flex items-center">
                                                      <input 
                                                          type="radio" 
                                                          name="payment_method" 
                                                          value="<?php echo $value; ?>" 
                                                          <?php echo (isset($_SESSION['checkout']['payment_method']) && $_SESSION['checkout']['payment_method'] === $value) ? 'checked' : ''; ?>
                                                          class="h-4 w-4 text-[#004aad] focus:ring-[#004aad] border-gray-300"
                                                          required
                                                      >
                                                      <span class="ml-2 text-sm text-gray-700"><?php echo $label; ?></span>
                                                  </label>
                                              </div>
                                          <?php endforeach; ?>
                                      </div>
                                      
                                      <!-- Schedule Order -->
                                      <div>
                                          <h3 class="text-lg font-medium text-gray-900 mb-3">Order Timing</h3>
                                          
                                          <div class="mb-2">
                                              <label class="flex items-center">
                                                  <input 
                                                      type="radio" 
                                                      name="order_timing" 
                                                      value="now" 
                                                      <?php echo (!isset($_SESSION['checkout']['user_inputs']['order_timing']) || $_SESSION['checkout']['user_inputs']['order_timing'] === 'now') ? 'checked' : ''; ?>
                                                      class="h-4 w-4 text-[#004aad] focus:ring-[#004aad] border-gray-300"
                                                  >
                                                  <span class="ml-2 text-sm text-gray-700">Process order now</span>
                                              </label>
                                          </div>
                                          
                                          <div class="mb-2">
                                              <label class="flex items-center">
                                                  <input 
                                                      type="radio" 
                                                      name="order_timing" 
                                                      value="later" 
                                                      <?php echo (isset($_SESSION['checkout']['user_inputs']['order_timing']) && $_SESSION['checkout']['user_inputs']['order_timing'] === 'later') ? 'checked' : ''; ?>
                                                      class="h-4 w-4 text-[#004aad] focus:ring-[#004aad] border-gray-300"
                                                  >
                                                  <span class="ml-2 text-sm text-gray-700">Process order later (pending)</span>
                                              </label>
                                          </div>
                                      </div>
                                      
                                      <div class="flex justify-between">
                                          <a href="cart.php" class="bg-gray-200 text-gray-800 px-6 py-3 rounded-md font-medium hover:bg-gray-300 transition-colors">
                                              Back to Cart
                                          </a>
                                          <button type="submit" class="bg-[#004aad] text-white px-6 py-3 rounded-md font-medium hover:bg-blue-700 transition-colors">
                                              Continue to Review
                                          </button>
                                      </div>
                                  </div>
                              </form>
                          </div>
                      <?php elseif ($current_step === 2): ?>
                          <!-- Step 2: Review Order -->
                          <div class="p-6">
                              <h2 class="text-xl font-bold text-gray-900 mb-4">Review Your Order</h2>
                              
                              <div class="space-y-6">
                                  <!-- Order Details -->
                                  <?php foreach ($cart_items as $index => $item): ?>
                                      <div class="border-b border-gray-200 pb-6">
                                          <div class="flex items-start">
                                              <div class="flex-shrink-0 w-16 h-16">
                                                  <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" class="w-full h-full object-cover rounded">
                                              </div>
                                              <div class="ml-4 flex-1">
                                                  <h3 class="text-lg font-medium text-gray-900"><?php echo $item['name']; ?></h3>
                                                  <p class="text-sm text-gray-600"><?php echo $item['description']; ?></p>
                                                  <?php if (isset($item['period']) && !empty($item['period'])): ?>
                                                      <p class="text-xs text-gray-500"><?php echo $item['period']; ?></p>
                                                  <?php endif; ?>
                                                  <p class="text-sm font-medium text-[#004aad] mt-1"><?php echo $item['price']; ?> × <?php echo $item['quantity']; ?></p>
                                              </div>
                                          </div>
                                          
                                          <div class="mt-4 bg-gray-50 p-4 rounded-md">
                                              <h4 class="text-sm font-medium text-gray-900 mb-2">Account Details:</h4>
                                              <ul class="text-sm text-gray-600 space-y-1">
                                                  <?php 
                                                  // Get required fields for this app
                                                  $fields = getRequiredFields($item['name']);
                                                  
                                                  // Display input values for each required field
                                                  foreach ($fields as $field_name => $field_label): 
                                                      $input_name = "item_{$index}_{$field_name}";
                                                      $input_value = $_SESSION['checkout']['user_inputs'][$input_name];
                                                      
                                                      // Mask password
                                                      if ($field_name === 'password') {
                                                          $input_value = str_repeat('•', strlen($input_value));
                                                      }
                                                  ?>
                                                      <li><strong><?php echo $field_label; ?>:</strong> <?php echo $input_value; ?></li>
                                                  <?php endforeach; ?>
                                              </ul>
                                          </div>
                                      </div>
                                  <?php endforeach; ?>
                                  
                                  <!-- Payment Method -->
                                  <div>
                                      <h3 class="text-lg font-medium text-gray-900 mb-2">Payment Method</h3>
                                      <p class="text-sm text-gray-600">
                                          <?php 
                                              $payment_method = $_SESSION['checkout']['payment_method'];
                                              echo $payment_methods[$payment_method];
                                          ?>
                                      </p>
                                  </div>
                                  
                                  <!-- Order Timing -->
                                  <div>
                                      <h3 class="text-lg font-medium text-gray-900 mb-2">Order Timing</h3>
                                      <p class="text-sm text-gray-600">
                                          <?php 
                                              $order_timing = $_SESSION['checkout']['user_inputs']['order_timing'];
                                              echo $order_timing === 'now' ? 'Process order now' : 'Process order later (pending)';
                                          ?>
                                      </p>
                                  </div>
                                  
                                  <form method="POST" action="checkout.php" class="flex justify-between mt-6">
                                      <input type="hidden" name="step" value="2">
                                      <button type="submit" name="cancel" value="1" class="bg-gray-200 text-gray-800 px-6 py-3 rounded-md font-medium hover:bg-gray-300 transition-colors">
                                          Back to Details
                                      </button>
                                      <button type="submit" name="confirm" value="1" class="bg-[#004aad] text-white px-6 py-3 rounded-md font-medium hover:bg-blue-700 transition-colors">
                                          Confirm Order
                                      </button>
                                  </form>
                              </div>
                          </div>
                      <?php endif; ?>
                  </div>
              </div>
              
              <!-- Order Summary -->
              <div class="lg:col-span-4">
                  <div class="bg-white rounded-lg shadow-md overflow-hidden sticky top-24">
                      <div class="p-6">
                          <h2 class="text-lg font-bold text-gray-900 mb-4">Order Summary</h2>
                          
                          <div class="space-y-4">
                              <!-- Items -->
                              <?php foreach ($cart_items as $item): ?>
                                  <div class="flex justify-between text-sm">
                                      <span class="text-gray-600">
                                          <?php echo $item['name']; ?> × <?php echo $item['quantity']; ?>
                                      </span>
                                      <span class="font-medium">
                                          <?php 
                                              $price = (int) str_replace(['Rp ', '.'], '', $item['price']);
                                              $total_item_price = $price * $item['quantity'];
                                              echo 'Rp ' . number_format($total_item_price, 0, ',', '.');
                                          ?>
                                      </span>
                                  </div>
                              <?php endforeach; ?>
                              
                              <!-- Divider -->
                              <div class="border-t border-gray-200 my-4"></div>
                              
                              <!-- Total -->
                              <div class="flex justify-between">
                                  <span class="font-medium text-gray-900">Total</span>
                                  <span class="font-bold text-[#004aad]"><?php echo $total_formatted; ?></span>
                              </div>
                          </div>
                      </div>
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
</body>

</html>

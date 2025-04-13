<?php
session_start();
include 'process_order.php';

// Check if order was successful
if (!isset($_SESSION['order_success']) || $_SESSION['order_success'] !== true) {
  header('Location: cart.php');
  exit;
}

// Get order number
$order_number = $_SESSION['order_number'];

// Get order details from session
$order = getOrderById($order_number);
$cart_items = $_SESSION['checkout_items'];
$checkout_data = $_SESSION['checkout'];
$payment_method = $checkout_data['payment_method'];
$order_timing = $checkout_data['user_inputs']['order_timing'];

// Calculate total
$total = 0;
foreach ($cart_items as $item) {
  // Remove 'Rp ' and '.' from price, then convert to integer
  $price = (int) str_replace(['Rp ', '.'], '', $item['price']);
  $total += $price * $item['quantity'];
}
// Format total back to currency format
$total_formatted = 'Rp ' . number_format($total, 0, ',', '.');

// Define payment methods
$payment_methods = [
  'bank_transfer' => 'Bank Transfer',
  'credit_card' => 'Credit Card',
  'e_wallet' => 'E-Wallet',
  'qris' => 'QRIS'
];

// Clear cart and checkout data
$_SESSION['cart'] = [];
unset($_SESSION['checkout']);
unset($_SESSION['order_success']);
unset($_SESSION['order_number']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Confirmation - Lunar Store</title>
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

  <!-- Confirmation Header -->
  <div class="bg-white shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
          <h1 class="lunar-text text-3xl font-bold text-[#004aad]">ORDER CONFIRMATION</h1>
          <p class="text-gray-600 mt-2">Thank you for your order!</p>
      </div>
  </div>

  <!-- Confirmation Content -->
  <section class="py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="bg-white rounded-lg shadow-md overflow-hidden">
              <div class="p-6 sm:p-8">
                  <!-- Success Message -->
                  <div class="text-center mb-8">
                      <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 text-green-500 mb-4">
                          <i class="fas fa-check-circle text-3xl"></i>
                      </div>
                      <h2 class="text-2xl font-bold text-gray-900">Order Placed Successfully!</h2>
                      <p class="text-gray-600 mt-2">
                          <?php if ($order_timing === 'now'): ?>
                              Your order has been placed and is being processed.
                          <?php else: ?>
                              Your order has been saved and will be processed later.
                          <?php endif; ?>
                      </p>
                  </div>

                  <!-- Order Details -->
                  <div class="border border-gray-200 rounded-lg p-6 mb-6">
                      <div class="flex justify-between items-center mb-4">
                          <h3 class="text-lg font-medium text-gray-900">Order Details</h3>
                          <span class="text-sm text-gray-600">Order #<?php echo $order_number; ?></span>
                      </div>

                      <div class="space-y-4">
                          <!-- Order Items -->
                          <?php foreach ($cart_items as $item): ?>
                              <div class="flex items-start py-4 border-t border-gray-200">
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
                                  <span class="text-sm text-gray-900"><?php echo $payment_methods[$payment_method]; ?></span>
                              </div>
                              <div class="flex justify-between mt-2">
                                  <span class="text-sm text-gray-600">Order Status</span>
                                  <span class="text-sm font-medium <?php echo $order_timing === 'now' ? 'text-green-600' : 'text-yellow-600'; ?>">
                                      <?php echo $order_timing === 'now' ? 'Processing' : 'Pending'; ?>
                                  </span>
                              </div>
                              <div class="flex justify-between mt-2">
                                  <span class="text-sm text-gray-600">Order Date</span>
                                  <span class="text-sm text-gray-900"><?php echo date('F j, Y'); ?></span>
                              </div>
                              <div class="flex justify-between mt-4 pt-4 border-t border-gray-200">
                                  <span class="text-base font-medium text-gray-900">Total</span>
                                  <span class="text-base font-bold text-[#004aad]"><?php echo $total_formatted; ?></span>
                              </div>
                          </div>
                      </div>
                  </div>

                  <!-- Next Steps -->
                  <div class="bg-gray-50 rounded-lg p-6">
                      <h3 class="text-lg font-medium text-gray-900 mb-4">Next Steps</h3>
                      
                      <?php if ($payment_method === 'bank_transfer'): ?>
                          <div class="space-y-4">
                              <p class="text-sm text-gray-600">
                                  Please complete your payment by transferring the total amount to one of our bank accounts:
                              </p>
                              <div class="bg-white p-4 rounded border border-gray-200">
                                  <p class="text-sm font-medium text-gray-900">Bank BCA</p>
                                  <p class="text-sm text-gray-600">Account Number: 1234567890</p>
                                  <p class="text-sm text-gray-600">Account Name: Lunar Store</p>
                              </div>
                              <div class="bg-white p-4 rounded border border-gray-200">
                                  <p class="text-sm font-medium text-gray-900">Bank Mandiri</p>
                                  <p class="text-sm text-gray-600">Account Number: 0987654321</p>
                                  <p class="text-sm text-gray-600">Account Name: Lunar Store</p>
                              </div>
                              <p class="text-sm text-gray-600">
                                  After completing the payment, please upload your payment proof in the order history page.
                              </p>
                          </div>
                      <?php elseif ($payment_method === 'qris'): ?>
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
                              Your payment has been processed. You will receive an email confirmation shortly.
                          </p>
                      <?php endif; ?>
                  </div>

                  <div class="mt-8 flex justify-center">
                      <a href="history.php" class="bg-[#004aad] text-white px-6 py-3 rounded-md font-medium hover:bg-blue-700 transition-colors">
                          View Order History
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
</body>

</html>

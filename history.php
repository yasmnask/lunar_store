<?php
session_start();
include 'process_order.php';

// Initialize user data in session if it doesn't exist
if (!isset($_SESSION['user'])) {
  // Default user data
  $_SESSION['user'] = [
      'name' => 'Zakiyah Yasmin',
      'email' => 'zakiyahyasmin1@gmail.com',
      'phone' => '+62 812-3456-7890',
      'avatar' => 'https://via.placeholder.com/150',
      'member_since' => '2023-01-15',
      'total_orders' => 8,
      'wallet_balance' => 'Rp 150.000',
      'password' => 'password123' // In a real app, this would be hashed
  ];
}

// Get active tab from URL parameter
$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'completed';

// Get orders from session
$completed_orders = getCompletedOrders();
$pending_orders = getPendingOrders();

// Handle payment completion (for demonstration purposes)
if (isset($_POST['complete_payment']) && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];
    updateOrderStatus($order_id, 'Completed');
    
    // Redirect to refresh the page
    header('Location: history.php?tab=' . $active_tab);
    exit;
}

// Define payment methods
$payment_methods = [
  'bank_transfer' => 'Bank Transfer',
  'credit_card' => 'Credit Card',
  'e_wallet' => 'E-Wallet',
  'qris' => 'QRIS'
];
?>

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

      .tab-active {
          color: #004aad;
          border-bottom: 2px solid #004aad;
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

  <!-- Order History Header -->
  <div class="bg-white shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
          <h1 class="lunar-text text-3xl font-bold text-[#004aad]">ORDER HISTORY</h1>
          <p class="text-gray-600 mt-2">View and manage your orders</p>
      </div>
  </div>

  <!-- Order History Tabs -->
  <div class="bg-white border-t border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex">
              <a href="?tab=completed" class="px-4 py-4 text-sm font-medium <?php echo $active_tab === 'completed' ? 'tab-active' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300'; ?>">
                  Completed Orders
              </a>
              <a href="?tab=pending" class="px-4 py-4 text-sm font-medium <?php echo $active_tab === 'pending' ? 'tab-active' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300'; ?>">
                  Pending Orders
              </a>
          </div>
      </div>
  </div>

  <!-- Order History Content -->
  <section class="py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <?php if ($active_tab === 'completed' && !empty($completed_orders)): ?>
              <!-- Completed Orders -->
              <div class="bg-white rounded-lg shadow-md overflow-hidden">
                  <div class="p-6">
                      <h2 class="text-xl font-bold text-gray-900 mb-6">Completed Orders</h2>
                      
                      <div class="space-y-6">
                          <?php foreach ($completed_orders as $order): ?>
                              <div class="border border-gray-200 rounded-lg overflow-hidden">
                                  <div class="bg-gray-50 px-4 py-3 flex justify-between items-center">
                                      <div>
                                          <span class="text-sm font-medium text-gray-900"><?php echo $order['id']; ?></span>
                                          <span class="text-sm text-gray-500 ml-2"><?php echo $order['date']; ?></span>
                                      </div>
                                      <div>
                                          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                              <?php echo $order['status']; ?>
                                          </span>
                                      </div>
                                  </div>
                                  <div class="p-4">
                                      <?php foreach ($order['items'] as $item): ?>
                                          <div class="flex justify-between items-center mb-2">
                                              <div>
                                                  <h3 class="text-sm font-medium text-gray-900"><?php echo $item['name']; ?></h3>
                                                  <p class="text-xs text-gray-500"><?php echo $item['description']; ?></p>
                                                  <?php if (isset($item['period']) && !empty($item['period'])): ?>
                                                      <p class="text-xs text-gray-500"><?php echo $item['period']; ?></p>
                                                  <?php endif; ?>
                                              </div>
                                              <div class="text-right">
                                                  <p class="text-sm font-medium text-gray-900"><?php echo $item['price']; ?></p>
                                                  <p class="text-xs text-gray-500">Qty: <?php echo $item['quantity']; ?></p>
                                              </div>
                                          </div>
                                      <?php endforeach; ?>
                                      
                                      <div class="border-t border-gray-200 mt-4 pt-4 flex justify-between items-center">
                                          <div>
                                              <p class="text-sm text-gray-500">Payment Method: <?php echo $payment_methods[$order['payment_method']]; ?></p>
                                          </div>
                                          <div>
                                              <p class="text-sm font-bold text-[#004aad]">Total: <?php echo $order['total']; ?></p>
                                          </div>
                                      </div>
                                      
                                      <div class="mt-4 flex justify-end">
                                          <a href="order_details.php?id=<?php echo $order['id']; ?>" class="text-sm text-[#004aad] hover:text-blue-700">
                                              View Order Details
                                          </a>
                                      </div>
                                  </div>
                              </div>
                          <?php endforeach; ?>
                      </div>
                  </div>
              </div>
          <?php elseif ($active_tab === 'pending' && !empty($pending_orders)): ?>
              <!-- Pending Orders -->
              <div class="bg-white rounded-lg shadow-md overflow-hidden">
                  <div class="p-6">
                      <h2 class="text-xl font-bold text-gray-900 mb-6">Pending Orders</h2>
                      
                      <div class="space-y-6">
                          <?php foreach ($pending_orders as $order): ?>
                              <div class="border border-gray-200 rounded-lg overflow-hidden">
                                  <div class="bg-gray-50 px-4 py-3 flex justify-between items-center">
                                      <div>
                                          <span class="text-sm font-medium text-gray-900"><?php echo $order['id']; ?></span>
                                          <span class="text-sm text-gray-500 ml-2"><?php echo $order['date']; ?></span>
                                      </div>
                                      <div>
                                          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                              <?php echo $order['status']; ?>
                                          </span>
                                      </div>
                                  </div>
                                  <div class="p-4">
                                      <?php foreach ($order['items'] as $item): ?>
                                          <div class="flex justify-between items-center mb-2">
                                              <div>
                                                  <h3 class="text-sm font-medium text-gray-900"><?php echo $item['name']; ?></h3>
                                                  <p class="text-xs text-gray-500"><?php echo $item['description']; ?></p>
                                                  <?php if (isset($item['period']) && !empty($item['period'])): ?>
                                                      <p class="text-xs text-gray-500"><?php echo $item['period']; ?></p>
                                                  <?php endif; ?>
                                              </div>
                                              <div class="text-right">
                                                  <p class="text-sm font-medium text-gray-900"><?php echo $item['price']; ?></p>
                                                  <p class="text-xs text-gray-500">Qty: <?php echo $item['quantity']; ?></p>
                                              </div>
                                          </div>
                                      <?php endforeach; ?>
                                      
                                      <div class="border-t border-gray-200 mt-4 pt-4 flex justify-between items-center">
                                          <div>
                                              <p class="text-sm text-gray-500">Payment Method: <?php echo $payment_methods[$order['payment_method']]; ?></p>
                                          </div>
                                          <div>
                                              <p class="text-sm font-bold text-[#004aad]">Total: <?php echo $order['total']; ?></p>
                                          </div>
                                      </div>
                                      
                                      <div class="mt-4 flex justify-between">
                                          <form method="POST" action="history.php?tab=<?php echo $active_tab; ?>">
                                              <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                              <button type="submit" name="complete_payment" class="text-sm bg-green-500 hover:bg-green-600 text-white py-1 px-3 rounded">
                                                  Complete Payment
                                              </button>
                                          </form>
                                          <a href="order_details.php?id=<?php echo $order['id']; ?>" class="text-sm text-[#004aad] hover:text-blue-700">
                                              View Order Details
                                          </a>
                                      </div>
                                  </div>
                              </div>
                          <?php endforeach; ?>
                      </div>
                  </div>
              </div>
          <?php else: ?>
              <!-- No Orders -->
              <div class="bg-white rounded-lg shadow-md p-8 text-center">
                  <div class="text-center mb-6">
                      <i class="fas fa-shopping-bag text-gray-400 text-6xl"></i>
                  </div>
                  <h2 class="text-2xl font-medium text-gray-900 mb-2">No <?php echo $active_tab === 'completed' ? 'completed' : 'pending'; ?> orders found</h2>
                  <p class="text-gray-600 mb-6">
                      <?php echo $active_tab === 'completed' 
                          ? 'You don\'t have any completed orders yet.' 
                          : 'You don\'t have any pending orders at the moment.'; ?>
                  </p>
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

  <script>
      // Handle any errors
      <?php if (isset($_SESSION['error_message'])): ?>
          alert('<?php echo $_SESSION['error_message']; ?>');
          <?php unset($_SESSION['error_message']); ?>
      <?php endif; ?>
  </script>
</body>

</html>

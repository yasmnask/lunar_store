<?php
session_start();

// Initialize user data in session if it doesn't exist
if (!$_SESSION['user'] && !isset($_SESSION['user'])) {
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

// Get user data from session
$user = $_SESSION['user'];

// Check if there's a success message
$success_message = '';
if (isset($_SESSION['profile_success'])) {
    $success_message = $_SESSION['profile_success'];
    unset($_SESSION['profile_success']); // Clear the message after displaying
}

// Check if there's an error message
$error_message = '';
if (isset($_SESSION['profile_error'])) {
    $error_message = $_SESSION['profile_error'];
    unset($_SESSION['profile_error']); // Clear the message after displaying
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - Lunar Store</title>
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
                    <a href="history.php" class="text-gray-700 hover:text-[#004aad] px-3 py-2 rounded-md text-sm font-medium flex items-center">
                        <i class="fas fa-history mr-1"></i>
                        <span>Orders</span>
                    </a>
                    <a href="profile.php" class="text-[#004aad] px-3 py-2 rounded-md text-sm font-medium flex items-center">
                        <i class="fas fa-user mr-1"></i>
                        <span>Profile</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Profile Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h1 class="lunar-text text-3xl font-bold text-[#004aad]">MY PROFILE</h1>
            <p class="text-gray-600 mt-2">Manage your account information and settings</p>
        </div>
    </div>

    <!-- Profile Content -->
    <section class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Success/Error Messages -->
            <?php if (!empty($success_message)): ?>
                <div id="success-message" class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    <span class="block sm:inline"><?php echo $success_message; ?></span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="document.getElementById('success-message').style.display = 'none';">
                        <i class="fas fa-times"></i>
                    </span>
                </div>
            <?php endif; ?>

            <?php if (!empty($error_message)): ?>
                <div id="error-message" class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    <span class="block sm:inline"><?php echo $error_message; ?></span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="document.getElementById('error-message').style.display = 'none';">
                        <i class="fas fa-times"></i>
                    </span>
                </div>
            <?php endif; ?>

            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <!-- Profile Header with Avatar -->
                <div class="p-6 sm:p-8 bg-gray-50 border-b border-gray-200">
                    <div class="flex flex-col sm:flex-row items-center">
                        <div class="flex-shrink-0 mb-4 sm:mb-0">
                            <img class="h-24 w-24 rounded-full object-cover border-4 border-white shadow" src="<?php echo $user['avatar']; ?>" alt="Profile picture">
                        </div>
                        <div class="sm:ml-6 text-center sm:text-left">
                            <h2 class="text-2xl font-bold text-gray-900"><?php echo $user['name']; ?></h2>
                            <p class="text-sm text-gray-600 mt-1">Member since <?php echo date('F j, Y', strtotime($user['member_since'])); ?></p>
                            <div class="mt-3 flex flex-wrap justify-center sm:justify-start gap-3">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-shopping-bag mr-1"></i> <?php echo $user['total_orders']; ?> Orders
                                </span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-wallet mr-1"></i> <?php echo $user['wallet_balance']; ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile Tabs -->
                <div class="border-b border-gray-200">
                    <nav class="flex -mb-px">
                        <button onclick="showTab('personal-info')" class="tab-btn tab-active w-1/3 py-4 px-1 text-center border-b-2 font-medium text-sm">
                            Personal Info
                        </button>
                        <button onclick="showTab('security')" class="tab-btn w-1/3 py-4 px-1 text-center border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                            Security
                        </button>
                        <button onclick="showTab('payment-methods')" class="tab-btn w-1/3 py-4 px-1 text-center border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                            Payment Methods
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div class="p-6 sm:p-8">
                    <!-- Personal Info Tab -->
                    <div id="personal-info" class="tab-content">
                        <form id="personal-info-form">
                            <div class="space-y-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                                    <input type="text" name="name" id="name" value="<?php echo $user['name']; ?>" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#004aad] focus:border-[#004aad]">
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                                    <input type="email" name="email" id="email" value="<?php echo $user['email']; ?>" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#004aad] focus:border-[#004aad]">
                                </div>

                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                    <input type="tel" name="phone" id="phone" value="<?php echo $user['phone']; ?>" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#004aad] focus:border-[#004aad]">
                                </div>

                                <div>
                                    <label for="avatar" class="block text-sm font-medium text-gray-700">Profile Picture</label>
                                    <div class="mt-1 flex items-center">
                                        <span class="inline-block h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                                            <img src="<?php echo $user['avatar']; ?>" alt="Current profile picture" class="h-full w-full object-cover">
                                        </span>
                                        <button type="button" class="ml-5 bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#004aad]">
                                            Change
                                        </button>
                                    </div>
                                </div>

                                <div class="flex justify-end">
                                    <button type="button" onclick="updatePersonalInfo()" class="bg-[#004aad] text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700 transition-colors">
                                        Save Changes
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Security Tab (Hidden by default) -->
                    <div id="security" class="tab-content hidden">
                        <form id="security-form">
                            <div class="space-y-6">
                                <div>
                                    <label for="current-password" class="block text-sm font-medium text-gray-700">Current Password</label>
                                    <input type="password" name="current-password" id="current-password" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#004aad] focus:border-[#004aad]">
                                </div>

                                <div>
                                    <label for="new-password" class="block text-sm font-medium text-gray-700">New Password</label>
                                    <input type="password" name="new-password" id="new-password" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#004aad] focus:border-[#004aad]">
                                </div>

                                <div>
                                    <label for="confirm-password" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                                    <input type="password" name="confirm-password" id="confirm-password" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#004aad] focus:border-[#004aad]">
                                </div>

                                <div class="flex justify-end">
                                    <button type="button" onclick="updatePassword()" class="bg-[#004aad] text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700 transition-colors">
                                        Update Password
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Payment Methods Tab (Hidden by default) -->
                    <div id="payment-methods" class="tab-content hidden">
                        <div class="space-y-6">
                            <div class="bg-gray-50 p-4 rounded-md">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <i class="fas fa-credit-card text-gray-400 text-xl"></i>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">Visa ending in 4242</p>
                                            <p class="text-xs text-gray-500">Expires 12/2025</p>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button class="text-sm text-gray-600 hover:text-gray-900">Edit</button>
                                        <button class="text-sm text-red-600 hover:text-red-900">Remove</button>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50 p-4 rounded-md">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <i class="fas fa-university text-gray-400 text-xl"></i>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">Bank Transfer (BCA)</p>
                                            <p class="text-xs text-gray-500">Account ending in 7890</p>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button class="text-sm text-gray-600 hover:text-gray-900">Edit</button>
                                        <button class="text-sm text-red-600 hover:text-red-900">Remove</button>
                                    </div>
                                </div>
                            </div>

                            <button class="flex items-center text-[#004aad] hover:text-blue-700">
                                <i class="fas fa-plus-circle mr-2"></i>
                                <span>Add Payment Method</span>
                            </button>
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

    <!-- JavaScript for profile functionality -->
    <script>
        function showTab(tabId) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.add('hidden');
            });

            // Show the selected tab content
            document.getElementById(tabId).classList.remove('hidden');

            // Update tab button styles
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('tab-active');
                btn.classList.add('text-gray-500');
                btn.classList.add('border-transparent');
            });

            // Highlight the active tab button
            event.currentTarget.classList.add('tab-active');
            event.currentTarget.classList.remove('text-gray-500');
            event.currentTarget.classList.remove('border-transparent');
        }

        // Function to update personal info
        function updatePersonalInfo() {
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const phone = document.getElementById('phone').value;

            // Basic validation
            if (!name || !email || !phone) {
                alert('Please fill in all fields');
                return;
            }

            // Use fetch API to update personal info
            fetch('update_profile.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=personal_info&name=${encodeURIComponent(name)}&email=${encodeURIComponent(email)}&phone=${encodeURIComponent(phone)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the profile header with new name
                    document.querySelector('h2.text-2xl').textContent = name;
                    
                    // Show success message
                    showMessage('success', data.message);
                } else {
                    showMessage('error', data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('error', 'An error occurred while updating your profile');
            });
        }

        // Function to update password
        function updatePassword() {
            const currentPassword = document.getElementById('current-password').value;
            const newPassword = document.getElementById('new-password').value;
            const confirmPassword = document.getElementById('confirm-password').value;

            // Basic validation
            if (!currentPassword || !newPassword || !confirmPassword) {
                alert('Please fill in all password fields');
                return;
            }

            if (newPassword !== confirmPassword) {
                alert('New password and confirmation do not match');
                return;
            }

            // Use fetch API to update password
            fetch('update_profile.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=security&current_password=${encodeURIComponent(currentPassword)}&new_password=${encodeURIComponent(newPassword)}&confirm_password=${encodeURIComponent(confirmPassword)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Clear password fields
                    document.getElementById('current-password').value = '';
                    document.getElementById('new-password').value = '';
                    document.getElementById('confirm-password').value = '';
                    
                    // Show success message
                    showMessage('success', data.message);
                } else {
                    showMessage('error', data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('error', 'An error occurred while updating your password');
            });
        }

        // Function to show message
        function showMessage(type, message) {
            // Create message element
            const messageDiv = document.createElement('div');
            messageDiv.className = type === 'success' 
                ? 'mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative'
                : 'mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative';
            
            messageDiv.innerHTML = `
                <span class="block sm:inline">${message}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.remove();">
                    <i class="fas fa-times"></i>
                </span>
            `;
            
            // Insert at the top of the profile content
            const profileContent = document.querySelector('.max-w-7xl.mx-auto.px-4.sm\\:px-6.lg\\:px-8');
            profileContent.insertBefore(messageDiv, profileContent.firstChild);
            
            // Auto-remove after 5 seconds
            setTimeout(() => {
                if (messageDiv.parentNode) {
                    messageDiv.remove();
                }
            }, 5000);
        }
    </script>
</body>

</html>

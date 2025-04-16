<?php
// Initialize variables
$selectedPlan = isset($_POST['plan']) ? $_POST['plan'] : '';
$selectedDuration = isset($_POST['duration']) ? $_POST['duration'] : '';
$totalPrice = 0;

// Define plans and their prices
$plans = [
    '1P1U' => [
        'name' => '1P1U Sharing',
        'description' => 'Share your account with 1 person, 1 user',
        'durations' => [
            '1day' => ['name' => '1 Day', 'price' => 5000],
            '3days' => ['name' => '3 Days', 'price' => 10500],
            '5days' => ['name' => '5 Days', 'price' => 14000],
            '1week' => ['name' => '1 Week', 'price' => 18000],
            '1month' => ['name' => '1 Month', 'price' => 41500],
        ]
    ],
    '1P2U' => [
        'name' => '1P2U Sharing',
        'description' => 'Share your account with 1 person, 2 users',
        'durations' => [
            '1week' => ['name' => '1 Week', 'price' => 16000],
            '1month' => ['name' => '1 Month', 'price' => 31500],
        ]
    ],
    'semi_private' => [
        'name' => 'Semi Private',
        'description' => 'Limited sharing with enhanced privacy',
        'durations' => [
            '1month' => ['name' => '1 Month', 'price' => 65000],
        ]
    ],
    'private' => [
        'name' => 'Private',
        'description' => 'Your own private Netflix account',
        'durations' => [
            '1month' => ['name' => '1 Month', 'price' => 184000],
        ]
    ],
];

// Calculate total price if plan and duration are selected
if ($selectedPlan && $selectedDuration && isset($plans[$selectedPlan]['durations'][$selectedDuration])) {
    $totalPrice = $plans[$selectedPlan]['durations'][$selectedDuration]['price'];
}

// Process form submission
$addedToCart = false;
$cartMessage = '';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    if ($selectedPlan && $selectedDuration) {
        // Get plan details
        $planName = $plans[$selectedPlan]['name'];
        $durationName = $plans[$selectedPlan]['durations'][$selectedDuration]['name'];
        $price = $plans[$selectedPlan]['durations'][$selectedDuration]['price'];

        // Create cart item
        $cartItem = [
            'id' => uniqid(),
            'product' => 'Netflix Premium',
            'plan' => $planName,
            'duration' => $durationName,
            'price' => $price,
            'timestamp' => time()
        ];

        // Add to cart session
        $_SESSION['cart'][] = $cartItem;

        $addedToCart = true;
        $cartMessage = "Your Netflix Premium subscription has been added to cart successfully!";
    } else {
        $cartMessage = "Please select a plan and duration before adding to cart.";
    }
}

// Format price to IDR
function formatPrice($price)
{
    return number_format($price, 0, ',', '.') . ' IDR';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Netflix Premium - Lunar Store</title>
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
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #e4e2dd;
        }

        .lunar-text {
            font-family: 'Righteous', cursive;
            color: #004aad;
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

        .plan-card {
            transition: all 0.3s ease;
        }

        .plan-card:hover {
            transform: translateY(-5px);
        }

        .plan-card.selected {
            border-color: #004aad;
            background-color: rgba(0, 74, 173, 0.05);
        }

        .duration-option {
            transition: all 0.2s ease;
            cursor: pointer;
            border: 1px solid #e5e7eb;
            background-color: white;
            user-select: none;
            -webkit-user-select: none;
        }

        .duration-option:hover {
            border-color: #004aad;
        }

        .duration-option.selected {
            background-color: #e6f0ff;
            border-color: #004aad;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 50;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            padding: 2rem;
            border-radius: 0.5rem;
            max-width: 500px;
            width: 90%;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .modal.active {
            display: flex;
        }

        /* Add animation for the success modal */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal.active .modal-content {
            animation: fadeIn 0.3s ease-out forwards;
        }
    </style>
</head>

<body class="bg-secondary min-h-screen">
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
                    <a href="catalog.php" class="text-gray-700 hover:text-primary px-3 py-2 rounded-md text-sm font-medium flex items-center">
                        <i class="fas fa-box mr-1"></i>
                        <span>Catalog</span>
                    </a>
                    <a href="cart.php" class="text-gray-700 hover:text-primary px-3 py-2 rounded-md text-sm font-medium flex items-center">
                        <i class="fas fa-shopping-cart mr-1"></i>
                        <span>Cart <?php echo !empty($_SESSION['cart']) ? '(' . count($_SESSION['cart']) . ')' : ''; ?></span>
                    </a>
                    <a href="history.php" class="text-gray-700 hover:text-primary px-3 py-2 rounded-md text-sm font-medium flex items-center">
                        <i class="fas fa-history mr-1"></i>
                        <span>Orders</span>
                    </a>
                    <a href="profile.php" class="text-gray-700 hover:text-primary px-3 py-2 rounded-md text-sm font-medium flex items-center">
                        <i class="fas fa-user mr-1"></i>
                        <span>Profile</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Product Header -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
            <div class="p-6 flex flex-col md:flex-row items-center">
                <div class="md:w-1/4 flex justify-center mb-6 md:mb-0">
                    <img src="https://assets.nflxext.com/us/ffe/siteui/common/icons/nfLogo.png" alt="Netflix Premium" class="h-40 w-40 object-contain">
                </div>
                <div class="md:w-3/4 md:pl-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Netflix Premium</h1>
                    <div class="category-title mb-4">
                        <span class="text-sm text-gray-500">Streaming Apps</span>
                    </div>
                    <p class="text-gray-600 mb-4">
                        Enjoy unlimited access to movies, TV shows, and more on Netflix with our premium subscription plans.
                        Watch on multiple devices in Ultra HD quality.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <div class="flex items-center">
                            <i class="fas fa-check text-primary mr-2"></i>
                            <span class="text-sm">Ultra HD (4K) and HDR</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check text-primary mr-2"></i>
                            <span class="text-sm">Watch on multiple devices</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check text-primary mr-2"></i>
                            <span class="text-sm">Download titles to watch offline</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form method="post" action="" id="subscriptionForm">
            <!-- Subscription Options -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gray-900 category-title mb-6">Choose Your Plan</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php foreach ($plans as $planId => $plan): ?>
                            <div class="plan-card border rounded-lg p-5 <?php echo $selectedPlan === $planId ? 'selected' : 'border-gray-200'; ?>"
                                id="plan-card-<?php echo $planId; ?>">
                                <div class="flex items-start">
                                    <input type="radio" name="plan" id="plan_<?php echo $planId; ?>" value="<?php echo $planId; ?>"
                                        <?php echo $selectedPlan === $planId ? 'checked' : ''; ?>
                                        class="mt-1 mr-3 plan-radio">
                                    <div class="w-full">
                                        <label for="plan_<?php echo $planId; ?>" class="font-semibold text-gray-800 block cursor-pointer text-lg">
                                            <?php echo $plan['name']; ?>
                                        </label>
                                        <p class="text-sm text-gray-600 mt-1 mb-3"><?php echo $plan['description']; ?></p>

                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mt-4 duration-container" id="durations-<?php echo $planId; ?>">
                                            <?php foreach ($plan['durations'] as $durationId => $duration): ?>
                                                <div class="duration-option rounded-md p-3 flex justify-between items-center
                                                    <?php echo ($selectedPlan === $planId && $selectedDuration === $durationId) ? 'selected' : ''; ?>"
                                                    data-plan="<?php echo $planId; ?>" data-duration="<?php echo $durationId; ?>">
                                                    <input type="radio" name="duration" id="duration_<?php echo $planId; ?>_<?php echo $durationId; ?>"
                                                        value="<?php echo $durationId; ?>"
                                                        <?php echo ($selectedPlan === $planId && $selectedDuration === $durationId) ? 'checked' : ''; ?>
                                                        class="hidden duration-radio">
                                                    <span class="text-sm"><?php echo $duration['name']; ?></span>
                                                    <span class="font-semibold text-primary"><?php echo formatPrice($duration['price']); ?></span>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="mt-6">
                        <button type="submit" id="addToCartBtn"
                            class="w-full bg-primary hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-md transition duration-200 flex items-center justify-center <?php echo ($selectedPlan && $selectedDuration) ? '' : 'opacity-50 cursor-not-allowed'; ?>"
                            <?php echo ($selectedPlan && $selectedDuration) ? '' : 'disabled'; ?>>
                            <i class="fas fa-shopping-cart mr-2"></i> Add to Cart
                        </button>
                    </div>
                </div>
            </div>

            <input type="hidden" name="add_to_cart" value="1" id="addToCartInput">
        </form>
    </div>

    <!-- Success Modal -->
    <div class="modal <?php echo $addedToCart ? 'active' : ''; ?>" id="successModal">
        <div class="modal-content">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-900">Success!</h3>
                <button type="button" class="close-modal text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="mb-6">
                <div class="flex items-center justify-center mb-4">
                    <div class="bg-green-100 text-green-500 rounded-full p-3">
                        <i class="fas fa-check-circle text-3xl"></i>
                    </div>
                </div>
                <p class="text-center text-gray-700"><?php echo $cartMessage; ?></p>
                <?php if ($addedToCart && $selectedPlan && $selectedDuration): ?>
                    <p class="text-center text-gray-500 text-sm mt-2" id="planDetails">
                        <?php
                        echo $plans[$selectedPlan]['name'] . ' - ' .
                            $plans[$selectedPlan]['durations'][$selectedDuration]['name'] . ' (' .
                            formatPrice($plans[$selectedPlan]['durations'][$selectedDuration]['price']) . ')';
                        ?>
                    </p>
                <?php endif; ?>
            </div>
            <div class="flex justify-between">
                <button type="button" class="close-modal bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-md transition duration-200">
                    Continue Shopping
                </button>
                <a href="cart.php" class="bg-primary hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-200">
                    Go to Cart
                </a>
            </div>
        </div>
    </div>

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
        document.addEventListener('DOMContentLoaded', function() {
            const planCards = document.querySelectorAll('.plan-card');
            const planRadios = document.querySelectorAll('.plan-radio');
            const durationOptions = document.querySelectorAll('.duration-option');
            const durationContainers = document.querySelectorAll('.duration-container');
            const form = document.getElementById('subscriptionForm');
            const addToCartBtn = document.getElementById('addToCartBtn');
            const successModal = document.getElementById('successModal');
            const planDetailsElement = document.getElementById('planDetails');
            const closeModalButtons = document.querySelectorAll('.close-modal');

            // Initially hide all duration containers except for the selected plan
            updateDurationVisibility();

            // Handle plan selection
            planCards.forEach(card => {
                card.addEventListener('click', function() {
                    const planId = this.id.replace('plan-card-', '');
                    const planRadio = document.getElementById('plan_' + planId);

                    // Select the plan
                    planRadio.checked = true;

                    // Update UI for plans
                    planCards.forEach(c => c.classList.remove('selected'));
                    this.classList.add('selected');

                    // Show durations for this plan only
                    updateDurationVisibility();
                });
            });

            // Handle duration selection
            durationOptions.forEach(option => {
                option.addEventListener('click', function() {
                    const planId = this.dataset.plan;
                    const durationId = this.dataset.duration;
                    const durationRadio = document.getElementById('duration_' + planId + '_' + durationId);

                    // Make sure the plan is selected first
                    const planRadio = document.getElementById('plan_' + planId);
                    planRadio.checked = true;

                    // Update UI for plans
                    planCards.forEach(c => c.classList.remove('selected'));
                    document.getElementById('plan-card-' + planId).classList.add('selected');

                    // Deselect all durations across all plans
                    durationOptions.forEach(opt => {
                        opt.classList.remove('selected');
                        const radio = opt.querySelector('input[type="radio"]');
                        if (radio) radio.checked = false;
                    });

                    // Select this duration
                    durationRadio.checked = true;
                    this.classList.add('selected');

                    // Enable the Add to Cart button
                    addToCartBtn.disabled = false;
                    addToCartBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                });
            });

            // Close modal when close button is clicked
            closeModalButtons.forEach(button => {
                button.addEventListener('click', function() {
                    successModal.classList.remove('active');
                });
            });

            // Close modal when clicking outside
            successModal.addEventListener('click', function(e) {
                if (e.target === successModal) {
                    successModal.classList.remove('active');
                }
            });

            // Function to update which duration options are visible
            function updateDurationVisibility() {
                const selectedPlan = document.querySelector('input[name="plan"]:checked');

                if (selectedPlan) {
                    const planId = selectedPlan.value;

                    // Hide all duration containers
                    durationContainers.forEach(container => {
                        if (container.id === `durations-${planId}`) {
                            container.style.display = 'grid';
                        } else {
                            container.style.display = 'none';
                        }
                    });
                }
            }

            // If the modal is active on page load (PHP added the class), set a timeout to auto-hide it
            if (successModal.classList.contains('active')) {
                setTimeout(() => {
                    successModal.classList.remove('active');
                }, 5000); // Hide after 5 seconds
            }
        });
    </script>
</body>

</html>
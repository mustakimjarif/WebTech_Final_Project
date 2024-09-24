<?php
session_start();

// Temporarily disable this check for development
// if (!isset($_COOKIE['user'])) {
//     header("Location: login.php");
//     exit();
// }

// For testing purposes, you can manually set a user cookie
// Uncomment the line below to set a test user cookie
// setcookie('user', 'test@example.com', time() + 3600); // Set for 1 hour

$email = htmlspecialchars($_COOKIE['user'] ?? ''); // Use null coalescing to avoid undefined notice
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="dashboard.css">
    <style>
        /* Add your CSS styles for cart button here */
        .cart-button {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
        }
    </style>
    <script src="cart.js"></script> <!-- Include your cart.js -->
    <script>
        function showSection(sectionId) {
            const sections = document.querySelectorAll('.form-section');
            sections.forEach(section => {
                section.style.display = 'none';
            });
            document.getElementById(sectionId).style.display = 'block';
        }

        function viewCart() {
            // Retrieve cart data from localStorage
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            
            // Encode the cart data as a JSON string to pass through the URL
            const cartData = encodeURIComponent(JSON.stringify(cart));
            
            // Redirect to viewcart.php with cart data as a query parameter
            window.location.href = `viewcart.php?cart=${cartData}`;
        }


        function toggleEdit() {
            const profileForm = document.getElementById('profileForm');
            const editButton = document.getElementById('editButton');
            const inputs = profileForm.querySelectorAll('input');

            inputs.forEach(input => {
                input.readOnly = !input.readOnly; // Toggle readonly state
            });
            editButton.style.display = inputs[0].readOnly ? 'block' : 'none'; // Show/hide edit button
        }

        function addProductToCart(id, name, price) {
            const item = {
                id: id,
                name: name,
                price: price,
                quantity: 1 // Default quantity set to 1
            };
            addToCart(item);

        }
    </script>
</head>
<body>
    <header>
        <h4 class="para1">Dreamer.BD </h4>
        <p class="wishlist">Wishlist</p>
        <p class="user">Username</p>
        <p class="search1">Search</p>
        <input type="search" name="" id="" class="search">
        
    </header>

     

    <section>
        <nav>
            <ul>
                <li><a href="#home" onclick="showSection('home')">Home</a></li>
                <li><a href="adminLogin.php">Admin</a></li> 
                <li><a href="#profile" onclick="showSection('profile')">Profile</a></li>
                <li><a href="#cp" onclick="showSection('change-password')">Change Password</a></li>
                <li><a href="../controller/logoutAction.php">Logout</a></li>
                <li>
                <button class="cart-button" onclick="viewCart()">View Cart (<span id="cart-count">0</span>)</button>
                </li>
            </ul>
        </nav>

        <article>
            <!-- Home Section -->
            <div id="home" class="form-section active">
                <h1 id="main-heading">Home</h1>
                <p>Welcome to your dashboard! Feel free to explore and manage your profile.</p>
                <div style="
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                ">
                    <img src="./assets/1.png" alt="Product 1" onclick="addProductToCart('1', 'Product 1', 20)">
                    <img src="./assets/2.png" alt="Product 2" onclick="addProductToCart('2', 'Product 2', 30)">
                    <img src="./assets/3.png" alt="Product 3" onclick="addProductToCart('3', 'Product 3', 25)">
                    <img src="./assets/4.png" alt="Product 4" onclick="addProductToCart('4', 'Product 4', 15)">
                    <img src="./assets/5.png" alt="Product 5" onclick="addProductToCart('5', 'Product 5', 50)">
                    <img src="./assets/6.png" alt="Product 6" onclick="addProductToCart('6', 'Product 6', 40)">
                </div>
            </div>

            <!-- Admin Section -->
            <div id="admin" class="form-section" style="display: none;">
                <h1 id="main-heading">Admin Panel</h1>
                <p>Manage users, view reports, and perform administrative tasks here.</p>
            </div>

            <!-- Profile Section -->
            <div id="profile" class="form-section">
                <div class="header">
                    <h1 id="main-heading">Profile</h1>
                    <button id="editButton" class="edit-button" onclick="toggleEdit()">Edit Profile</button>
                </div>
                <form id="profileForm" action="../controller/updateProfileAction.php" method="POST" novalidate onsubmit="updateProfile(this)">
                    <div class="form-group">
                        <label for="user-id">User ID:</label>
                        <input type="text" id="user-id" value="" readonly>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" id="email" name="email" value="" readonly>
                        <span id="emailError" style="color: red; font-size: 12px; display: none;"><?php echo (empty($_SESSION['emailError']) ? "" : $_SESSION['emailError']); ?></span>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone:</label>
                        <input type="text" id="phone" name="phone" value="" readonly>
                        <span id="phoneError" style="color: red; font-size: 12px; display: none;"><?php echo (empty($_SESSION['phoneError']) ? "" : $_SESSION['phoneError']); ?></span>
                    </div>
                    <div class="form-group">
                        <label for="full-name">Full Name:</label>
                        <input type="text" id="full-name" name="full_name" value="" readonly>
                        <span id="nameError" style="color: red; font-size: 12px; display: none;"><?php echo (empty($_SESSION['nameError']) ? "" : $_SESSION['nameError']); ?></span>
                    </div>
                    <button type="submit" class="edit-button" id="saveButton" style="display: none;">Update Profile</button>
                </form>
            </div>

            <!-- Change Password Form -->
            <div id="change-password" class="form-section">
                <form id="changePasswordForm" action="../controller/changePassAction.php" method="POST" novalidate onsubmit="return changePassword(this)">
                    <p>Please enter your current and new password to change your password.</p>
                    <div class="form-group">
                        <label for="current-password">Current Password</label>
                        <input type="password" name="current_password" id="current-password" placeholder="Enter current password">
                        <span id="cCurrentpasserr" style="color: red; font-size: 12px; display: block; margin-bottom: 7px;"></span>
                    </div>
                    <div class="form-group">
                        <label for="new-password">New Password</label>
                        <input type="password" name="new_password" id="new-password" placeholder="Enter new password">
                        <span id="cNewpasserr" style="color: red; font-size: 12px; display: block; margin-bottom: 7px;"><?php echo (empty($_SESSION['change_pass_error']) ? "" : $_SESSION['change_pass_error']); ?></span>
                    </div>
                    <input type="submit" value="Change Password">
                </form>
            </div>
        </article>
    </section>

    <footer>
        <p>Welcome admin</p>
    </footer>

    <script src="cart.js"></script>
</body>
</html>

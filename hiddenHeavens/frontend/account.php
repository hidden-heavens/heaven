<?php
require 'php/db.php'; // Corrected path to db.php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start session to access user data
}

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Initialize session variables safely
$username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : '';
$email = isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : '';
$phone_number = isset($_SESSION['phone_number']) ? htmlspecialchars($_SESSION['phone_number']) : '';
$location = isset($_SESSION['location']) ? htmlspecialchars($_SESSION['location']) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account - HiddenHeavens</title>
    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="css/fontawesome/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'components/header.php'; ?>

<section class="page-title bg-holder bg-overlay-black-50" style="background: url(images/bg/02.jpg);">
    <div class="container">
        <div class="row align-items-center position-relative">
            <div class="col-lg-6">
                <h3 class="text-white mb-2">Account Settings</h3>
            </div>
        </div>
    </div>
</section>

<section class="space-ptb bg-light">
    <div class="container">
        <div class="row">
            <?php include 'components/sidebar.php'; ?>
            <!-- Main Content -->
            <div class="col-lg-9 col-md-8">
                <!-- General Information -->
                <h4 class="mb-4">Edit Profile</h4>
                <div class="sidebar mb-0">
                    <div class="widget">
                        <div class="widget-title">
                            <h6><i class="fas fa-user"></i> General Information:</h6>
                        </div>
                        <div class="widget-content">
                            <form method="POST" action="php/user/update-profile.php">
                                <div class="row">
                                    <div class="form-group mb-3 col-md-6">
                                        <label class="form-label">Username</label>
                                        <input type="text" class="form-control" name="username" value="<?php echo $username; ?>" required>
                                    </div>
                                    <div class="form-group mb-3 col-md-6">
                                        <label class="form-label">Email Address</label>
                                        <input type="email" class="form-control" value="<?php echo $email; ?>" readonly>
                                    </div>
                                    <div class="form-group mb-3 col-md-6">
                                        <label class="form-label">Phone Number</label>
                                        <input type="text" class="form-control" name="phone_number" value="<?php echo $phone_number; ?>">
                                    </div>
                                    <div class="form-group mb-3 col-md-6">
                                        <label class="form-label">Location</label>
                                        <input type="text" class="form-control" name="location" value="<?php echo $location; ?>">
                                    </div>
                                    <div class="form-group mb-3 col-12">
                                        <button class="btn btn-secondary" type="submit">Update Profile</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Change Password -->
                <div class="widget mt-5">
                    <div class="widget-title">
                        <h6><i class="fas fa-lock-open"></i> Change Password:</h6>
                    </div>
                    <div class="widget-content">
                        <form id="changePasswordForm" class="row align-items-end">
                            <div class="form-group mb-3 col-md-6">
                                <label class="form-label">Current Password</label>
                                <input type="password" class="form-control" name="current_password" placeholder="Current Password" required>
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <label class="form-label">New Password</label>
                                <input type="password" class="form-control" name="new_password" placeholder="New Password" required>
                            </div>
                            <div class="form-group mb-3 col-12">
                                <label class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" name="confirm_new_password" placeholder="Confirm New Password" required>
                            </div>
                            <div id="passwordChangeMessage" class="text-danger mb-3"></div>
                            <div class="form-group mb-3 col-12">
                                <button class="btn btn-secondary" type="submit">Change Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'components/footer.php'; ?>

<script src="js/jquery-3.6.0.min.js"></script>
<script src="js/bootstrap/bootstrap.min.js"></script>
<script src="js/custom.js"></script>

<script>
    document.querySelector('#changePasswordForm').addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent default form submission

        const formData = new FormData(this);

        fetch('php/user/change-password.php', {
            method: 'POST',
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                const messageElement = document.querySelector('#passwordChangeMessage');
                if (data.status === 'success') {
                    messageElement.textContent = data.message;
                    messageElement.classList.remove('text-danger');
                    messageElement.classList.add('text-success');
                    this.reset(); // Reset the form
                } else {
                    messageElement.textContent = data.message;
                    messageElement.classList.remove('text-success');
                    messageElement.classList.add('text-danger');
                }
            })
            .catch(error => {
                document.querySelector('#passwordChangeMessage').textContent = 'An error occurred. Please try again.';
                console.error(error);
            });
    });
</script>
</body>
</html>

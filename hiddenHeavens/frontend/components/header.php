<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>


<header class="header">
    <nav class="navbar navbar-static-top navbar-expand-lg header-sticky">
        <div class="container-fluid">
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target=".navbar-collapse">
                <i class="fas fa-align-left"></i>
            </button>
            <a class="navbar-brand" href="index.php">
                <img class="img-fluid" src="images/logo.svg" alt="logo">
            </a>
            <div class="navbar-collapse collapse justify-content-end">
                <ul class="nav navbar-nav">
                    <!-- Home -->
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home<i class="fas fa-home fa-xs"></i></a>
                    </li>

                    <!-- About Us -->
                    <li class="nav-item">
                        <a class="nav-link" href="about-us.php">About Us<i class="fas fa-info-circle fa-xs"></i></a>
                    </li>

                    <!-- Blog -->
                    <li class="nav-item">
                        <a class="nav-link" href="blog.php">Blog<i class="fas fa-blog fa-xs"></i></a>
                    </li>

                    <!-- Contact Us -->
                    <li class="nav-item">
                        <a class="nav-link" href="contact-us.php">Contact Us<i class="fas fa-envelope fa-xs"></i></a>
                    </li>
                </ul>
            </div>

            <div class="call d-block d-md-flex align-items-center">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- Logged In: Display Username -->
                    <div class="dropdown">
                        <a class="btn btn-secondary dropdown-toggle text-white d-flex align-items-center" href="#" role="button" id="accountDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-user-circle text-primary me-2"></i><?php echo htmlspecialchars($_SESSION['username']); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown">
                            <li><a class="dropdown-item" href="account.php">Account Settings</a></li>
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <!-- Not Logged In: Sign In Button -->
                    <div class="login d-inline-block me-4">
                        <a class="text-white" href="login.php">
                            <i class="fa fa-user pe-2 text-primary"></i>Sign In
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</header>

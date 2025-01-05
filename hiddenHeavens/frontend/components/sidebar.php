<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userType = $_SESSION['user_type']; // Get the user type from the session
?>
<div class="col-lg-3 col-md-4">
    <div class="sidebar">
        <div class="widget">
            <div class="widget-title">
                <h6><i class="fas fa-home"></i> Main</h6>
            </div>
            <div class="widget-content dashboard-nav">
                <ul class="list-unstyled">
                    <!-- Visible to all users -->
                    <li><a href="account.php"><i class="far fa-user me-2"></i> My Profile</a></li>
                    <li><a href="bookmark.php"><i class="far fa-bookmark me-2"></i> Bookmarks</a></li>
                    <li><a href="reviews.php"><i class="far fa-star me-2"></i> Reviews</a></li>
                </ul>
                <?php if ($userType === 'listing'): ?>
                    <h5 class="mb-4 mt-5">Listings</h5>
                    <ul class="list-unstyled">
                        <li><a href="dashboard.php"><i class="fas fa-home me-2"></i> Dashboard</a></li>
                        <li><a href="add-listing.php"><i class="far fa-edit me-2"></i> Add Listing</a></li>
                        <li><a href="my-listings.php"><i class="fas fa-list-ul me-2"></i> My Listings</a></li>
                        <li><a href="invoice-listing.php"><i class="fas fa-file-invoice me-2"></i> Invoice Listing</a></li>
                    </ul>
                <?php endif; ?>
                <a class="btn btn-secondary btn-sm mt-2" href="logout.php">Logout</a>
            </div>
        </div>
    </div>
</div>


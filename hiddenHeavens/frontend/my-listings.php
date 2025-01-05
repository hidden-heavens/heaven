<?php
// my-listings.php

session_start();
require 'php/db.php'; // Adjust the path if necessary

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];

// Fetch user listings from the database
try {
    $stmt = $pdo->prepare("
        SELECT 
            listings.*, 
            categories.name AS category_name,
            ISNULL(rating_avg.avg_rating, 0) AS rating,
            ISNULL(rating_avg.rating_count, 0) AS rating_count
        FROM listings
        JOIN categories ON listings.category_id = categories.id
        LEFT JOIN (
            SELECT listing_id, AVG(rating) AS avg_rating, COUNT(id) AS rating_count
            FROM reviews
            GROUP BY listing_id
        ) AS rating_avg ON listings.id = rating_avg.listing_id
        WHERE listings.user_id = ?
        ORDER BY listings.created_at DESC
    ");
    $stmt->execute([$userId]);
    $listings = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Failed to fetch listings: " . htmlspecialchars($e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Listings - HiddenHeavens</title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="images/favicon.ico">
    
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS Global Compulsory (Do not remove)-->
    <link rel="stylesheet" href="css/fontawesome/all.min.css">
    <link rel="stylesheet" href="css/flaticon/flaticon.css">
    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
    
    <!-- Page CSS Implementing Plugins -->
    <link rel="stylesheet" href="css/magnific-popup/magnific-popup.css">
    
    <!-- Template Style -->
    <link rel="stylesheet" href="css/style.css">
    
    <style>
        /* Custom Styles for My Listings */
        .listing-item {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
            background-color: #fff;
            transition: box-shadow 0.3s ease;
        }
        .listing-item:hover {
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .listing-image img {
            width: 100%;
            height: auto;
        }
        .listing-details {
            padding: 15px;
        }
        .listing-title a {
            color: #333;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .listing-title a:hover {
            color: #007bff;
        }
        .listing-rating .fa-star,
        .listing-rating .fa-star-half-alt {
            color: #ffc107;
        }
        .listing-call i {
            margin-right: 5px;
            color: #28a745;
        }
        .listing-location i {
            margin-right: 5px;
            color: #17a2b8;
        }
        .remove-listing-btn {
            background: none;
            border: none;
            color: #dc3545;
            cursor: pointer;
        }
        .remove-listing-btn:hover {
            color: #a71d2a;
        }
    </style>
</head>
<body>

<?php include 'components/header.php'; ?>

<!-- Page Title Section -->
<section class="page-title bg-holder bg-overlay-black-50" style="background: url(images/bg/02.jpg);">
    <div class="container">
        <div class="row align-items-center position-relative">
            <div class="col-lg-6">
                <h3 class="text-white mb-2">My Listings</h3>
            </div>
        </div>
    </div>
</section>
<!-- End of Page Title Section -->

<!-- My Listings Section -->
<section class="space-ptb bg-light">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 col-md-4">
                <?php include 'components/sidebar.php'; ?>
            </div>
            <!-- End of Sidebar -->

            <!-- Main Content -->
            <div class="col-lg-9 col-md-8">
                <h4 class="mb-4">Your Listings</h4>
                <div class="sidebar mb-0">
                    <div class="widget mb-0">
                        <div class="widget-title">
                            <h6><i class="fas fa-list-ul"></i> Active Listings:</h6>
                        </div>
                        <div class="widget-content">
                            <?php if (isset($error)): ?>
                                <div class="alert alert-danger">
                                    <?php echo $error; ?>
                                </div>
                            <?php endif; ?>

                            <?php if (empty($listings)): ?>
                                <p>You have no listings yet. <a href="dashboard-add-listing.html">Add a new listing</a>.</p>
                            <?php else: ?>
                                <?php foreach ($listings as $listing): ?>
                                    <div class="listing-item listing-list mb-4" id="listing-<?php echo htmlspecialchars($listing['id']); ?>">
                                        <div class="row g-0">
                                            <!-- Listing Image -->
                                            <div class="col-lg-4 col-md-5">
                                                <div class="listing-image bg-overlay-half-top h-100">
                                                    <?php
                                                        // Handle Thumbnail
                                                        $thumbnail = !empty($listing['thumbnail']) ? $listing['thumbnail'] : 'images/listing/default-thumbnail.jpg';
                                                    ?>
                                                    <img class="img-fluid" src="<?php echo htmlspecialchars($thumbnail); ?>" alt="<?php echo htmlspecialchars($listing['title'] ?? 'No Title'); ?>">
                                                    <div class="listing-quick-box">
                                                        <a class="category" href="#"> <i class="flaticon-megaphone"></i> <?php echo htmlspecialchars($listing['category_name'] ?? 'Uncategorized'); ?></a>
                                                        <a class="popup popup-single" href="<?php echo htmlspecialchars($thumbnail); ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Zoom"> <i class="fas fa-search-plus"></i> </a>
                                                        <button class="like remove-listing-btn" data-listing-id="<?php echo htmlspecialchars($listing['id']); ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Listing"> <i class="fas fa-trash-alt text-danger"></i> </button>
                                                    </div>
                                                    <div class="listing-info">
                                                        <?php
                                                            // Handle Brand Logo
                                                            $galleryImages = json_decode($listing['gallery'], true);
                                                            $brandLogo = (!empty($galleryImages) && isset($galleryImages[0])) ? $galleryImages[0] : 'images/listing/default-brand-logo.jpg';
                                                        ?>
                                                        <img class="img-fluid" src="<?php echo htmlspecialchars($brandLogo); ?>" alt="Brand Logo">
                                                        <div class="info-content">
                                                            <p class="mb-0"><?php echo htmlspecialchars(getUsernameById($listing['user_id'], $pdo)); ?></p>
                                                            <div class="listing-rating">
                                                                <span class="stars-wrapper">
                                                                    <?php
                                                                        // Handle Rating
                                                                        $rating = isset($listing['rating']) ? (int)$listing['rating'] : 0;
                                                                        for ($i = 0; $i < 5; $i++):
                                                                    ?>
                                                                        <i class="fas fa-star<?php echo ($i < $rating ? '' : '-half-alt'); ?>"></i>
                                                                    <?php endfor; ?>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End of Listing Image -->

                                            <!-- Listing Details -->
                                            <div class="col-lg-8 col-md-7">
                                                <div class="listing-details h-100">
                                                    <div class="listing-details-inner">
                                                        <div class="listing-title d-flex align-items-center">
                                                            <h6 class="mb-0"><a href="listing-single.php?id=<?php echo htmlspecialchars($listing['id']); ?>"><?php echo htmlspecialchars($listing['title'] ?? 'No Title'); ?></a></h6>
                                                            <div class="ms-auto">
                                                                <a class="btn btn-light btn-sm px-3 me-2" href="dashboard-edit-listing.php?id=<?php echo htmlspecialchars($listing['id']); ?>" data-bs-toggle="tooltip" title="Edit Listing">
                                                                    <i class="far fa-edit"></i>
                                                                </a>
                                                                <button class="btn btn-danger btn-sm px-3 remove-listing-btn" data-listing-id="<?php echo htmlspecialchars($listing['id']); ?>" data-bs-toggle="tooltip" title="Delete Listing">
                                                                    <i class="far fa-trash-alt"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <p class="my-2"><?php echo htmlspecialchars(substr($listing['description'] ?? 'No Description', 0, 100)); ?>...</p>
                                                        <div class="listing-rating-call">
                                                            <a class="listing-rating" href="#"><span class="me-1"><?php echo htmlspecialchars(number_format($listing['rating'], 1)); ?></span> <?php echo htmlspecialchars($listing['rating_count']); ?> Rating<?php echo ($listing['rating_count'] > 1) ? 's' : ''; ?></a>
                                                            <a class="listing-call" href="tel:<?php echo htmlspecialchars($listing['phone_number'] ?? '+000000000'); ?>"><i class="fas fa-phone-volume"></i> <?php echo htmlspecialchars($listing['phone_number'] ?? '+000 000 000'); ?></a>
                                                        </div>
                                                    </div>
                                                    <div class="listing-bottom">
                                                        <a class="listing-location" href="#"> <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($listing['address'] ?? 'No Address'); ?></a>
                                                        <span class="listing-status <?php echo (strtolower($listing['status']) === 'open') ? 'text-success' : 'text-danger'; ?>">
                                                            <?php echo htmlspecialchars($listing['status'] ?? 'Unknown'); ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End of Listing Details -->
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End of My Listings Section -->

<?php include 'components/footer.php'; ?>

<!--=================================
Back To Top-->

<div id="back-to-top" class="back-to-top">
    <a href="#"> <i class="fas fa-angle-up"></i></a>
</div>

<!--=================================
Back To Top-->

<!--=================================
Javascript -->

<!-- JS Global Compulsory (Do not remove)-->
<script src="js/jquery-3.6.0.min.js"></script>
<script src="js/popper/popper.min.js"></script>
<script src="js/bootstrap/bootstrap.min.js"></script>

<!-- Page JS Implementing Plugins -->
<script src="js/magnific-popup/jquery.magnific-popup.min.js"></script>

<!-- Template Scripts (Do not remove)-->
<script src="js/custom.js"></script>

<!-- Custom JS for Removing Listings -->
<script>
$(document).ready(function(){
    $('.remove-listing-btn').click(function(e){
        e.preventDefault();
        var listingId = $(this).data('listing-id');
        var listingElement = $('#listing-' + listingId);

        if(confirm('Are you sure you want to delete this listing?')) {
            $.ajax({
                url: 'php/listings/delete-listing.php',
                type: 'POST',
                data: { id: listingId },
                success: function(response){
                    if(response.status === 'success'){
                        listingElement.fadeOut(500, function(){
                            $(this).remove();
                        });
                        alert('Listing deleted successfully.');
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(){
                    alert('An error occurred while deleting the listing.');
                }
            });
        }
    });
});
</script>

</body>
</html>

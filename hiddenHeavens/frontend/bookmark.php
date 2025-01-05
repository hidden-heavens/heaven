<?php
// bookmark.php

require 'php/db.php'; // Adjust the path if necessary
session_start();

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];

// Fetch user bookmarks from the database
try {
    $stmt = $pdo->prepare("
        SELECT 
            listings.*, 
            categories.name AS category_name,
            ISNULL(rating_avg.avg_rating, 0) AS rating
        FROM bookmarks
        JOIN listings ON bookmarks.listing_id = listings.id
        JOIN categories ON listings.category_id = categories.id
        LEFT JOIN (
            SELECT listing_id, AVG(rating) AS avg_rating
            FROM reviews
            GROUP BY listing_id
        ) AS rating_avg ON listings.id = rating_avg.listing_id
        WHERE bookmarks.user_id = ?
        ORDER BY bookmarks.created_at DESC
    ");
    $stmt->execute([$userId]);
    $bookmarks = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Handle database errors gracefully
    $error = "Failed to fetch bookmarks: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookmarks - HiddenHeavens</title>
    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="css/fontawesome/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Optional: Custom styles for bookmarks */
        .bookmark-btn.bookmarked {
            color: #dc3545; /* Bootstrap danger color */
        }
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
        .remove-bookmark-btn {
            background: none;
            border: none;
            color: #dc3545;
            cursor: pointer;
        }
        .remove-bookmark-btn:hover {
            color: #a71d2a;
        }
    </style>
</head>
<body>

<?php include 'components/header.php'; ?>

<section class="page-title bg-holder bg-overlay-black-50" style="background: url(images/bg/02.jpg);">
    <div class="container">
        <div class="row align-items-center position-relative">
            <div class="col-lg-6">
                <h3 class="text-white mb-2">My Bookmarks</h3>
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
                <h4 class="mb-4">Your Bookmarked Listings</h4>
                <div class="sidebar mb-0">
                    <div class="widget mb-0">
                        <div class="widget-title">
                            <h6><i class="fas fa-bookmark"></i> Bookmarked Listings</h6>
                        </div>
                        <div class="widget-content">
                            <?php if (isset($error)): ?>
                                <div class="alert alert-danger">
                                    <?php echo htmlspecialchars($error); ?>
                                </div>
                            <?php endif; ?>

                            <?php if (empty($bookmarks)): ?>
                                <p>You have no bookmarks yet.</p>
                            <?php else: ?>
                                <?php foreach ($bookmarks as $listing): ?>
                                    <div class="listing-item listing-list mb-4" id="listing-<?php echo htmlspecialchars($listing['id']); ?>">
                                        <div class="row g-0">
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
                                                        <button class="like remove-bookmark-btn" data-listing-id="<?php echo htmlspecialchars($listing['id']); ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove Bookmark"> <i class="fas fa-heart text-danger"></i> </button>
                                                    </div>
                                                    <div class="listing-info">
                                                        <?php
                                                            // Handle Gallery Images
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
                                            <div class="col-lg-8 col-md-7">
                                                <div class="listing-details h-100">
                                                    <div class="listing-details-inner">
                                                        <div class="listing-title d-flex align-items-center">
                                                            <h6 class="mb-0"><a href="listing-single.php?id=<?php echo htmlspecialchars($listing['id']); ?>"><?php echo htmlspecialchars($listing['title'] ?? 'No Title'); ?></a></h6>
                                                            <button class="btn btn-danger btn-sm px-3 ms-auto remove-bookmark-btn" data-listing-id="<?php echo htmlspecialchars($listing['id']); ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove Bookmark">
                                                                <i class="far fa-trash-alt pe-0"></i>
                                                            </button>
                                                        </div>
                                                        <p class="my-2"><?php echo htmlspecialchars(substr($listing['description'] ?? 'No Description', 0, 100)); ?>...</p>
                                                        <div class="listing-rating-call">
                                                            <a class="listing-rating" href="#">
                                                                <span class="me-1"><?php echo htmlspecialchars($rating); ?></span> <?php echo htmlspecialchars(getRatingCount($listing['id'], $pdo)); ?> Rating
                                                            </a>
                                                            <a class="listing-call" href="#">
                                                                <i class="fas fa-phone-volume"></i> <?php echo htmlspecialchars($listing['phone_number'] ?? '+000 000 000'); ?>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="listing-bottom">
                                                        <a class="listing-location" href="#"> <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($listing['address'] ?? 'No Address'); ?></a>
                                                        <span class="listing-status"><?php echo htmlspecialchars($listing['status'] ?? 'Open'); ?></span>
                                                    </div>
                                                </div>
                                            </div>
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

<?php include 'components/footer.php'; ?>

<!-- Include JavaScript Files -->
<script src="js/bootstrap/bootstrap.min.js"></script>
<script src="js/bookmark.js"></script> <!-- Your custom JS for bookmarks -->
</body>
</html>

<?php
// Helper function to get username by user ID
function getUsernameById($userId, $pdo) {
    try {
        $stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ? $user['username'] : 'Unknown User';
    } catch (PDOException $e) {
        return 'Unknown User';
    }
}

// Helper function to get rating count for a listing
function getRatingCount($listingId, $pdo) {
    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) AS count FROM reviews WHERE listing_id = ?");
        $stmt->execute([$listingId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['count'] : 0;
    } catch (PDOException $e) {
        return 0;
    }
}
?>

<?php
// reviews.php

session_start();
require 'php/db.php'; // Adjust the path if necessary
require 'php/functions.php'; // Include helper functions

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];

// Fetch Visitor Reviews (Reviews others have left for your listings)
try {
    $stmtVisitor = $pdo->prepare("
        SELECT 
            reviews.id,
            reviews.rating,
            reviews.comment,
            reviews.created_at,
            listings.title AS listing_title,
            users.username AS reviewer_username
        FROM reviews
        JOIN listings ON reviews.listing_id = listings.id
        JOIN users ON reviews.user_id = users.id
        WHERE listings.user_id = ?
        ORDER BY reviews.created_at DESC
    ");
    $stmtVisitor->execute([$userId]);
    $visitorReviews = $stmtVisitor->fetchAll();
} catch (PDOException $e) {
    $errorVisitor = "Failed to fetch visitor reviews: " . htmlspecialchars($e->getMessage());
}

// Fetch Your Reviews (Reviews you have left for others' listings)
try {
    $stmtYour = $pdo->prepare("
        SELECT 
            reviews.id,
            reviews.rating,
            reviews.comment,
            reviews.created_at,
            listings.title AS listing_title,
            users.username AS reviewed_username
        FROM reviews
        JOIN listings ON reviews.listing_id = listings.id
        JOIN users ON listings.user_id = users.id
        WHERE reviews.user_id = ?
        ORDER BY reviews.created_at DESC
    ");
    $stmtYour->execute([$userId]);
    $yourReviews = $stmtYour->fetchAll();
} catch (PDOException $e) {
    $errorYour = "Failed to fetch your reviews: " . htmlspecialchars($e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews - HiddenHeavens</title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="images/favicon.ico">
    
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS Global Compulsory (Do not remove)-->
    <link rel="stylesheet" href="css/fontawesome/all.min.css">
    <link rel="stylesheet" href="css/flaticon/flaticon.css">
    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
    
    <!-- Template Style -->
    <link rel="stylesheet" href="css/style.css">
    
    <style>
        /* Custom Styles for Reviews */
        .review-item {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            background-color: #fff;
            margin-bottom: 20px;
            transition: box-shadow 0.3s ease;
        }
        .review-item:hover {
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .review-avatar img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 50%;
        }
        .review-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .review-rating .fa-star,
        .review-rating .fa-star-half-alt {
            color: #ffc107;
        }
        .edit-review-btn,
        .delete-review-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: #dc3545;
        }
        .edit-review-btn:hover,
        .delete-review-btn:hover {
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
                <h3 class="text-white mb-2">Reviews</h3>
            </div>
        </div>
    </div>
</section>
<!-- End of Page Title Section -->

<!-- Reviews Section -->
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
                <h4 class="mb-4">Visitor Reviews</h4>
                <div class="widget mb-5">
                    <div class="widget-title">
                        <h6><i class="fas fa-inbox"></i> Visitor Reviews</h6>
                    </div>
                    <div class="widget-content">
                        <?php if (isset($errorVisitor)): ?>
                            <div class="alert alert-danger">
                                <?php echo $errorVisitor; ?>
                            </div>
                        <?php endif; ?>

                        <?php if (empty($visitorReviews)): ?>
                            <p>No visitor reviews yet.</p>
                        <?php else: ?>
                            <?php foreach ($visitorReviews as $review): ?>
                                <div class="review-item">
                                    <div class="review-header">
                                        <div class="d-flex align-items-center">
                                            <div class="review-avatar me-3">
                                                <img src="images/avatar/default-avatar.png" alt="Reviewer Avatar">
                                            </div>
                                            <div>
                                                <h6 class="mb-0"><?php echo htmlspecialchars($review['reviewer_username']); ?></h6>
                                                <small class="text-muted"><?php echo date("F j, Y, g:i a", strtotime($review['created_at'])); ?></small>
                                            </div>
                                        </div>
                                        <div class="review-rating">
                                            <?php
                                                $rating = (int)$review['rating'];
                                                for ($i = 0; $i < 5; $i++) {
                                                    if ($i < $rating) {
                                                        echo '<i class="fas fa-star"></i>';
                                                    } else {
                                                        echo '<i class="far fa-star"></i>';
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <p class="mt-3"><?php echo htmlspecialchars($review['comment']); ?></p>
                                    <div class="d-flex">
                                        <a class="btn btn-sm btn-primary" href="listing-single.php?id=<?php echo htmlspecialchars($review['listing_id']); ?>">View Listing</a>
                                        <!-- Add Reply functionality here if needed -->
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <h4 class="mb-4">Your Reviews</h4>
                <div class="widget mb-0">
                    <div class="widget-title">
                        <h6><i class="far fa-star"></i> Your Reviews</h6>
                    </div>
                    <div class="widget-content">
                        <?php if (isset($errorYour)): ?>
                            <div class="alert alert-danger">
                                <?php echo $errorYour; ?>
                            </div>
                        <?php endif; ?>

                        <?php if (empty($yourReviews)): ?>
                            <p>You have not left any reviews yet.</p>
                        <?php else: ?>
                            <?php foreach ($yourReviews as $review): ?>
                                <div class="review-item" id="review-<?php echo htmlspecialchars($review['id']); ?>">
                                    <div class="review-header">
                                        <div class="d-flex align-items-center">
                                            <div class="review-avatar me-3">
                                                <img src="images/avatar/default-avatar.png" alt="Reviewed User Avatar">
                                            </div>
                                            <div>
                                                <h6 class="mb-0"><?php echo htmlspecialchars($review['reviewed_username']); ?></h6>
                                                <small class="text-muted"><?php echo date("F j, Y, g:i a", strtotime($review['created_at'])); ?></small>
                                            </div>
                                        </div>
                                        <div>
                                            <button class="edit-review-btn me-2" data-review-id="<?php echo htmlspecialchars($review['id']); ?>" data-bs-toggle="tooltip" title="Edit Review">
                                                <i class="far fa-edit"></i>
                                            </button>
                                            <button class="delete-review-btn" data-review-id="<?php echo htmlspecialchars($review['id']); ?>" data-bs-toggle="tooltip" title="Delete Review">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        </div>
                                        <!-- Edit Review Modal Trigger -->
                                        <button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#editReviewModal" style="display: none;" id="triggerEditModal-<?php echo htmlspecialchars($review['id']); ?>">
                                            Edit Review
                                        </button>
                                    </div>
                                    <p class="mt-3"><?php echo htmlspecialchars($review['comment']); ?></p>
                                    <div class="d-flex">
                                        <a class="btn btn-sm btn-primary" href="listing-single.php?id=<?php echo htmlspecialchars($review['listing_id']); ?>">View Listing</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <!-- End of Main Content -->
        </div>
    </div>
</section>
<!-- End of Reviews Section -->

<?php include 'components/footer.php'; ?>

<!--=================================
Back To Top-->

<div id="back-to-top" class="back-to-top">
    <a href="#"> <i class="fas fa-angle-up"></i></a>
</div>

<!--=================================
Back To Top-->

<!--=================================
Edit Review Modal -->
<div class="modal fade" id="editReviewModal" tabindex="-1" aria-labelledby="editReviewModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="editReviewForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Review</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="editReviewId" name="id">
            <div class="mb-3">
                <label for="editRating" class="form-label">Rating</label>
                <select class="form-select" id="editRating" name="rating" required>
                    <option value="">Select Rating</option>
                    <?php for ($i = 1; $i <=5; $i++): ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?> Star<?php echo ($i >1) ? 's' : ''; ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="editComment" class="form-label">Comment</label>
                <textarea class="form-control" id="editComment" name="comment" rows="4" required></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save Changes</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!--=================================
Edit Review Modal -->

<!--=================================
Javascript -->

<!-- JS Global Compulsory (Do not remove)-->
<script src="js/jquery-3.6.0.min.js"></script>
<script src="js/popper/popper.min.js"></script>
<script src="js/bootstrap/bootstrap.min.js"></script>

<!-- Template Scripts (Do not remove)-->
<script src="js/custom.js"></script>

<!-- Additional Scripts -->
<script>
$(document).ready(function(){
    // Initialize Bootstrap tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();

    // Handle Delete Review
    $('.delete-review-btn').click(function(e){
        e.preventDefault();
        var reviewId = $(this).data('review-id');
        var reviewElement = $('#review-' + reviewId);

        if(confirm('Are you sure you want to delete this review?')) {
            $.ajax({
                url: 'php/reviews/delete-review.php',
                type: 'POST',
                data: { id: reviewId },
                success: function(response){
                    if(response.status === 'success'){
                        reviewElement.fadeOut(500, function(){
                            $(this).remove();
                        });
                        alert('Review deleted successfully.');
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(){
                    alert('An error occurred while deleting the review.');
                }
            });
        }
    });

    // Handle Edit Review - Populate Modal
    $('.edit-review-btn').click(function(e){
        e.preventDefault();
        var reviewId = $(this).data('review-id');

        // Fetch review data via AJAX
        $.ajax({
            url: 'php/reviews/get-review.php',
            type: 'POST',
            data: { id: reviewId },
            success: function(response){
                if(response.status === 'success'){
                    $('#editReviewId').val(response.data.id);
                    $('#editRating').val(response.data.rating);
                    $('#editComment').val(response.data.comment);
                    $('#editReviewModal').modal('show');
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(){
                alert('An error occurred while fetching the review data.');
            }
        });
    });

    // Handle Edit Review Form Submission
    $('#editReviewForm').submit(function(e){
        e.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            url: 'php/reviews/edit-review.php',
            type: 'POST',
            data: formData,
            success: function(response){
                if(response.status === 'success'){
                    // Update the review in the DOM
                    var reviewId = response.data.id;
                    var reviewElement = $('#review-' + reviewId);
                    reviewElement.find('select[name="rating"]').val(response.data.rating);
                    reviewElement.find('p').text(response.data.comment);
                    
                    // Update rating stars
                    var starsHtml = '';
                    for(var i=1; i<=5; i++){
                        if(i <= response.data.rating){
                            starsHtml += '<i class="fas fa-star"></i>';
                        } else {
                            starsHtml += '<i class="far fa-star"></i>';
                        }
                    }
                    reviewElement.find('.review-rating').html(starsHtml);

                    $('#editReviewModal').modal('hide');
                    alert('Review updated successfully.');
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(){
                alert('An error occurred while updating the review.');
            }
        });
    });
});
</script>

</body>
</html>

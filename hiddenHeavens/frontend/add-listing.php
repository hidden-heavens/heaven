<?php
// add-listing.php

// Start session only if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require 'php/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="keywords" content="HTML5 Template">
  <meta name="description" content="Hidden Heavens - Add Listing">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Hidden Heavens - Add Listing</title>

  <!-- Favicon -->
  <link rel="shortcut icon" href="images/favicon.ico">

  <!-- Google Font -->
  <link
    href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap"
    rel="stylesheet"
  >

  <!-- CSS Global Compulsory -->
  <link rel="stylesheet" href="css/fontawesome/all.min.css">
  <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">

  <!-- Template Style -->
  <link rel="stylesheet" href="css/style.css">

  <!-- SweetAlert2 (for success/failure popups) -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    /* Basic styling for the custom tag search & chips UI */
    .tag-search-results {
      border: 1px solid #ccc;
      max-height: 150px;
      overflow-y: auto;
      display: none; /* hidden by default */
      background: #fff;
      margin-top: 5px;
      position: absolute;
      z-index: 999;
      width: 100%;
    }
    .tag-search-item {
      padding: 5px 10px;
      cursor: pointer;
    }
    .tag-search-item:hover {
      background: #f0f0f0;
    }
    .selected-tags-container {
      margin-top: 5px;
      display: flex;
      flex-wrap: wrap;
      gap: 5px;
    }
    .tag-chip {
      display: inline-flex;
      align-items: center;
      background: #007bff;
      color: #fff;
      padding: 3px 8px;
      border-radius: 15px;
      font-size: 0.85rem;
    }
    .tag-chip .remove-tag {
      margin-left: 5px;
      cursor: pointer;
      font-weight: bold;
    }
  </style>
</head>
<body>

  <?php include 'components/header.php'; ?>

  <section
    class="page-title bg-holder bg-overlay-black-50"
    style="background: url(images/bg/02.jpg);"
  >
    <div class="container">
      <div class="row align-items-center position-relative">
        <div class="col-lg-6">
          <h3 class="text-white mb-2">Add Listing</h3>
        </div>
      </div>
    </div>
  </section>

  <!--=================================
  Add Listings -->
  <section class="space-ptb bg-light">
    <div class="container">
      <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3 col-md-4">
          <?php include 'components/sidebar.php'; ?>
        </div>
        <!-- Main Content -->
        <div class="col-lg-9 col-md-8">
          <h4 class="mb-4">Add Listing</h4>
          <div class="sidebar mb-0">
            <div class="widget">
              <div class="widget-title">
                <h6><i class="far fa-address-book"></i> General Information:</h6>
              </div>
              <div class="widget-content">
                <?php
                  // Fetch tags from DB as an array
                  $tagsStmt = $pdo->query("SELECT id, name FROM tags WHERE category_type = 'food'");
                  $allTags = $tagsStmt->fetchAll(PDO::FETCH_ASSOC);

                  // Convert to JSON so JavaScript can do the search
                  $allTagsJson = json_encode($allTags);

                  // Prepare CSRF
                  $csrfToken = bin2hex(random_bytes(32));
                  $_SESSION['csrf_token'] = $csrfToken;
                ?>
                <!-- No action, no method: we do everything via JS fetch -->
                <form
                  id="addListingForm"
                  enctype="multipart/form-data"
                >
                  <!-- CSRF -->
                  <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">

                  <!-- Business Name -->
                  <div class="mb-3 col-lg-6">
                    <label class="form-label">Name</label>
                    <input
                      type="text"
                      class="form-control"
                      name="business_name"
                      placeholder="Business name"
                      required
                    >
                  </div>

                  <!-- Category -->
                  <div class="mb-3 col-lg-6 select-border">
                    <label class="form-label">Category*</label>
                    <select class="form-control" name="category_id" required>
                      <?php
                        $stmtCat = $pdo->query("SELECT id, name FROM categories WHERE type = 'food'");
                        while ($row = $stmtCat->fetch(PDO::FETCH_ASSOC)) {
                          echo '<option value="' . htmlspecialchars($row['id']) . '">'
                               . htmlspecialchars($row['name']) . '</option>';
                        }
                      ?>
                    </select>
                  </div>

                  <!-- TAGS: We'll do a custom search & selection UI -->
                  <div class="mb-3 col-lg-6" style="position: relative;">
                    <label class="form-label">Tags</label>
                    <input
                      type="text"
                      class="form-control"
                      id="tagSearchInput"
                      placeholder="Search tags..."
                      autocomplete="off"
                    >
                    <div id="tagSearchResults" class="tag-search-results"></div>
                    <div id="selectedTagsContainer" class="selected-tags-container"></div>
                    <!-- Hidden input that will contain selected tag IDs in JSON -->
                    <input type="hidden" name="tags" id="selectedTagsInput">
                  </div>

                  <!-- Description -->
                  <div class="col-12 mb-3">
                    <label class="form-label">Description</label>
                    <textarea
                      class="form-control"
                      rows="4"
                      name="description"
                      placeholder="Description"
                    ></textarea>
                  </div>

                  <!-- Location Section -->
                  <div class="widget mt-3 w-100">
                    <div class="widget-title">
                      <h6><i class="fas fa-map-marked-alt"></i> Location:</h6>
                    </div>
                    <div class="widget-content">
                      <button type="button" class="btn btn-secondary mb-3" id="autoDetectLocation">
                        Auto-detect My Location
                      </button>
                      <div class="row">
                        <div class="mb-3 col-md-12">
                          <label class="form-label">Street Address</label>
                          <input
                            type="text"
                            class="form-control"
                            id="street_address"
                            name="street_address"
                            placeholder="Street Address"
                            required
                          >
                        </div>
                        <div class="mb-3 col-md-12">
                          <label class="form-label">Province</label>
                          <input
                            type="text"
                            class="form-control"
                            id="province"
                            name="province"
                            placeholder="Province"
                            required
                          >
                        </div>
                        <div class="mb-3 col-md-12">
                          <label class="form-label">City</label>
                          <input
                            type="text"
                            class="form-control"
                            id="city"
                            name="city"
                            placeholder="City"
                            required
                          >
                        </div>
                        <div class="mb-3 col-md-6">
                          <label class="form-label">Postal Code</label>
                          <input
                            type="text"
                            class="form-control"
                            id="postal_code"
                            name="postal_code"
                            placeholder="Postal Code"
                            required
                          >
                        </div>
                        <div class="mb-3 col-md-6">
                          <label class="form-label">Longitude</label>
                          <!-- Not readonly, user can type or auto-detect -->
                          <input
                            type="text"
                            class="form-control"
                            id="longitude"
                            name="longitude"
                            placeholder="Longitude"
                            required
                          >
                        </div>
                        <div class="mb-3 col-md-6">
                          <label class="form-label">Latitude</label>
                          <!-- Not readonly, user can type or auto-detect -->
                          <input
                            type="text"
                            class="form-control"
                            id="latitude"
                            name="latitude"
                            placeholder="Latitude"
                            required
                          >
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Gallery Upload (multiple) -->
                  <div class="widget mt-3 w-100">
                    <div class="widget-title">
                      <h6><i class="fas fa-th"></i> Gallery:</h6>
                    </div>
                    <div class="widget-content">
                      <input
                        type="file"
                        name="gallery_images[]"
                        multiple
                        class="form-control"
                        accept="image/*"
                      >
                      <small class="text-muted">Select multiple images if needed</small>
                    </div>
                  </div>

                  <!-- PDF Menu Upload -->
                  <div class="widget mt-3 w-100">
                    <div class="widget-title">
                      <h6><i class="fas fa-file-pdf"></i> Upload Menu (PDF):</h6>
                    </div>
                    <div class="widget-content">
                      <input
                        type="file"
                        name="menu_pdf"
                        class="form-control"
                        accept="application/pdf"
                      >
                      <small class="text-muted">Upload your menu in PDF format</small>
                    </div>
                  </div>

                  <!-- Opening Hours -->
                  <div class="widget mt-3 w-100">
                    <div class="widget-title">
                      <h6><i class="far fa-clock"></i> Opening Hours:</h6>
                    </div>
                    <div class="widget-content">
                      <div class="row">
                        <?php 
                          $days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
                          foreach ($days as $day):
                            $dayLower = strtolower($day);
                        ?>
                          <div class="col-12">
                            <h6 class="font-md"><?= $day; ?>:</h6>
                          </div>
                          <!-- Opening Time -->
                          <div class="mb-3 col-md-6 select-border">
                            <label class="form-label">Opening Time</label>
                            <select
                              class="form-control opening-time"
                              name="opening_time[<?= $dayLower; ?>]"
                              data-day="<?= $dayLower; ?>"
                              required
                            >
                              <option value="Closed">Closed</option>
                              <?php for ($i = 1; $i <= 12; $i++): ?>
                                <option value="<?= $i; ?>:00 AM"><?= $i; ?>:00 AM</option>
                                <option value="<?= $i; ?>:30 AM"><?= $i; ?>:30 AM</option>
                              <?php endfor; ?>
                              <?php for ($i = 1; $i <= 12; $i++): ?>
                                <option value="<?= $i; ?>:00 PM"><?= $i; ?>:00 PM</option>
                                <option value="<?= $i; ?>:30 PM"><?= $i; ?>:30 PM</option>
                              <?php endfor; ?>
                            </select>
                          </div>

                          <!-- Closing Time -->
                          <div class="mb-3 col-md-6 select-border">
                            <label class="form-label">Closing Time</label>
                            <select
                              class="form-control closing-time"
                              name="closing_time[<?= $dayLower; ?>]"
                              data-day="<?= $dayLower; ?>"
                              required
                            >
                              <option value="Closed">Closed</option>
                              <?php for ($i = 1; $i <= 12; $i++): ?>
                                <option value="<?= $i; ?>:00 AM"><?= $i; ?>:00 AM</option>
                                <option value="<?= $i; ?>:30 AM"><?= $i; ?>:30 AM</option>
                              <?php endfor; ?>
                              <?php for ($i = 1; $i <= 12; $i++): ?>
                                <option value="<?= $i; ?>:00 PM"><?= $i; ?>:00 PM</option>
                                <option value="<?= $i; ?>:30 PM"><?= $i; ?>:30 PM</option>
                              <?php endfor; ?>
                            </select>
                          </div>
                        <?php endforeach; ?>
                      </div>
                    </div>
                  </div>

                  <!-- Pricing -->
                  <div class="widget mt-3 w-100">
                    <div class="widget-title">
                      <h6>Pricing:</h6>
                    </div>
                    <div class="widget-content">
                      <div class="row g-2 align-items-end">
                        <div class="mb-3 col-md-12">
                          <label class="form-label">Price Range (Per Person)</label>
                          <div class="input-group">
                            <span class="input-group-text">R</span>
                            <input
                              type="text"
                              class="form-control"
                              name="price_range"
                              placeholder="Enter price range (e.g., 50 - 150)"
                              required
                            >
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Facilities -->
                  <div class="widget mt-3 w-100">
                    <div class="widget-title">
                      <h6><i class="fas fa-users-cog"></i> Facility:</h6>
                    </div>
                    <div class="widget-content table-responsive">
                      <div class="d-flex flex-wrap">
                        <?php
                          $facilitiesList = [
                            'Event',
                            'Outdoor Seating',
                            'Street Parking',
                            'Instant Book',
                            'Smoking Allowed',
                            'Wheelchair Accessible',
                            'Free Wi-Fi',
                            'Pet-Friendly',
                            'Live Music',
                            'Halaal Options',
                            'Kosher Options'
                          ];
                          foreach ($facilitiesList as $index => $facility):
                        ?>
                          <div class="mb-3 me-3">
                            <div class="custom-control custom-checkbox">
                              <input
                                type="checkbox"
                                class="custom-control-input"
                                id="facility<?php echo $index; ?>"
                                name="facilities[]"
                                value="<?php echo htmlspecialchars($facility); ?>"
                              >
                              <label
                                class="custom-control-label"
                                for="facility<?php echo $index; ?>"
                              >
                                <?php echo htmlspecialchars($facility); ?>
                              </label>
                            </div>
                          </div>
                        <?php endforeach; ?>
                      </div>
                    </div>
                  </div>

                  <!-- Social Networks -->
                  <div class="widget mt-3 w-100">
                    <div class="widget-title">
                      <h6><i class="fas fa-share-alt"></i> Social Networks:</h6>
                    </div>
                    <div class="widget-content">
                      <div class="row align-items-end">
                        <div class="mb-3 col-md-6">
                          <label class="form-label">Facebook</label>
                          <input
                            type="text"
                            class="form-control"
                            name="facebook"
                            placeholder="Facebook"
                          >
                        </div>
                        <div class="mb-3 col-md-6">
                          <label class="form-label">Twitter</label>
                          <input
                            type="text"
                            class="form-control"
                            name="twitter"
                            placeholder="Twitter"
                          >
                        </div>
                        <div class="mb-3 col-md-6">
                          <label class="form-label">Pinterest</label>
                          <input
                            type="text"
                            class="form-control"
                            name="pinterest"
                            placeholder="Pinterest"
                          >
                        </div>
                        <div class="mb-3 col-md-6">
                          <label class="form-label">Instagram</label>
                          <input
                            type="text"
                            class="form-control"
                            name="instagram"
                            placeholder="Instagram"
                          >
                        </div>
                        <div class="mb-3 col-md-6">
                          <label class="form-label">TikTok</label>
                          <input
                            type="text"
                            class="form-control"
                            name="tiktok"
                            placeholder="Tiktok"
                          >
                        </div>
                        <!-- Removed the Save & Preview button -->
                      </div>
                    </div>
                  </div>

                  <!-- Final Save Button -->
                  <div class="widget mt-3 mb-0 w-100">
                    <div class="widget-content text-end">
                      <button
                        type="submit"
                        class="btn btn-success btn-lg"
                        id="saveAllButton"
                      >
                        <i class="fas fa-save me-2"></i> Save All Information
                      </button>
                    </div>
                  </div>
                </form><!-- End of Form -->

                <!-- We'll pass the tags JSON into a JS variable -->
                <script>
                  const allTags = <?php echo $allTagsJson; ?>;
                  const csrfToken = "<?php echo $csrfToken; ?>"; // Pass CSRF token to JS
                </script>
              </div><!-- widget-content -->
            </div><!-- widget -->
          </div><!-- sidebar mb-0 -->
        </div><!-- col-lg-9 -->
      </div><!-- row -->
    </div><!-- container -->
  </section>
  <!--=================================
  Add Listings -->

  <?php require 'components/footer.php'; ?>

  <!-- JS Global Compulsory -->
  <script src="js/popper/popper.min.js"></script>
  <script src="js/bootstrap/bootstrap.min.js"></script>
  <script src="js/bookmark.js"></script> <!-- Your custom JS for bookmarks -->
  <script src="js/add-listing.js"></script> <!-- Your custom JS for adding listings -->
</body>
</html>

<?php
// php/listings/save-listing.php

header('Content-Type: application/json');

// Hide direct PHP error messages, so we don't return HTML
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

// Enable error logging for debugging (optional but recommended)
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error_log.txt');

session_start();

require '../db.php';

$debug = [];

try {
    $debug[] = 'save-listing.php started';

    // Must be POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $debug[] = 'Not a POST request.';
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid request method.',
            'debug'   => $debug
        ]);
        exit;
    }
    $debug[] = 'POST request confirmed';

    // CSRF check
    if (
        !isset($_POST['csrf_token']) ||
        !isset($_SESSION['csrf_token']) ||
        $_POST['csrf_token'] !== $_SESSION['csrf_token']
    ) {
        $debug[] = 'CSRF mismatch.';
        echo json_encode([
            'status' => 'error',
            'message' => 'CSRF token mismatch or missing.',
            'debug'   => $debug
        ]);
        exit;
    }
    $debug[] = 'CSRF check passed';

    // Check user login
    $userId = $_SESSION['user_id'] ?? null;
    if (!$userId) {
        $debug[] = 'No user ID in session.';
        echo json_encode([
            'status'  => 'error',
            'message' => 'User not logged in.',
            'debug'   => $debug
        ]);
        exit;
    }
    $debug[] = "User ID: $userId";

    // Gather fields
    $businessName  = $_POST['business_name']   ?? '';
    $categoryId     = $_POST['category_id']        ?? null; // Changed from 'category' to 'category_id'
    $description   = $_POST['description']     ?? '';
    $streetAddress = $_POST['street_address']  ?? '';
    $province      = $_POST['province']        ?? '';
    $city          = $_POST['city']            ?? '';
    $postalCode    = $_POST['postal_code']     ?? '';
    $latitude      = $_POST['latitude']        ?? '';
    $longitude     = $_POST['longitude']       ?? '';
    $priceRange    = $_POST['price_range']     ?? '';

    $debug[] = 'Collected main form fields';

    // Facilities => array => JSON
    $facilities = $_POST['facilities'] ?? [];
    $facilitiesJson = json_encode($facilities);

    // Tags => from hidden input
    $tagsJson  = $_POST['tags'] ?? '[]';
    $tagsArray = json_decode($tagsJson, true);
    $debug[] = 'tagsArray: ' . print_r($tagsArray, true);
    if (!is_array($tagsArray)) {
        $tagsArray = [];
    }

    // Opening Hours
    $openingTimes = $_POST['opening_time'] ?? [];
    $closingTimes = $_POST['closing_time'] ?? [];
    $combinedHours = [];
    foreach ($openingTimes as $day => $openVal) {
        $closeVal = isset($closingTimes[$day]) ? $closingTimes[$day] : 'Closed';
        $combinedHours[$day] = [
            'open'  => $openVal,
            'close' => $closeVal
        ];
    }
    $openingHoursJson = json_encode($combinedHours);

    // Social links
    $socialFields = ['facebook', 'twitter', 'pinterest', 'instagram', 'tiktok'];
    $socialLinks  = [];
    foreach ($socialFields as $field) {
        if (!empty($_POST[$field])) {
            $socialLinks[$field] = $_POST[$field];
        }
    }
    $socialLinksJson = json_encode($socialLinks);

    // PDF limit 2MB
    if (!empty($_FILES['menu_pdf']['name'])) {
        $pdfSize = $_FILES['menu_pdf']['size'];
        if ($pdfSize > 2 * 1024 * 1024) {
            $debug[] = "PDF too large: $pdfSize bytes";
            echo json_encode([
                'status'  => 'error',
                'message' => 'PDF exceeds 2MB file-size limit.',
                'debug'   => $debug
            ]);
            exit;
        }
        $debug[] = "PDF size is $pdfSize bytes, OK.";
    }

    // Images total limit 5MB
    $imagesTotalSize = 0;
    if (!empty($_FILES['gallery_images']['name'][0])) {
        foreach ($_FILES['gallery_images']['size'] as $sz) {
            $imagesTotalSize += $sz;
        }
        if ($imagesTotalSize > 5 * 1024 * 1024) {
            $debug[] = "Images too large: $imagesTotalSize total bytes";
            echo json_encode([
                'status'  => 'error',
                'message' => 'Gallery images exceed 5MB total file-size limit.',
                'debug'   => $debug
            ]);
            exit;
        }
        $debug[] = "Images total size: $imagesTotalSize bytes, OK.";
    }

    // Define the absolute path for uploads
    $basePath = 'C:/Users/victo/OneDrive/Pictures/uploads';
    $debug[] = "Base path for uploads: $basePath";

    // Ensure the uploads directory exists
    if (!is_dir($basePath)) {
        if (!mkdir($basePath, 0777, true)) {
            $debug[] = "Failed to create directory: $basePath";
            echo json_encode([
                'status'  => 'error',
                'message' => "Failed to create directory for uploads.",
                'debug'   => $debug
            ]);
            exit;
        } else {
            $debug[] = "Created directory: $basePath";
        }
    } else {
        $debug[] = "Uploads directory exists: $basePath";
    }

    // Insert listing
    $debug[] = 'Inserting listing into DB...';
    $stmt = $pdo->prepare("
        INSERT INTO listings
            (user_id, title, category_id, tags, description, address,
             latitude, longitude, opening_hours, facilities,
             social_links, price_range, province, city, postal_code,
             created_at, menu_pdf, gallery)
        VALUES
            (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
             GETDATE(), NULL, NULL)
    ");
    $stmt->execute([
        $userId,
        $businessName,
        $categoryId, // Changed to category_id
        $tagsJson,
        $description,
        $streetAddress,
        $latitude,
        $longitude,
        $openingHoursJson,
        $facilitiesJson,
        $socialLinksJson,
        $priceRange,
        $province,
        $city,
        $postalCode
    ]);
    $listingId = $pdo->lastInsertId();
    $debug[] = "New listing ID: $listingId";

    // Handle gallery images
    $uploadedPaths = [];
    if (!empty($_FILES['gallery_images']['name'][0])) {
        foreach ($_FILES['gallery_images']['tmp_name'] as $i => $tmpName) {
            $originalName = $_FILES['gallery_images']['name'][$i];
            
            // Sanitize file name to prevent security issues
            $originalName = basename($originalName);
            $originalName = preg_replace("/[^A-Za-z0-9_\-\.]/", '_', $originalName);
            
            // Optional: Generate a unique file name to prevent collisions
            $uniqueName = uniqid() . '_' . $originalName;
            
            // Define the target path using the absolute base path
            $targetPath   = $basePath . '/' . $uniqueName;

            if (move_uploaded_file($tmpName, $targetPath)) {
                $uploadedPaths[] = $targetPath;
                $debug[] = "Moved image: $targetPath";

                // Insert into gallery table if desired
                $stmtG = $pdo->prepare("
                    INSERT INTO gallery (listing_id, image_url, created_at)
                    VALUES (?, ?, GETDATE())
                ");
                $stmtG->execute([$listingId, $targetPath]);
            } else {
                $debug[] = "Failed to move image: $originalName. Check if the uploads directory is writable.";
                error_log("Failed to move image: $originalName to $targetPath");
                echo json_encode([
                    'status'  => 'error',
                    'message' => "Failed to move image: $originalName.",
                    'debug'   => $debug
                ]);
                exit;
            }
        }
        // Also store them in listings.gallery
        if (!empty($uploadedPaths)) {
            $galleryJson = json_encode($uploadedPaths);
            $stmtGalleryUpdate = $pdo->prepare("
                UPDATE listings
                SET gallery = ?
                WHERE id = ?
            ");
            $stmtGalleryUpdate->execute([$galleryJson, $listingId]);
            $debug[] = 'Updated listings.gallery with JSON.';
        }
    } else {
        $debug[] = 'No images uploaded.';
    }

    // Handle PDF upload
    if (!empty($_FILES['menu_pdf']['name'])) {
        $pdfSize = $_FILES['menu_pdf']['size'];
        $pdfTmp  = $_FILES['menu_pdf']['tmp_name'];
        $pdfError = $_FILES['menu_pdf']['error'];
        $debug[] = "PDF upload details: size=$pdfSize, tmp_name=$pdfTmp, error=$pdfError";

        if ($pdfError !== UPLOAD_ERR_OK) {
            $errorMessage = match ($pdfError) {
                UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
                UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive specified in the HTML form.',
                UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded.',
                UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
                UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
                UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
                UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload.',
                default => 'Unknown upload error.',
            };
            $debug[] = "PDF upload error: $errorMessage";
            error_log("PDF upload error: $errorMessage");
            echo json_encode([
                'status'  => 'error',
                'message' => "PDF upload failed: $errorMessage",
                'debug'   => $debug
            ]);
            exit;
        }

        if ($pdfSize > 2 * 1024 * 1024) {
            $debug[] = "PDF too large: $pdfSize bytes";
            echo json_encode([
                'status'  => 'error',
                'message' => 'PDF exceeds 2MB file-size limit.',
                'debug'   => $debug
            ]);
            exit;
        }
        $debug[] = "PDF size is $pdfSize bytes, OK.";

        // Sanitize PDF file name
        $pdfName = basename($_FILES['menu_pdf']['name']);
        $pdfName = preg_replace("/[^A-Za-z0-9_\-\.]/", '_', $pdfName);
        $uniquePdfName = uniqid() . '_' . $pdfName;

        // Define the target path for PDF
        $pdfTargetPath = $basePath . '/' . $uniquePdfName;

        if (move_uploaded_file($pdfTmp, $pdfTargetPath)) {
            $debug[] = "Moved PDF: $pdfTargetPath";

            // Update listings.menu_pdf
            $stmtPdfUpdate = $pdo->prepare("
                UPDATE listings
                SET menu_pdf = ?
                WHERE id = ?
            ");
            $stmtPdfUpdate->execute([$pdfTargetPath, $listingId]);
            $debug[] = 'Updated listings.menu_pdf with PDF path.';
        } else {
            $debug[] = "Failed to move PDF: " . $_FILES['menu_pdf']['name'];
            error_log("Failed to move PDF: " . $_FILES['menu_pdf']['name'] . " to $pdfTargetPath");
            echo json_encode([
                'status'  => 'error',
                'message' => "Failed to move PDF: " . $_FILES['menu_pdf']['name'],
                'debug'   => $debug
            ]);
            exit;
        }
    } else {
        $debug[] = 'No PDF uploaded.';
    }

    // Insert tags in pivot
    foreach ($tagsArray as $tagIdStr) {
        $tagId = (int)$tagIdStr; // cast to int to avoid nvarchar->numeric issue
        if ($tagId > 0) {
            $stmtTag = $pdo->prepare("
                INSERT INTO listing_tags (listing_id, tag_id)
                VALUES (?, ?)
            ");
            $stmtTag->execute([$listingId, $tagId]);
            $debug[] = "Pivot: listing=$listingId, tag=$tagId";
        } else {
            $debug[] = "Skipping invalid tag: $tagIdStr";
        }
    }

    $debug[] = 'Done saving listing.';
    echo json_encode([
        'status'  => 'success',
        'message' => 'Listing saved successfully!',
        'debug'   => $debug
    ]);
    exit;

} catch (PDOException $e) {
    $debug[] = 'PDOException: ' . $e->getMessage();
    error_log("PDOException: " . $e->getMessage());
    echo json_encode([
        'status'  => 'error',
        'message' => 'SQL Error: ' . $e->getMessage(),
        'debug'   => $debug
    ]);
    exit;
} catch (Exception $ex) {
    $debug[] = 'Exception: ' . $ex->getMessage();
    error_log("Exception: " . $ex->getMessage());
    echo json_encode([
        'status'  => 'error',
        'message' => 'Error: ' . $ex->getMessage(),
        'debug'   => $debug
    ]);
    exit;
}
?>

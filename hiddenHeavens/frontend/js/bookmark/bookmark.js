// bookmark.js

document.addEventListener('DOMContentLoaded', function () {
    // Function to retrieve CSRF token (assuming it's available as a global JS variable)
    const csrfToken = typeof csrfToken !== 'undefined' ? csrfToken : '';

    // Function to handle bookmark removal
    function handleRemoveBookmark(event) {
        event.preventDefault();

        // Determine the button that was clicked
        const button = event.currentTarget;
        const listingId = button.getAttribute('data-listing-id');

        if (!listingId) {
            console.error('Listing ID not found.');
            return;
        }

        // Confirm the action with the user
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to remove this bookmark?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, remove it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Prepare the data to send
                const formData = new URLSearchParams();
                formData.append('listing_id', listingId);
                formData.append('csrf_token', csrfToken);

                // Send the POST request to remove the bookmark
                fetch('php/bookmarks/remove-bookmark.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: formData.toString(),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Remove the listing from the DOM
                        const listingElement = document.getElementById(`listing-${listingId}`);
                        if (listingElement) {
                            listingElement.remove();
                        }

                        // Display success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Removed!',
                            text: data.message,
                            timer: 2000,
                            showConfirmButton: false
                        });

                        // If no more bookmarks, display a message
                        const bookmarksContainer = document.querySelector('.widget-content');
                        if (bookmarksContainer && bookmarksContainer.children.length === 0) {
                            bookmarksContainer.innerHTML = '<p>You have no bookmarks yet.</p>';
                        }

                        // Update bookmark button on listings page if present
                        const bookmarkButtons = document.querySelectorAll(`.bookmark-btn[data-listing-id="${listingId}"]`);
                        bookmarkButtons.forEach(btn => {
                            btn.classList.remove('bookmarked');
                            btn.innerHTML = '<i class="fas fa-bookmark"></i> Bookmark';
                            btn.setAttribute('title', 'Add Bookmark');
                            btn.removeEventListener('click', handleRemoveBookmark);
                            btn.addEventListener('click', handleAddBookmark);
                        });

                    } else {
                        // Display error message
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message,
                        });
                    }
                })
                .catch(error => {
                    console.error('Error removing bookmark:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while removing the bookmark. Please try again.',
                    });
                });
            }
        });
    }

    // Function to handle bookmark addition
    function handleAddBookmark(event) {
        event.preventDefault();

        // Determine the button that was clicked
        const button = event.currentTarget;
        const listingId = button.getAttribute('data-listing-id');

        if (!listingId) {
            console.error('Listing ID not found.');
            return;
        }

        // Prepare the data to send
        const formData = new URLSearchParams();
        formData.append('listing_id', listingId);
        formData.append('csrf_token', csrfToken);

        // Send the POST request to add the bookmark
        fetch('php/bookmarks/add-bookmark.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: formData.toString(),
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Update the button to indicate it's bookmarked
                button.classList.add('bookmarked');
                button.innerHTML = '<i class="fas fa-bookmark text-primary"></i> Bookmarked';
                button.setAttribute('title', 'Remove Bookmark');

                // Display success message
                Swal.fire({
                    icon: 'success',
                    title: 'Bookmarked!',
                    text: data.message,
                    timer: 2000,
                    showConfirmButton: false
                });

                // Update bookmark button on bookmarks page if present
                const removeButtons = document.querySelectorAll(`.remove-bookmark-btn[data-listing-id="${listingId}"]`);
                removeButtons.forEach(btn => {
                    btn.setAttribute('title', 'Remove Bookmark');
                });

                // Change the event listener to handle removal if desired
                button.removeEventListener('click', handleAddBookmark);
                button.addEventListener('click', handleRemoveBookmark);

            } else {
                // Display error message
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message,
                });
            }
        })
        .catch(error => {
            console.error('Error adding bookmark:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while adding the bookmark. Please try again.',
            });
        });
    }

    // Attach event listeners to all remove bookmark buttons
    const removeButtons = document.querySelectorAll('.remove-bookmark-btn');
    removeButtons.forEach(button => {
        button.addEventListener('click', handleRemoveBookmark);
    });

    // Attach event listeners to all add bookmark buttons
    const addButtons = document.querySelectorAll('.bookmark-btn');
    addButtons.forEach(button => {
        // Check if already bookmarked
        if (button.classList.contains('bookmarked')) {
            // Already bookmarked, set up remove handler
            button.addEventListener('click', handleRemoveBookmark);
        } else {
            button.addEventListener('click', handleAddBookmark);
        }
    });
});

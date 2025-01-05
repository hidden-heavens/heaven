// js/listings/add-listing.js

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('addListingForm');
  
    // TAGS
    const tagSearchInput = document.getElementById('tagSearchInput');
    const tagSearchResults = document.getElementById('tagSearchResults');
    const selectedTagsContainer = document.getElementById('selectedTagsContainer');
    const selectedTagsInput = document.getElementById('selectedTagsInput');
  
    // We'll store selected tags as an array of {id, name}
    let selectedTags = [];
  
    // 1) TAG SEARCH
    if (tagSearchInput && tagSearchResults) {
      tagSearchInput.addEventListener('input', function () {
        const query = tagSearchInput.value.trim().toLowerCase();
        if (!query) {
          tagSearchResults.style.display = 'none';
          tagSearchResults.innerHTML = '';
          return;
        }
        const filtered = allTags.filter(t => t.name.toLowerCase().includes(query));
        if (filtered.length === 0) {
          tagSearchResults.style.display = 'none';
          tagSearchResults.innerHTML = '';
          return;
        }
        tagSearchResults.innerHTML = '';
        filtered.forEach(tag => {
          const isSelected = selectedTags.some(st => st.id === tag.id);
          if (!isSelected) {
            const div = document.createElement('div');
            div.classList.add('tag-search-item');
            div.textContent = tag.name;
            div.addEventListener('click', () => {
              selectedTags.push({ id: tag.id, name: tag.name });
              renderSelectedTags();
              tagSearchResults.style.display = 'none';
              tagSearchInput.value = '';
            });
            tagSearchResults.appendChild(div);
          }
        });
        tagSearchResults.style.display = 'block';
      });
  
      // Hide dropdown if user clicks outside
      document.addEventListener('click', function (e) {
        if (!tagSearchInput.contains(e.target) && !tagSearchResults.contains(e.target)) {
          tagSearchResults.style.display = 'none';
        }
      });
    }
  
    function renderSelectedTags() {
      selectedTagsContainer.innerHTML = '';
      selectedTags.forEach(tag => {
        const chip = document.createElement('div');
        chip.classList.add('tag-chip');
        chip.textContent = tag.name;
  
        const removeBtn = document.createElement('span');
        removeBtn.classList.add('remove-tag');
        removeBtn.textContent = '×';
        removeBtn.addEventListener('click', () => {
          selectedTags = selectedTags.filter(t => t.id !== tag.id);
          renderSelectedTags();
        });
        chip.appendChild(removeBtn);
  
        selectedTagsContainer.appendChild(chip);
      });
      // Hidden input: store JSON array of IDs
      const ids = selectedTags.map(t => t.id);
      selectedTagsInput.value = JSON.stringify(ids);
    }
  
    // 2) AUTO DETECT LOCATION
    const autoDetectLocationBtn = document.getElementById('autoDetectLocation');
    if (autoDetectLocationBtn) {
      autoDetectLocationBtn.addEventListener('click', function () {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(async function (pos) {
            const lat = pos.coords.latitude;
            const lng = pos.coords.longitude;
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
  
            // If you have a Google Geocoding API key
            try {
              const res = await fetch(`https://maps.googleapis.com/maps/api/geocode/json?latlng=${lat},${lng}&key=YOUR_GOOGLE_MAPS_API_KEY`);
              const data = await res.json();
              if (data.status === 'OK') {
                const comps = data.results[0].address_components;
                const getComp = (type) => comps.find(c => c.types.includes(type))?.long_name || '';
                document.getElementById('street_address').value = getComp('route') + ' ' + getComp('street_number');
                document.getElementById('city').value = getComp('locality');
                document.getElementById('province').value = getComp('administrative_area_level_1');
                document.getElementById('postal_code').value = getComp('postal_code');
              }
            } catch (err) {
              console.error('Geocoding error:', err);
            }
          }, function (error) {
            Swal.fire('Error', 'Unable to retrieve location. Please enter manually.', 'error');
          });
        } else {
          Swal.fire('Error', 'Geolocation not supported.', 'error');
        }
      });
    }
  
    // 3) DISABLE CLOSING TIME IF OPENING == "Closed"
    const openingTimeEls = document.querySelectorAll('.opening-time');
    openingTimeEls.forEach(openEl => {
      openEl.addEventListener('change', function() {
        const day = openEl.dataset.day;
        const closeEl = document.querySelector(`.closing-time[data-day="${day}"]`);
        if (openEl.value === 'Closed') {
          closeEl.value = 'Closed';
          closeEl.disabled = true;
        } else {
          closeEl.disabled = false;
          if (closeEl.value === 'Closed') {
            closeEl.value = '1:00 AM';
          }
        }
      });
      // On page load
      if (openEl.value === 'Closed') {
        const day = openEl.dataset.day;
        const closeEl = document.querySelector(`.closing-time[data-day="${day}"]`);
        closeEl.value = 'Closed';
        closeEl.disabled = true;
      }
    });
  
    // 4) INTERCEPT FORM SUBMISSION, SINGLE FETCH
    if (form) {
      form.addEventListener('submit', function (e) {
        e.preventDefault(); // Stop normal submission
  
        const formData = new FormData(form);
  
        fetch('php/listings/save-listing.php', {
          method: 'POST',
          body: formData
        })
        .then(res => res.json())
        .then(data => {
          if (data.status === 'success') {
            // Show success, but do NOT redirect
            Swal.fire({
              icon: 'success',
              title: 'Listing Saved',
              text: data.message,
              confirmButtonText: 'OK'
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: data.message || 'An error occurred.'
            });
            console.error('Save error:', data);
          }
        })
        .catch(err => {
          console.error('Fetch error:', err);
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Something went wrong. Please try again.'
          });
        });
      });
    }
  });
  
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


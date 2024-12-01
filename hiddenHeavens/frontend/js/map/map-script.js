
(function ($) {
  "use strict";

$(function() {

    // Snazzy Map Style - https://snazzymaps.com/style/8097/wy
    var mapStyle = [
    {
        "featureType": "administrative",
        "elementType": "labels.text.fill",
        "stylers": [
            {
                "color": "#444444"
            }
        ]
    },
    {
        "featureType": "landscape",
        "elementType": "all",
        "stylers": [
            {
                "color": "#f2f2f2"
            }
        ]
    },
    {
        "featureType": "poi",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "all",
        "stylers": [
            {
                "saturation": -100
            },
            {
                "lightness": 45
            }
        ]
    },
    {
        "featureType": "road.highway",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "simplified"
            }
        ]
    },
    {
        "featureType": "road.arterial",
        "elementType": "labels.icon",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "transit",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "water",
        "elementType": "all",
        "stylers": [
            {
                "color": "#FF2222"
            },
            {
                "visibility": "on"
            }
        ]
    }
];
	var center = { lat: 40.712776, lng: -74.005974 };
	var offsetCenter = function(dx, dy) {
        return { lat: center.lat + dx, lng: center.lng + dy };
    };
	// Add a custom marker
    var markerIcon = {
        path: 'M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z',
        fillColor: '#FF2222',
        fillOpacity: 0.95,
        scale: 2,
        strokeColor: '#fff',
        strokeWeight: 3,
        anchor: new google.maps.Point(12, 24)
    };

    // Set latitude longitude units of the map where you want to center your map
    var map = new google.maps.Map($('.map-canvas')[0], {
        zoom: 12,
        styles: mapStyle,
        center: new google.maps.LatLng(40.712776, -74.005974)
    });


// Blow you can find all map listing items. You can add/edit/remove these listings as per your need

// Map Listing items START
	var dx = 0.003;
    var placements = [

        {
            title: 'Espresso macchiato',
            link: '#',
            bgImg: 'images/listing/grid/01.jpg',
            body: '<p><i class="fas fa-map-marker-alt pe-2"></i> Virginia drive temple hills</p>' +
                '<div class="listing-rating-call mt-3"><a class="listing-rating" href="#"><span class="me-1">5.4</span> 12 Rating</a><a class="listing-call" href="#"><i class="fas fa-phone-volume"></i> +440 125 658</a>',
			LatLng: { lat : 40.718062, lng : -74.078939 }
		},

		{
			title: 'Fantastic Fridaze',
            link: '#',
            bgImg: 'images/listing/grid/02.jpg',
            body: '<p><i class="fas fa-map-marker-alt pe-2"></i> Border st. nicholasville, ky</p>' +
                '<div class="listing-rating-call mt-3"><a class="listing-rating" href="#"><span class="me-1">5.4</span> 12 Rating</a><a class="listing-call" href="#"><i class="fas fa-phone-volume"></i> +440 125 658</a>',
			LatLng: { lat : 40.723945, lng : -74.000588 },
		},
		{
			title: 'Bike Tours Hollywood',
            link: '#',
            bgImg: 'images/listing/grid/03.jpg',
            body: '<p><i class="fas fa-map-marker-alt pe-2"></i> Newport st. mebane, nc</p>' +
                '<div class="listing-rating-call mt-3"><a class="listing-rating" href="#"><span class="me-1">5.4</span> 12 Rating</a><a class="listing-call" href="#"><i class="fas fa-phone-volume"></i> +440 125 658</a>',
			LatLng: { lat : 40.731375, lng : -74.006193 },
		},
		{
			title: 'The Vatican Museums',
            link: '#',
            bgImg: 'images/listing/grid/04.jpg',
            body: '<p><i class="fas fa-map-marker-alt pe-2"></i> Vermont dr. hephzibah</p>' +
                '<div class="listing-rating-call mt-3"><a class="listing-rating" href="#"><span class="me-1">5.4</span> 12 Rating</a><a class="listing-call" href="#"><i class="fas fa-phone-volume"></i> +440 125 658</a>',
			LatLng: { lat : 40.733391, lng : -73.985345 },
		},
        {
            title: 'Liberty Club',
            link: '#',
            permalink: 'hitest',
            bgImg: 'images/listing/grid/05.jpg',
            body: '<p><i class="fas fa-map-marker-alt pe-2"></i> West Indian St. Missoula</p>' +
                '<div class="listing-rating-call mt-3"><a class="listing-rating" href="#"><span class="me-1">5.4</span> 12 Rating</a><a class="listing-call" href="#"><i class="fas fa-phone-volume"></i> +440 125 658</a>',
            LatLng: { lat : 40.731245, lng : -74.032788 },
        },
        {
            title: 'Honey Restaurant',
            link: '#',
            bgImg: 'images/listing/grid/06.jpg',
            body: '<p><i class="fas fa-map-marker-alt pe-2"></i> Hamilton rd. willoughby, oh</p>' +
                '<div class="listing-rating-call mt-3"><a class="listing-rating" href="#"><span class="me-1">5.4</span> 12 Rating</a><a class="listing-call" href="#"><i class="fas fa-phone-volume"></i> +440 125 658</a>',
            LatLng: { lat : 40.728991, lng : -74.167134 },
        },
        {
            title: 'Espresso macchiato',
            link: '#',
            bgImg: 'images/listing/grid/01.jpg',
            body: '<p><i class="fas fa-map-marker-alt pe-2"></i> Virginia drive temple hills.</p>' +
                '<div class="listing-rating-call mt-3"><a class="listing-rating" href="#"><span class="me-1">5.4</span> 12 Rating</a><a class="listing-call" href="#"><i class="fas fa-phone-volume"></i> +440 125 658</a>',
            LatLng: { lat : 40.682143, lng : -74.259448 },
        },
        {
            title: 'Fantastic Fridaze',
            link: '#',
            bgImg: 'images/listing/grid/02.jpg',
            body: '<p><i class="fas fa-map-marker-alt pe-2"></i> Virginia drive temple hills.</p>' +
                '<div class="listing-rating-call mt-3"><a class="listing-rating" href="#"><span class="me-1">5.4</span> 12 Rating</a><a class="listing-call" href="#"><i class="fas fa-phone-volume"></i> +440 125 658</a>',
            LatLng: { lat : 40.748761, lng : -74.306119 },
        },
        {
            title: 'Bike Tours Hollywood',
            link: '#',
            bgImg: 'images/listing/grid/03.jpg',
            body: '<p><i class="fas fa-map-marker-alt pe-2"></i> Virginia drive temple hills.</p>' +
                '<div class="listing-rating-call mt-3"><a class="listing-rating" href="#"><span class="me-1">5.4</span> 12 Rating</a><a class="listing-call" href="#"><i class="fas fa-phone-volume"></i> +440 125 658</a>',
            LatLng: { lat : 40.675113, lng : -73.843865 },
        },
        {
            title: 'The Vatican Museums',
            link: '#',
            bgImg: 'images/listing/grid/04.jpg',
            body: '<p><i class="fas fa-map-marker-alt pe-2"></i> Virginia drive temple hills.</p>' +
                '<div class="listing-rating-call mt-3"><a class="listing-rating" href="#"><span class="me-1">5.4</span> 12 Rating</a><a class="listing-call" href="#"><i class="fas fa-phone-volume"></i> +440 125 658</a>',
            LatLng: { lat : 40.727430, lng : -73.800626 },
        },
        {
            title: 'Liberty Club',
            link: '#',
            bgImg: 'images/listing/grid/05.jpg',
            body: '<p><i class="fas fa-map-marker-alt pe-2"></i> Virginia drive temple hills.</p>' +
                '<div class="listing-rating-call mt-3"><a class="listing-rating" href="#"><span class="me-1">5.4</span> 12 Rating</a><a class="listing-call" href="#"><i class="fas fa-phone-volume"></i> +440 125 658</a>',
            LatLng: { lat : 40.715981, lng : -73.897336 },
        },
        {
            title: 'Honey Restaurant',
            link: '#',
            bgImg: 'images/listing/grid/06.jpg',
            body: '<p><i class="fas fa-map-marker-alt pe-2"></i> Virginia drive temple hills.</p>' +
                '<div class="listing-rating-call mt-3"><a class="listing-rating" href="#"><span class="me-1">5.4</span> 12 Rating</a><a class="listing-call" href="#"><i class="fas fa-phone-volume"></i> +440 125 658</a>',
            LatLng: { lat : 40.669385, lng : -73.705160 },
        },
        {
            title: 'Espresso macchiato',
            link: '#',
            bgImg: 'images/listing/grid/01.jpg',
            body: '<p><i class="fas fa-map-marker-alt pe-2"></i> Virginia drive temple hills.</p>' +
                '<div class="listing-rating-call mt-3"><a class="listing-rating" href="#"><span class="me-1">5.4</span> 12 Rating</a><a class="listing-call" href="#"><i class="fas fa-phone-volume"></i> +440 125 658</a>',
            LatLng: { lat : 40.826483, lng : -74.014765 },
        },
        {
            title: 'Fantastic Fridaze',
            link: '#',
            bgImg: 'images/listing/grid/02.jpg',
            body: '<p><i class="fas fa-map-marker-alt pe-2"></i> Virginia drive temple hills.</p>' +
                '<div class="listing-rating-call mt-3"><a class="listing-rating" href="#"><span class="me-1">5.4</span> 12 Rating</a><a class="listing-call" href="#"><i class="fas fa-phone-volume"></i> +440 125 658</a>',
            LatLng: { lat : 40.884132, lng : -73.913512 },
        },
        {
            title: 'Bike Tours Hollywood',
            link: '#',
            bgImg: 'images/listing/grid/03.jpg',
            body: '<p><i class="fas fa-map-marker-alt pe-2"></i> Virginia drive temple hills.</p>' +
                '<div class="listing-rating-call mt-3"><a class="listing-rating" href="#"><span class="me-1">5.4</span> 12 Rating</a><a class="listing-call" href="#"><i class="fas fa-phone-volume"></i> +440 125 658</a>',
            LatLng: { lat : 40.915531, lng : -74.062449 },
        },
        {
            title: 'The Vatican Museums',
            link: '#',
            bgImg: 'images/listing/grid/04.jpg',
            body: '<p><i class="fas fa-map-marker-alt pe-2"></i> Virginia drive temple hills.</p>' +
                '<div class="listing-rating-call mt-3"><a class="listing-rating" href="#"><span class="me-1">5.4</span> 12 Rating</a><a class="listing-call" href="#"><i class="fas fa-phone-volume"></i> +440 125 658</a>',
            LatLng: { lat : 40.653759, lng : -73.994861 },
        },
        {
            title: 'Liberty Club',
            link: '#',
            bgImg: 'images/listing/grid/05.jpg',
            body: '<p><i class="fas fa-map-marker-alt pe-2"></i> Virginia drive temple hills.</p>' +
                '<div class="listing-rating-call mt-3"><a class="listing-rating" href="#"><span class="me-1">5.4</span> 12 Rating</a><a class="listing-call" href="#"><i class="fas fa-phone-volume"></i> +440 125 658</a>',
            LatLng: { lat : 40.669385, lng : -74.116001 },
        },

    ];
// Map Listing items END

    $.each(placements, function(i, e) {

    var marker = new google.maps.Marker({
        map: map,
        icon: markerIcon,
        position: e.LatLng //new google.maps.LatLng(40.72, -74)
    });

    // Set up handle bars
    var template = Handlebars.compile($('#marker-content-template').html());

    // Set up a close delay for CSS animations
    var info = null;
    var closeDelayed = false;
    var closeDelayHandler = function() {
        $(info.getWrapper()).removeClass('active');
        setTimeout(function() {
            closeDelayed = true;
            info.close();
        }, 300);
    };


    // Add a Snazzy Info Window to the marker
    info = new SnazzyInfoWindow({
        marker: marker,
        wrapperClass: 'custom-window',
        offset: {
            top: '-72px'
        },
        edgeOffset: {
            top: 50,
            right: 60,
            bottom: 50
        },
        closeWhenOthersOpen: true,
        border: false,
        closeButtonMarkup: '<button type="button" class="custom-close">&#215;</button>',
        content: template({
            title: e.title,
            link:e.link,
            subtitle: e.subtitle,
            bgImg: e.bgImg,
            body: e.body
        }),
        callbacks: {
            open: function() {


                $(this.getWrapper()).addClass('open');
            },
            afterOpen: function() {
                var wrapper = $(this.getWrapper());
                wrapper.addClass('active');
                wrapper.find('.custom-close').on('click', closeDelayHandler);
            },
            beforeClose: function() {
                if (!closeDelayed) {
                    closeDelayHandler();
                    return false;
                }
                return true;
            },
            afterClose: function() {
                var wrapper = $(this.getWrapper());
                wrapper.find('.custom-close').off();
                wrapper.removeClass('open');
                closeDelayed = false;
            }
        }
    });
	});


    // Open the Snazzy Info Window
   // info.open();
});

})(jQuery);

(function () {
	'use strict';

	document.addEventListener( 'DOMContentLoaded', function () {
		document.querySelectorAll( '.gpc-carousel-outer' ).forEach( initCarousel );
	} );

	function initCarousel( root ) {
		var slides = root.querySelectorAll( '.gpc-slide' );
		var dots   = root.querySelectorAll( '.gpc-dot' );
		var prev   = root.querySelector( '.gpc-prev' );
		var next   = root.querySelector( '.gpc-next' );

		// Map toggle is set up regardless of how many photos there are, so a
		// single-image post's location still shows up.
		var mapToggle = root.querySelector( '.gpc-map-toggle' );
		var mapPane   = root.querySelector( '.gpc-map-pane' );
		var mapEmbed  = mapPane ? mapPane.querySelector( '.gpc-leaflet-embed' ) : null;
		var mapLoaded = false;

		if ( mapToggle && mapPane ) {
			mapToggle.addEventListener( 'click', function () {
				var showingMap = root.classList.toggle( 'is-map-view' );
				mapToggle.classList.toggle( 'is-active', showingMap );
				var label = mapToggle.querySelector( '.gpc-map-toggle-label' );
				if ( label ) { label.textContent = showingMap ? 'Photos' : 'Map'; }

				if ( showingMap ) {
					if ( ! mapLoaded && mapEmbed ) {
						mapLoaded = true;
						initLeafletEmbed( mapEmbed );
					}
					stopAutoplay();
				} else {
					startAutoplay();
				}
			} );
		}

		if ( slides.length < 2 ) { return; }

		var index = 0;
		var timer = null;
		var autoplay = root.getAttribute( 'data-autoplay' ) === '1';
		var speed = parseInt( root.getAttribute( 'data-speed' ), 10 ) || 4000;

		function show( i ) {
			slides[ index ].classList.remove( 'is-active' );
			if ( dots[ index ] ) { dots[ index ].classList.remove( 'is-active' ); }
			index = ( i + slides.length ) % slides.length;
			slides[ index ].classList.add( 'is-active' );
			if ( dots[ index ] ) { dots[ index ].classList.add( 'is-active' ); }
		}

		function goNext() { show( index + 1 ); }
		function goPrev() { show( index - 1 ); }

		function startAutoplay() {
			if ( ! autoplay ) { return; }
			stopAutoplay();
			timer = setInterval( goNext, speed );
		}
		function stopAutoplay() {
			if ( timer ) { clearInterval( timer ); timer = null; }
		}

		if ( next ) { next.addEventListener( 'click', function () { goNext(); startAutoplay(); } ); }
		if ( prev ) { prev.addEventListener( 'click', function () { goPrev(); startAutoplay(); } ); }
		dots.forEach( function ( dot, i ) {
			dot.addEventListener( 'click', function () { show( i ); startAutoplay(); } );
		} );

		root.addEventListener( 'mouseenter', stopAutoplay );
		root.addEventListener( 'mouseleave', startAutoplay );

		// Basic touch swipe support.
		var touchStartX = null;
		root.addEventListener( 'touchstart', function ( e ) { touchStartX = e.touches[0].clientX; }, { passive: true } );
		root.addEventListener( 'touchend', function ( e ) {
			if ( touchStartX === null || root.classList.contains( 'is-map-view' ) ) { return; }
			var delta = e.changedTouches[0].clientX - touchStartX;
			if ( Math.abs( delta ) > 40 ) {
				delta < 0 ? goNext() : goPrev();
				startAutoplay();
			}
			touchStartX = null;
		}, { passive: true } );

		startAutoplay();
	}

	// Renders a Leaflet/OpenStreetMap map inside one listing's map pane —
	// no Google Maps embed, no API key, nothing that can be silently
	// blocked or rate-limited. If the poster dropped an exact pin
	// (_gpc_lat/_gpc_lng) that's used directly; otherwise the typed
	// address text is geocoded once via Nominatim (OSM's free geocoder),
	// same as the "Find on map" button on the submission form.
	var PIN_ZOOM = 15;
	function initLeafletEmbed( el ) {
		if ( typeof L === 'undefined' ) {
			el.textContent = 'Map is unavailable right now.';
			return;
		}
		var lat = parseFloat( el.getAttribute( 'data-lat' ) );
		var lng = parseFloat( el.getAttribute( 'data-lng' ) );
		var location = el.getAttribute( 'data-location' ) || '';

		function render( rLat, rLng ) {
			var map = L.map( el, { attributionControl: true } ).setView( [ rLat, rLng ], PIN_ZOOM );
			L.tileLayer( 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
				maxZoom: 19,
				attribution: '&copy; OpenStreetMap contributors',
			} ).addTo( map );
			L.marker( [ rLat, rLng ] ).addTo( map );
			setTimeout( function () { map.invalidateSize(); }, 150 );
		}

		if ( isFinite( lat ) && isFinite( lng ) ) {
			render( lat, lng );
			return;
		}

		if ( ! location ) {
			el.textContent = 'No location saved for this listing.';
			return;
		}

		el.textContent = 'Loading map…';
		fetch( 'https://nominatim.openstreetmap.org/search?format=json&limit=1&q=' + encodeURIComponent( location ) )
			.then( function ( r ) { return r.json(); } )
			.then( function ( results ) {
				el.textContent = '';
				if ( results && results.length ) {
					render( parseFloat( results[0].lat ), parseFloat( results[0].lon ) );
				} else {
					el.textContent = "Couldn't find this address on the map.";
				}
			} )
			.catch( function () {
				el.textContent = 'Map is unavailable right now.';
			} );
	}
})();

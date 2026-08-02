(function () {
	'use strict';

	// Default view when nothing's been picked yet — Lagos, Nigeria, city-wide
	// zoom. Just a starting point; it's replaced the moment someone searches,
	// drops a pin, or uses their current location.
	var DEFAULT_LAT = 6.5244;
	var DEFAULT_LNG = 3.3792;
	var DEFAULT_ZOOM = 11;
	var PIN_ZOOM = 15;

	document.addEventListener( 'DOMContentLoaded', function () {
		var mapEl      = document.getElementById( 'gpcMapPickerMap' );
		var latInput   = document.getElementById( 'gpcLat' );
		var lngInput   = document.getElementById( 'gpcLng' );
		var findBtn    = document.getElementById( 'gpcMapFindBtn' );
		var myLocBtn   = document.getElementById( 'gpcMapMyLocationBtn' );
		var locationEl = document.getElementById( 'gpcLocation' );

		if ( ! mapEl || ! latInput || ! lngInput || typeof L === 'undefined' ) { return; }

		var map = null;
		var marker = null;

		function setCoords( lat, lng ) {
			latInput.value = lat;
			lngInput.value = lng;
		}

		function placeMarker( lat, lng, recenter ) {
			if ( ! map ) { return; }
			if ( marker ) {
				marker.setLatLng( [ lat, lng ] );
			} else {
				marker = L.marker( [ lat, lng ], { draggable: true } ).addTo( map );
				marker.on( 'dragend', function () {
					var pos = marker.getLatLng();
					setCoords( pos.lat, pos.lng );
				} );
			}
			if ( recenter ) { map.setView( [ lat, lng ], PIN_ZOOM ); }
			setCoords( lat, lng );
		}

		function initMap() {
			if ( map ) { return; }
			map = L.map( mapEl ).setView( [ DEFAULT_LAT, DEFAULT_LNG ], DEFAULT_ZOOM );
			L.tileLayer( 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
				maxZoom: 19,
				attribution: '&copy; OpenStreetMap contributors',
			} ).addTo( map );

			map.on( 'click', function ( e ) {
				placeMarker( e.latlng.lat, e.latlng.lng, false );
			} );

			// The container may have been hidden (display:none) at the moment
			// Leaflet measured it, which gives it a broken 0x0 size. Fixing
			// that up shortly after it becomes visible is the standard
			// Leaflet workaround.
			setTimeout( function () { map.invalidateSize(); }, 150 );
		}

		// The map lives inside "#gpcPropertyFields", which the main submit
		// script shows/hides based on the chosen post type. Leaflet can't
		// size itself correctly inside a display:none container, so it's
		// only initialized the first time this box actually becomes visible.
		var observer = new IntersectionObserver( function ( entries ) {
			entries.forEach( function ( entry ) {
				if ( entry.isIntersecting ) {
					initMap();
					map.invalidateSize();
				}
			} );
		}, { threshold: 0.01 } );
		observer.observe( mapEl );

		if ( findBtn ) {
			findBtn.addEventListener( 'click', function () {
				var query = locationEl ? locationEl.value.trim() : '';
				if ( ! query ) {
					if ( locationEl ) { locationEl.focus(); }
					return;
				}
				initMap();
				var originalText = findBtn.textContent;
				findBtn.disabled = true;
				findBtn.textContent = 'Searching…';

				// Nominatim (OpenStreetMap's free geocoder) turns the typed
				// address into coordinates — no API key needed. This is a
				// convenience to jump the map near the right spot; the poster
				// can still drag the pin afterwards to be exact.
				fetch( 'https://nominatim.openstreetmap.org/search?format=json&limit=1&q=' + encodeURIComponent( query ) )
					.then( function ( r ) { return r.json(); } )
					.then( function ( results ) {
						if ( results && results.length ) {
							placeMarker( parseFloat( results[0].lat ), parseFloat( results[0].lon ), true );
						} else {
							alert( "Couldn't find that address on the map — try a more specific location, or just tap/drag the pin yourself." );
						}
					} )
					.catch( function () {
						alert( 'Map search is unavailable right now — you can still tap or drag the pin directly on the map.' );
					} )
					.finally( function () {
						findBtn.disabled = false;
						findBtn.textContent = originalText;
					} );
			} );
		}

		if ( myLocBtn ) {
			myLocBtn.addEventListener( 'click', function () {
				if ( ! navigator.geolocation ) {
					alert( 'Your browser or device does not support location detection — please use "Find on map" or drag the pin instead.' );
					return;
				}
				initMap();
				var originalText = myLocBtn.textContent;
				myLocBtn.disabled = true;
				myLocBtn.textContent = 'Locating…';
				navigator.geolocation.getCurrentPosition(
					function ( pos ) {
						placeMarker( pos.coords.latitude, pos.coords.longitude, true );
						myLocBtn.disabled = false;
						myLocBtn.textContent = originalText;
					},
					function () {
						alert( "Couldn't get your current location — please allow location access, or use \"Find on map\" / drag the pin instead." );
						myLocBtn.disabled = false;
						myLocBtn.textContent = originalText;
					}
				);
			} );
		}

		// Called by gpc-frontend-submit.js after a successful submission so
		// the picker doesn't carry a stale pin into the next post someone adds.
		window.gpcResetMapPicker = function () {
			setCoords( '', '' );
			if ( marker && map ) {
				map.removeLayer( marker );
				marker = null;
			}
			if ( map ) {
				map.setView( [ DEFAULT_LAT, DEFAULT_LNG ], DEFAULT_ZOOM );
			}
		};

		// Called by gpc-frontend-submit.js when opening the edit modal for a
		// listing that already has saved coordinates, so the pin starts in
		// the right place instead of the default city-wide view.
		window.gpcSetMapPickerPin = function ( lat, lng ) {
			if ( ! isFinite( lat ) || ! isFinite( lng ) ) { return; }
			initMap();
			setTimeout( function () { placeMarker( lat, lng, true ); }, 200 );
		};
	} );
})();

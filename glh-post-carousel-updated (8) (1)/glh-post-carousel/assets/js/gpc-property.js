(function () {
	'use strict';

	document.addEventListener( 'DOMContentLoaded', function () {
		document.querySelectorAll( '.gpc-faq-trigger' ).forEach( function ( trigger ) {
			trigger.addEventListener( 'click', function () {
				var item  = trigger.closest( '.gpc-faq-item' );
				var panel = item ? item.querySelector( '.gpc-faq-panel' ) : null;
				if ( ! item || ! panel ) return;
				var isOpen = item.classList.toggle( 'is-open' );
				trigger.setAttribute( 'aria-expanded', isOpen ? 'true' : 'false' );
				panel.style.maxHeight = isOpen ? panel.scrollHeight + 'px' : null;
			} );
		} );
	} );
})();

/* --------------------------------------------------------------------------
   Property action icons (Image counter / Map / Share) that sit beneath the
   hero gallery. These enhance the carousel plugin's existing gallery + map
   rather than replacing them: the Map button just triggers the carousel's
   own built-in map toggle, and the gallery/counter button scrolls back up to
   the carousel. Share uses the native Web Share API with a copy-link fallback.
   -------------------------------------------------------------------------- */
(function () {
	'use strict';

	document.addEventListener( 'DOMContentLoaded', function () {
		function getCarousel() {
			// Prefer the single-post carousel (not the "-grid" listing variant).
			return document.querySelector( '.gpc-carousel-outer:not(.gpc-carousel-grid)' ) ||
			       document.querySelector( '.gpc-carousel-outer' );
		}

		// Image counter / gallery button — scroll up to the hero carousel.
		document.querySelectorAll( '.gpc-action-gallery' ).forEach( function ( btn ) {
			btn.addEventListener( 'click', function () {
				var c = getCarousel();
				if ( c ) c.scrollIntoView( { behavior: 'smooth', block: 'start' } );
			} );
		} );

		// Map button — reuse the carousel's own map toggle so the existing
		// Leaflet/OpenStreetMap integration is preserved, not duplicated.
		document.querySelectorAll( '.gpc-action-map' ).forEach( function ( btn ) {
			btn.addEventListener( 'click', function () {
				var c = getCarousel();
				var mapToggle = c ? c.querySelector( '.gpc-map-toggle' ) : null;
				if ( c ) c.scrollIntoView( { behavior: 'smooth', block: 'start' } );
				if ( mapToggle ) mapToggle.click();
			} );
		} );

		// Share button — native share sheet on mobile, clipboard fallback.
		document.querySelectorAll( '.gpc-action-share' ).forEach( function ( btn ) {
			btn.addEventListener( 'click', function () {
				var url   = btn.getAttribute( 'data-share-url' ) || window.location.href;
				var title = btn.getAttribute( 'data-share-title' ) || document.title;
				if ( navigator.share ) {
					navigator.share( { title: title, url: url } ).catch( function () {} );
				} else if ( navigator.clipboard && navigator.clipboard.writeText ) {
					navigator.clipboard.writeText( url ).then( function () {
						flash( btn );
					} ).catch( function () {} );
				} else {
					window.prompt( 'Copy this listing link:', url );
				}
			} );
		} );

		function flash( btn ) {
			btn.classList.add( 'is-active' );
			setTimeout( function () { btn.classList.remove( 'is-active' ); }, 1200 );
		}
	} );
})();

(function () {
	'use strict';
	if ( typeof gpcPropertyData === 'undefined' ) { return; }

	document.addEventListener( 'DOMContentLoaded', function () {
		document.querySelectorAll( '.gpc-rating-interactive' ).forEach( setupWidget );
	} );

	function setupWidget( widget ) {
		var postId = widget.getAttribute( 'data-post-id' );
		var stars = Array.prototype.slice.call( widget.querySelectorAll( '.gpc-rating-stars svg' ) );
		if ( ! postId || ! stars.length ) return;

		stars.forEach( function ( star, idx ) {
			star.addEventListener( 'mouseenter', function () { previewFill( stars, idx + 1 ); } );
			star.addEventListener( 'mouseleave', function () { resetPreview( stars, widget ); } );
			star.addEventListener( 'click', function ( e ) {
				e.preventDefault();
				if ( widget.classList.contains( 'is-submitting' ) ) return;
				submitRating( widget, postId, idx + 1, stars );
			} );
		} );
	}

	function previewFill( stars, count ) {
		stars.forEach( function ( s, i ) {
			s.classList.toggle( 'is-filled', i < count );
			s.classList.toggle( 'is-empty', i >= count );
		} );
	}

	function resetPreview( stars, widget ) {
		var current = widget.getAttribute( 'data-current-avg' );
		var rounded = current ? Math.round( parseFloat( current ) ) : 0;
		previewFill( stars, rounded );
	}

	function submitRating( widget, postId, stars, starEls ) {
		widget.classList.add( 'is-submitting' );

		var fd = new FormData();
		fd.append( 'action', 'gpc_rate_post' );
		fd.append( 'nonce', gpcPropertyData.nonce );
		fd.append( 'post_id', postId );
		fd.append( 'stars', stars );

		fetch( gpcPropertyData.ajaxUrl, { method: 'POST', body: fd } )
			.then( function ( r ) { return r.json(); } )
			.then( function ( json ) {
				if ( json && json.success ) {
					var avg = json.data.average;
					var count = json.data.count;
					widget.setAttribute( 'data-current-avg', avg );
					widget.setAttribute( 'data-my-rating', stars );
					previewFill( starEls, Math.round( avg ) );

					var scoreEl = widget.querySelector( '.gpc-rating-score' );
					var countEl = widget.querySelector( '.gpc-rating-count' );
					var mineEl  = widget.querySelector( '.gpc-rating-mine' );
					if ( scoreEl ) scoreEl.textContent = ( typeof avg === 'number' ? avg.toFixed( 1 ) : avg );
					if ( countEl ) countEl.textContent = '(' + count + ')';
					if ( mineEl )  mineEl.textContent  = 'Your rating: ' + stars + '★ (tap to change)';
				}
			} )
			.catch( function () { /* silent — worst case the click just doesn't register, no broken UI */ } )
			.finally( function () {
				widget.classList.remove( 'is-submitting' );
			} );
	}
})();

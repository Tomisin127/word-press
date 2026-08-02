(function () {
	'use strict';

	document.addEventListener( 'DOMContentLoaded', function () {
		document.querySelectorAll( '.gpc-desc-faq-trigger' ).forEach( function ( trigger ) {
			trigger.addEventListener( 'click', function () {
				var faq   = trigger.closest( '.gpc-desc-faq' );
				var panel = faq ? faq.querySelector( '.gpc-desc-faq-panel' ) : null;
				if ( ! faq || ! panel ) return;
				var isOpen = faq.classList.toggle( 'is-open' );
				trigger.setAttribute( 'aria-expanded', isOpen ? 'true' : 'false' );
				panel.style.maxHeight = isOpen ? panel.scrollHeight + 'px' : null;
			} );
		} );
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

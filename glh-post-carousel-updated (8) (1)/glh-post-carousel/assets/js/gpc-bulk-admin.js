(function () {
	'use strict';
	if ( typeof gpcBulkData === 'undefined' ) { return; }

	document.addEventListener( 'DOMContentLoaded', function () {
		var avatarPool  = []; // array of File objects, in add-order
		var galleryPool = []; // array of File objects, in add-order

		var titlesEl = document.getElementById( 'gpcBulkTitles' );
		var descEl   = document.getElementById( 'gpcBulkDescriptions' );
		var namesEl  = document.getElementById( 'gpcBulkNames' );
		var emailsEl = document.getElementById( 'gpcBulkEmails' );
		var biosEl   = document.getElementById( 'gpcBulkBios' );

		/* ---------------------------------------------------------- parsing helpers */

		function parseLines( text ) {
			return text.split( '\n' ).map( function ( l ) { return l.trim(); } ).filter( function ( l ) { return l !== ''; } );
		}

		function parseBlocks( text ) {
			return text.split( /\n\s*---\s*\n/ ).map( function ( b ) { return b.trim(); } ).filter( function ( b ) { return b !== ''; } );
		}

		/* ---------------------------------------------------------- live counts + summary */

		function updateCounts() {
			var titles = parseLines( titlesEl.value );
			var descs  = parseBlocks( descEl.value );
			var names  = parseLines( namesEl.value );
			var emails = parseLines( emailsEl.value );
			var bios   = parseBlocks( biosEl.value );

			document.getElementById( 'gpcTitleCount' ).textContent = titles.length;
			document.getElementById( 'gpcDescCount' ).textContent = descs.length;
			document.getElementById( 'gpcNameCount' ).textContent = names.length;
			document.getElementById( 'gpcEmailCount' ).textContent = emails.length;
			document.getElementById( 'gpcBioCount' ).textContent = bios.length;
			document.getElementById( 'gpcAvatarCount' ).textContent = avatarPool.length;
			document.getElementById( 'gpcGalleryCount' ).textContent = galleryPool.length;

			var imagesPerRow = Math.max( 2, Math.min( 11, parseInt( document.getElementById( 'gpcImagesPerRow' ).value, 10 ) || 5 ) );
			var galleryGroups = Math.floor( galleryPool.length / imagesPerRow );

			var summary = document.getElementById( 'gpcSummaryBox' );
			if ( ! titles.length ) {
				summary.innerHTML = '<p>Paste at least one title above to get started.</p>';
				return;
			}

			var lines = [];
			lines.push( '<strong>' + titles.length + ' post(s)</strong> will be created.' );
			if ( descs.length < titles.length ) {
				lines.push( '<span class="gpc-warn">Only ' + descs.length + ' description(s) provided — the rest will be created empty.</span>' );
			}
			if ( names.length < titles.length ) {
				lines.push( '<span class="gpc-warn">Only ' + names.length + ' author name(s) — remaining posts reuse the last name, numbered.</span>' );
			}
			lines.push( emails.length + ' email(s) pasted — any author without one gets an auto-generated placeholder address.' );
			lines.push( bios.length + ' bio(s) pasted — any author without one gets a short auto-generated bio.' );
			lines.push( avatarPool.length + ' avatar photo(s) in the pool — assigned to authors in order.' );
			lines.push( galleryPool.length + ' gallery photo(s) in the pool, split into groups of ' + imagesPerRow + ' — enough for <strong>' + galleryGroups + '</strong> propert' + ( galleryGroups === 1 ? 'y' : 'ies' ) + ' with a working carousel.' );
			if ( galleryGroups < titles.length ) {
				lines.push( '<span class="gpc-warn">' + ( titles.length - galleryGroups ) + ' post(s) will not have enough gallery photos for a carousel yet — add more photos above, or edit those posts later.</span>' );
			} else {
				lines.push( '<span class="gpc-good">Every post will have enough photos for a carousel.</span>' );
			}

			summary.innerHTML = lines.map( function ( l ) { return '<p>' + l + '</p>'; } ).join( '' );
		}

		[ titlesEl, descEl, namesEl, emailsEl, biosEl ].forEach( function ( el ) {
			el.addEventListener( 'input', updateCounts );
		} );
		document.getElementById( 'gpcImagesPerRow' ).addEventListener( 'input', updateCounts );

		/* ---------------------------------------------------------- media pools */

		function wirePool( pickBtnId, inputId, gridId, pool, countUpdater ) {
			var pickBtn = document.getElementById( pickBtnId );
			var input   = document.getElementById( inputId );
			var grid    = document.getElementById( gridId );

			pickBtn.addEventListener( 'click', function () { input.click(); } );

			input.addEventListener( 'change', function () {
				var files = Array.prototype.slice.call( input.files ).slice( 0, 20 );
				files.forEach( function ( file ) { pool.push( file ); } );
				renderPool( grid, pool );
				updateCounts();
				input.value = '';
			} );
		}

		function renderPool( grid, pool ) {
			grid.innerHTML = '';
			pool.forEach( function ( file, i ) {
				var thumb = document.createElement( 'div' );
				thumb.className = 'gpc-pool-thumb';
				var url = URL.createObjectURL( file );
				thumb.innerHTML = '<img src="' + url + '" alt=""><span class="gpc-pool-num">' + ( i + 1 ) + '</span><button type="button" class="gpc-pool-remove" data-index="' + i + '">✕</button>';
				grid.appendChild( thumb );
			} );

			grid.querySelectorAll( '.gpc-pool-remove' ).forEach( function ( btn ) {
				btn.addEventListener( 'click', function () {
					var idx = parseInt( btn.getAttribute( 'data-index' ), 10 );
					pool.splice( idx, 1 );
					renderPool( grid, pool );
					updateCounts();
				} );
			} );
		}

		wirePool( 'gpcAvatarPickBtn', 'gpcAvatarInput', 'gpcAvatarPoolGrid', avatarPool );
		wirePool( 'gpcGalleryPickBtn', 'gpcGalleryInput', 'gpcGalleryPoolGrid', galleryPool );

		/* ---------------------------------------------------------- generate */

		document.getElementById( 'gpcRunBatch' ).addEventListener( 'click', function () {
			var titles = parseLines( titlesEl.value );
			var descs  = parseBlocks( descEl.value );
			var names  = parseLines( namesEl.value );
			var emails = parseLines( emailsEl.value );
			var bios   = parseBlocks( biosEl.value );

			if ( ! titles.length ) {
				alert( 'Paste at least one title first.' );
				return;
			}

			var imagesPerRow = Math.max( 2, Math.min( 11, parseInt( document.getElementById( 'gpcImagesPerRow' ).value, 10 ) || 5 ) );

			var batch = {
				category_id: document.getElementById( 'gpcBatchCategory' ).value,
				status:      document.getElementById( 'gpcBatchStatus' ).value,
				role:        document.getElementById( 'gpcBatchRole' ).value,
				notify:      document.getElementById( 'gpcBatchNotify' ).checked ? '1' : '',
			};

			var runBtn = document.getElementById( 'gpcRunBatch' );
			runBtn.disabled = true;

			var progressWrap = document.getElementById( 'gpcProgress' );
			var progressBar  = document.getElementById( 'gpcProgressBar' );
			var progressText = document.getElementById( 'gpcProgressText' );
			var resultsTable = document.getElementById( 'gpcResultsTable' );
			var resultsBody  = document.getElementById( 'gpcResultsBody' );

			progressWrap.style.display = '';
			resultsTable.style.display = '';
			resultsBody.innerHTML = '';

			var total = titles.length;
			var done = 0;

			function updateProgress() {
				var pct = Math.round( ( done / total ) * 100 );
				progressBar.style.width = pct + '%';
				progressText.textContent = 'Creating post ' + done + ' of ' + total;
			}

			function escapeHtml( s ) {
				var d = document.createElement( 'div' );
				d.textContent = s || '';
				return d.innerHTML;
			}

			function addResultRow( title, author, message, ok ) {
				var tr = document.createElement( 'tr' );
				tr.innerHTML = '<td>' + escapeHtml( title ) + '</td><td>' + escapeHtml( author ) + '</td><td style="color:' + ( ok ? '#22c55e' : '#e05050' ) + '">' + escapeHtml( message ) + '</td>';
				resultsBody.appendChild( tr );
			}

			function processRow( i ) {
				if ( i >= titles.length ) {
					progressText.textContent = 'Done. Created ' + done + ' of ' + total + ' posts.';
					runBtn.disabled = false;
					return;
				}

				var title       = titles[ i ];
				var description = descs[ i ] || '';
				var authorName  = names.length ? ( names[ i ] || names[ names.length - 1 ] + ' ' + ( i + 1 ) ) : ( 'Author ' + ( i + 1 ) );
				var authorEmail = emails[ i ] || '';
				var bio         = bios[ i ] || '';
				var avatarFile  = avatarPool[ i ] || null;
				var galleryFiles = galleryPool.slice( i * imagesPerRow, ( i + 1 ) * imagesPerRow );

				var fd = new FormData();
				fd.append( 'action', 'gpc_bulk_create_single' );
				fd.append( 'nonce', gpcBulkData.nonce );
				fd.append( 'title', title );
				fd.append( 'description', description );
				fd.append( 'author_name', authorName );
				fd.append( 'author_email', authorEmail );
				fd.append( 'author_bio', bio );
				fd.append( 'category_id', batch.category_id );
				fd.append( 'status', batch.status );
				fd.append( 'role', batch.role );
				fd.append( 'notify', batch.notify );

				if ( avatarFile ) {
					fd.append( 'avatar', avatarFile );
				}
				galleryFiles.forEach( function ( file ) {
					fd.append( 'gallery[]', file );
				} );

				fetch( gpcBulkData.ajaxUrl, { method: 'POST', body: fd } )
					.then( function ( r ) { return r.json(); } )
					.then( function ( json ) {
						if ( json.success ) {
							var msg = 'Created (' + json.data.images + ' image' + ( json.data.images === 1 ? '' : 's' ) + ')';
							if ( json.data.warnings && json.data.warnings.length ) {
								msg += '. ' + json.data.warnings.join( ' ' );
							}
							addResultRow( title, json.data.author, msg, true );
						} else {
							addResultRow( title, authorName, json.data && json.data.message ? json.data.message : 'Failed', false );
						}
					} )
					.catch( function () {
						addResultRow( title, authorName, 'Network error, this row was not created', false );
					} )
					.finally( function () {
						done++;
						updateProgress();
						processRow( i + 1 );
					} );
			}

			updateProgress();
			processRow( 0 );
		} );

		updateCounts();
	} );
})();

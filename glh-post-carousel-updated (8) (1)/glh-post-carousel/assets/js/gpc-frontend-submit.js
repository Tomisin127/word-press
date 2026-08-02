(function () {
	'use strict';
	if ( typeof gpcSubmitData === 'undefined' ) { return; }

	document.addEventListener( 'DOMContentLoaded', function () {
		var fab      = document.getElementById( 'gpcSubmitFab' );
		var overlay  = document.getElementById( 'gpcSubmitOverlay' );
		var closeBtn = document.getElementById( 'gpcSubmitClose' );
		var form     = document.getElementById( 'gpcSubmitForm' );
		if ( ! fab || ! overlay || ! form ) { return; }

		var imagePool  = [];
		var bannerFile = null;
		var existingPhotoCount = 0;
		var MAX_BANNER_BYTES = 5 * 1024 * 1024; // 5MB — a safe ceiling under typical shared-hosting PHP upload limits

		function setFieldVal( id, value ) {
			var el = document.getElementById( id );
			if ( el ) el.value = value || '';
		}

		function resetToCreateMode() {
			var heading      = document.getElementById( 'gpcSubmitHeading' );
			var note         = document.getElementById( 'gpcSubmitNote' );
			var editIdField  = document.getElementById( 'gpcEditPostId' );
			var submitBtn    = document.getElementById( 'gpcSubmitBtn' );
			var existingGrid = document.getElementById( 'gpcExistingPhotosGrid' );
			if ( heading )     heading.textContent = 'Add a post';
			if ( note )        note.textContent = 'Your post will be reviewed before it appears on the site.';
			if ( editIdField ) editIdField.value = '';
			if ( submitBtn )   submitBtn.textContent = 'Submit for review';
			if ( existingGrid ) { existingGrid.innerHTML = ''; existingGrid.style.display = 'none'; }
			existingPhotoCount = 0;
			form.reset();
			imagePool = [];
			bannerFile = null;
			var bp = document.getElementById( 'gpcAdBannerPreview' );
			if ( bp ) bp.innerHTML = '';
			renderPool();
			if ( typeof onTypeChange === 'function' ) onTypeChange();
			if ( typeof window.gpcResetMapPicker === 'function' ) { window.gpcResetMapPicker(); }
		}

		fab.addEventListener( 'click', function () { resetToCreateMode(); overlay.classList.add( 'is-open' ); } );
		if ( closeBtn ) closeBtn.addEventListener( 'click', function () { overlay.classList.remove( 'is-open' ); } );
		overlay.addEventListener( 'click', function ( e ) { if ( e.target === overlay ) { overlay.classList.remove( 'is-open' ); } } );

		var pickBtn = document.getElementById( 'gpcSubmitPickBtn' );
		var input   = document.getElementById( 'gpcSubmitImages' );
		var grid    = document.getElementById( 'gpcSubmitPoolGrid' );

		if ( pickBtn && input ) {
			pickBtn.addEventListener( 'click', function () { input.click(); } );
			input.addEventListener( 'change', function () {
				var remaining = gpcSubmitData.maxImages - imagePool.length;
				var files = Array.prototype.slice.call( input.files ).slice( 0, Math.max( 0, remaining ) );
				files.forEach( function ( file ) { imagePool.push( file ); } );
				renderPool();
				input.value = '';
			} );
		}

		function renderPool() {
			if ( ! grid ) return;
			grid.innerHTML = '';
			imagePool.forEach( function ( file, i ) {
				var thumb = document.createElement( 'div' );
				thumb.className = 'gpc-submit-pool-thumb';
				var url = URL.createObjectURL( file );
				thumb.innerHTML = '<img src="' + url + '" alt=""><button type="button" class="gpc-submit-pool-remove" data-index="' + i + '">✕</button>';
				grid.appendChild( thumb );
			} );
			grid.querySelectorAll( '.gpc-submit-pool-remove' ).forEach( function ( btn ) {
				btn.addEventListener( 'click', function () {
					imagePool.splice( parseInt( btn.getAttribute( 'data-index' ), 10 ), 1 );
					renderPool();
				} );
			} );
		}

		/* ---- Type-dependent field toggling (Property / Ads / regular) ---- */
		var typeSelect       = document.getElementById( 'gpcSubmitType' );
		var regularFields    = document.getElementById( 'gpcRegularFields' );
		var adFields         = document.getElementById( 'gpcAdFields' );
		var subcatSelect     = document.getElementById( 'gpcSubcat' );
		var subcatLabel      = document.getElementById( 'gpcSubcatLabel' );
		var propertyFields   = document.getElementById( 'gpcPropertyFields' );
		var adPlanSelect     = document.getElementById( 'gpcAdPlan' );
		var bannerPickBtn    = document.getElementById( 'gpcAdBannerPickBtn' );
		var bannerInput      = document.getElementById( 'gpcAdBanner' );
		var bannerPreview    = document.getElementById( 'gpcAdBannerPreview' );

		function populateSubcats() {
			if ( ! subcatSelect ) return;
			var subcats = gpcSubmitData.subcats || [];
			subcatSelect.innerHTML = '<option value="">Choose a property type…</option>';
			subcats.forEach( function ( row ) {
				var opt = document.createElement( 'option' );
				opt.value = row.slug;
				opt.textContent = row.label;
				subcatSelect.appendChild( opt );
			} );
		}
		populateSubcats();

		function populatePlans() {
			if ( ! adPlanSelect ) return;
			var plans = gpcSubmitData.adPlans || [];
			adPlanSelect.innerHTML = '';
			if ( ! plans.length ) {
				adPlanSelect.innerHTML = '<option value="">No plans available yet — contact the admin</option>';
				return;
			}
			plans.forEach( function ( plan, i ) {
				var opt = document.createElement( 'option' );
				opt.value = i;
				opt.textContent = plan.label + ' — ₦' + Number( plan.amount ).toLocaleString() + ' / ' + plan.days + ' day' + ( plan.days == 1 ? '' : 's' );
				adPlanSelect.appendChild( opt );
			} );
		}
		populatePlans();

		function onTypeChange() {
			var val = typeSelect.value;
			var isAd = val === 'ads';
			var isProperty = ( gpcSubmitData.propertyTypeSlugs || [] ).indexOf( val ) !== -1;

			if ( adFields )       adFields.style.display = isAd ? '' : 'none';
			if ( regularFields )  regularFields.style.display = isAd ? 'none' : '';
			if ( subcatSelect )   subcatSelect.style.display = ( ! isAd && isProperty ) ? '' : 'none';
			if ( subcatLabel )    subcatLabel.style.display = ( ! isAd && isProperty ) ? '' : 'none';
			if ( propertyFields ) propertyFields.style.display = ( ! isAd && isProperty ) ? '' : 'none';
		}
		if ( typeSelect ) {
			typeSelect.addEventListener( 'change', onTypeChange );
			onTypeChange(); // run once on load in case the browser restored a previous selection
		}

		/* ---- Edit mode: open + prefill the same modal for an existing post ---- */
		window.gpcOpenEditModal = function ( postId ) {
			resetToCreateMode();
			overlay.classList.add( 'is-open' );

			var heading      = document.getElementById( 'gpcSubmitHeading' );
			var note         = document.getElementById( 'gpcSubmitNote' );
			var editIdField  = document.getElementById( 'gpcEditPostId' );
			var submitBtn    = document.getElementById( 'gpcSubmitBtn' );
			var existingGrid = document.getElementById( 'gpcExistingPhotosGrid' );

			if ( heading )     heading.textContent = 'Edit your post';
			if ( note )        note.textContent = 'Loading your post…';
			if ( submitBtn )   submitBtn.textContent = 'Save changes';
			if ( editIdField ) editIdField.value = postId;

			var fd = new FormData();
			fd.append( 'action', 'gpc_frontend_edit_fetch' );
			fd.append( 'nonce', gpcSubmitData.nonce );
			fd.append( 'post_id', postId );

			fetch( gpcSubmitData.ajaxUrl, { method: 'POST', body: fd } )
				.then( function ( r ) { return r.json(); } )
				.then( function ( json ) {
					if ( ! json || ! json.success ) {
						if ( note ) note.textContent = ( json && json.data && json.data.message ) ? json.data.message : 'Could not load this post.';
						return;
					}
					var d = json.data;
					if ( note ) note.textContent = 'Editing your existing post — changes save immediately.';

					setFieldVal( 'gpcSubmitTitle', d.title );
					setFieldVal( 'gpcSubmitDescription', d.description );
					setFieldVal( 'gpcSubmitTags', d.tags );
					setFieldVal( 'gpcSubmitLink', d.link );
					setFieldVal( 'gpcBedrooms', d.bedrooms );
					setFieldVal( 'gpcBathrooms', d.bathrooms );
					setFieldVal( 'gpcToilets', d.toilets );
					setFieldVal( 'gpcLocation', d.location );
					setFieldVal( 'gpcPrice', d.price );
					setFieldVal( 'gpcLat', d.lat );
					setFieldVal( 'gpcLng', d.lng );

					if ( typeSelect && d.type ) { typeSelect.value = d.type; onTypeChange(); }
					if ( subcatSelect && d.subcat ) { subcatSelect.value = d.subcat; }

					existingPhotoCount = ( d.photos || [] ).length;
					if ( existingGrid ) {
						existingGrid.innerHTML = '';
						if ( existingPhotoCount ) {
							existingGrid.style.display = '';
							d.photos.forEach( function ( p ) {
								var thumb = document.createElement( 'div' );
								thumb.className = 'gpc-submit-pool-thumb';
								thumb.innerHTML = '<img src="' + p.url + '" alt="">';
								existingGrid.appendChild( thumb );
							} );
						} else {
							existingGrid.style.display = 'none';
						}
					}

					if ( typeof window.gpcSetMapPickerPin === 'function' && d.lat && d.lng ) {
						window.gpcSetMapPickerPin( parseFloat( d.lat ), parseFloat( d.lng ) );
					}
				} )
				.catch( function () {
					if ( note ) note.textContent = 'Network error — could not load this post. Please try again.';
				} );
		};

		if ( bannerPickBtn && bannerInput ) {
			bannerPickBtn.addEventListener( 'click', function () { bannerInput.click(); } );
			bannerInput.addEventListener( 'change', function () {
				var f = bannerInput.files[0] || null;
				if ( f && f.size > MAX_BANNER_BYTES ) {
					var msgEl = document.getElementById( 'gpcSubmitMsg' );
					if ( msgEl ) { msgEl.textContent = 'That banner image is too large (max 5MB). Please choose a smaller file.'; msgEl.className = 'gpc-submit-msg is-error'; }
					bannerInput.value = '';
					return;
				}
				bannerFile = f;
				if ( bannerPreview ) {
					bannerPreview.innerHTML = '';
					if ( bannerFile ) {
						var thumb = document.createElement( 'div' );
						thumb.className = 'gpc-submit-pool-thumb';
						var url = URL.createObjectURL( bannerFile );
						thumb.innerHTML = '<img src="' + url + '" alt="">';
						bannerPreview.appendChild( thumb );
					}
				}
			} );
		}

		function showMsg( text, isError ) {
			var msg = document.getElementById( 'gpcSubmitMsg' );
			if ( ! msg ) { return; }
			msg.textContent = text;
			msg.className = 'gpc-submit-msg ' + ( isError ? 'is-error' : 'is-success' );
			// Make sure the person actually sees it, even on a tall mobile form.
			if ( typeof msg.scrollIntoView === 'function' ) {
				msg.scrollIntoView( { behavior: 'smooth', block: 'center' } );
			}
		}

		function val( id ) {
			var el = document.getElementById( id );
			return el ? el.value : '';
		}

		form.addEventListener( 'submit', function ( e ) {
			e.preventDefault();

			try {
				var submitBtn = document.getElementById( 'gpcSubmitBtn' );
				var isAd = typeSelect && typeSelect.value === 'ads';
				var isProperty = typeSelect && ( gpcSubmitData.propertyTypeSlugs || [] ).indexOf( typeSelect.value ) !== -1;

				if ( ! isAd && imagePool.length > 0 && imagePool.length < gpcSubmitData.minImages ) {
					showMsg( 'Add at least ' + gpcSubmitData.minImages + ' photos, or none at all — one photo alone will not show a carousel.', true );
					return;
				}
				if ( ! isAd && isProperty && imagePool.length === 0 && existingPhotoCount === 0 ) {
					showMsg( 'Please add at least one photo — a featured image is required for property listings.', true );
					return;
				}
				var hasTypedLocation = !! val( 'gpcLocation' ).trim();
				var hasPinnedLocation = !! ( val( 'gpcLat' ).trim() && val( 'gpcLng' ).trim() );
				if ( ! isAd && isProperty && ! hasTypedLocation && ! hasPinnedLocation ) {
					showMsg( 'Location is required for property listings — type an address or drop a pin on the map.', true );
					return;
				}
				if ( ! isAd && isProperty && ! val( 'gpcPrice' ).trim() ) {
					showMsg( 'Price is required for property listings.', true );
					return;
				}

				if ( isAd ) {
					if ( ! val( 'gpcAdBrand' ).trim() )    { showMsg( 'Brand name is required', true ); return; }
					if ( ! val( 'gpcAdLink' ).trim() )     { showMsg( 'A redirect link is required', true ); return; }
					if ( ! bannerFile )                    { showMsg( 'A banner image is required', true ); return; }
					if ( ! adPlanSelect || adPlanSelect.value === '' ) { showMsg( 'Please choose a plan', true ); return; }
				}

				var fd = new FormData();
				fd.append( 'action', 'gpc_frontend_submit' );
				fd.append( 'nonce', gpcSubmitData.nonce );
				fd.append( 'type', typeSelect ? typeSelect.value : 'general' );
				fd.append( 'edit_post_id', val( 'gpcEditPostId' ) || '0' );
				fd.append( 'title', val( 'gpcSubmitTitle' ) );
				fd.append( 'description', val( 'gpcSubmitDescription' ) );

				if ( isAd ) {
					fd.append( 'brand', val( 'gpcAdBrand' ) );
					fd.append( 'link', val( 'gpcAdLink' ) );
					fd.append( 'plan_index', adPlanSelect.value );
					fd.append( 'age_min', val( 'gpcAdAgeMin' ) );
					fd.append( 'age_max', val( 'gpcAdAgeMax' ) );
					fd.append( 'country', val( 'gpcAdCountry' ) );
					fd.append( 'banner', bannerFile );
				} else {
					fd.append( 'tags', val( 'gpcSubmitTags' ) );
					fd.append( 'link', val( 'gpcSubmitLink' ) );
					var markAsAd = document.getElementById( 'gpcMarkAsAd' );
					if ( markAsAd ) fd.append( 'is_ad', markAsAd.checked ? '1' : '0' );
					if ( isProperty ) {
						fd.append( 'subcat', subcatSelect ? subcatSelect.value : '' );
						fd.append( 'bedrooms', val( 'gpcBedrooms' ) );
						fd.append( 'bathrooms', val( 'gpcBathrooms' ) );
						fd.append( 'toilets', val( 'gpcToilets' ) );
						fd.append( 'location', val( 'gpcLocation' ) );
						fd.append( 'price', val( 'gpcPrice' ) );
						fd.append( 'lat', val( 'gpcLat' ) );
						fd.append( 'lng', val( 'gpcLng' ) );
					}
					imagePool.forEach( function ( file ) { fd.append( 'images[]', file ); } );
				}

				if ( submitBtn ) { submitBtn.disabled = true; submitBtn.textContent = 'Submitting…'; }
				showMsg( '', false );

				fetch( gpcSubmitData.ajaxUrl, { method: 'POST', body: fd } )
					.then( function ( r ) { return r.json(); } )
					.then( function ( json ) {
						if ( json && json.success ) {
							var wasEdit = !! val( 'gpcEditPostId' );
							showMsg( json.data && json.data.message ? json.data.message : 'Submitted!', false );
							resetToCreateMode();
							setTimeout( function () {
								overlay.classList.remove( 'is-open' );
								if ( wasEdit ) { window.location.reload(); }
							}, wasEdit ? 900 : 2200 );
						} else {
							showMsg( json && json.data && json.data.message ? json.data.message : 'Something went wrong. Please try again.', true );
						}
					} )
					.catch( function ( err ) {
						console.error( 'GPC submit error:', err );
						showMsg( 'Network error — please check your connection and try again.', true );
					} )
					.finally( function () {
						if ( submitBtn ) { submitBtn.disabled = false; submitBtn.textContent = 'Submit for review'; }
					} );
			} catch ( err ) {
				console.error( 'GPC submit handler error:', err );
				showMsg( 'Something went wrong on this page. Please refresh and try again.', true );
			}
		} );
	} );
})();

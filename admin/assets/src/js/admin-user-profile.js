/* global MMAOCFCA */

import domReady from '@wordpress/dom-ready'

domReady( () => {
	const coupons = MMAOCFCA.ALL_COUPONS

	const industryCustomerCheckbox = document.getElementById( 'mmaocfca_industry_customer' )
	const autoApplyCouponCheckbox  = document.getElementById( 'mmaocfca_apply_auto_coupon' )

	const applyAutoCouponContainer = document.getElementById( 'mmaocfca_auto_apply_coupon_container' )
	const autoCouponsContainer     = document.getElementById( 'mmaocfca_auto_coupons_container' )
	const autoCouponsSearchInput   = document.getElementById( 'mmaocfca_auto_coupons_names' )
	const autoCouponsHiddenValue   = document.getElementById( 'mmaocfca_auto_coupons' )

	const suggestionsContainer = document.getElementById( 'mmaocfca-autocomplete-coupons-list' )

	const searchKeys = [
		'name',
		'code',
	]

	industryCustomerCheckbox.addEventListener( 'click', ( { target } ) => {
		const { checked } = target

		switch ( checked ) {
			case true: {
				applyAutoCouponContainer.classList.remove( 'hidden' )
				break
			}
			case false:
			default: {
				applyAutoCouponContainer.classList.add( 'hidden' )
				autoCouponsContainer.classList.add( 'hidden' )

				autoCouponsSearchInput.value = ''
				autoCouponsHiddenValue.value = ''
				break
			}
		}
	} )

	autoApplyCouponCheckbox.addEventListener( 'click', ( { target } ) => {
		const { checked } = target

		switch ( checked ) {
			case true: {
				autoCouponsContainer.classList.remove( 'hidden' )
				break
			}
			case false:
			default: {
				autoCouponsContainer.classList.add( 'hidden' )

				autoCouponsSearchInput.value = ''
				autoCouponsHiddenValue.value = ''
				break
			}
		}
	} )

	autoCouponsSearchInput.addEventListener( 'input', () => {
		// Clear previous suggestions.
		suggestionsContainer.innerHTML = '';
		suggestionsContainer.classList.add( 'hidden' )

		const value = autoCouponsSearchInput.value.toLowerCase()

		const matches = coupons.filter( ( coupon ) => {
			let found = false

			searchKeys.forEach( ( searchKey ) => {
				found = found || coupon[ searchKey ].toLowerCase().includes( value )
			} )

			return found
		} )

		matches.forEach( ( match ) => {
			const li = document.createElement( 'li' )

			li.textContent = `${ match.name } (${ match.code })`
			li.classList.add( 'autocomplete-item' )

			li.addEventListener( 'click', () => {
				autoCouponsSearchInput.value = `${ match.name } (${ match.code })`
				autoCouponsHiddenValue.value = match.id

				suggestionsContainer.innerHTML = ''

				suggestionsContainer.classList.add( 'hidden' )
			} )

			suggestionsContainer.appendChild( li )
		} )

		if ( matches?.length ) {
			suggestionsContainer.classList.remove( 'hidden' )
		}
	} )
} )

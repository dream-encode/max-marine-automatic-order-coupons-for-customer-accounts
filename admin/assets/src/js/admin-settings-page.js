import {
	createRoot
} from '@wordpress/element'

import domReady from '@wordpress/dom-ready'

import AdminSettingsPage from './components/AdminSettings/AdminSettingsPage.jsx'

domReady( () => {
	const root = createRoot(
		document.getElementById( 'max-marine-automatic-order-coupons-for-customer-accounts-plugin-settings' )
	)

	root.render( <AdminSettingsPage /> )
} )

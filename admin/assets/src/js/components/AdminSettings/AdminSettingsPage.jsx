import { __ } from '@wordpress/i18n'

import {
	PanelBody,
	PanelRow,
	Button,
	SelectControl,
	Placeholder,
	Spinner,
	__experimentalHStack as HStack
} from '@wordpress/components'

import {
	Fragment
} from '@wordpress/element'

import {
	useDispatch
} from '@wordpress/data'

import {
	store as noticesStore
} from '@wordpress/notices'

import { useSettings } from '../../hooks/useSettings'
import Notices from '../Notices/Notices'

const AdminSettingsPage = () => {
    const { createSuccessNotice } = useDispatch( noticesStore )

	const {
		settingsLoaded,
        pluginLogLevel,
        updatePluginLogLevel,
		saveSettings,
		settingsSaving
    } = useSettings()

	const updateSettings = async ( event ) => {
		event.preventDefault()

		saveSettings()
			.then( () => {
				createSuccessNotice(
					__( 'Settings saved.', 'max-marine-automatic-order-coupons-for-customer-accounts' )
				)
			} )
	}

	return (
		<Fragment>
			<div className="settings-header">
				<div className="settings-container">
					<div className="settings-logo">
						<h1>{ __( 'Max Marine - Automatic Order Coupons For Customer Accounts', 'max-marine-automatic-order-coupons-for-customer-accounts' ) }</h1>
					</div>
				</div>
			</div>

			<div className="settings-main">
				{ ! settingsLoaded ? (
					<Placeholder>
						<Spinner />
					</Placeholder>
				) : (
					<Fragment>
						<Notices />

						<PanelBody title={ __( 'General', 'max-marine-automatic-order-coupons-for-customer-accounts' ) }>
							<PanelRow className="field-row">
								<SelectControl
									label={ __( 'Log Level', 'max-marine-automatic-order-coupons-for-customer-accounts' ) }
									value={ pluginLogLevel || 'off' }
									options={ mappedLogLevels }
									onChange={ updatePluginLogLevel }
									__nextHasNoMarginBottom
								/>
							</PanelRow>
						</PanelBody>
						<HStack
							alignment="center"
						>
							<Button
								variant="primary"
								isBusy={ settingsSaving }
								isLarge
								target="_blank"
								href="#"
								onClick={ updateSettings }
							>
								{ __( 'Save', 'max-marine-automatic-order-coupons-for-customer-accounts' ) }
							</Button>
						</HStack>

					</Fragment>
				) }
			</div>
		</Fragment>
	)
}

export default AdminSettingsPage

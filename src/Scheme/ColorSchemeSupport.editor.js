/**
 * The control of the color scheme of sections, groups and columns: every scheme as it is defined in the settings,
 * with its name and a swatch of its colors. A block without a scheme of its own shows the first (the page scheme)
 * as chosen: at the top level that is what it has. The schemes are view data of SchemeStyles.
 */
import {
	getData,
	registerSupportControl,
} from '@webcodingcat/wp-app-framework';
import { BaseControl, Button } from '@wordpress/components';

function Swatch( { scheme, page } ) {
	const color = ( key ) => scheme[ key ] || page?.[ key ] || 'transparent';
	return (
		<span
			className="strata-scheme-swatch"
			style={ {
				display: 'inline-flex',
				alignItems: 'center',
				justifyContent: 'center',
				width: '28px',
				height: '28px',
				marginInlineEnd: '8px',
				borderRadius: '50%',
				border: '2px solid',
				fontSize: '11px',
				fontWeight: 600,
				background: color( 'background' ),
				color: color( 'foreground' ),
				borderColor: color( 'accent' ),
			} }
		>
			Aa
		</span>
	);
}

registerSupportControl( 'colorScheme', ( { value, onChange } ) => {
	const schemes = ( getData( 'colorSchemes' ) ?? [] ).filter(
		( scheme ) => scheme.id !== ''
	);
	const page = schemes[ 0 ];
	const chosen = schemes.some( ( scheme ) => scheme.id === value )
		? value
		: page?.id;
	return (
		<div className="strata-scheme-control">
			<BaseControl.VisualLabel>Color scheme</BaseControl.VisualLabel>
			<div
				className="strata-scheme-choices"
				role="radiogroup"
				aria-label="Color scheme"
				style={ { display: 'flex', flexWrap: 'wrap', gap: '4px' } }
			>
				{ schemes.map( ( scheme ) => (
					<Button
						key={ scheme.id }
						role="radio"
						aria-checked={ chosen === scheme.id }
						isPressed={ chosen === scheme.id }
						onClick={ () => onChange( scheme.id ) }
					>
						<Swatch scheme={ scheme } page={ page } />
						{ scheme.name }
					</Button>
				) ) }
			</div>
		</div>
	);
} );

/**
 * The control of the color scheme of sections and groups: one swatch per scheme besides the page scheme, and
 * "Around" for none, which keeps the scheme around the block – its swatch shows the page scheme, dashed. The
 * schemes are view data of SchemeStyles.
 */
import { getData, registerSupportControl } from '@saij/wp-app-framework';
import { BaseControl, Button } from '@wordpress/components';

function Swatch( { scheme, page, dashed = false } ) {
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
				border: `2px ${ dashed ? 'dashed' : 'solid' }`,
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
	const schemes = getData( 'colorSchemes' ) ?? [];
	const [ page, ...choices ] = schemes;
	return (
		<div className="strata-scheme-control">
			<BaseControl.VisualLabel>Color scheme</BaseControl.VisualLabel>
			<div
				className="strata-scheme-choices"
				role="radiogroup"
				aria-label="Color scheme"
				style={ { display: 'flex', flexWrap: 'wrap', gap: '4px' } }
			>
				<Button
					role="radio"
					aria-checked={ ! value }
					isPressed={ ! value }
					onClick={ () => onChange( '' ) }
				>
					<Swatch scheme={ {} } page={ page } dashed />
					Around
				</Button>
				{ choices.map( ( scheme ) => (
					<Button
						key={ scheme.id }
						role="radio"
						aria-checked={ value === scheme.id }
						isPressed={ value === scheme.id }
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

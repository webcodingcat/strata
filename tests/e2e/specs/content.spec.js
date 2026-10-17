/**
 * Content blocks on the front end: people with their contact links, facts with icons and links, and a glossary whose
 * index links every letter to its first term.
 */
const path = require( 'path' );

const { test, expect } = require( '../fixtures' );

const { block, cleanUp, createPost } = require( '../helpers' );

const url = ( value ) => ( {
	url: value,
	opensInNewTab: false,
	kind: 'url',
	id: 0,
} );

test.describe( 'Content blocks', () => {
	test.afterEach( async ( { requestUtils } ) => {
		await cleanUp( requestUtils );
	} );

	test( 'show an image of the media library as an image, not as text', async ( {
		page,
		requestUtils,
	} ) => {
		const media = await requestUtils.uploadMedia(
			path.join( __dirname, '../assets/image.png' )
		);
		try {
			const post = await createPost( requestUtils, {
				content: block(
					'strata/section',
					{},
					block( 'strata/image', {
						imageId: media.id,
						caption: 'Red',
					} )
				),
			} );
			await page.goto( post.link );

			const figure = page.locator( '.strata-image' );
			await expect( figure.locator( 'img' ) ).toHaveAttribute(
				'src',
				/image.*\.png$/
			);
			await expect(
				figure.locator( '.strata-image__media' )
			).not.toContainText( '<img' );
			await expect( figure.locator( 'figcaption' ) ).toHaveText( 'Red' );
		} finally {
			await requestUtils.deleteMedia( media.id );
		}
	} );

	test( 'show people in a grid, with phone and email as links where given', async ( {
		page,
		requestUtils,
	} ) => {
		const person = ( attributes ) => block( 'strata/person', attributes );
		const post = await createPost( requestUtils, {
			content: block(
				'strata/section',
				{},
				block(
					'strata/people',
					{ columns: '3' },
					[
						person( {
							name: 'Kirsten',
							role: 'President',
							phone: '+49 162 42 55 480',
							email: 'kirsten@example.org',
						} ),
						person( { name: 'Michi', role: 'Vice president' } ),
						person( { name: 'Anke' } ),
					].join( '\n' )
				)
			),
		} );
		await page.setViewportSize( { width: 1280, height: 900 } );
		await page.goto( post.link );

		const people = page.locator( '.strata-person' );
		await expect( people ).toHaveCount( 3 );
		const tops = await Promise.all(
			[ 0, 1, 2 ].map(
				async ( index ) => ( await people.nth( index ).boundingBox() ).y
			)
		);
		expect( new Set( tops ).size ).toBe( 1 );

		const kirsten = people.nth( 0 );
		await expect(
			kirsten.getByRole( 'link', { name: '+49 162 42 55 480' } )
		).toHaveAttribute( 'href', 'tel:+491624255480' );
		await expect(
			kirsten.getByRole( 'link', { name: 'kirsten@example.org' } )
		).toHaveAttribute( 'href', 'mailto:kirsten@example.org' );
		// Empty fields leave nothing behind on the front end.
		await expect( people.nth( 1 ).getByRole( 'link' ) ).toHaveCount( 0 );
		await expect( people.nth( 2 ).locator( 'figcaption > *' ) ).toHaveCount(
			1
		);
		await expect( people.nth( 2 ).locator( 'img' ) ).toHaveCount( 0 );
	} );

	test( 'show facts with icons, as boxes, the value linked where given', async ( {
		page,
		requestUtils,
	} ) => {
		const post = await createPost( requestUtils, {
			content: block(
				'strata/section',
				{},
				block(
					'strata/facts',
					{ boxed: true },
					[
						block( 'strata/fact', {
							icon: 'clock',
							label: 'Training',
							value: 'Tuesdays\nfrom 7 pm',
						} ),
						block( 'strata/fact', {
							icon: 'none',
							label: 'Place',
							value: 'Hall',
							link: url( '#directions' ),
						} ),
					].join( '\n' )
				)
			),
		} );
		await page.goto( post.link );

		const facts = page.locator( '.strata-fact' );
		await expect( facts.nth( 0 ).locator( 'svg' ) ).toHaveCount( 1 );
		await expect( facts.nth( 0 ) ).toContainText( 'Tuesdays' );
		await expect( facts.nth( 0 ).locator( 'br' ) ).toHaveCount( 1 );
		await expect( facts.nth( 1 ).locator( 'svg' ) ).toHaveCount( 0 );
		await expect(
			facts.nth( 1 ).getByRole( 'link', { name: 'Hall' } )
		).toHaveAttribute( 'href', '#directions' );
		// Boxes take the raised background of the scheme.
		await expect( facts.nth( 0 ) ).not.toHaveCSS(
			'background-color',
			'rgba(0, 0, 0, 0)'
		);
	} );

	test( 'link every letter of the glossary index to its first term', async ( {
		page,
		requestUtils,
	} ) => {
		const term = ( name, explanation ) =>
			block( 'strata/glossary-term', { term: name }, explanation );
		const post = await createPost( requestUtils, {
			content: block(
				'strata/section',
				{},
				block(
					'strata/glossary',
					{},
					[
						term( 'Applejack', 'A step.' ),
						term( 'Ändern', 'Change.' ),
						term( 'Coaster Step', 'Back, together, forward.' ),
						term( '1-2-3', 'Counting.' ),
					].join( '\n' )
				)
			),
		} );
		await page.goto( post.link );

		const index = page.getByRole( 'navigation', { name: 'Index' } );
		await expect(
			index.getByRole( 'link', { name: 'A', exact: true } )
		).toHaveAttribute( 'href', '#applejack' );
		await expect(
			index.getByRole( 'link', { name: 'C', exact: true } )
		).toHaveAttribute( 'href', '#coaster-step' );
		await expect(
			index.getByRole( 'link', { name: '#', exact: true } )
		).toHaveAttribute( 'href', '#1-2-3' );
		// Letters without a term are no links; # appears only for terms that start otherwise.
		await expect( index.getByRole( 'link' ) ).toHaveCount( 3 );
		await expect( index.locator( 'span' ) ).toHaveCount( 24 );

		const terms = page.locator( '.strata-glossary-term' );
		await expect( terms.locator( 'dt' ) ).toHaveText( [
			'Applejack',
			'Ändern',
			'Coaster Step',
			'1-2-3',
		] );
		await expect( terms.nth( 2 ).locator( 'dd' ) ).toHaveText(
			'Back, together, forward.'
		);
		await index.getByRole( 'link', { name: 'C', exact: true } ).click();
		await expect( page ).toHaveURL( /#coaster-step$/ );
		await expect( page.locator( '#coaster-step' ) ).toBeInViewport();
	} );
} );

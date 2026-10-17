/**
 * The block editor: the blocks of the theme instead of the core blocks that store markup, a section with a color
 * scheme chosen in the inspector, and every block of the theme without console errors.
 */
const { test, expect } = require( '../fixtures' );

const {
	SCHEMES,
	block,
	cleanUp,
	createPost,
	openEditor,
} = require( '../helpers' );

test.describe( 'Editor', () => {
	test.afterEach( async ( { requestUtils } ) => {
		await cleanUp( requestUtils );
	} );

	test( 'offers sections at the top level and the blocks of the theme inside them', async ( {
		admin,
		editor,
		page,
		requestUtils,
	} ) => {
		const post = await createPost( requestUtils, {
			status: 'draft',
			content: block(
				'strata/section',
				{},
				block( 'strata/paragraph', {}, 'Inside' )
			),
		} );
		await openEditor( { admin, editor }, post.id );
		await expect(
			editor.canvas.locator( '[data-type="strata/section"]' )
		).toBeVisible();

		const insertable = await page.evaluate( () => {
			const store = window.wp.data.select( 'core/block-editor' );
			const section = store.getBlocks()[ 0 ].clientId;
			const names = [
				'core/paragraph',
				'core/heading',
				'core/group',
				'core/query',
				'core/search',
				'core/site-title',
				'strata/paragraph',
				'strata/columns',
				'strata/section',
			];
			return {
				top: Object.fromEntries(
					names.map( ( name ) => [
						name,
						store.canInsertBlockType( name ),
					] )
				),
				section: Object.fromEntries(
					names.map( ( name ) => [
						name,
						store.canInsertBlockType( name, section ),
					] )
				),
			};
		} );
		// The top level holds sections only; core blocks that store markup are not offered at all.
		expect( insertable.top ).toEqual( {
			'core/paragraph': false,
			'core/heading': false,
			'core/group': false,
			'core/query': false,
			'core/search': false,
			'core/site-title': false,
			'strata/paragraph': false,
			'strata/columns': false,
			'strata/section': true,
		} );
		expect( insertable.section ).toEqual( {
			'core/paragraph': false,
			'core/heading': false,
			'core/group': false,
			'core/query': false,
			'core/search': false,
			'core/site-title': true,
			'strata/paragraph': true,
			'strata/columns': true,
			'strata/section': true,
		} );
	} );

	test( 'chooses the color scheme of a section and edits its heading', async ( {
		admin,
		editor,
		page,
		requestUtils,
	} ) => {
		const post = await createPost( requestUtils, {
			status: 'draft',
			content: block(
				'strata/section',
				{},
				block( 'strata/heading', {}, 'Hello' )
			),
		} );
		await openEditor( { admin, editor }, post.id );
		const section = editor.canvas.locator( '[data-type="strata/section"]' );
		await expect( section.locator( '.strata-heading' ) ).toHaveText(
			'Hello'
		);

		await editor.selectBlocks( section );
		await editor.openDocumentSettingsSidebar();
		await page
			.getByRole( 'region', { name: 'Editor settings' } )
			.getByRole( 'tab', { name: 'Styles' } )
			.click();
		// Every scheme as it is defined; without a scheme of its own the page scheme is chosen.
		await expect( page.getByRole( 'radio' ) ).toHaveText( [
			'AaPage',
			'AaSoft',
			'AaDark',
		] );
		await expect(
			page.getByRole( 'radio', { name: 'Page' } )
		).toHaveAttribute( 'aria-checked', 'true' );
		await page.getByRole( 'radio', { name: 'Dark' } ).click();
		await expect( section ).toHaveClass( /scheme-c3f5a7d9/ );
		await expect( section ).toHaveCSS(
			'background-color',
			'rgb(22, 24, 29)'
		);

		await section.locator( '.strata-heading' ).click();
		await page.keyboard.press( 'End' );
		await page.keyboard.type( ' world' );
		await editor.saveDraft();
		const saved = await requestUtils.rest( {
			path: `/wp/v2/pages/${ post.id }`,
			params: { context: 'edit' },
		} );
		expect( saved.content.raw ).toContain(
			`"colorScheme":"${ SCHEMES.dark }"`
		);
		expect( saved.content.raw ).toContain( 'Hello world' );
	} );

	test( 'renders every block of the theme', async ( {
		admin,
		editor,
		requestUtils,
	} ) => {
		const content = block(
			'strata/section',
			{},
			[
				block( 'strata/heading', {}, 'Heading' ),
				block( 'strata/paragraph', {}, 'Paragraph' ),
				block(
					'strata/list',
					{},
					block(
						'strata/list-item',
						{},
						block( 'strata/paragraph', {}, 'Item' )
					)
				),
				block( 'strata/image', { caption: 'Caption' } ),
				block(
					'strata/buttons',
					{},
					block( 'strata/button', { label: 'Button' } )
				),
				block(
					'strata/columns',
					{},
					[
						block(
							'strata/column',
							{},
							block( 'strata/paragraph', {}, 'One' )
						),
						block(
							'strata/column',
							{},
							block( 'strata/paragraph', {}, 'Two' )
						),
					].join( '\n' )
				),
				block( 'strata/quote', { citation: 'Source' }, 'Quote' ),
				block( 'strata/separator', { variant: 'short' } ),
				block(
					'strata/details',
					{ summary: 'Summary' },
					block( 'strata/paragraph', {}, 'Answer' )
				),
				block(
					'strata/group',
					{ layout: 'row' },
					block( 'strata/copyright' )
				),
				block(
					'strata/navigation',
					{},
					block( 'strata/navigation-link', { label: 'Link' } )
				),
			].join( '\n' )
		);
		const post = await createPost( requestUtils, {
			status: 'draft',
			content,
		} );
		await openEditor( { admin, editor }, post.id );

		const canvas = editor.canvas;
		for ( const selector of [
			'.strata-heading',
			'.strata-paragraph',
			'.strata-list-item',
			'.strata-image',
			'.strata-button',
			'.strata-columns',
			'.strata-quote',
			'hr.strata-separator',
			'.strata-details',
			'.strata-copyright',
			'.strata-navigation-link',
		] ) {
			await expect( canvas.locator( selector ).first() ).toBeVisible();
		}
		// The details stay open in the editor, so their content can be edited.
		await expect(
			canvas.locator( '.strata-details' ).getByText( 'Answer' )
		).toBeVisible();
	} );
} );

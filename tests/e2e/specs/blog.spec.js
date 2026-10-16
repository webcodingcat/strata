/**
 * The blog: the posts of the page in the post template, with pagination, and a single post.
 */
const { test, expect } = require( '../fixtures' );

const { block, cleanUp, createPost } = require( '../helpers' );

test.describe( 'Blog', () => {
	test.afterEach( async ( { requestUtils } ) => {
		await cleanUp( requestUtils );
	} );

	test( 'lists the posts with pagination and shows a single post', async ( {
		page,
		requestUtils,
	} ) => {
		const settings = await requestUtils.rest( { path: '/wp/v2/settings' } );
		const perPage = settings.posts_per_page;
		const posts = [];
		for ( let index = 1; index <= perPage + 1; index++ ) {
			posts.push(
				await createPost(
					requestUtils,
					{
						title: `Blog post ${ index }`,
						date_gmt: `2020-01-${ String( index ).padStart(
							2,
							'0'
						) }T00:00:00`,
						content: block(
							'strata/paragraph',
							{},
							`Text ${ index }`
						),
					},
					'posts'
				)
			);
		}

		await page.goto( '/' );
		const items = page.locator( '.strata-post-template__item' );
		await expect( items ).toHaveCount( perPage );
		await expect(
			items.first().locator( '.wp-block-post-title' )
		).toBeVisible();
		const pagination = page.locator( '.strata-pagination' );
		await expect( pagination.locator( '.current' ) ).toHaveText( '1' );

		await pagination.getByRole( 'link', { name: 'Older posts' } ).click();
		await expect( page ).toHaveURL( /\/page\/2\/|paged=2/ );
		await expect( items.first() ).toBeVisible();

		await page.goto( posts[ 0 ].link );
		await expect(
			page.locator( 'main h1.wp-block-post-title' )
		).toHaveText( 'Blog post 1' );
		await expect( page.locator( 'main .strata-paragraph' ) ).toHaveText(
			'Text 1'
		);
	} );
} );

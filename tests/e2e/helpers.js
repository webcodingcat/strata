/**
 * Helpers of the browser tests: serialized blocks, posts the tests create and delete again, and the color schemes,
 * restored after a test.
 */

/** Posts (rest base and ID) the tests created; cleanUp() deletes them. */
const created = [];

/** Identifiers of the default schemes (src/Scheme/ColorSchemes.php). */
const SCHEMES = { page: 'a1e5c0de', soft: 'b2d4e6f8', dark: 'c3f5a7d9' };

/**
 * A serialized block.
 *
 * @param {string} name
 * @param {Object} [attributes]
 * @param {string} [inner]      Inner blocks or the text of a post content field.
 * @return {string} Block markup.
 */
function block( name, attributes = {}, inner ) {
	const json = Object.keys( attributes ).length
		? ` ${ JSON.stringify( attributes ) }`
		: '';
	return inner === undefined
		? `<!-- wp:${ name }${ json } /-->`
		: `<!-- wp:${ name }${ json } -->\n${ inner }\n<!-- /wp:${ name } -->`;
}

/**
 * Creates a post or page; cleanUp() deletes it.
 *
 * @param {Object} requestUtils
 * @param {Object} post         Fields: title, content, status (default publish).
 * @param {string} [restBase]   "posts" or "pages".
 * @return {Promise<Object>} The post as the REST API returns it.
 */
async function createPost( requestUtils, post, restBase = 'pages' ) {
	const result = await requestUtils.rest( {
		method: 'POST',
		path: `/wp/v2/${ restBase }`,
		data: { status: 'publish', title: 'E2E', ...post },
	} );
	created.push( [ restBase, result.id ] );
	return result;
}

/**
 * @param {Object} requestUtils
 */
async function cleanUp( requestUtils ) {
	while ( created.length > 0 ) {
		const [ restBase, id ] = created.pop();
		await requestUtils.rest( {
			method: 'DELETE',
			path: `/wp/v2/${ restBase }/${ id }`,
			params: { force: true },
		} );
	}
}

/**
 * The stored color schemes (the option strata_color_schemes).
 *
 * @param {Object} requestUtils
 * @return {Promise<Object>} The settings group.
 */
async function colorSchemes( requestUtils ) {
	const settings = await requestUtils.rest( { path: '/wp/v2/settings' } );
	return settings.strata_color_schemes;
}

/**
 * Saves the color schemes through the REST API.
 *
 * @param {Object} requestUtils
 * @param {Object} value        The settings group.
 */
async function saveColorSchemes( requestUtils, value ) {
	await requestUtils.rest( {
		method: 'POST',
		path: '/wp/v2/settings',
		data: { strata_color_schemes: value },
	} );
}

/**
 * Opens a post or page in the block editor.
 *
 * @param {Object} fixtures
 * @param {Object} fixtures.admin
 * @param {Object} fixtures.editor
 * @param {number} id
 */
async function openEditor( { admin, editor }, id ) {
	await admin.visitAdminPage( 'post.php', `post=${ id }&action=edit` );
	await editor.setPreferences( 'core/edit-post', {
		welcomeGuide: false,
		fullscreenMode: false,
	} );
}

module.exports = {
	SCHEMES,
	block,
	cleanUp,
	colorSchemes,
	createPost,
	openEditor,
	saveColorSchemes,
};

import { BlockView } from '@webcodingcat/wp-app-framework/view';

/**
 * Closes the menu panel of small screens when a link in it is followed: a link to a section of the same page does not
 * leave the page, and the panel would cover the section.
 */
export default class Navigation extends BlockView {
	mount() {
		const panel = this.find( '.strata-navigation__panel' );
		this.listen( panel, 'click', ( event ) => {
			if (
				event.target.closest( 'a' ) &&
				panel.matches( ':popover-open' )
			) {
				panel.hidePopover();
			}
		} );
	}
}

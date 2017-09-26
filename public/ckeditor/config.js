/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
};
var toolbar_group = {
	toolbarGroups: [
		{"name":"basicstyles","groups":["basicstyles"]},
		{"name":"links","groups":["links"]},
		{"name":"paragraph","groups":["list"]},
		// {"name":"document","groups":["mode"]},
		// {"name":"insert","groups":["insert"]},
		{"name":"styles","groups":["styles"]},
		// {"name":"about","groups":["about"]}
	],
	baseFloatZIndex : 20000
}
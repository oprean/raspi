define([
	'jquery',
	'underscore',
	'backbone',
	'backbone.marionette',
	'modules/Utils',
	'collections/Settings',
	'views/HeaderView',
	'views/FooterView',
	'globals'
], function( $, _, Backbone, Marionette, Utils, Settings, HeaderView, FooterView, globals) {
	var App = Backbone.Marionette.Application.extend({
		initialize: function() {
			Settings.fetch({async:false});
			$.ajaxSetup({cache: false});
					
			this.env = Utils.bootstrapEnv();
			this.rootUri = globals.rootUri;
			this.addRegions({
				headerRegion : "#header-container",
				mainRegion: "#main-container",
				footerRegion: "#footer-container",
			});

			this.headerRegion.show(new HeaderView());
			this.footerRegion.show(new FooterView());
		}
	});
	
	return App;
});
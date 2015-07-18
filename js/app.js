define([
	'jquery',
	'underscore',
	'backbone',
	'backbone.marionette',
	'modules/Utils',
	'views/HeaderView',
	'views/FooterView',
], function( $, _, Backbone, Marionette, Utils, HeaderView, FooterView) {
	var App = Backbone.Marionette.Application.extend({
		initialize: function() {
			$.ajaxSetup({cache: false});
			this.env = Utils.bootstrapEnv();
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
define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'views/tiles/BaseTileView',
  'text!templates/tiles/ledstrip_tile.html',
  'collections/Settings',
  'modules/Utils',
], function($, _, Backbone, Marionette, BaseTileView, tileTpl, Settings, Utils){
	var LedstripTileView = BaseTileView.extend({
		template : _.template(tileTpl),
		
		events : {
			'click .tile-content' : 'action',
		},
		
		initialize : function(options) {
			this.data = this.model.get('data');
		},
		
		updateLedstrip : function() {
			var self = this;	
			Utils.authAjax({
				type: "POST",
				url: 'api/ledstrip',
				data: {
					cmd: this.data.cmd,
					r: this.data.r,
					g: this.data.g,
					b: this.data.b
				},  
			});
		},
		
		action : function(e) {
			this.updateLedstrip();
		},
		
		templateHelpers: function() {
			return {
			};
		}
	});
	 
	return LedstripTileView;
});
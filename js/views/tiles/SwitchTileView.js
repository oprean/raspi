define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'views/tiles/BaseTileView',
  'text!templates/tiles/switch_tile.html',
], function($, _, Backbone, Marionette, BaseTileView, tileTpl){
	var SwitchTileView = BaseTileView.extend({
		template : _.template(tileTpl),
		
		events : {
			'click .tile-container' : 'action',
		},
		
		initialize : function(options) {
			var self = this;
		},
		
		action : function(e) {
			console.log('switch tile action');
		},
		
		templateHelpers: function() {
			return {
			};
		}
	});
	 
	return SwitchTileView;
});
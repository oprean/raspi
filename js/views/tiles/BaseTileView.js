//https://samkelleher.com/portfolio/Responsive-Realtime-Customisable-Interactive-Dashboard
define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'text!templates/tiles/base_tile.html',
], function($, _, Backbone, Marionette, tileTpl){
	var BaseTileView = Backbone.Marionette.ItemView.extend({
		template : _.template(tileTpl),
		className : 'tile-container',
		
		events : {
			'click .tile-container' : 'action',
		},
		
		initialize : function(options) {
			var self = this;
		},
		
		action : function(e) {
			console.log('base tile action');
		},
		
		templateHelpers: function() {
			return {
			};
		}
	});
	 
	return BaseTileView;
});
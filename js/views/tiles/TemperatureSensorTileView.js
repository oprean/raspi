define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'views/tiles/BaseTileView',
  'text!templates/tiles/temperature_sensor_tile.html',
], function($, _, Backbone, Marionette, BaseTileView, tileTpl){
	var TemperatureSensorTileView = BaseTileView.extend({
		template : _.template(tileTpl),
		
		events : {
			'click .tile-container' : 'action',
		},
		
		initialize : function(options) {
			var self = this;
		},
		
		action : function(e) {
			console.log('temp sensor tile action');
		},
		
		templateHelpers: function() {
			return {
			};
		}
	});
	 
	return TemperatureSensorTileView;
});
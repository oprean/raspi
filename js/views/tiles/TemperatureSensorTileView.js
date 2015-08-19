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
			'click .tile-content' : 'action',
		},
		
		initialize : function(options) {
			this.temperature = 'N/A';
			this.data = this.model.get('data');
			this.updateTemperature();
		},
		
		updateTemperature : function() {
			var self = this;
			$.getJSON('api/temperature/now/'+ this.data.type, function(data){
				self.temperature = data.value;
				self.$('.tile-content').html(data.value + '<sup style="font-size:.5em;">°C</sup>');
				self.$('.tile-footer').html(data.date); 	
			});			
		},
		
		action : function(e) {
			this.updateTemperature();
		},
		
		templateHelpers: function() {
			return {
			};
		}
	});
	 
	return TemperatureSensorTileView;
});
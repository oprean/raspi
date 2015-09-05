define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'views/tiles/BaseTileView',
  'text!templates/tiles/temperature_sensor_tile.html',
  'collections/Settings',
], function($, _, Backbone, Marionette, BaseTileView, tileTpl, Settings){
	var TemperatureSensorTileView = BaseTileView.extend({
		template : _.template(tileTpl),
		
		events : {
			'click .tile-content' : 'action',
		},
		
		initialize : function(options) {
			this.data = this.model.get('data');
			//this.intT = '--';
			//this.decT = '-';
			this.updateTemperature();
		},
		
		updateTemperature : function() {
			var self = this;		
			$.ajax({
				type: "GET",
  				dataType: "json",
				url: 'api/temperature/now/' + this.data.type,
				headers: {'Authorization': Settings.getVal('token')},
				beforeSend: function() {
					self.$('.tile-footer').html('fetching data ...');
				},
				error: function(jqXHR, textStatus, errorThrown) {
					if (jqXHR.status == 401) {
						window.location.href = app.rootUri + '#login';
					} else {
						console.log(jqXHR);
					}
				},
				success: function(data) {
					var temp = parseFloat(data.value).toPrecision(3);
					var intT = parseInt(temp);
					var decT = temp.slice(temp.indexOf('.'));
					self.$('.int').html(intT);
					self.$('.dec').html(decT);
					self.$('.tile-footer').html(data.date);	
				}  
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
define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'text!templates/temperatures.html',
  'collections/Temperatures',
], function($, _, Backbone, Marionette, statsTpl, Temperatures){
	var TemperaturesView = Backbone.Marionette.ItemView.extend({
		template : _.template(statsTpl),
		initialize : function(options) {
			var self = this;
			this.temperatures = null;
			var stats = new Temperatures();
			stats.fetch({
				success: function(temps) {
					self.temperatures = temps;
					self.render();
				}
			});
		},
		
		/*onRender: function() {
			// Create ZingChart Model Passing in Data to Plot
			if (this.temperatures != null) {
				var chartData = new ZingChart.ZingChartModel(
				            {
				                //data: [[3,2,3,3,9] , [1,2,3,4,5]],
				                data : this.temperatures.pluck("value"),
				                width: 500,
				                height: 400
				            });
				
				
				// Render the Chart
				// Note that the el must already be added to the DOM
				var chartView = new ZingChart.ZingChartView({model: chartData, el: this.$('#zing-chart-container')});
				chartView.render();				
			}
		},*/
		
		templateHelpers: function() {
			return {
				temperatures: this.temperatures,
				getCss: function(value) {
					if (value <= 27) {
						return 'info';
					} else if (value < 30 && value > 27) {
						return 'warning';
					} else {
						return 'danger';
					}
				}
			};
		}
	});
	 
	return TemperaturesView;
});
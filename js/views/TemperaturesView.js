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
			$.getJSON('api/temperatures/3', function(data){
				self.temperatures = self.prepareData(data);
				self.render(); 	
			});
		},
		
		prepareData: function(data) {
			var returnData = [];
			var filteredData = _.filter(data, function(item){
				return item.date[14] == 0;
			});
			var series = _.groupBy(filteredData, function(item){
				return item.date.substring(0,10);
			});
			
			_.each(series, function(serie) {
				var text = serie[0].date.substring(0,10);
				var values = []; 
				_.each(serie, function(value) {
					values.push([parseInt(value.date.substring(11,13)), parseFloat(value.value)]);
				});
				returnData.push({
					'text':text,
					'values': values,
					'tooltip':{ 
				        'text':"%t, ora %k:00 <br><div style='font-size:14px'>%v °C</div>" 
        			}
				});
			});
			
			return returnData;
		},
		
		onRender: function() {
			// Create ZingChart Model Passing in Data to Plot
			if (this.temperatures != null) {
				console.log(this.temperatures);				
				var chartData = new ZingChart.ZingChartModel({
					"width":"1140px",
					json: {
						"type": "line",
						"background-color": "#fff",
						"legend":{
					        "layout":"x1",
					        "margin-top":"5%",
					        "border-width":"0",
					        "shadow":false,
					        "marker":{
					            "cursor":"hand",
					            "border-width":"0"
					        },
					        "background-color":"white",
					        "item":{
					            "cursor":"hand"
					        },
					        "toggle-action":"remove"
					    },

						"scaleY": {
							"values":"20:40:4",
						},
						"series": this.temperatures,
					}

				});
				
				// Render the Chart
				// Note that the el must already be added to the DOM
				var chartView = new ZingChart.ZingChartView({model: chartData, el: this.$('#zing-chart-container')});
				chartView.render();				
			}
		},
		
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
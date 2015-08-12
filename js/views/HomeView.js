define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'text!templates/home.html',
  'models/Command',
], function($, _, Backbone, Marionette, homeTpl, Command){
	var HomeView = Backbone.Marionette.ItemView.extend({
		template : _.template(homeTpl),
		className : 'bg-raspi-logo',
		initialize : function(options) {
			var self = this;
			this.cpu_temp = 0;
			this.room_temp = 0;
			var tempCmd = new Command({id:'tempsensor'});
			tempCmd.fetch({
				success: function(model) {
					if (model.get('status') == 'success') {
						self.cpu_temp = 0;//parseFloat(model.get('response'));				
						self.room_temp = parseFloat(model.get('response'));
					} else {
						self.cpu_temp = 0;
						self.room_temp = 0;
					}
					self.render();
				}
			});
		},
		
		onRender : function() {
				var chartData = new ZingChart.ZingChartModel({
					width:340,
					height: 150,
					json: {
				        "scale":{
				            "size-factor":2,
				            "offset-y":40
				        },
						"scale-r":{
            				"values":"0:120:5",
            			},
						"type": "gauge",
						"series": [
							{"values":[this.room_temp]},
							{"values":[this.cpu_temp]},
						],
					}

				});
				var chartView = new ZingChart.ZingChartView({model: chartData, el: this.$('#room-temp-gauge-container')});
				chartView.render();		
		},
		
		templateHelpers: function() {
			return {
				cpu_temp: this.cpu_temp.toFixed(2),
				room_temp: this.room_temp.toFixed(2),
			};
		}
	});
	 
	return HomeView;
});
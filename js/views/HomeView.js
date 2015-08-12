define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'text!templates/home.html',
  'models/Command',
  'models/Pin',
], function($, _, Backbone, Marionette, homeTpl, Command, Pin){
	var HomeView = Backbone.Marionette.ItemView.extend({
		template : _.template(homeTpl),
		className : 'bg-raspi-logo',
		
		events: {
			'click #power1' : 'powerSwitch'
		},
		
		initialize : function(options) {
			var self = this;
			this.cpu_temp = 0;
			this.room_temp = 0;
			this.pin = new Pin({id: 23});
			this.pin.fetch({async:false}); 
			var tempCmd = new Command({id:'tempsensor'});
			tempCmd.fetch({
				async:false,
				success: function(model) {
					if (model.get('status') == 'success') {	
						self.room_temp = parseFloat(model.get('response'));
					} else {
						self.room_temp = 0;
					}
				}
			});
			tempCmd = new Command({id:'temp'});
			tempCmd.fetch({
				async:false,
				success: function(model) {
					if (model.get('status') == 'success') {	
						self.cpu_temp = parseFloat(model.get('response'));
					} else {
						self.cpu_temp = 0;
					}
				}
			});
		},
		
		onRender : function() {
				var chartData = new ZingChart.ZingChartModel({
					width:'100%',
					height: 300,
					json: {
						"scale-r":{
            				"values":"0:120:5",
            				"aperture":"240",
           				    "ring":{
						      "size":10
						    }
            			},
            			"plot": {
            				"csize":"5%"
            			},
						"background-color": "transparent",
						"type": "gauge",
						"series": [
							{"values":[this.room_temp]},
							{"values":[this.cpu_temp]},
						],
					}

				});
				var chartView = new ZingChart.ZingChartView({model: chartData, el: this.$('#temp-gauge-container')});
				chartView.render();		
		},
		
		powerSwitch: function(e) {
			console.log('toggle val: ' + this.pin.get('Phys'));
			var value = (this.pin.get('Value') == 0)?1:0;
			this.pin.save({Value:value}, {patch:true});
			this.render();
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
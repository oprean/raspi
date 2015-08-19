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
			'click #power1' : 'powerSwitch1',
			'click #power2' : 'powerSwitch2',
		},
		
		initialize : function(options) {
			var self = this;
			this.cpu_temp = 0;
			this.room_temp = 0;
			this.pin1 = new Pin({id: 23});
			this.pin1.fetch({async:false});
			this.pin2 = new Pin({id: 11});
			this.pin2.fetch({async:false});

			$.getJSON('api/temperature/now/1', function(data){
				self.room_temp = data.value;
				self.$('#room-temperature .tile-content').html(data.value + '<sup style="font-size:.5em;">°C</sup>');
				self.$('#room-temperature .tile-footer').html(data.date); 	
			});
			 
			$.getJSON('api/temperature/now/0', function(data){
				self.cpu_temp = data.value;
				self.$('#cpu-temperature .tile-content').html(data.value + '<sup style="font-size:.5em;">°C</sup>'); 	
				self.$('#cpu-temperature .tile-footer').html(data.date);
			});
		},
		
		powerSwitch1: function(e) {
			var value = (this.pin1.get('Value') == 0)?1:0;
			this.pin1.save({Value:value}, {patch:true});
			this.$('#power1').toggleClass('power-on');
		},
		
		powerSwitch2: function(e) {
			var value = (this.pin2.get('Value') == 0)?1:0;
			this.pin2.save({Value:value}, {patch:true});
			this.$('#power2').toggleClass('power-on');
		},
		
		templateHelpers: function() {
			return {
				cpu_temp: this.cpu_temp.toFixed(2),
				room_temp: this.room_temp.toFixed(2),
				power1:this.pin1,
				power2:this.pin2
			};
		}
	});
	 
	return HomeView;
});
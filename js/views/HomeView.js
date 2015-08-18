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

			$.getJSON('api/temperature/now/1', function(data){
				self.room_temp = data.value;
				self.$('#room-temperature .tail-content').html(data.value + '<sup style="font-size:.5em;">°C</sup>');
				self.$('#room-temperature .tail-footer').html(data.date); 	
			});
			 
			$.getJSON('api/temperature/now/0', function(data){
				self.cpu_temp = data.value;
				self.$('#cpu-temperature .tail-content').html(data.value + '<sup style="font-size:.5em;">°C</sup>'); 	
				self.$('#cpu-temperature .tail-footer').html(data.date);
			});
		},
		
		powerSwitch: function(e) {
			console.log('toggle val: ' + this.pin.get('Phys'));
			var value = (this.pin.get('Value') == 0)?1:0;
			this.pin.save({Value:value}, {patch:true});
			this.$('#power1').toggleClass('power-on');
		},
		
		templateHelpers: function() {
			return {
				cpu_temp: this.cpu_temp.toFixed(2),
				room_temp: this.room_temp.toFixed(2),
				power:this.pin
			};
		}
	});
	 
	return HomeView;
});
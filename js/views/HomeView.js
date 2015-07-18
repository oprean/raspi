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
			var tempCmd = new Command({id:'temp'});
			tempCmd.fetch({
				success: function(model) {
					if (model.get('status') == 'success') {
						self.cpu_temp = parseFloat(model.get('response'));				
						self.room_temp = self.cpu_temp - 21.6;
					} else {
						self.cpu_temp = 0;
						self.room_temp = 0;
					}
					self.render();
				}
			});
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
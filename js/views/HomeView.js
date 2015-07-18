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
			
			var tempCmd = new Command({id:'temp'});
			tempCmd.fetch({
				success: function(model) {
					if (model.get('status') == 'success') {
						self.cpu_temp = model.get('response');				
						self.root_temp = parseFloat(self.cpu_temp) - 21.6;
					} else {
						self.cpu_temp = null;
						self.room_temp = null;
						
					}
					self.render();
				}
			});
		},
		
		templateHelpers: function() {
			return {
				cpu_temp: this.cpu_temp,
				room_temp: this.room_temp,
			};
		}
	});
	 
	return HomeView;
});
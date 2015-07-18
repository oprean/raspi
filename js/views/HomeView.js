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
		initialize : function(options) {
			var self = this;
			
			var tempCmd = new Command({id:'temp'});
			tempCmd.fetch({
				success: function(model) {
					if (model.get('status') == 'success') {
						self.temp = model.get('response');				
					} else {
						self.temp = 'failed!';
					}
					self.render();
				}
			});
			tempCmd.set({id:'clock'});
			tempCmd.fetch({
				success: function(model) {
					if (model.get('status') == 'success') {
						self.clock = model.get('response');				
					} else {
						self.clock = 'failed!';
					}
					self.render();
				}
			});
			tempCmd.set({id:'volts'});
			tempCmd.fetch({
				success: function(model) {
					if (model.get('status') == 'success') {
						self.volts = model.get('response');				
					} else {
						self.volts = 'failed!';
					}
					self.render();
				}
			});
		},
		
		templateHelpers: function() {
			return {
				temp: this.temp,
				clock: this.clock,
				volts: this.volts,
			};
		}
	});
	 
	return HomeView;
});
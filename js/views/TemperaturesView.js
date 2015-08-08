define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'text!templates/temperatures.html',
  'collections/Temperatures'
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
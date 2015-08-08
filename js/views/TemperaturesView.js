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
			var stats = new Temperatures();
			stats.fetch({
				success: function(stats) {
					self.render();
				}
			});
		},
	});
	 
	return TemperaturesView;
});
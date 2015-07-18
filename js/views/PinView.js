define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'text!templates/pin.html',
  'models/Command',
], function($, _, Backbone, Marionette, pinTpl, Command){
	var PinView = Backbone.Marionette.ItemView.extend({
		template : _.template(pinTpl),
		className : 'pin',
		initialize : function(options) {
			var self = this;
		},
		
		templateHelpers: function() {
			return {
			};
		}
	});
	 
	return PinView;
});
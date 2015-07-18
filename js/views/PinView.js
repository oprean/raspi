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
		
		events : {
			'click .btn-read-pin' : 'read',
			'click .btn-toggle-pin' : 'toggle',
		},
		
		initialize : function(options) {
			var self = this;
		},
		
		read : function(e) {
			console.log('read' + $(e.target).data('pin'));
		},

		toggle : function(e) {
			console.log('toggle ' + $(e.target).data('pin'));
		},
		
		templateHelpers: function() {
			return {
			};
		}
	});
	 
	return PinView;
});
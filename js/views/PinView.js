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
			'click .btn-pin-read' : 'read',
			'click .btn-pin-toggle-mode' : 'toggleMode',
			'click .btn-pin-toggle-val' : 'toggleVal',
		},
		
		initialize : function(options) {
			var self = this;
		},
		
		read : function(e) {
			console.log('read' + $(e.target).data('pin'));
		},

		toggleMode : function(e) {
			console.log('toggle mode: ' + $(e.target).data('pin'));
		},
		
		toggleVal : function(e) {
			console.log('toggle val: ' + $(e.target).data('pin'));
		},
		
		templateHelpers: function() {
			return {
			};
		}
	});
	 
	return PinView;
});
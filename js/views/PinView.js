define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'text!templates/pin.html',
], function($, _, Backbone, Marionette, pinTpl){
	var PinView = Backbone.Marionette.ItemView.extend({
		template : _.template(pinTpl),
		className : 'pin',
		
		events : {
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
		
		pinCssClass : function() {
			var pinClass = '';
			var name = this.model.get('Name');
			if (name == 'GND' || name == '3V' || name == '5V') {
				pinClass = 'pin-' + this.model.get('Name').toLowerCase();				
			} else {
				if (this.model.get('Value') == null) {
					pinClass = ' pin-null';
				} else if (this.model.get('Value') == 0) {
					pinClass = ' pin-off';
				} else {
					pinClass = ' pin-on';
				}
			}
			
			if (this.model.get('Phys') > 100) {
				pinClass += ' header5';
			}
			
			return pinClass;
		},
		
		templateHelpers: function() {
			return {
				css : (this.model.get('Phys') % 2)?'pull-right':'pull-left',
				pinCss : this.pinCssClass()
			};
		}
	});
	 
	return PinView;
});
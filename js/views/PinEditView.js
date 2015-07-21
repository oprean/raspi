define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'text!templates/pin-edit.html',
  'models/Pin',
], function($, _, Backbone, Marionette, pinEditTpl, Pin){
	var PinEditView = Backbone.Marionette.ItemView.extend({
		template : _.template(pinEditTpl),
		className : 'pin-container',
		
		events : {
			'click .btn-pin-read' : 'read',
			'click .btn-pin-toggle-mode' : 'toggleMode',
			'click .btn-pin-toggle-val' : 'toggleVal',
		},
		
		initialize : function(options) {
			var self = this;
			this.model = new Pin({id: options.pin});
			this.model.fetch({async:false});
		},
		
		onRender: function() {
			this.$(".bt-switch").bootstrapSwitch();
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
				pinClass = this.model.get('Value')?' pin-on':' pin-off';
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
	 
	return PinEditView;
});
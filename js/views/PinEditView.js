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
			'click .chk-pin-toggle-mode' : 'toggleMode',
			'click .chk-pin-toggle-value' : 'toggleValue',
		},
		
		initialize : function(options) {
			var self = this;
			this.model = new Pin({id: options.pin});
			this.model.fetch({async:false});
		},
		
		onRender: function() {
			this.$(".bt-switch").bootstrapSwitch();
			var name = this.model.get('Name');
			if (name == 'GND' || name == '3V' || name == '5V') {
				this.$(".toggle-mode").hide();
				this.$(".toggle-value").hide();
			} else {
				if (this.model.get('Mode') == 'in') {
					this.$(".toggle-value").hide();
				}
			}
			
		},
		
		read : function(e) {
			console.log('read' + this.model.get('Phys'));
		},

		toggleMode : function(e) {
			console.log('toggle mode: ' + this.model.get('Phys'));
		},
		
		toggleValue : function(e) {
			console.log('toggle val: ' + this.model.get('Phys'));
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
				pinCss : this.pinCssClass()
			};
		}
	});
	 
	return PinEditView;
});
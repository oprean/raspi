define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'text!templates/ledstrip.html',
  'modules/Utils',
], function($, _, Backbone, Marionette, ledstripTpl, Utils){
	var LedstripView = Backbone.Marionette.ItemView.extend({
		template : _.template(ledstripTpl),
		
		events : {
			'click .palette-color' : 'fillLedstrip',
		},
		
		initialize : function(options) {
			this.pallete = [];
			var steps = 1280;
			for(i=0;i<steps;i+=10) {
    			this.pallete.push(this.color(steps, i));
			}
		},
		
		color: function(steps, whichStep) {
		    var stepChange = 1280 / steps;
    		var change = stepChange * whichStep;
    		var r=0; var g=0; var b=0;
		    if (change < 256) {
		        r = 255;
		        g += change;
		    } else if (change < 512) {
		        r = 511 - change;
		        g = 255;
		    } else if (change < 768){
		        g = 255;
		        b = change-512;
		    } else if (change < 1024){
		        g = 1023 - change;
		        b = 255;
		    } else {
		        r = change - 1024;
		        b = 255;
		    }   
       		return {r:r,g:g,b:b};
		},
		
		fillLedstrip : function(e) {
			var self = this;	
			Utils.authAjax({
				type: "POST",
				url: 'api/ledstrip',
				data: {
					cmd: 'fill',
					r: $(e.target).data('r'),
					g: $(e.target).data('g'),
					b: $(e.target).data('b'),
				},  
				complete: function() {
					self.$('.palette-color').css('border', '');
					$(e.target).css('border-width', '1px');
					$(e.target).css('border-style', 'solid');
				},
			});
		},
		
		templateHelpers: function() {
			return {
				pallete:this.pallete
			};
		}		
	});
 
	return LedstripView;
});
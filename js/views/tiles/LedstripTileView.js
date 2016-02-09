define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'views/tiles/BaseTileView',
  'text!templates/tiles/ledstrip_tile.html',
  'collections/Settings',
  'modules/Utils',
], function($, _, Backbone, Marionette, BaseTileView, tileTpl, Settings, Utils){
	var LedstripTileView = BaseTileView.extend({
		template : _.template(tileTpl),
		
		events : {
			'click .tile-content' : 'action',
			//'click .color' : 'action',
		},
		
		initialize : function(options) {
			this.data = this.model.get('data');
			this.pallete = [];
			for(i=0;i<255;i++) {
				color = {
					r:this.data.r?this.data.r:i,
					g:this.data.g?this.data.g:i,
					b:this.data.b?this.data.b:i
				};
				this.pallete.push(color);
			}
		},
		
		/*onRender: function() {
			//this.$el.css('width', 488);
		},*/
		
		updateLedstrip : function() {
			var self = this;	
			Utils.authAjax({
				type: "POST",
				url: 'api/ledstrip',
				data: {
					cmd: this.data.cmd,
					r: this.data.r,
					g: this.data.g,
					b: this.data.b,
					t: this.data.t
				},  
			});
		},
		
		updateLedstripColor : function(color) {
			var self = this;	
			Utils.authAjax({
				type: "POST",
				url: 'api/ledstrip',
				data: {
					cmd: this.data.cmd,
					r: color.r,
					g: color.g,
					b: color.b
				},  
			});
		},
		
		action : function(e) {
			console.log($(e.target).data('r'));
			$(e.target).css('border',1);
			this.updateLedstrip();
		},
		
		templateHelpers: function() {
			return {
				pallete:this.pallete
			};
		}
	});
	 
	return LedstripTileView;
});
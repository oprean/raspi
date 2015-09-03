//https://samkelleher.com/portfolio/Responsive-Realtime-Customisable-Interactive-Dashboard
define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'text!templates/tiles/base_tile.html',
], function($, _, Backbone, Marionette, tileTpl){
	var BaseTileView = Backbone.Marionette.ItemView.extend({
		template : _.template(tileTpl),
		className : 'tile-container',
		
		events : {
			'click .tile-content' : 'action',
		},
		
		initialize : function(options) {
			var self = this;
		},
		
		action : function(e) {
			console.log('base tile action');
		},
		
		onRender: function() {
			this.$el.css('background-color', 
				this.model.get('bk_color')
					?this.model.get('bk_color')
					:'#'+Math.floor(Math.random()*16777215).toString(16)
			);
		},
		
		templateHelpers: function() {
			return {
			};
		}
	});
	 
	return BaseTileView;
});
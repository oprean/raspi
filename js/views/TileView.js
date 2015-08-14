//https://samkelleher.com/portfolio/Responsive-Realtime-Customisable-Interactive-Dashboard
define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'text!templates/tile.html',
], function($, _, Backbone, Marionette, tileTpl){
	var TileView = Backbone.Marionette.ItemView.extend({
		template : _.template(tileTpl),
		className : 'tile',
		
		events : {
			'click .btn-tile' : 'action',
		},
		
		initialize : function(options) {
			var self = this;
		},
		
		action : function(e) {
			console.log('action' + $(e.target).data('pin'));
		},
		
		templateHelpers: function() {
			return {
			};
		}
	});
	 
	return TileView;
});
define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'views/tiles/BaseTileView',
  'models/Pin',
  'text!templates/tiles/switch_tile.html',
], function($, _, Backbone, Marionette, BaseTileView, Pin, tileTpl){
	var SwitchTileView = BaseTileView.extend({
		template : _.template(tileTpl),
		
		events : {
			'click .btn-power-switch' : 'action',
		},
		
		initialize : function(options) {
			var self = this;
			this.data = this.model.get('data');
			this.pin = new Pin({id: this.data.pin});
			this.pin.fetch({async:false});
		},
		
		action : function(e) {
			var value = (this.pin.get('Value') == 0)?1:0;
			this.pin.save({Value:value}, {patch:true});
			this.$('.btn-power-switch').toggleClass('power-on');
		},
		
		templateHelpers: function() {
			return {
				power: this.pin
			};
		}
	});
	 
	return SwitchTileView;
});
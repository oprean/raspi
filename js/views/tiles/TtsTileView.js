define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'views/tiles/BaseTileView',
  'text!templates/tiles/tts_tile.html',
], function($, _, Backbone, Marionette, BaseTileView, ttsTpl){
	var TtsTileView = BaseTileView.extend({
		template : _.template(ttsTpl),
		
		events : {
			'click .btn-power-switch' : 'action',
		},
		
		initialize : function(options) {
			this.data = this.model.get('data');
			this.tts_text = this.data.text;
		},
		
		action : function(e) {
			$.get('/raspi/api/tts/' + this.tts_text);
		},
	
	});
	 
	return TtsTileView;
});
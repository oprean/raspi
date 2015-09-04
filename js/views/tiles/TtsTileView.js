define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'views/tiles/BaseTileView',
  'text!templates/tiles/tts_tile.html',
  'collections/Settings'
], function($, _, Backbone, Marionette, BaseTileView, ttsTpl, Settings){
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
			var self = this;
			$.ajax({
				type: "POST",
				url: '/raspi/api/tts',
				headers: {'Authorization': Settings.getVal('token')},
				beforeSend: function() {
					self.$('.tile-footer').html('talking ...');
				}, 
				complete: function() {
					self.$('.tile-footer').html('done talking!');
				},
				data: {
					tts: this.tts_text,
					lang: 'ro',
					gender:'m',
					voice:4,
					speed:120,
				}, 
			});
		},
	});
	 
	return TtsTileView;
});
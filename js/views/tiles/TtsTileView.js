define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'views/tiles/BaseTileView',
  'text!templates/tiles/tts_tile.html',
  'collections/Settings',
  'modules/Utils',
], function($, _, Backbone, Marionette, BaseTileView, ttsTpl, Settings, Utils){
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
			Utils.authAjax({
				type: "POST",
				url: '/raspi/api/tts',
				data: {
					tts: this.tts_text,
					lang: 'ro',
					gender:'m',
					voice:4,
					speed:120,
				},
				beforeSend: function() {
					self.$('.tile-footer').html('talking ...');
				}, 
				complete: function() {
					self.$('.tile-footer').html('done talking!');
				},  
			});
		},
	});
	 
	return TtsTileView;
});
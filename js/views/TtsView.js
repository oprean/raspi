define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'text!templates/tts.html',
], function($, _, Backbone, Marionette, ttsTpl){
	var TtsView = Backbone.Marionette.ItemView.extend({
		template : _.template(ttsTpl),
		events : {
			'click .btn-tts-temp': 'ttsTemp',
			'click .btn-tts-time': 'ttsTime',
			'click .btn-tts-text': 'ttsText'
		},
		
		initialize : function(options) {
		},
		
		ttsTemp: function() {
			$.get('/raspi/api/tts/temp');
		},

		ttsTime: function() {
			$.get('/raspi/api/tts/time');
		},
		
		ttsText : function() {
			$.ajax({
				type: "POST",
				//dataType: "json",
				url: '/raspi/api/tts', 
				data: {
					tts: this.$('#tts_text').val(),
				}, 
			});
		},
		
		templateHelpers: function() {
			return {
			};
		}
	});
	 
	return TtsView;
});
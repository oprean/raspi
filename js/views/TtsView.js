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
				dataType: "json",
				url: 'api/pdf', 
				data: JSON.stringify({
					html: this.$('.result-container').html(),
					data: this.model,
				}), 
				success: function(result) {
					if (result.status == 'success') {
						self.model.save();
						self.$('.pdf-generating-response').html('<div role="alert" class="alert alert-success"><strong>Success! </strong> ' + result.data.message + '</div>');
						self.$('.btn-generate-pdf').toggle();
						self.$('.btn-download-pdf').toggle();
						self.$('.btn-download-pdf').attr('href', 'api/pdf/' + result.data.filename);
					} else {
						self.$('.pdf-generating-response').html('<div role="alert" class="alert alert-danger"><strong>Error! </strong> ' + result.data.message + '</div>');
					}
				},
				error: function(result) {
					self.$('.pdf-generating-response').html('<div role="alert" class="alert alert-danger"><strong>Error!</strong> Internal server error!</div>');
				},
				complete: function() {
					self.$('.btn-generate-pdf').button('reset');					
				}
			});
		},
		
		templateHelpers: function() {
			return {
			};
		}
	});
	 
	return TtsView;
});
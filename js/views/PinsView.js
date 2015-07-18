define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'text!templates/pins.html',
  'collections/Pins',
  'views/PinView'
], function($, _, Backbone, Marionette, pinsTpl, Pins, PinView){
	var PinsView = Backbone.Marionette.CompositeView.extend({
		template : _.template(pinsTpl),
		childViewContainer: '.pins-container',
		childView: PinView,
		initialize : function(options) {
			var self = this;
			this.model = app.quizzes;
			this.collection = new Pins();
			this.collection.fetch();
		},
	});
	 
	return PinsView;
});
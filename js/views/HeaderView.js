define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'text!templates/header.html',
], function($, _, Backbone, Marionette, headerTpl){
	var HeaderView = Backbone.Marionette.ItemView.extend({
		template : _.template(headerTpl),
		initialize : function(options) {
			//this.model = app.quizzes;
		},
	});
	 
	return HeaderView;
});
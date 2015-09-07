define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'text!templates/user.html',
], function($, _, Backbone, Marionette, userTpl){
	var UserView = Backbone.Marionette.ItemView.extend({
		template : _.template(userTpl),
		initialize : function(options) {
		},
	});
	 
	return UserView;
});
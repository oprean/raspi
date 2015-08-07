define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'text!templates/login.html',
], function($, _, Backbone, Marionette, loginTpl){
	var LoginView = Backbone.Marionette.ItemView.extend({
		template : _.template(loginTpl),
		className : 'login',
		
		events : {
			'click .btn-pin-toggle-mode' : 'toggleMode',
		},
		
		initialize : function(options) {
			var self = this;
		},
				
		templateHelpers: function() {
			return {
			};
		}
	});
	 
	return LoginView;
});
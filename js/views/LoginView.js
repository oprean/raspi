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
			'click .btn-login' : 'login',
		},
		
		initialize : function(options) {
			var self = this;
		},
				
		login: function() {
			$.ajax({
				type: "POST",
				url: 'login',
				data: {
					username: this.$('#username').val(),
					password:this.$('#password').val(),
				}, 
				success: function(data) {
					
					console.log('login successfully!');
					
					$.ajaxSetup({
					    headers: { 'Authorization' :data }
					});
					window.location.replace('');
				}
			});
		},
		templateHelpers: function() {
			return {
			};
		}
	});
	 
	return LoginView;
});
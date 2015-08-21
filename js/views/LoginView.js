define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'text!templates/login.html',
  'collections/Settings'
], function($, _, Backbone, Marionette, loginTpl, Settings){
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
				success: function(auth) {
					
					console.log('login successfully!');
					console.log(auth);
					
					Settings.setVal('uid', auth.uid);
					Settings.setVal('token', auth.token);

					window.location.replace('index');
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
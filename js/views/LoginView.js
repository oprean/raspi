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
			var self = this;
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
					
					window.location.replace(app.rootUri);
				},
				error: function(response) {
					self.$('.form-group').addClass('has-error');
					self.$('.error-block').removeClass('hidden');
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
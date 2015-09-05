define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'text!templates/account.html',
  'models/User',
  'modules/Constants',
  'collections/Settings',
  'modules/Utils',
], function($, _, Backbone, Marionette, accountTpl, User, Constant, Settings, Utils){
	var AccountView = Backbone.Marionette.ItemView.extend({
		template : _.template(accountTpl),	
		events : {
			'click .btn-changepwd' : 'changePwd'
		},
		
		initialize : function(options) {
			this.model = new User({id: Settings.uid()});
			this.model.fetch({async: false});
		},
		
		changePwd : function() {
			if (this.$('#newpassword').val() == this.$('#newpassword2').val() && this.$('#newpassword').val()) {
				console.log(this.model);
				Utils.authAjax({
					type:'POST',
					url: 'api/user/changepwd',
					data: {
						username: this.model.get('username'),
						oldpassword: self.$('#oldpassword').val(),
						newpassword: self.$('#newpassword').val()
					},
					success: function() {
						self.$('.error-block').html('Password updated');
						self.$('.error-block').removeClass('hidden');
					},
					error: function(response) {
						if (response.status == 403) {
							self.$('.form-group').addClass('has-error');
							self.$('.error-block').html('Wrong old password');
							self.$('.error-block').removeClass('hidden');
						}
					}
				});
			} else {
				self.$('.form-group').addClass('has-error');
				self.$('.error-block').html('New pass empty or entered differently 2nd time');
				self.$('.error-block').removeClass('hidden');				
			}
		}
	});
	 
	return AccountView;
});
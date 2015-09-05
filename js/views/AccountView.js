define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'text!templates/account.html',
  'models/User',
  'modules/Constants',
  'collections/Settings',

], function($, _, Backbone, Marionette, accountTpl, User, Constant, Settings){
	var AccountView = Backbone.Marionette.CompositeView.extend({
		template : _.template(accountTpl),	
		events : {
			'click .btn-changepwd' : 'changePwd'
		},
		
		initialize : function(options) {
			this.model = new User({id: Settings.uid()});
			console.log(Settings.uid());
			this.model.fetch();
		},
		
		changePwd : function() {
			var oldP = this.$('#oldpassword').val();
			var newP = this.$('#password').val();
			var newP2 = this.$('#password2').val();
			if (newP != newP2) {
				self.$('.form-group').addClass('has-error');
				self.$('.error-block').html('new pass entered differently');
				self.$('.error-block').removeClass('hidden');
			}
		}
	});
	 
	return AccountView;
});
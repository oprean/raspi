define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'text!templates/users.html',
  'collections/Users',
  'views/UserView'
], function($, _, Backbone, Marionette, usersTpl, Users, UserView){
	var UsersView = Backbone.Marionette.CompositeView.extend({
		template : _.template(usersTpl),
		childViewContainer: '.users-container',
		childView: UserView,
		
		events : {
		},

		initialize : function(options) {
			this.collections = new Users();
			this.collections.fetch();
		},
		
	});
	 
	return UsersView;
});
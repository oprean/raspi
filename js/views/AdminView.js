define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'text!templates/admin.html',
  'models/User',
  'modules/Constants',
  'collections/Settings',
  'modules/Utils',
], function($, _, Backbone, Marionette, adminTpl, User, Constant, Settings, Utils){
	var AdminView = Backbone.Marionette.LayoutView.extend({
		template : _.template(adminTpl),	
		events : {
		},
		
		initialize : function(options) {

		},
	});
	 
	return AdminView;
});
define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'text!templates/admin.html',
  'views/UsersView',
  'views/AssignmentsView',
  'modules/Constants',
  'collections/Settings',
  'modules/Utils',
], function($, _, Backbone, Marionette, adminTpl, UsersView, AssignmentsView, Constant, Settings, Utils){
	var AdminView = Backbone.Marionette.LayoutView.extend({
		template : _.template(adminTpl),	
		regions : {
			navContent : '.nav-content',
		},
		events : {
			'click .nav-tab' : 'showTabContent'
		},
		
		showTabContent: function(e) {
			var tabViewName = $(e.target).data('view');
			switch(tabViewName) {
				case 'users':
					this.navContentView = new UsersView();
					break;
				case 'assignments':
					this.navContentView = new AssignmentsView();
					break;
			}
			this.showChildView('navContent', this.navContentView);
		},
		
		initialize : function(options) {
			this.navContentView = new UsersView();
		},
		
		onBeforeShow : function() {
			this.showChildView('navContent', this.navContentView);
		},
	});
	 
	return AdminView;
});
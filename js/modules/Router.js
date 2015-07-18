define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'modules/Controller',
  'globals'
], function($, _, Backbone, Marionette, Controller, globals){
	var controller = new Controller();
	var Router = Marionette.AppRouter.extend({
	  
	  initialize: function() {
	  },
	  
	  controller: controller,
	  appRoutes: {
	    '': 'home',
	    'home': 'home',
	    'pins': 'pins',
	    'socket/:id': 'socket',
	  }
	});
  return Router;
});
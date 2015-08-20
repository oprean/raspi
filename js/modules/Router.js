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
	  
	  onRoute: function(name, path, args) {
	  	console.log('onRoute');
	  	if ( window.location.pathname.indexOf('/login') >= 0 ) {
	  		this.navigate('#login', {trigger: true});
	  	}
	  },
	  
	  appRoutes: {
	    '': 'home',
	    'login': 'login',
	    'home': 'home',
	    'tts': 'tts',
	    'pins': 'pins',
	    'pin/:id': 'pin',
	    'sockets': 'sockets',
	    'temperatures': 'temperatures',
	    'socket/:id': 'socket',
	  }
	});
  return Router;
});
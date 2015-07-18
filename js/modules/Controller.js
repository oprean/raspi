define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'views/HomeView',
  'views/SocketView'
], function($, _, Backbone, Marionette, 
	HomeView, SocketView){
	var Controller = Marionette.Controller.extend({
	  initialize: function() {
	  },
	  
	  home: function() {
	  	console.log('home');
		app.mainRegion.show(new HomeView());
	  },
	  
	  socket: function(id) {
	  	console.log('socket');
	  	var view;
		view = new SocketView({
			socketId: id
		});
		app.mainRegion.show(view);
	  },
	});
	
	return Controller;
});
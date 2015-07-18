define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'views/HomeView',
  'views/PinsView',
  'views/SocketView'
], function($, _, Backbone, Marionette, 
	HomeView, PinsView, SocketView){
	var Controller = Marionette.Controller.extend({
	  initialize: function() {
	  },
	  
	  home: function() {
	  	console.log('home');
		app.mainRegion.show(new HomeView());
	  },

	  pins: function() {
	  	console.log('pins');
		app.mainRegion.show(new PinsView());
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
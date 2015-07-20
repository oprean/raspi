define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'views/HomeView',
  'views/PinsView',
  'views/PinEditView',
  'views/SocketView'
], function($, _, Backbone, Marionette, 
	HomeView, PinsView, PinEditView, SocketView){
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

	  pin: function(id) {
	  	console.log('view pin ' + id);
		app.mainRegion.show(new PinEditView({pin:id}));
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
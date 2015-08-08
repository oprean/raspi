define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'views/LoginView',
  'views/HomeView',
  'views/TtsView',
  'views/PinsView',
  'views/PinEditView',
  'views/SocketsView',
  'views/SocketView',
  'views/TemperaturesView'
], function($, _, Backbone, Marionette, 
	LoginView, HomeView, TtsView, PinsView, PinEditView, SocketsView, SocketView, TemperaturesView){
	var Controller = Marionette.Controller.extend({
	  initialize: function() {
	  },

 	  login: function() {
	  	console.log('login');
		app.mainRegion.show(new LoginView());
 	  },  

	  home: function() {
	  	console.log('home');
		app.mainRegion.show(new HomeView());
	  },

	  tts: function() {
	  	console.log('tts');
		app.mainRegion.show(new TtsView());
	  },

	  temperatures: function() {
	  	console.log('temperatures');
		app.mainRegion.show(new TemperaturesView());
	  },

	  pins: function() {
	  	console.log('pins');
		app.mainRegion.show(new PinsView());
	  },

	  pin: function(id) {
	  	console.log('view pin ' + id);
		app.mainRegion.show(new PinEditView({pin:id}));
	  },
	  
	  sockets: function() {
	  	console.log('sockets');
		app.mainRegion.show(new SocketsView());
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
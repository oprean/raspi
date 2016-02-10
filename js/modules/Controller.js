define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'views/HomeView',
  'views/AdminView',
  'views/AccountView',
  'views/LoginView',
  'views/TtsView',
  'views/PinsView',
  'views/PinEditView',
  'views/SocketsView',
  'views/SocketView',
  'views/TemperaturesView',
  'views/LedstripView',
  'collections/Settings'
], function($, _, Backbone, Marionette, 
	HomeView, AdminView, AccountView, LoginView,  TtsView, PinsView, PinEditView, SocketsView, SocketView, TemperaturesView, LedstripView, 
	Settings){
	var Controller = Marionette.Controller.extend({
	  initialize: function() {
	  },

	  home: function() {
	  	console.log('home');
		app.mainRegion.show(new HomeView());
	  },

	  admin: function() {
	  	console.log('admin');
		app.mainRegion.show(new AdminView());
	  },
	  
	  account: function() {
	  	console.log('account');
		app.mainRegion.show(new AccountView());
	  },

 	  login: function() {
	  	console.log('login');
		app.mainRegion.show(new LoginView());
 	  },  

 	  logout: function() {
	  	console.log('logout');
		Settings.removeVal('token');
		Settings.removeVal('uid');
		window.location.href = app.rootUri;
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
	  ledstrip: function() {
	  	console.log('ledstrip');
	  	var view;
		view = new LedstripView({
		});
		app.mainRegion.show(view);
	  },
	});
	
	return Controller;
});
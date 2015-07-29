define([
  'underscore',
  'backbone',
  'models/Socket'
], function(_, Backbone, Socket){
	var Sockets = Backbone.Collection.extend({
	  url : 'api/gpio',
	  model: Socket, 
	});
	
	return Sockets;
});
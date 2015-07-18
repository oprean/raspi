define([
  'underscore',
  'backbone',
  'models/Socket'
], function(_, Backbone, Socket){
	var Sockets = Backbone.Collection.extend({
	  model: Socket, 
	});
	
	return Sockets;
});
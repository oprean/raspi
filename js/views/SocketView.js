define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'text!templates/socket.html',
], function($, _, Backbone, Marionette, socketTpl){
	var SocketView = Backbone.Marionette.ItemView.extend({
		template : _.template(socketTpl),
		initialize : function(options) {
		},
	});
	 
	return SocketView;
});
define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'text!templates/sockets.html',
  'collections/Sockets',
  'views/SocketView'
], function($, _, Backbone, Marionette, socketsTpl, Sockets, SocketView){
	var SocketsView = Backbone.Marionette.CompositeView.extend({
		template : _.template(socketsTpl),
		childViewContainer: '.sockets-container',
		childView: SocketView,
				
		initialize : function(options) {
			var self = this;
			//this.collection = new Sockets();
			//this.collection.fetch();
		},
	});
	 
	return SocketsView;
});
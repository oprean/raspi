define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'text!templates/home.html',
  'collections/Sockets',
  'views/SocketView'
], function($, _, Backbone, Marionette, homeTpl, Sockets, SocketView){
	var HomeView = Backbone.Marionette.CompositeView.extend({
		template : _.template(homeTpl),
		childViewContainer: '.sockets-container',
		childView: SocketView,
		initialize : function(options) {
			var self = this;
			this.collection = new Sockets();
		},
	});
	 
	return HomeView;
});
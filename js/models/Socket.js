define([
  'jquery',
  'underscore',
  'backbone',
], function($, _, Backbone){
	var Socket = Backbone.Model.extend({
		defaults : {
			name: null,
		}
	});

	return Socket;
});
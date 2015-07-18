define([
  'jquery',
  'underscore',
  'backbone',
], function($, _, Backbone){
	var Socket = Backbone.Model.extend({
		urlRoot : 'api/gpio',
		defaults : {
			name: null,
		}
	});

	return Socket;
});
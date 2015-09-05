define([
  'jquery',
  'underscore',
  'backbone',
], function($, _, Backbone){
	var User = Backbone.Model.extend({
		urlRoot : 'api/user',
		defaults : {
			name: null,
			username: null,
			password: null,
			email: null
		}
	});

	return User;
});
define([
  'jquery',
  'underscore',
  'backbone',
], function($, _, Backbone){
	var AuthAssignment = Backbone.Model.extend({
		urlRoot : 'api/auth_assignment',
		defaults : {
			item_name: null,
			user_id: null,
		}
	});

	return AuthAssignment;
});
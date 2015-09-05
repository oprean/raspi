define([
  'jquery',
  'underscore',
  'backbone',
], function($, _, Backbone){
	var AuthItem = Backbone.Model.extend({
		urlRoot : 'api/auth_item',
		defaults : {
			name: null,
			type: null,
			description: null
		}
	});

	return AuthItem;
});
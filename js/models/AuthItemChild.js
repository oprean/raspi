define([
  'jquery',
  'underscore',
  'backbone',
], function($, _, Backbone){
	var AuthItemChild = Backbone.Model.extend({
		urlRoot : 'api/authitem',
		defaults : {
			parent: null,
			child: null,
		}
	});

	return AuthItemChild;
});
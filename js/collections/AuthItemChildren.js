define([
  'underscore',
  'backbone',
  'models/AuthItemChild'
], function(_, Backbone, AuthItemChild){
	var AuthItemChildren = Backbone.Collection.extend({
	  url : 'api/auth_item_child',
	  model: AuthItemChild,     
	});
	
	return AuthItemChildren;
});
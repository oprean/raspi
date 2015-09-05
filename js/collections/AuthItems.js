define([
  'underscore',
  'backbone',
  'models/AuthItem'
], function(_, Backbone, AuthItem){
	var AuthItems = Backbone.Collection.extend({
	  url : 'api/auth_item',
	  model: AuthItem,     
	});
	
	return AuthItems;
});
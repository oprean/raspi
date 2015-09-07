define([
  'underscore',
  'backbone',
  'models/User'
], function(_, Backbone, User){
	var Users = Backbone.Collection.extend({
	  url : 'api/user',
	  model: User,     
	});
	
	return Users;
});
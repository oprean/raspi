define([
  'underscore',
  'backbone',
  'models/AuthAssignment'
], function(_, Backbone, AuthAssignment){
	var AuthAssignments = Backbone.Collection.extend({
	  url : 'api/auth_assignment',
	  model: AuthAssignment,     
	});
	
	return AuthAssignments;
});
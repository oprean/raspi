define([
  'underscore',
  'backbone',
  'models/Command'
], function(_, Backbone, Command){
	var Commands = Backbone.Collection.extend({
	  url : 'api/cmd',
	  model: Command, 
	});
	
	return Commands;
});
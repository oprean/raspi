define([
  'underscore',
  'backbone',
  'models/Command'
], function(_, Backbone, Command){
	var Commands = Backbone.Collection.extend({
	  model: Command, 
	});
	
	return Commands;
});
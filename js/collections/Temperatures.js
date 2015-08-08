define([
  'underscore',
  'backbone',
  'models/Temperature'
], function(_, Backbone, Temperature){
	var Temperatures = Backbone.Collection.extend({
	  url : 'api/temperature',
	  model: Temperature, 
	});
	
	return Temperatures;
});
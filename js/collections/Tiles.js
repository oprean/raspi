define([
  'underscore',
  'backbone',
  'models/Tile'
], function(_, Backbone, Pin){
	var Tiles = Backbone.Collection.extend({
	  url : 'api/Tile',
	  model: Tile,
	         
	});
	
	return Tiles;
});
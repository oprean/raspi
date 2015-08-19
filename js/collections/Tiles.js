define([
  'underscore',
  'backbone',
  'models/Tile'
], function(_, Backbone, Tile){
	var Tiles = Backbone.Collection.extend({
	  url : 'api/tiles',
	  model: Tile,
	  initialize : function () {

	  }	
	});
	
	return Tiles;
});
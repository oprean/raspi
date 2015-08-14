define([
  'jquery',
  'underscore',
  'backbone',
], function($, _, Backbone){
	var Tile = Backbone.Model.extend({
		urlRoot : 'api/tile',
		defaults : {
			name: null,
		}
	});

	return Tile;
});
define([
  'jquery',
  'underscore',
  'backbone',
], function($, _, Backbone){
	var Temperature = Backbone.Model.extend({
		urlRoot : 'api/temperature',
	});

	return Temperature;
});
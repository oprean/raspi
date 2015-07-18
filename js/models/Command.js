define([
  'jquery',
  'underscore',
  'backbone',
], function($, _, Backbone){
	var Command = Backbone.Model.extend({
		urlRoot : 'api/cmd',
		defaults : {
			status : 	null,
			id: 		null,
			cmd: 		null,
			response: 	null,
		}
	});

	return Command;
});
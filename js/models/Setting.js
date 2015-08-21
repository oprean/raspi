define([
  'jquery',
  'underscore',
  'backbone',
], function($, _, Backbone){
	var Setting = Backbone.Model.extend({
		defaults : {
			id:null,
			key: null,
			value: null,
		}
	});

	return Setting;
});
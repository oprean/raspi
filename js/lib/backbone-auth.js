/*
 * Using AMD/RequireJS
 */
define([
	'collections/Settings'
], function (Settings) {
    'use strict';
    var backboneSync = Backbone.sync;
	Backbone.sync = function(method, model, options) {
	    
	    options.headers = options.headers || {};
	    
	    _.extend(options.headers, { 'Authorization': Settings.getVal('token') });
	    
	    options.error = function(jqXHR, textStatus, errorThrown) {
			if (jqXHR.status == 401) {
				window.location.href = app.rootUri + '/login#login';
			} else {
				console.log(jqXHR);
			}
		};
	    
	    backboneSync.call(model, method, model, options);
	};
});
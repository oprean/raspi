require.config({
	urlArgs: new Date().getTime().toString(),
	"paths":{
		"jquery" : "lib/jquery-2.1.3.min",
 		"jquery.bootstrap": "lib/bootstrap.min",
		"bootstrap-switch":"lib/bootstrap-switch.min",
		 		
		"jquery.ui":"lib/jquery-ui.min",
		
		"underscore":"lib/lodash.min",
		
		"zingchart":"lib/zingchart.min",
		
		"backbone":"lib/backbone-min",
		"backbone.marionette":"lib/backbone.marionette.min",
		"backbone.localStorage":"lib/backbone.localStorage.min",
		"backbone.validation":"lib/backbone-validation-min",		
		"backbone.zingchart":"lib/backbone.zingchart.min",
		
		"moment":"lib/moment.min",
		"text":"lib/text",
	},
	
	"shim":{
		"jquery.ui": {
			"deps": ["jquery"]
		},
		"jquery.bootstrap": {
			"deps": ["jquery.ui"]
		},
		"bootstrap-switch": {
			"deps": ["jquery"]
		},
		"backbone":{
			"deps":["jquery","underscore"],
			"exports":"Backbone"
		},
		"backbone.marionette":{
			"deps":["jquery","underscore","backbone"],
			"exports":"Marionette"
		},
		"backbone.localStorage":{
			"deps":["backbone"],
			"exports":"Backbone"
		},
		"backbone.validation":{
			"deps":["backbone"],
			"exports":"Backbone"
		},
		"backbone.zingchart":{
			"deps":["zingchart"],
			"exports":"ZingChart"
		},
	}
});

require([ 
  'infrastructure', 
], function () { 
	require([ 
	  'app',
	  'modules/Router',
	], function ( App, Router ) {
		app = new App();
		app.router = new Router();
		if( ! Backbone.History.started) Backbone.history.start();
		app.start(); 
	}); 
});
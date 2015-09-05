define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'collections/Settings',
  'moment'
], function($, _, Backbone, Marionette, Settings, moment ){
	
	String.prototype.ucfirst = function() {
	    return this.charAt(0).toUpperCase() + this.slice(1);
	};
	
	/** Converts numeric degrees to radians */
	if (typeof(Number.prototype.toRad) === "undefined") {
		Number.prototype.toRad = function() {
			return this * Math.PI / 180;
		};
	}
	
	var Utils = {
		
		authAjax : function(url, settings) {
			
			var oSettings;
			if (typeof(url) === 'object' && url !== null) {
				oSettings = url;
			} else {
				oSettings.url = url;
			}
			
			// prepare setting
			var url = oSettings.url;
			var type = oSettings.type || 'GET';
			var dataType = oSettings.dataType || 'json';
			var data = oSettings.data || null;
			var beforeSend = oSettings.beforeSend || function() {
					$('#auth-ajax').html('fetching data ...');
				};
			var complete = oSettings.complete || function() {
					$('#auth-ajax').html(null);
				}; 
			var error = oSettings.error || function(jqXHR, textStatus, errorThrown) {
					if (jqXHR.status == 401) {
						window.location.href = app.rootUri + '#login';
					} else {
						console.log(jqXHR);
					}
				};
			var success = oSettings.success || function(data) {
				$('#auth-ajax').html(null);
			};
			
			$.ajax({
				url: url,
				type: type,
  				dataType: dataType,
				data: data,
				headers: {'Authorization': Settings.getVal('token')},
				beforeSend: beforeSend,
				complete: complete,
				error: error,
				success: success  
			});	
		},
		
		getDistance : function(lon, lat, pid) {
			point = _.findWhere(Constants.LOCATIONS, {id:pid});
			if (point) {
				var R = 6371; // Radius of the earth in km
				var dLat = (lat-point.lat).toRad();  // Javascript functions in radians
				var dLon = (lon-point.lon).toRad(); 
				var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
				          Math.cos(lat.toRad()) * Math.cos(lat.toRad()) * 
				          Math.sin(dLon/2) * Math.sin(dLon/2); 
				var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
				var d = R * c; // Distance in km
				return d;				
			} else {
				return 0;
			}
		},
		
		getJson : function(name) {
			var quiz;
			$.ajax({
				url : 'assets/data/' + name + '.json',
				dataType: 'json',
				async: false, 
				success : function(data) {
					quiz = data;
				}
			});
			
			return quiz;
		},
							
		bootstrapEnv: function() {
		    var envs = ['xs', 'sm', 'md', 'lg'];
		
		    $el = $('<div>');
		    $el.appendTo($('body'));
		
		    for (var i = envs.length - 1; i >= 0; i--) {
		        var env = envs[i];
		
		        $el.addClass('hidden-'+env);
		        if ($el.is(':hidden')) {
		            $el.remove();
		            return env;
		        }
		    };
		}
	};

	return Utils;
});

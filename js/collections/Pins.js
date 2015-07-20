define([
  'underscore',
  'backbone',
  'models/Pin'
], function(_, Backbone, Pin){
	var Pins = Backbone.Collection.extend({
	  url : 'api/gpio',
	  model: Pin,
	  
	  comparator: function(m) {
		return m.get('Phys');
	  },
       
	});
	
	return Pins;
});
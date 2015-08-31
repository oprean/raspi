define([
  'underscore',
  'backbone',
  'backbone.localStorage',
  'models/Setting'
], function(_, Backbone, LocalStorage, Setting){
	var Settings = Backbone.Collection.extend({
	  model: Setting,
	  localStorage: new LocalStorage("settings"),
	  
	  getVal: function(key) {
	  	var s = this.findWhere({key:key});
	  	if (s) return s.get('value');
	  },
	  
	  setVal : function(key, value) {
	  	var setting = this.findWhere({key:key});
	  	if (!setting) {
	  		setting = new Setting({
		  		key: key,
		  		value: value
	  		});
	  		this.add(setting);
	  	} else {
	  		setting.set({value:value});
	  	}
		setting.save();
	  },
	  
	  token : function() {
	  	return this.get('token');
	  },
	  
	  uid : function() {
	  	return this.get('uid');
	  },
	});

	return new Settings();
});
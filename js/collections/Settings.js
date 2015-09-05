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
	  	return (s)?s.get('value'):null;
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
	  
	  removeVal : function(key) {
	  	var setting = this.findWhere({key:key});
	  	if (setting) setting.destroy();
	  },
	  
	  token : function() {
	  	return this.getVal('token');
	  },
	  
	  uid : function() {
	  	return this.getVal('uid');
	  },
	});

	return new Settings();
});
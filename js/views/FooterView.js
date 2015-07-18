define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'text!templates/footer.html',
], function($, _, Backbone, Marionette, footerTpl){
	var FooterView = Backbone.Marionette.ItemView.extend({
		template : _.template(footerTpl),
		initialize : function(options) {
		},
		events : {
			'click .local-storage-clear' : 'localStorageClear'
		},
		
		localStorageClear : function() {
			localStorage.clear();
			location.reload(true);
		}
	});
	 
	return FooterView;
});
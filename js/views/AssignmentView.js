define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'text!templates/assignment.html',
], function($, _, Backbone, Marionette, assignmentTpl){
	var AssignmentView = Backbone.Marionette.ItemView.extend({
		template : _.template(assignmentTpl),
		initialize : function(options) {
		},
	});
	 
	return AssignmentView;
});
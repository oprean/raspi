define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'text!templates/assignments.html',
  'collections/Users',
  'views/AssignmentView'
], function($, _, Backbone, Marionette, assignmentsTpl, Assignments, AssignmentView){
	var AssignmentsView = Backbone.Marionette.CompositeView.extend({
		template : _.template(assignmentsTpl),
		childViewContainer: '.assignments-container',
		childView: AssignmentView,
		
		events : {
		},

		initialize : function(options) {
			this.collections = new Assignments();
			this.collections.fetch();
		},
		
	});
	 
	return AssignmentsView;
});
define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'text!templates/home2.html',
  
  'collections/Tiles',
  
  'modules/Constants',

  'views/tiles/BaseTileView',  
  'views/tiles/TemperatureSensorTileView',
  'views/tiles/SwitchTileView'
 
], function($, _, Backbone, Marionette, homeTpl, Tiles, Constant,
	BaseTileView, TemperatureSensorTileView, SwitchTileView){
	var HomeView = Backbone.Marionette.CompositeView.extend({
		template : _.template(homeTpl),
		childViewContainer: '.tiles-container',
		childView: BaseTileView,
		getChildView: function(item) {
			var view;
			switch(item.get('type')) {
			case Constant.TILE_TYPE_TEMPERATURE_SENSOR:
				view = TemperatureSensorTileView;
				break;
			case Constant.TILE_TYPE_SWITCH:
				view = SwitchTileView;
				break;
			default:
				view = BaseTileView;
				break;
			}
			return view;
		},
		
		initialize : function(options) {
			this.collection = new Tiles();
			this.collection.fetch();
		},
	});
	 
	return HomeView;
});
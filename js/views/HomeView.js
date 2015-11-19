define([
  'jquery',
  'underscore',
  'backbone',
  'backbone.marionette',
  'text!templates/home.html',
  
  'collections/Tiles',
  
  'modules/Constants',
  'collections/Settings',

  'views/tiles/BaseTileView',  
  'views/tiles/TemperatureSensorTileView',
  'views/tiles/SwitchTileView',
  'views/tiles/TtsTileView',
  'views/tiles/LedstripTileView'
 
], function($, _, Backbone, Marionette, homeTpl, Tiles, Constant, Settings,
	BaseTileView, TemperatureSensorTileView, SwitchTileView, TtsTileView, LedstripTileView){
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
			case Constant.TILE_TYPE_TTS:
				view = TtsTileView;
				break;
			case Constant.TILE_TYPE_LEDSTRIP:
				view = LedstripTileView;
				break;
			default:
				view = BaseTileView;
				break;
			}
			return view;
		},
		
		initialize : function(options) {
			this.collection = new Tiles();
			this.collection.fetch({});
		},
	});
	 
	return HomeView;
});
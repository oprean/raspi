<?php
class Tile {
	const TILE_TYPE_BUTTON = 'button';
	const TILE_TYPE_COMMAND = 'command';
	const TILE_TYPE_SWITCH = 'switch';
	const TILE_TYPE_TEMPERATURE_SENSOR = 'temperature_sensor';
	const TILE_TYPE_TTS = 'tts';
	const TILE_TYPE_LEDSTRIP = 'ledstrip';
	
	const TILE_DEFAULT_COLOR = '#000000';
	const TILE_DEFAULT_BK_COLOR = '#CCCCCC';
	
	function __construct() {}
	
	public static function getList() {
		return array(
			array(
				'id' => 1,
				'type' => Tile::TILE_TYPE_TEMPERATURE_SENSOR,
				'name' => 'room',
				'icon' => null,
				'color' => Tile::TILE_DEFAULT_COLOR,
				'bk_color' => '#79822b',
				'data' => array('type' => ROOM_TEMPERATURE)
			),
			array(
				'id' => 2,
				'type' => Tile::TILE_TYPE_TEMPERATURE_SENSOR,
				'name' => 'cpu',
				'icon' => null,
				'color' => Tile::TILE_DEFAULT_COLOR,
				'bk_color' => '#79822b',
				'data' => array('type' => CPU_TEMPERATURE)
			),
			array(
				'id' => 3,
				'type' => Tile::TILE_TYPE_SWITCH,
				'name' => 'lamp',
				'icon' => null,
				'color' => Tile::TILE_DEFAULT_COLOR,
				'bk_color' => '#307391',
				'data' => array('pin' => 13)
			),
			array(
				'id' => 4,
				'type' => Tile::TILE_TYPE_SWITCH,
				'name' => 'vent',
				'icon' => null,
				'color' => Tile::TILE_DEFAULT_COLOR,
				'bk_color' => '#307391',
				'data' => array('pin' => 11)
			),
			/*array(
				'id' => 5,
				'type' => Tile::TILE_TYPE_TTS,
				'name' => 'sunt la ușă',
				'icon' => null,
				'color' => Tile::TILE_DEFAULT_COLOR,
				'bk_color' => '#87622d',
				'data' => array('text' => 'sunt la ușă')
			),
			array(
				'id' => 6,
				'type' => Tile::TILE_TYPE_TTS,
				'name' => 'te iubesc',
				'icon' => null,
				'color' => Tile::TILE_DEFAULT_COLOR,
				'bk_color' => '#87622d',
				'data' => array('text' => 'te iubesc')
			),*/
			array(
				'id' => 7,
				'type' => Tile::TILE_TYPE_BUTTON,
				'name' => 'pins',
				'icon' => 'fa-wrench',
				'color' => Tile::TILE_DEFAULT_COLOR,
				'bk_color' => '#c34b53',
				'data' => array('url' => '#pins')
			),
			array(
				'id' => 8,
				'type' => Tile::TILE_TYPE_BUTTON,
				'name' => 'tts',
				'icon' => 'fa-bullhorn',
				'color' => Tile::TILE_DEFAULT_COLOR,
				'bk_color' => '#c34b53',
				'data' => array('url' => '#tts')
			),
			array(
				'id' => 9,
				'type' => Tile::TILE_TYPE_BUTTON,
				'name' => 'temperatures stats',
				'icon' => 'fa-line-chart',
				'color' => Tile::TILE_DEFAULT_COLOR,
				'bk_color' => '#d19f75', 
				'data' => array('url' => '#temperatures')
			),
			array(
				'id' => 10,
				'type' => Tile::TILE_TYPE_BUTTON,
				'name' => 'sockets',
				'icon' => 'fa-plug',
				'color' => Tile::TILE_DEFAULT_COLOR,
				'bk_color' => '#d19f75',
				'data' => array('url' => '#sockets')
			),
			array(
				'id' => 11,
				'type' => Tile::TILE_TYPE_BUTTON,
				'name' => 'Account',
				'icon' => 'fa-user',
				'color' => Tile::TILE_DEFAULT_COLOR,
				'bk_color' => '#d19f75',
				'data' => array('url' => '#account')
			),
			array(
				'id' => 12,
				'type' => Tile::TILE_TYPE_BUTTON,
				'name' => 'Admin',
				'icon' => 'fa-cogs',
				'color' => Tile::TILE_DEFAULT_COLOR,
				'bk_color' => '#d19f75',
				'data' => array('url' => '#admin')
			),
		array(
				'id' => 13,
				'type' => Tile::TILE_TYPE_LEDSTRIP,
				'name' => 'white',
				'icon' => 'fa-lightbulb-o',
				'color' => '#ffffff',
				'bk_color' => '#CCCCCC',
				'data' => array('cmd'=> 'fill', 'r' => 255, 'g' => 255, 'b' => 255)
			),
		array(
				'id' => 14,
				'type' => Tile::TILE_TYPE_LEDSTRIP,
				'name' => 'red',
				'icon' => 'fa-lightbulb-o',
				'color' => Tile::TILE_DEFAULT_COLOR,
				'bk_color' => '#ff0000',
				'data' => array('cmd'=> 'fill', 'r' => 255, 'g' => 0, 'b' => 0)
			),
		array(
				'id' => 15,
				'type' => Tile::TILE_TYPE_LEDSTRIP,
				'name' => 'green',
				'icon' => 'fa-lightbulb-o',
				'color' => Tile::TILE_DEFAULT_COLOR,
				'bk_color' => '#00ff00',
				'data' => array('cmd'=> 'fill', 'r' => 0, 'g' => 255, 'b' => 0)
			),
		array(
				'id' => 16,
				'type' => Tile::TILE_TYPE_LEDSTRIP,
				'name' => 'blue',
				'icon' => 'fa-lightbulb-o',
				'color' => Tile::TILE_DEFAULT_COLOR,
				'bk_color' => '#0000ff',
				'data' => array('cmd'=> 'fill', 'r' => 0, 'g' => 0, 'b' => 255)
			),
		array(
				'id' => 17,
				'type' => Tile::TILE_TYPE_LEDSTRIP,
				'name' => 'led clock',
				'icon' => 'fa-clock-o',
				'color' => Tile::TILE_DEFAULT_COLOR,
				'bk_color' => '#454545',
				'data' => array('cmd'=> 'clock', 't' => 5)
			),
		array(
				'id' => 18,
				'type' => Tile::TILE_TYPE_LEDSTRIP,
				'name' => 'rainbow',
				'icon' => 'fa-clock-o',
				'color' => Tile::TILE_DEFAULT_COLOR,
				'bk_color' => '#004545',
				'data' => array('cmd'=> 'rainbow')
			),
			array(
				'id' => 19,
				'type' => Tile::TILE_TYPE_BUTTON,
				'name' => 'Ledstrip',
				'icon' => 'fa-user',
				'color' => Tile::TILE_DEFAULT_COLOR,
				'bk_color' => '#d19f75',
				'data' => array('url' => '#ledstrip')
			),
		);
	}
}

?>
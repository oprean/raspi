<?php
class Tile {
	const TILE_TYPE_BUTTON = 'button';
	const TILE_TYPE_COMMAND = 'command';
	const TILE_TYPE_SWITCH = 'switch';
	const TILE_TYPE_TEMPERATURE_SENSOR = 'temperature_sensor';
	const TILE_TYPE_TTS = 'tts';
	
	function __construct() {}
	
	public static function getList() {
		return array(
			array(
				'id' => 1,
				'type' => Tile::TILE_TYPE_TEMPERATURE_SENSOR,
				'name' => 'room',
				'icon' => null,
				'color' => null,				
				'data' => array('type' => ROOM_TEMPERATURE)
			),
			array(
				'id' => 2,
				'type' => Tile::TILE_TYPE_TEMPERATURE_SENSOR,
				'name' => 'cpu',
				'icon' => null,
				'color' => null,
				'data' => array('type' => CPU_TEMPERATURE)
			),
			array(
				'id' => 3,
				'type' => Tile::TILE_TYPE_SWITCH,
				'name' => 'lamp',
				'icon' => null,
				'color' => null,
				'data' => array('pin' => 23)
			),
			array(
				'id' => 4,
				'type' => Tile::TILE_TYPE_SWITCH,
				'name' => 'vent',
				'icon' => null,
				'color' => null,
				'data' => array('pin' => 11)
			),
			array(
				'id' => 5,
				'type' => Tile::TILE_TYPE_TTS,
				'name' => 'say time',
				'icon' => null,
				'color' => null,
				'data' => array('text' => 'time')
			),
			array(
				'id' => 6,
				'type' => Tile::TILE_TYPE_TTS,
				'name' => 'say temperature',
				'icon' => null,
				'color' => null,
				'data' => array('text' => 'temp')
			),
			array(
				'id' => 7,
				'type' => Tile::TILE_TYPE_BUTTON,
				'name' => 'pins',
				'icon' => 'fa-wrench',
				'color' => null,

				'data' => array('url' => '#pins')
			),
			array(
				'id' => 8,
				'type' => Tile::TILE_TYPE_BUTTON,
				'name' => 'tts',
				'icon' => 'fa-bullhorn',
				'color' => null,
				'data' => array('url' => '#tts')
			),
			array(
				'id' => 9,
				'type' => Tile::TILE_TYPE_BUTTON,
				'name' => 'temperatures stats',
				'icon' => 'fa-line-chart',
				'color' => null,
				'data' => array('url' => '#temperatures')
			),
			array(
				'id' => 10,
				'type' => Tile::TILE_TYPE_BUTTON,
				'name' => 'sockets',
				'icon' => 'fa-plug',
				'color' => null,
				'data' => array('url' => '#sockets')
			),
		);
	}
}

?>
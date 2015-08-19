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
				'data' => array('type' => ROOM_TEMPERATURE)
			),
			array(
				'id' => 2,
				'type' => Tile::TILE_TYPE_TEMPERATURE_SENSOR,
				'name' => 'cpu',
				'data' => array('type' => CPU_TEMPERATURE)
			),
			array(
				'id' => 3,
				'type' => Tile::TILE_TYPE_SWITCH,
				'name' => 'lamp',
				'data' => array('pin' => 23)
			),
			array(
				'id' => 4,
				'type' => Tile::TILE_TYPE_SWITCH,
				'name' => 'vent',
				'data' => array('pin' => 11)
			),
			/*array(
				'id' => 5,
				'type' => Tile::TILE_TYPE_TTS,
				'name' => 'I\'m home',
				'data' => array('text' => 'Cami, sunt acasă!')
			),*/
		);
	}
}

?>
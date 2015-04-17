<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Default Connection Name
	|--------------------------------------------------------------------------
	|
	| Here you may specify which of the connections below you wish to use as
	| your default connection for all work. Of course, you may use many
	| connections at once using the manager class.
	|
	*/

	'default' => 'main',

	/*
    |--------------------------------------------------------------------------
    | Hashids Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the connections setup for your application. Example con-
    | figuration has been included, but you may add as many connections as
    | you would like.
    |
    */

	'connections' => [

		'main' => [
			'salt' => env('APP_KEY', '"R*5F_w86[Rw?W)QvYyNkfS.VO5MRI'),
			'length' => '8',
			'alphabet' => 'abcdefghijklmnopqrstuvwxyz0123456789'
		],

		'alternative' => [
			'salt' => 'your-salt-string',
			'length' => 'your-length-integer',
			'alphabet' => 'your-alphabet-string'
		],

	]

];

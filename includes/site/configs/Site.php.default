<?php

/**
 * Copyright (C) 2009-2011 Shadez <https://github.com/Shadez>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 **/

$SiteConfigs = array(
	'site' => array(
		'path' => '',
		'locale_indexes' => array(0, 1),
		'log' => array(
			'enabled' => true,
			'filename' => WEBROOT_DIR . '_debug' . DS . 'tmp.dbg',
			'level' => 3
		),
		'locale' => array(
			'default' => 'en',
		),
		'title' => 'World of Warcraft',
	),
	'misc' => array(
		'admin_email' => 'admin@' . $_SERVER['SERVER_NAME'],
	),

	'session' => array(
		'identifier' => 'wow_id',
		'user' => array(
			'storage' => 'wow_session'
		),
		'magic_string' => 'SESSION_CONVERT'
	),

	'database' => array(
		'characters' => array(
			1 => array(
				'host' => 'localhost',
				'user' => 'root',
				'password' => '',
				'db_name' => 'characters',
				'charset' => 'UTF8',
				'driver' => 'mysqli',
				'prefix' => ''
			)
		),
		'world' => array(
			'host' => 'localhost',
			'user' => 'root',
			'password' => '',
			'db_name' => 'mangos',
			'charset' => 'UTF8',
			'driver' => 'mysqli',
			'prefix' => ''
		),
		'wow' => array(
			'host' => 'localhost',
			'user' => 'root',
			'password' => '',
			'db_name' => 'wow_cs',
			'charset' => 'UTF8',
			'driver' => 'mysqli',
			'prefix' => 'wow'
		)
	)
);
?>
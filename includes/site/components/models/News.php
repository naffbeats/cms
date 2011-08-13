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

class News_Model_Component extends Model_Db_Component
{
	public $m_model = 'News';
	public $m_table = 'wow_news';
	public $m_dbType = 'wow';
	public $m_fields = array(
		'id' => 'Id',
		'image' => array('type' => 'string'),
		'header_image' => array('type' => 'string'),
		'title' => 'Locale',
		'desc' => 'Locale',
		'text' => 'Locale',
		'author' => array('type' => 'string'),
		'postdate' => array('type' => 'integer'),
	);
}
?>
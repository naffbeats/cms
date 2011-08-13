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

class Character_Controller_Component extends Controller_Component
{
	public function build($core)
	{
		$this->c('Config')->setValue('tmp.db_characters.active', 1);
		$this->c('Config')->setValue('tmp.db_world.active', 1);

		if ($core->getUrlAction(1))
			$this->buildBlock('item');
		else
			$this->buildBlock('main');
		return $this;
	}
	
	public function unit_main()
	{
		return $this->unit('List')
			->setFind(array(
				'model' => 'Characters'
			));
	}

	public function unit_item()
	{
		return $this->unit('Item')
			->setFind(array(
				'model' => 'Characters',
			))
			->setFindWhere(array(
				array(
					'field' => 'name',
					'type' => '=',
					'value' => $this->core->getUrlAction(1),
					'typeAndOr' => 'AND'
				)
			));
	}

	public function block_main()
	{
		return $this->block('List')
			->setMainUnit('main')
			->setRegion('content')
			->setTemplate('list', 'character');
	}

	public function block_item()
	{
		return $this->block('Item')
			->setMainUnit('item')
			->setRegion('content')
			->setTemplate('item', 'character');
	}

	public function block_left()
	{
		return $this->block('Item')
			->setMainUnit('item')
			->setRegion('left')
			->setTemplate('item', 'character');
	}
}
?>
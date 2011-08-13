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

class Achievement_Controller_Component extends Controller_Component
{
	public function build($core)
	{
		if ($this->core->getUrlAction(1))
			$this->buildBlock('item');
		else
			$this->buildBlock('main');

		return $this;
	}

	protected function block_main()
	{
		return $this->block('List')
			->setRegion('main')
			->setFind(array(
				'model' => 'Achievement',
				'fields' => array('id', 'name_ru')
			))
			->setFindWhere(array(
				array(
					'field' => 'titleReward_ru',
					'type' => '<>',
					'value' => '',
					'typeAndOr' => 'AND'
				)
			))
			->setTemplate('main', 'achievements');
	}

	protected function block_item()
	{
		$this->c('Config')->setValue('tmp.db_characters.active', 1);
		$this->c('Config')->setValue('tmp.db_world.active', 1);
		return $this->block('Item')
			->setRegion('main')
			->setFind(array(
				'model' => 'Achievement',
				'fields' => array('id', 'name_en', 'categoryId', 'wow_achievement_category.name_ru')
			))
			->setJoin(array(
				array(
					'parent_table' => 'wow_achievement',
					'parent_field' => 'categoryId',
					'table' => 'wow_achievement_category',
					'field' => 'id',
					'type' => '=',
					'join_type' => 'left',
					'value' => ''
				)
			))
			->setConditions(array(
				array(
					'field' => 'id',
					'type' => '=',
					'value' => $this->core->getUrlAction(1)
				)
			))
			->setTemplate('item', 'achievements');
	}
}
?>
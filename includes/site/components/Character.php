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

class Character_Component extends Wow_Util_Component
{
	public function onDataReceive(&$data)
	{
		//$this->gData($data);
	}

	private function gData(&$data)
	{
		echo $data['name'] . ', ' . $this->c('Locale')->getString('character_class_' . $data['class'])  ;
		echo ' - ' . $this->c('Locale')->getString('character_race_' . $data['race']);
		echo ' ' . $this->c('Locale')->format('tempalte_lvl_fmt', $data['level']);
	}

	public function buildCharacter($realmName, $name, $type = 'simple')
	{
		if ($type == 'advanced')
			return $this->buildAdvancedProfile($realmName, $name);
		else
			return $this->buildSimpleProfile($realmName, $name);
	}

	protected function buildAdvancedProfile($realmName, $name)
	{
		return $this;
	}

	protected function buildSimpleProfile($realmName, $name)
	{
		
	}
}
?>
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

class Wow_Util_Component extends Component
{
	public function getFactionID($raceID)
	{
		$horde_races    = array(RACE_ORC,     RACE_TROLL, RACE_TAUREN, RACE_UNDEAD, RACE_BLOODELF, RACE_GOBLIN);
		$alliance_races = array(RACE_DRAENEI, RACE_DWARF, RACE_GNOME,  RACE_HUMAN,  RACE_NIGHTELF, RACE_WORGEN);
		
		if (in_array($raceID, $horde_races))
			return FACTION_HORDE;
		elseif (in_array($raceID, $alliance_races))
			return FACTION_ALLIANCE;
		else
		{
			$this->c('Log')->writeError('%s : unknown race ID %d!', __METHOD__, $raceID);
			return -1;
		}
	}

	public function getRealmIDByName($name)
	{
		if ($realms = explode('/', $name))
			$name = $realms[0];

		return $this->findRealm($name);
	}

	public function findRealm($name)
	{
		foreach ($this->c('Config')->getValue('realms') as $realm)
			if (strtolower($realm['name']) == strtolower($name))
				return $realm['id'];

		return 0;
	}

	public function getMaxArray($holder)
	{
		if (!is_array($holder))
		{
			$this->c('Log')->writeError('%s : $holder must be an array!', __METHOD__);
			return false;
		}

		$keys = array_keys($holder);
		$count = count($holder);
		$min = $max = $holder[$keys[0]];
		$index_min = $index_max = 0;

		for ($i = 0; $i < $count; ++$i)
		{
			if ($holder[$keys[$i]] > $max)
			{
				$index_max = $i;
				$max = $holder[$keys[$i]];
			}
		}

		return $index_max;
	}

	public function ComputePetBonus($stat, $value, $unitClass)
	{
		if(!in_array($unitClass, array(CLASS_HUNTER, CLASS_WARLOCK)))
			return -1;

		$hunter_pet_bonus = array(0.22, 0.1287, 0.3, 0.4, 0.35, 0.0, 0.0, 0.0);
		$warlock_pet_bonus = array(0.0, 0.0, 0.3, 0.4, 0.35, 0.15, 0.57, 0.3);

		switch($unitClass)
		{
			case CLASS_WARLOCK:
				if(isset($warlock_pet_bonus[$stat]))
					return ($value * $warlock_pet_bonus[$stat] > 0) ? $value * $warlock_pet_bonus[$stat] : -1;
				else
					return -1;
				break;
			case CLASS_HUNTER:
				if(isset($hunter_pet_bonus[$stat]))
					return ($value * $hunter_pet_bonus[$stat] > 0) ? $value * $hunter_pet_bonus[$stat] : -1;
				else
					return -1;
				break;
		}

		return -1;
    }

	public function GetFloatValue($value, $num)
	{
		$txt = unpack('f', pack('L', $value));
		return round($txt[1], $num);
	}
}
?>
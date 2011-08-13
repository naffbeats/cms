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

/**
 * Config component provides easy access to any configuration value
 * @copyright Copyright (C) 2010-2011 Shadez <https://github.com/Shadez>
 * @category  Core
 **/
class Config_Component extends Component
{
	private $m_holder = array();

	public function initialize()
	{
		$this->loadConifgs();

		return $this;
	}

	/**
	 * Loads configuration file into $m_holder
	 * @param  string $type = 'site'
	 * @return Config_Component
	 * @todo   Maybe load database configurations file here? Or store all configs in one file?
	 **/
	public function loadConifgs($type = 'site')
	{
		if ($this->m_holder)
			return $this;

		if (!in_array($type, array('site', 'database')))
			$type = 'site';

		$type = ucfirst($type);

		// First of all, try to load configuration file from "site" directory.
		$files = array(SITE_CONFIGS_DIR .  $type . '.php', CORE_CONFIGS_DIR .  $type . '.php');
		foreach ($files as $file)
			if (file_exists($file))
			{
				include($file);
				if (!isset(${$type . 'Configs'}) || !is_array(${$type . 'Configs'}))
				{
					$this->c('Log')->writeError('%s : unable to find configuration variable for %s type!', __METHOD__, $type);
					return $this;
				}
				$this->m_holder = ${$type . 'Configs'};
				break;
			}

		if (!$this->m_holder)
			$this->c('Log')->writeError('%s : unable to find configuration file for %s type!', __METHOD__, $type);

		return $this;
	}

	/**
	 * Transforms string path to array accessors
	 * @access private
	 * @param  $path
	 * @return mixed
	 **/
	private function getConfigPath(&$path)
	{
		$holder_path = '';

		$pieces = explode('.', $path);
		if (!$pieces)
			return false;

		foreach ($pieces as &$piece)
			$holder_path .= '[\'' . $piece . '\']';

		return $holder_path;
	}

	/**
	 * Returns configuration value
	 * @param  $path
	 * @return mixed
	 **/
	public function getValue($path)
	{
		if (!$path)
			return false;

		$value = false;
		
		$holder_path = $this->getConfigPath($path);

		if (!$holder_path)
			return false;
		eval('if (isset($this->m_holder' . $holder_path  .')) $value = $this->m_holder' . $holder_path .';');
		return $value;
	}

	/**
	 * Sets $path value to $value (for current session only)
	 * @param $path
	 * @param $value
	 * @return Config_Component
	 **/
	public function setValue($path, $value)
	{
		if (!$path || !$value)
		{
			$this->c('Log')->writeError('%s : unable to set value: path or value is not defined (path: %s, value: %s)!', __METHOD__, $path, $value);
			return $this;
		}

		$holder_path = $this->getConfigPath($path);

		if (!$holder_path)
			return $this;

		eval('$this->m_holder' . $holder_path . ' = ' . $value . ';');

		return $this;
	}
}
?>
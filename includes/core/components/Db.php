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

class Db_Component extends Component
{
	private $m_databases = array();
	private $m_database_types = array();

	public function __call($method, $args)
	{
		$db_type = strtolower($method);
		if (method_exists($this, $method))
			return call_user_func_array(array($this, $method), $args);
		elseif (isset($this->m_database_types[$db_type]))
		{
			if (isset($this->m_database_types[$db_type][$this->c('Config')->getValue('tmp.db_' . $db_type . '.active')]))
				return $this->m_database_types[$db_type][$this->c('Config')->getValue('tmp.db_' . $db_type . '.active')];
		}
		elseif (isset($this->m_databases[$db_type]))
			return $this->m_databases[$db_type];
		else
			return $this;
	}

	protected function getDb($db_type, $fromTypes = false)
	{
		if (!$fromTypes)
			$db = isset($this->m_databases[$db_type]) ? $this->m_databases[$db_type] : null;
		else
			$db = isset($this->m_database_types[$db_type]) ? $this->m_database_types[$db_type] : null;

		if (!$db)
			$this->core->terminate('Database ' . $db_type . ' was not found');

		if (!$db->isConnected())
			$db->delayedConnect();

		return $db;
	}

	public function initialize()
	{
		$databases = $this->c('Config')->getValue('database');
		if (!$databases)
			return $this;

		foreach ($databases as $type => $db)
		{	if (!$db)
				continue;
			if (is_array($db) && !isset($db['host']))
			{
				foreach ($db as $id => $data) {
					$this->m_database_types[$type][$id] = new Database_Component('Database', $this->core);
					if ($id <= 1)
						$this->m_database_types[$type][$id]->connect($data, true);
				}
				$this->switchTo($type, 1);
			}
			else
			{
				$this->m_databases[$type] = new Database_Component('Database', $this->core);
				$this->m_databases[$type]->connect($db);
			}
		}

		return $this;
	}
	
	public function switchTo($type, $id)
	{
		if (isset($this->m_database_types[$type][$id]))
			$this->m_database_types[$type][$id]->connect($this->c('Config')->getValue('database.' . $type . '.' . $id));

		return $this;
	}

	public function model($model_name)
	{
		$m = &$this->c($model_name, 'Model');
		if (!$m)
			$this->core->terminate('model ' . $model_name . ' was not found!');

		return $m;
	}
}
?>
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

class Session_Component extends Component
{
	private $m_sessionId 	 = null;
	private $m_sessionData   = null;

	private $m_userId	 	 = null;
	private $m_userName  	 = null;
	private $m_userPassword  = null;
	private $m_userLoginHash = null;
	private $m_userData		 = null;

	public function initialize()
	{
		$this->initSession();

		return $this;
	}

	/**
	 * Restores session from $_SESSION variable
	 * @access private
	 * @return Session_Component
	 **/
	private function initSession()
	{
		$this->m_sessionData = array(
			'sess_identifier' => $this->c('Config')->getValue('session.identifier'),
			'sess_user_data'  => $this->c('Config')->getValue('session.user.storage'),
			'sess_magic_string' => $this->c('Config')->getValue('session.magic_string')
		);
		if (!$this->m_sessionData['sess_identifier'] ||
			!$this->m_sessionData['sess_user_data'] ||
			!$this->m_sessionData['sess_magic_string'])
		{
			$this->c('Log')->writeError('%s : unable to initialize session manager: not enough actual data!', __METHOD__);
			return $this;
		}

		return $this->checkExisted()->createSession();
	}

	/**
	 * Returns $_SESSION data
	 * @access private
	 * @param  string $index
	 * @return mixed
	 **/
	private function sess($index)
	{
		return isset($_SESSION[$index]) ? $_SESSION[$index] : false;
	}

	/**
	 * Replaces special chars to magic string
	 * @access private
	 * @param  string $sess
	 * @return string
	 **/
	private function sess_string($sess)
	{
		$sess_string = '';
		if (strpos($sess, $this->m_sessionData['sess_magic_string']) === false)
			$sess_string = str_replace(';', $this->m_sessionData['sess_magic_string'], $sess); // Convert to
		else
			$sess_string = str_replace($this->m_sessionData['sess_magic_string'], ';', $sess); // Convert from

		return $sess_string;
	}

	/**
	 * Checks for existed session data and rebuilds account data from it (if found)
	 * @access private
	 * @return Session_Component
	 **/
	private function checkExisted()
	{
		if (!$this->m_sessionData)
			return $this;

		$s_id = $this->m_sessionData['sess_identifier'];
		$s_u = $this->m_sessionData['sess_user_data'];
		$s_m = $this->m_sessionData['sess_magic_string'];

		if (!$this->sess($s_id) || !$this->sess($s_u) || !$this->sess($s_m))
			return $this;

		$sess_user = $this->sess($s_u);
		$user_data = explode(';', $this->sess_string($sess_user));
		if (!$user_data)
			return $this;

		foreach($user_data as $data_id => $value)
		{
			if (isset($this->{'m_' . $data_id}))
				$this->{'m_' . $data_id} = $value;
			else
				$this->m_userData[$data_id] = $value;
		}

		return $this;
	}

	/**
	 * Creates new session
	 * @access private
	 * @todo   implement
	 * @return Session_Component
	 **/
	private function createSession()
	{
		if ($this->m_sessionId != null)
			return $this; // Already initialized

		$this->m_sessionId = sha1('SESSION');

		return $this;
	}
}
?>
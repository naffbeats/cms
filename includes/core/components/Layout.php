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

class Layout_Component extends Component
{
	private $m_css = array();
	private $m_js = array();

	public function getPageTitle()
	{
		return $this->c('Config')->getValue('site.title');
	}

	public function initialize()
	{
		include(SITE_DIR . 'layouts' . DS . 'ClientCss.php');
		include(SITE_DIR . 'layouts' . DS . 'ClientJs.php');
		$this->m_css = $ClientCSS;
		$this->m_js = $ClientJS;

		unset($ClientCSS, $ClientJS);

		return $this;
	}

	public function getControllerCss($controller)
	{
		return isset($this->m_css[$controller]) ? $this->m_css[$controller] : null;
	}

	public function getControllerJs($controller)
	{
		return isset($this->m_js[$controller]) ? $this->m_js[$controller] : null;
	}
}
?>
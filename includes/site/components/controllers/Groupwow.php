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

abstract class Groupwow_Controller_Component extends Controller_Component
{
	protected function setTemplates()
	{
		$this->m_templates = array(
			(TEMPLATES_DIR . 'elements' . DS . 'ajax.ctp'),
			(TEMPLATES_DIR . 'elements' . DS . 'wow' . DS . 'layout.ctp'),
		);

		return $this;
	}

	protected function beforeActions()
	{
		if (!$this->core->getUrlLocale())
		{
			// Redirect
			$actions = $this->core->getActions();
			$locale_index = $this->c('Config')->getValue('site.locale_indexes.0');

			$location = CLIENT_FILES_PATH . '/';
			$size = sizeof($actions);

			for($i = 0; $i < $size; ++$i)
			{
				$location .= $actions['action' . $i] . '/';
				if ($i == $locale_index)
					$location .= $this->c('Locale')->getLocale() . '/';
			}

			header('Location: ' . substr($location, 0, strlen($location)-1));

			exit(0);
		}

		return $this;
	}

	protected function block_header()
	{
		return $this->block()
			->setRegion('header')
			->setTemplate('header', 'wow' . DS . 'elements');
	}

	protected function block_footer()
	{
		return $this->block()
			->setRegion('footer')
			->setTemplate('footer', 'wow' . DS . 'elements');
	}

	protected function block_service()
	{
		return $this->block()
			->setRegion('service')
			->setTemplate('service', 'wow' . DS . 'elements');
	}
}
?>
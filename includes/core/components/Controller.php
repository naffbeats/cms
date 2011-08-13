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

class Controller_Component extends Component
{
	private $m_postBuild = array();
	private $m_blocks = array();
	private $m_units = array();
	protected $m_isAjax = false;

	protected $m_templates = array();

	protected $m_css = array();
	protected $m_js = array();

	public function initialize()
	{
		$this->setTemplates();

		$controller = substr($this->m_component, 0, strpos($this->m_component, '_'));

		$this->m_css = $this->c('Layout')->getControllerCss($controller);
		$this->m_js = $this->c('Layout')->getControllerJs($controller);

		$this->preparePage()
			->beforeActions()
			->registerClientFiles()
			->addClientFiles()
			->build($this->c('Core'))
			->performPostBuild()
			->complete();

		return $this;
	}

	protected function preparePage()
	{
		if ($this->m_isAjax)
			header('Content-type: text/javascript');

		return $this;
	}

	protected function beforeActions()
	{
		return $this;
	}

	protected function registerClientFiles()
	{
		return $this;
	}

	protected function setTemplates()
	{
		$this->m_templates = array(
			(TEMPLATES_DIR . 'elements' . DS . 'ajax.ctp'),
			(TEMPLATES_DIR . 'elements' . DS . 'layout.ctp'),
		);

		return $this;
	}

	public function block($type = '')
	{
		$class = ($type ? $type . '_' : '') . 'Block_Component';
		$block = new $class('Block', $this->core);
		return $block->setBlockType($type)->setBlockState(true);
	}

	public function unit($type = '')
	{
		$class = ($type ? $type . '_' : '') . 'Unit_Component';
		$unit = new $class('Unit', $this->core);
		return $unit;
	}

	public function buildBlock($name)
	{
		if (method_exists($this, 'block_' . $name))
		{
			$block = &$this->{'block_' . $name}();
			$block->setBlockName($name);
			if ($block->getMainUnit() != null && method_exists($this, 'unit_' . $block->getMainUnit()))
			{
				if (isset($this->m_units[$block->getMainUnit()]))
					$unit = $this->m_units[$block->getMainUnit()];
				else
				{
					$unit = &$this->{'unit_' . $block->getMainUnit()}();
					$unit->findData();
				}
				$block->setMainUnitObject($unit);
				$this->m_units[$block->getMainUnit()] = $unit;
			}
		}

		return $this;
	}

	public function getUnit($unitName)
	{
		if (method_exists($this, 'unit_' . $unitName))
			return $this->{'unit_' . $unitName}();

		return $this->c('Unit');
	}

	public function buildBlocks($blocks)
	{
		if (is_array($blocks))
			foreach($blocks as $block)
				$this->buildBlock($block);

		return $this;
	}

	protected function addClientFiles()
	{
		if (is_array($this->m_css))
			foreach($this->m_css as $type => $css)
				$this->c('Document')->registerCss($css, $type);

		if (is_array($this->m_js))
			foreach($this->m_js as $type => $js)
				$this->c('Document')->registerJs($js, $type);

		return $this;
	}

	public function addPostAction($act)
	{
		if (!$act)
			return $this;

		$this->m_postBuild[] = $act;

		return $this;
	}

	private function performPostBuild()
	{
		if ($this->m_postBuild)
			foreach ($this->m_postBuild as &$post)
				if (is_array($post))
					if (method_exists($post[0], $post[1]))
						$post[0]->{$post[1]}();
				else
					if (function_exists($post))
						$post();

		return $this;
	}

	public function build($core)
	{
		return $this;
	}

	protected function complete()
	{
		return $this->renderRegions()->view();
	}

	private function renderRegions()
	{
		$regions = $this->c('Document')->getAllRegions();
		if (!$regions)
			return $this;

		foreach ($regions as &$region)
			$region->renderAllBlocks();

		return $this;
	}

	private function view()
	{
		if ($this->m_isAjax)
			$template = $this->m_templates[0];
		else
			$template = $this->m_templates[1];

		if (!file_exists($template))
			$this->core->terminate('Unable to load core view');

		include($template);

		return $this;
	}

	protected function ajaxPage()
	{
		$this->m_isAjax = true;

		return $this;
	}
}
?>
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

session_start();
error_reporting(E_ALL);

$debug = true;

$tstart = microtime(true);

define('ROOT', dirname(dirname(__FILE__)));
define('DS', DIRECTORY_SEPARATOR);
define('WEBROOT_DIR', ROOT . DS . 'webroot' . DS);

define('INCLUDES_DIR', ROOT . DS . 'includes' . DS);
define('TEMPLATES_DIR', INCLUDES_DIR . 'templates' . DS);

define('CORE_DIR', INCLUDES_DIR . 'core' . DS);
define('CORE_CLASSES_DIR', CORE_DIR . 'classes' . DS);
define('CORE_CONFIGS_DIR', CORE_DIR . 'configs' . DS);
define('CORE_COMPONENTS_DIR', CORE_DIR . 'components' . DS);
define('CORE_MODELS_DIR', CORE_DIR . 'models' . DS);
define('CORE_LOCALES_DIR', CORE_DIR . 'locales' . DS);
define('CORE_TEMPLATES_DIR', CORE_DIR . 'templates' . DS);

define('SITE_DIR', INCLUDES_DIR . 'site' . DS);
define('SITE_CLASSES_DIR', SITE_DIR . 'classes' . DS);
define('SITE_CONFIGS_DIR', SITE_DIR . 'configs' . DS);
define('SITE_COMPONENTS_DIR', SITE_DIR . 'components' . DS);
define('SITE_MODELS_DIR', SITE_DIR . 'models' . DS);
define('SITE_LOCALES_DIR', SITE_DIR . 'locales' . DS);
define('SITE_TEMPLATES_DIR', SITE_DIR . 'templates' . DS);

define('NL', "\n");
define('TAB', "\t");
define('NLTAB', NL . TAB);
define('TABNL', TAB . NL);

// Load required files
include(CORE_DIR . 'dumpvar.php');
include(CORE_CLASSES_DIR . 'Autoload.php');
include(CORE_CLASSES_DIR . 'Component.php');
include(SITE_DIR . 'SharedDefines.php');

// Register classes autoloader
Autoload::register();

// Create core
Core_Component::create()->execute();

if ($debug)
{
	$tend = microtime(true);
	$totaltime = ($tend - $tstart) * 1000;
	printf('<p>Page generated in %f ms.</p><br />', $totaltime);
}
?>
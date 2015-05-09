<?php
/**
 * @package		Donate Elite
 * @subpackage	mod_donate_elite
 * @copyright	Copyright (C) 2013 Elite Developers All rights reserved.
 * @license		GNU/GPL v3 http://www.gnu.org/licenses/gpl.html
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

	$moduleclass_sfx = htmlspecialchars( $params->get( 'moduleclass_sfx' ) );

	require( JModuleHelper::getLayoutPath( 'mod_donate_elite' ) );
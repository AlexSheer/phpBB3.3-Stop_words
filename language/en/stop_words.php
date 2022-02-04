<?php
/**
*
* @package phpBB Extension - Stop Words
* @copyright (c) 2015 Sheer
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'USE_RESTRICTED_WORDS'		=> 'Название темы не должно содержать слов: %s и др.<br />Дайте теме более полное и точное название, соответствующее её содержанию.',
));

<?php
/**
 *
 * BBCode Enabled Profile Fields. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019 3Di <https://www.phpbbstudio.com>
 * @copyright (c) 2017 3Di, javiexin
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 * Translated By : Bassel Taha Alhitary <http://alhitary.net>
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'ERROR_PHPBB_VERSION'	=> 'الحد الأدنى لنسخة المنتدى هو %1$s ولكن أقل من %2$s',
]);

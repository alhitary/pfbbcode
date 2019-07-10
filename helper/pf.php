<?php
/**
 * 3Di's PFbbcode extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019 phpBB Studio <https://www.phpbbstudio.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace threedi\pfbbcode\helper;

/**
 * 3Di's PFbbcode Common functions.
 */
class pf
{
	/**
	 * Constructor.
	 *
	 * @param  \phpbb\user								$user			User object
	 * @return void
	 * @access public
	 */
	public function __construct()
	{
	}

	public function pf_validate($field_value, $field_data)
	{
		if ($s_parse_bbcodes = ((int) $field_data['field_novalue']) & OPTION_FLAG_BBCODE)
		{
			$uid = $bitfield = $options = '';
			generate_text_for_storage($field_value, $uid, $bitfield, $options, $s_parse_bbcodes, false, false);
			strip_bbcode($field_value, $uid);
		}
	}

	public function pf_profile_value($field_value, $field_data)
	{
		if (($field_value === null || $field_value === '') && !$field_data['field_show_novalue'])
		{
			return null;
		}

		if ($field_data['field_novalue'])
		{
			$field_value = (!$field_value) ? ' ' : $field_value;

			$uid = $bitfield = $options = '';
			$s_parse_bbcodes = ((int) $field_data['field_novalue']) & OPTION_FLAG_BBCODE;
			$s_parse_smilies = ((int) $field_data['field_novalue']) & OPTION_FLAG_SMILIES;
			$s_parse_urls = ((int) $field_data['field_novalue']) & OPTION_FLAG_LINKS;
			generate_text_for_storage($field_value, $uid, $bitfield, $options, $s_parse_bbcodes, $s_parse_urls, $s_parse_smilies);
			$field_value = generate_text_for_display($field_value, $uid, $bitfield, $options);
		}
		else
		{
			$field_value = make_clickable($field_value);
			$field_value = censor_text($field_value);
			$field_value = bbcode_nl2br($field_value);
		}

		return $field_value;
	}

	public function pf_profile_value_raw($field_value, $field_data)
	{
		if (($field_value === null || $field_value === '') && !$field_data['field_show_novalue'])
		{
			return null;
		}

		if ($field_data['field_novalue'])
		{
			$field_value = (!$field_value) ? ' ' : $field_value;

			$uid = $bitfield = $options = '';
			$s_parse_bbcodes = ((int) $field_data['field_novalue']) & OPTION_FLAG_BBCODE;
			$s_parse_smilies = ((int) $field_data['field_novalue']) & OPTION_FLAG_SMILIES;
			$s_parse_urls = ((int) $field_data['field_novalue']) & OPTION_FLAG_LINKS;
			generate_text_for_storage($field_value, $uid, $bitfield, $options, $s_parse_bbcodes, $s_parse_urls, $s_parse_smilies);
			$field_value = generate_text_for_display($field_value, $uid, $bitfield, $options);
		}
		else
		{
			$field_value = make_clickable($field_value);
			$field_value = censor_text($field_value);
			$field_value = bbcode_nl2br($field_value);
		}

		return $field_value;
	}


}

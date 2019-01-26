<?php
/**
 *
 * BBCode Enabled Profile Fields. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2017 3Di, javiexin
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace threedi\pfbbcode\profilefields\type;

class type_string extends \phpbb\profilefields\type\type_string
{
	/**
	* {@inheritDoc}
	*/
	public function get_name_short()
	{
		return 'string';
	}

	/**
	* {@inheritDoc}
	*/
	public function get_options($default_lang_id, $field_data)
	{
		$s_parse_bbcodes = $this->request->variable('parse_bbcodes', (((int) $field_data['field_novalue']) & OPTION_FLAG_BBCODE) ? true : false);
		$s_parse_smilies = $this->request->variable('parse_smilies', (((int) $field_data['field_novalue']) & OPTION_FLAG_SMILIES) ? true : false);
		$s_parse_urls = $this->request->variable('parse_urls', (((int) $field_data['field_novalue']) & OPTION_FLAG_LINKS) ? true : false);

		$options = array_merge(parent::get_options($default_lang_id, $field_data), array(
			4 => array('TITLE' => $this->user->lang['PARSE_BBCODE'],
						'FIELD' => '<label><input type="radio" class="radio" name="parse_bbcodes" value="1"' . (($s_parse_bbcodes) ? ' checked="checked"' : '') . ' /> ' . $this->user->lang['YES'] . '</label><label><input type="radio" class="radio" name="parse_bbcodes" value="0"' . ((!$s_parse_bbcodes) ? ' checked="checked"' : '') . ' /> ' . $this->user->lang['NO'] . '</label>'),
			5 => array('TITLE' => $this->user->lang['PARSE_SMILIES'],
						'FIELD' => '<label><input type="radio" class="radio" name="parse_smilies" value="1"' . (($s_parse_smilies) ? ' checked="checked"' : '') . ' /> ' . $this->user->lang['YES'] . '</label><label><input type="radio" class="radio" name="parse_smilies" value="0"' . ((!$s_parse_smilies) ? ' checked="checked"' : '') . ' /> ' . $this->user->lang['NO'] . '</label>'),
			6 => array('TITLE' => $this->user->lang['PARSE_URLS'],
						'FIELD' => '<label><input type="radio" class="radio" name="parse_urls" value="1"' . (($s_parse_urls) ? ' checked="checked"' : '') . ' /> ' . $this->user->lang['YES'] . '</label><label><input type="radio" class="radio" name="parse_urls" value="0"' . ((!$s_parse_urls) ? ' checked="checked"' : '') . ' /> ' . $this->user->lang['NO'] . '</label>'),
		));
		return $options;
	}

	/**
	* {@inheritDoc}
	*/
	public function validate_profile_field(&$field_value, $field_data)
	{
		$field_value_to_validate = $field_value;

		if ($s_parse_bbcodes = ((int) $field_data['field_novalue']) & OPTION_FLAG_BBCODE)
		{
			$uid = $bitfield = $options = '';
			generate_text_for_storage($field_value_to_validate, $uid, $bitfield, $options, $s_parse_bbcodes, false, false);
			strip_bbcode($field_value_to_validate, $uid);
		}
		return $this->validate_string_profile_field('string', $field_value_to_validate, $field_data);
	}

	/**
	* {@inheritDoc}
	*/
	public function get_profile_value($field_value, $field_data)
	{
		if ($field_value === null && !$field_data['field_show_novalue'])
		{
			$field_value = '';
		}

		if ($field_data['field_novalue'])
		{
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

	/**
	* {@inheritDoc}
	*/
	public function get_profile_value_raw($field_value, $field_data)
	{
		if ($field_value === null && !$field_data['field_show_novalue'])
		{
			$field_value = '';
		}

		if ($field_data['field_novalue'])
		{
			$uid = $bitfield = $options = '';
			$s_parse_bbcodes = ((int) $field_data['field_novalue']) & OPTION_FLAG_BBCODE;
			$s_parse_smilies = ((int) $field_data['field_novalue']) & OPTION_FLAG_SMILIES;
			$s_parse_urls = ((int) $field_data['field_novalue']) & OPTION_FLAG_LINKS;
			generate_text_for_storage($field_value, $uid, $bitfield, $options, $s_parse_bbcodes, $s_parse_urls, $s_parse_smilies);
			strip_bbcode($field_value, $uid);
		}
		return $field_value;
	}

	/**
	* {@inheritDoc}
	*/
	public function get_excluded_options($key, $action, $current_value, &$field_data, $step)
	{
		if ($step == 2 && $key == 'field_novalue')
		{
			if ($this->request->is_set('parse_bbcodes'))
			{
				$s_parse_bbcodes = $this->request->variable('parse_bbcodes', (((int) $current_value) & OPTION_FLAG_BBCODE) ? true : false);
				$s_parse_smilies = $this->request->variable('parse_smilies', (((int) $current_value) & OPTION_FLAG_SMILIES) ? true : false);
				$s_parse_urls = $this->request->variable('parse_urls', (((int) $current_value) & OPTION_FLAG_LINKS) ? true : false);
				$current_value = (($s_parse_bbcodes) ? OPTION_FLAG_BBCODE : 0) + (($s_parse_smilies) ? OPTION_FLAG_SMILIES : 0) + (($s_parse_urls) ? OPTION_FLAG_LINKS : 0);
			}
			return $current_value ?: '';
		}

		return parent::get_excluded_options($key, $action, $current_value, $field_data, $step);
	}

	/**
	* {@inheritDoc}
	*/
	public function prepare_hidden_fields($step, $key, $action, &$field_data)
	{
		if ($key == 'field_novalue')
		{
			$current_value = $field_data['field_novalue'];

			if ($this->request->is_set('parse_bbcodes'))
			{
				$s_parse_bbcodes = $this->request->variable('parse_bbcodes', false);
				$s_parse_smilies = $this->request->variable('parse_smilies', false);
				$s_parse_urls = $this->request->variable('parse_urls', false);
				$current_value = (($s_parse_bbcodes) ? OPTION_FLAG_BBCODE : 0) + (($s_parse_smilies) ? OPTION_FLAG_SMILIES : 0) + (($s_parse_urls) ? OPTION_FLAG_LINKS : 0);
			}

			return $current_value ?: '';
		}

		return parent::prepare_hidden_fields($step, $key, $action, $field_data);
	}
}

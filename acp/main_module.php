<?php
/**
*
* @package phpBB Extension - Stop Words
* @copyright (c) 2015 Sheer
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace sheer\stop_words\acp;

class main_module
{
	var $u_action;

	function main($id, $mode)
	{
		global $user, $template, $request, $config, $phpbb_container;

		$this->page_title = $user->lang('ACP_STOP_WORDS');
		$this->tpl_name = 'acp_stop_words_body';

		$config_text = $phpbb_container->get('config_text');

		$stop_words		= $config_text->get('stop_words');
		$stop_words		= ($stop_words) ? explode('|', $stop_words) : array();
		$action			= $request->variable('action', '');
		$words_ary		= $request->variable('stop_words', $stop_words, true);
		$word_name		= $request->variable('word_name', '', true);

		$delete			= $request->variable('del', 0);

		if ($action == 'delete')
		{
			unset($stop_words[$delete]);
			$stop_words = implode('|', $stop_words);
			$config_text->set('stop_words', $stop_words);
			meta_refresh(3, append_sid($this->u_action));
			trigger_error($user->lang['UPDATE_STOP_SUCCESS'] . adm_back_link($this->u_action));
		}

		$template->assign_vars(array(
				'STOP_WORD'			=> $word_name,
			)
		);

		foreach ($stop_words as $key => $value)
		{
			$template->assign_block_vars('words', array(
					'KEY'			=> $key,
					'WORD'			=> $value,
					'U_DELETE'		=> $this->u_action . '&amp;action=delete&amp;del=' .$key. '',
				)
			);
		}

		add_form_key('sheer/stop_words');

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key('sheer/stop_words'))
			{
				trigger_error('FORM_INVALID');
			}

			$words_ary = implode('|', $words_ary);
			if ($word_name)
			{
				if ($words_ary)
				{
					$words_ary .= '|' . $word_name;
				}
				else
				{
					$words_ary = $word_name;
				}
			}

			$config_text->set('stop_words', $words_ary);

			meta_refresh(3, append_sid($this->u_action));
			trigger_error($user->lang['UPDATE_STOP_SUCCESS'] . adm_back_link($this->u_action));
		}
	}
}

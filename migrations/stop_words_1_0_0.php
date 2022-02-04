<?php
/**
*
* @package phpBB Extension - Stop Words
* @copyright (c) 2015 Sheer
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/
namespace sheer\stop_words\migrations;

class stop_words_1_0_0 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return;
	}

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\dev');
	}

	public function update_schema()
	{
		return array(
		);
	}

	public function revert_schema()
	{
		return array(
		);
	}

	public function update_data()
	{
		return array(
			// Current version
			array('config.add', array('stop_words_version', '1.0.0')),
			array('config_text.add', array('stop_words', '')),
			// ACP
			array('module.add', array('acp', 'ACP_CAT_DOT_MODS', 'ACP_STOP_WORDS')),
			array('module.add', array('acp', 'ACP_STOP_WORDS', array(
				'module_basename'	=> '\sheer\stop_words\acp\main_module',
				'module_langname'	=> 'ACP_STOP_WORDS_MANAGE',
				'module_mode'		=> 'settings',
				'module_auth'		=> 'ext_sheer/stop_words && acl_a_board',
			))),
		);
	}
}
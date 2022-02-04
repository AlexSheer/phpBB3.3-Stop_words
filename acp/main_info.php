<?php
/**
*
* @package phpBB Extension - Stop Words
* @copyright (c) 2015 Sheer
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace sheer\stop_words\acp;

class main_info
{
	function module()
	{
		return array(
			'filename'	=> '\sheer\stop_words\acp\main_module',
			'version'	=> '1.0.0',
			'title' => 'ACP_STOP_WORDS',
			'modes'		=> array(
				'settings'	=> array(
					'title' => 'ACP_STOP_WORDS_MANAGE',
					'auth' => 'ext_sheer/stop_words && acl_a_board',
					'cat' => array('ACP_STOP_WORDS')
				),
			),
		);
	}
}

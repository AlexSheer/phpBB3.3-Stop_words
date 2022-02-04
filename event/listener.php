<?php
/**
*
* @package phpBB Extension - Stop Words
* @copyright (c) 2015 Sheer
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/
namespace sheer\stop_words\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
/**
* Assign functions defined in this class to event listeners in the core
*
* @return array
* @static
* @access public
*/
	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'							=> 'load_language_on_setup',
			'core.posting_modify_submission_errors'		=> 'check_subject',
		);
	}

	/** @var \phpbb\config\db_text */
	protected $config_text;

	/** @var \phpbb\user\user */
	protected $user;

	/**
	* Constructor
	*/
	public function __construct(\phpbb\config\db_text $config_text, \phpbb\user $user)
	{
		$this->user			= $user;
		$this->config_text	= $config_text;
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'sheer/stop_words',
			'lang_set' => 'stop_words',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function check_subject($event)
	{
		$post_data = $event['post_data'];
		$subject = $post_data['post_subject'];
		$mode = $event['mode'];

		// Remove multiplay . ? and !
		$subject = preg_replace('#(\.){2,}#', '\1', $subject);
		$subject = preg_replace('#(\?){2,}#', '\1', $subject);
		$subject = preg_replace('#(\!){2,}#', '\1', $subject);

		$topic_first_post_id	= (isset($post_data['topic_first_post_id'])) ? $post_data['topic_first_post_id'] : 0;
		$post_id				= (isset($post_data['post_id'])) ? $post_data['post_id'] : 0;
		if (($mode == 'post' || $mode == 'edit') && ($post_id == $topic_first_post_id || !$topic_first_post_id))
		{	// Check only if new topic
			$stop_words = (string) $this->config_text->get('stop_words');
			if ($stop_words)
			{
				$error = $event['error'];
				if (preg_match_all('/(' . $stop_words . ')/ius', $subject, $matches))
				{
					$event['error'] = array_merge($error, array(sprintf($this->user->lang['USE_RESTRICTED_WORDS'], str_replace('|', ', ', $stop_words))));
				}
			}
		}
		$post_data['post_subject'] = $subject;
		$event['post_data'] = $post_data;
	}
}

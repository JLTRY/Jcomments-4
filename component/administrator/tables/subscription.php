<?php
/**
 * JComments - Joomla Comment System
 *
 * @version       3.0
 * @package       JComments
 * @author        Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2022 by Sergey M. Litvinov (http://www.joomlatune.ru) & exstreme (https://protectyoursite.ru) & Vladimir Globulopolis (https://xn--80aeqbhthr9b.com/ru/)
 * @license       GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Table\Table;
use Joomla\Database\DatabaseDriver;

/**
 * JComments subscriptions table
 *
 */
class JCommentsTableSubscription extends Table
{
	protected $_supportNullValue = true;

	/** @var integer Primary key */
	public $id = null;

	/** @var integer */
	public $object_id = null;

	/** @var string */
	public $object_group = null;

	/** @var string */
	public $lang = null;

	/** @var integer */
	public $userid = null;

	/** @var string */
	public $name = null;

	/** @var string */
	public $email = null;

	/** @var string */
	public $hash = null;

	/** @var boolean */
	public $published = null;

	/** @var string */
	public $source = null;

	/** @var boolean */
	public $checked_out = null;

	/** @var datetime */
	public $checked_out_time = null;

	public function __construct($table)
	{
		parent::__construct('#__jcomments_subscriptions', 'id', $table);
	}

	public function store($updateNulls = false)
	{
		/** @var DatabaseDriver $db */
		$db = Factory::getContainer()->get('DatabaseDriver');

		if ($this->userid != 0 && empty($this->email))
		{
			/** @var \Joomla\CMS\User\UserFactory $userFactory */
			$userFactory = Factory::getContainer()->get('user.factory');
			$user        = $userFactory->loadUserById($this->userid);
			$this->email = $user->email;
		}

		if ($this->userid == 0 && !empty($this->email))
		{
			$query = $db->getQuery(true)
				->select('*')
				->from($db->quoteName('#__users'))
				->where($db->quoteName('email') . ' = ' . $db->quote($this->email));

			$db->setQuery($query);
			$users = $db->loadObjectList();

			if (count($users))
			{
				$this->userid = $users[0]->id;
				$this->name   = $users[0]->name;
			}
		}

		if (empty($this->lang))
		{
			$this->lang = Factory::getApplication()->getLanguage()->getTag();
		}
		// Update 'lang' in #__jcomments_objects, #__jcomments tables. If you do not change the value, this will lead
		// to a loss of connection in the tables.
		else
		{
			$query = $db->getQuery(true)
				->update($db->quoteName('#__jcomments'))
				->set($db->quoteName('lang') . ' = ' . $db->quote($this->lang))
				->where($db->quoteName('object_id') . ' = ' . (int) $this->object_id)
				->where($db->quoteName('object_group') . ' = ' .  $db->quote($this->object_group));

			$db->setQuery($query);
			$db->execute();

			$query = $db->getQuery(true)
				->update($db->quoteName('#__jcomments_objects'))
				->set($db->quoteName('lang') . ' = ' . $db->quote($this->lang))
				->where($db->quoteName('object_id') . ' = ' . (int) $this->object_id)
				->where($db->quoteName('object_group') . ' = ' .  $db->quote($this->object_group));

			$db->setQuery($query);
			$db->execute();
		}

		$this->hash = $this->getHash();

		return parent::store($updateNulls);
	}

	public function getHash()
	{
		return md5($this->object_id . $this->object_group . $this->userid . $this->email . $this->lang);
	}
}

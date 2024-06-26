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

use Joomla\CMS\Router\Route;
use Joomla\Utilities\ArrayHelper;

class JCommentsControllerSubscriptions extends JCommentsControllerList
{
	public function __construct($config = array())
	{
		parent::__construct($config);

		$this->registerTask('unpublish', 'publish');
	}

	public function display($cachable = false, $urlparams = array())
	{
		$this->input->set('view', 'subscriptions');

		parent::display($cachable, $urlparams);
	}

	public function publish()
	{
		$this->checkToken();

		$cid   = $this->input->get('cid', array(), 'array');
		$data  = array('publish' => 1, 'unpublish' => 0);
		$task  = $this->getTask();
		$value = ArrayHelper::getValue($data, $task, 0, 'int');

		if (!empty($cid))
		{
			$model = $this->getModel('Subscriptions', 'JCommentsModel', array('ignore_request' => true));
			$model->publish($cid, $value);
		}

		$this->setRedirect(Route::_('index.php?option=' . $this->option . '&view=' . $this->view, false));

		return true;
	}
}

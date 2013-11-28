<?php
/**
 * Part of the Joomla Tracker's Tracker Application
 *
 * @copyright  Copyright (C) 2012 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace App\Tracker\Controller\Issue;

use Joomla\Application\AbstractApplication;
use Joomla\Input\Input;
use App\Tracker\Model\IssueModel;
use JTracker\Controller\AbstractTrackerController;

/**
 * Random item controller class for the Tracker component.
 *
 * @since  1.0
 */
class RandomController extends AbstractTrackerController
{
	/**
	 * Constructor
	 *
	 * @param   Input                $input  The input object.
	 * @param   AbstractApplication  $app    The application object.
	 *
	 * @since   1.0
	 */
	public function __construct(Input $input = null, AbstractApplication $app = null)
	{
		parent::__construct($input, $app);

		// Set the default view
		$input->set('view', 'issue');
		$this->defaultView = 'issue';
	}

	/**
	 * Execute the controller.
	 *
	 * @return  string  The rendered view.
	 *
	 * @since   1.0
	 */
	public function execute()
	{
		$application = $this->getApplication();
		$application->getUser()->authorize('view');

		try
		{
			$model = new IssueModel;
			$randomId = $model->getRandomItem();

			$application->redirect(
				$application->get('uri.base.path')
				. '/tracker/' . $application->input->get('project_alias') . '/' . $randomId
			);
		}
		catch (\Exception $e)
		{
			$application->enqueueMessage($e->getMessage(), 'error');

			$application->redirect(
				$application->get('uri.base.path')
				. 'tracker/' . $application->input->get('project_alias')
			);
		}

		parent::execute();
	}
}

<?php

/**
 * Wizard Behavior class file.
 *
 * Handles multi-step form navigation, data persistence, and plot-branching navigation.
 * Wizard Behavoir also allows steps to be expired, the saving and restoring of data across sessions, and can generate a
 * menu (defaults to CMenu) of steps.
 * Inspired by the CakePHP Wizard component by jaredhoyt {@link http://github.com/jaredhoyt}.
 *
 * @copyright    Copyright &copy; 2011 PBM Web Development - All Rights Reserved
 * @package      RBAM
 * @since        V1.0.0
 * @version      $Revision: 6 $
 * @license      BSD License (see documentation)
 */

    namespace application\components\form;

    use \Yii;
    use \CMap as Map;
    use \CMenu as Menu;
    use \CEvent as Event;
    use \CList as IndexedList;
    use \CBehavior as Behaviour;
    use \CException as Exception;
    use \CHttpException as HttpException;

    class Wizard extends Behaviour
    {

        const BRANCH_SELECT     = 'Select';
        const BRANCH_SKIP       = 'Skip';
        const BRANCH_DESELECT   = 'Deselect';

        /**
         * @access public
         * @var boolean $autoAdvance
         * If true, the behaviour will redirect to the "expected step" after a step has been successfully completed. If
         * false, it will redirect to the next step in the steps array.
         */
        public $autoAdvance = true;

        /**
         * @access public
         * @var array $steps
         * List of steps, in order, that are to be included in the wizard. A basic example can be found at (1), steps
         * can be labelled as seen in (2).
         * The steps can also contain branch groups that are used to determine the path at runtime. The "branch names"
         * (ie. "degree" and "nodegree" from the (3) example) are arbitary; they are used as selectors for the branch()
         * method. Branches can point either to another steps array, that can also have branch groups, or a single step.
         * The first "non-skipped" branch in a group is used by default, if $defaultBranch is true and a branch has not
         * been specifically selected.
         *
         * (1): array('login_info', 'profile', 'confirm')
         * (2): array('Username and Password'=>'login_info', 'User Profile'=>'profile', 'confirm')
         * (3): array(
         *          'job_application',
         *          array(
         *              'degree' => array('college', 'degree_type'),
         *              'nodegree' => 'experience'
         *          ),
         *          'confirm'
         *      )
        */
        public $steps = array();

        /**
         * @access public
         * @var boolean $defaultBranch
         * If true, the first "non-skipped" branch is a group will be used (given that a branch has not been
         * specifically selected).
         */
        public $defaultBranch = true;

        /**
         * @access public
         * @var boolean $continueOnExpired
         * Whether the wizard should go to the next step if the current step expires. If true the wizard continues, if
         * false the wizard is reset and the redirects to the $expiredUrl.
         */
        public $continueOnExpired = false;

        /**
         * @access public
         * @var boolean $forwardOnly
         * If true, the user will not be allowed to edit previously completed steps.
         */
        public $forwardOnly = false;

        /**
         * @access public
         * @var array $events
         * Owner event handlers
         */
        public $events = array(
            'onFinished'    => 'wizardFinished',
            'onProcessStep' => 'wizardProcessStep',
            'onStart'       => 'wizardStart',
            'onInvalidStep' => 'wizardInvalidStep',
        );

        /**
         * @access public
         * @var string $queryParam
         * Query parameter for the step. This must match the name of the parameter in the action that calls the wizard.
         */
        public $queryParam ='step';

        /**
         * @access public
         * @var string $sessionKey
         * The session key for the wizard.
         */
        public $sessionKey = 'Wizard';

        /**
         * @access public
         * @var integer $timeout
         * The timeout in seconds. Set to empty for no timeout. Each step must be completed within the timeout period or
         * else the wizard expires.
         */
        public $timeout;

        /**
         * @access public
         * @var string $cancelButton
         * The name attribute of the button used to cancel the wizard.
         */

        public $cancelButton = 'cancel';
        /**
         * @access public
         * @var string $previousButton
         * The name attribute of the button used to navigate to the previous step.
         */

        public $previousButton = 'previous';
        /**
         * @access public
         * @var string $resetButton
         * The name attribute of the button used to reset the wizard and start from the beginning.
         */

        public $resetButton = 'reset';
        /**
         * @access public
         * @var string $saveDraftButton
         * The name attribute of the button used to save draft data.
         */

        public $saveDraftButton = 'save_draft';

        /**
         * @access public
         * @var mixed $finishedUrl
         * Url to be redirected to after the wizard has finished.
         */
        public $finishedUrl = '/';

        /**
         * @access public
         * @var mixed $cancelledUrl
         * Url to be redirected to after 'Cancel' submit button has been pressed by user.
         */

        public $cancelledUrl = '/';
        /**
         * @access public
         * @var mixed $expiredUrl
         * Url to be redirected to if the timeout expires.
         */

        public $expiredUrl = '/';

        /**
         * @access public
         * @var mixed $draftSavedUrl
         * Url to be redirected to after 'Draft' submit button has been pressed by user.
         */
        public $draftSavedUrl = '/';

        /**
         * @access public
         * @var array $menuProperties
         * Menu properties. In addition to the properties of CMenu there is an additional previousItemCssClass that is
         * applied to previous items. See getMenu() method.
         */
        public $menuProperties = array(
            'id'                    => 'wzd-menu',
            'activeCssClass'        => 'wzd-active',
            'firstItemCssClass'     => 'wzd-first',
            'lastItemCssClass'      => 'wzd-last',
            'previousItemCssClass'  => 'wzd-previous'
        );

        /**
         * @access public
         * @var string $menuLastItem
         * If not empty, this is added to the menu as the last item. Used to add the conclusion, i.e. what happens when
         * the wizard completes - e.g. Register, to a menu.
         */
        public $menuLastItem;

        /**
         * @access private
         * @var string $_currentStep
         * Internal step tracking.
         */
        private $_currentStep;

        /**
         * @access private
         * @var object $_menu
         * The menu.
         */
        private $_menu;

        /**
         * @access private
         * @var CList $_steps
         * The steps to be processed.
         */
        private $_steps;

        /**
         * @access private
         * @var CMap $_stepLabels
         * Step Labels.
         */
        private $_stepLabels;

        /**
         * @access private
         * @var string $_stepsKey
         * The session key that holds processed step data.
         */
        private $_stepsKey;

        /**
         * @access private
         * @var string $_branchKey
         * The session key that holds branch directives.
         */
        private $_branchKey;

        /**
         * @access private
         * @var string $_timeoutKey
         * The session key that holds the timeout value.
         */
        private $_timeoutKey;

        /**
         * @access private
         * @var CHttpSession $_session
         * The session.
         */
        private $_session;

        /**
         * Attach
         *
         * Attaches this behavior to the owner. In addition to the CBehavior default implementation, the owner's event
         * handlers for wizard events are also attached.
         *
         * @access public
         * @param CController $owner "The controller that this behavior is to be attached to."
         * @return void
         */
        public function attach($owner)
        {
            if(!$owner instanceof \CController) {
                throw new Exception(Yii::t('wizard', 'Owner must be an instance of CController'));
            }
            parent::attach($owner);
            foreach($this->events as $event => $handler) {
                $this->attachEventHandler($event, array($owner, $handler));
            }
            $this->_session = Yii::app()->getSession();
            $this->_stepsKey = $this->sessionKey . '.steps';
            $this->_branchKey = $this->sessionKey . '.branches';
            $this->_timeoutKey = $this->sessionKey . '.timeout';
            $this->parseSteps();
        }

        /**
         * Process Step
         *
         * Run the wizard for the given step. This method is called from the controller action using the wizard.
         *
         * @access public
         * @param string $step "Name of step to be processed."
         * @return void
         */
        public function process($step)
        {
            if(isset($_REQUEST[$this->cancelButton])) {
                $this->cancelled($step); // Ends the wizard
            }
            elseif(isset($_REQUEST[$this->resetButton]) && !$this->forwardOnly) {
                $this->resetWizard($step); // Restarts the wizard
                $step = null;
            }

            if(empty($step)) {
                if(!$this->hasStarted() && !$this->start()) {
                    $this->finished(false);
                }
                if($this->hasCompleted()) {
                    $this->finished(true);
                }
                else {
                    $this->nextStep();
                }
            }
            else {
                if($this->isValidStep($step)) {
                    $this->_currentStep = $step;
                    if(!$this->forwardOnly && isset($_REQUEST[$this->previousButton])) {
                        $this->previousStep();
                    }
                    elseif($this->processStep()) {
                        if(isset($_REQUEST[$this->saveDraftButton])) {
                            $this->saveDraft($step); // Ends the wizard
                        }
                        $this->nextStep();
                    }
                }
                else {
                    $this->invalidStep($step);
                }
            }
        }

        /**
         * Restore Wizard
         *
         * Sets data into wizard session. Particularly useful if the data originated from WizardComponent::read() as
         * this will restore a previous session. $data[0] is the step data, $data[1] the branch data, $data[2] is the
         * timeout value.
         *
         * @access public
         * @param array $data   "Data to be written to the wizard session."
         * @return boolean      "Whether the data was successfully restored; true if the data was successfully restored, false if not."
         */
        public function restore($data)
        {
            if(sizeof($data) !== 3 || !is_array($data[0]) || !is_array($data[1]) || !(is_integer($data[2]) || is_null($data[2]))) {
                return false;
            }
            $this->_session[$this->_stepsKey]   = new Map($data[0]);
            $this->_session[$this->_branchKey]  = new Map($data[1]);
            $this->_session[$this->_timeoutKey] = $data[2];
            return true;
        }

        /**
         * Save Data
         *
         * Saves data into the Session. This is normally called automatically after the onProcessStep event, but can be
         * called directly for advanced navigation purposes.
         *
         * @access public
         * @param mixed $data   "Data to be saved."
         * @param string $step  "Step name. If empty the current step is used."
         * @return void
         */
        public function save($data, $step = null)
        {
            $this->_session[$this->_stepsKey] = new Map(
                Map::mergeArray(
                    isset($this->_session[$this->_stepsKey]) ? $this->_session[$this->_stepsKey] : array(),
                    array(empty($step) ? $this->_currentStep : $step => $data)
                )
            );
        }

        /**
         * Read
         *
         * Reads data stored for a step.
         *
         * @access public
         * @param string $step  "The name of the step. If empty the data for all steps are returned."
         * @return mixed        "Data for the specified step; array: data for all steps; null is no data exist for the specified step."
         */
        public function read($step = null)
        {
            return $step === null
                ? $this->_session[$this->_stepsKey]
                : (isset($this->_session[$this->_stepsKey][$step]) ? $this->_session[$this->_stepsKey][$step] : null);
        }

        /**
         * Get: Current Step
         *
         * Returns the one-based index of the current step. Note that this is for the current steps; branching may vary
         * the index of a given step
         *
         * @access public
         * @return void
         */
        public function getCurrentStep()
        {
            return $this->_steps->indexOf($this->_currentStep) + 1;
        }

        /**
         * Get: Step Count
         *
         * Returns the number of steps. Note that this is for the current steps; branching may vary the number of steps.
         *
         * @access public
         * @return void
         */
        public function getStepCount()
        {
            return $this->_steps->count();
        }

        /**
         * Get: Step Label
         *
         * @access public
         * @param string $step
         * @return string
         */
        public function getStepLabel($step = null)
        {
            if(is_null($step)) {
                $step = $this->_currentStep;
            }
            $label = $this->_stepLabels->itemAt($step);
            if(!is_string($label)) {
                $label = ucwords(trim(strtolower(str_replace(
                    array('-','_','.'),
                    ' ',
                    preg_replace('/(?<![A-Z])[A-Z]/', ' \0', $step)
                ))));
            }
            return $label;
        }

        /**
         * Reset
         *
         * Resets the wizard by deleting the wizard session.
         *
         * @access public
         * @return void
         */
        public function reset()
        {
            $this->_session->remove($this->_branchKey);
            $this->_session->remove($this->_stepsKey);
            $this->_session->remove($this->_timeoutKey);
        }

        /**
         * Set: Menu
         *
         * Sets the menu object or the menu object properties. If the value is an Menu object, it must have a property
         * named items. If the value is an array, it is an array of CMenu properties that are merged with
         * $menuProperties.
         *
         * @access public
         * @param mixed $value "A menu object, or an array of menu property values."
         */
        public function setMenu($value)
        {
            if(is_array($value)) {
                $this->menuProperties = Map::mergeArray($this->menuProperties, $value);
            }
            elseif($value instanceof Menu) {
                $this->_menu = $value;
            }
        }

        /**
         * Get: Menu
         *
         * @access public
         * @return \CMenu
         */
        public function getMenu()
        {
            if($this->_menu === null) {
                $properties = $this->menuProperties;
                unset($properties['previousItemCssClass']);
                $this->_menu = $this->getOwner()->createWidget('zii.widgets.CMenu', $properties);
            }
            $this->generateMenuItems();
            return $this->_menu;
        }

        /**
         * Generate Menu Items
         *
         * @access private
         * @return void
         */
        private function generateMenuItems()
        {
            $previous = true;
            $items = array();
            $url = array($this->owner->id . '/' . $this->getOwner()->getAction()->getId());

            // We should not have a url for later steps
            // We should not have a url for earlier steps if forwards only
            foreach ($this->_steps as $step) {
                $item = array();
                $item['label'] = $this->getStepLabel($step);
                if(($previous && !$this->forwardOnly) || ($step === $this->_currentStep)) {
                    $item['url'] = $url + array($this->queryParam => $step);
                    if($step === $this->_currentStep) {
                        $previous = false;
                    }
                }
                $item['active'] = $step === $this->_currentStep;
                if($previous && !empty($this->menuProperties['previousItemCssClass'])) {
                    $item['itemOptions'] = array('class' => $this->menuProperties['previousItemCssClass']);
                }
                $items[] = $item;
            }
            if(!empty($this->menuLastItem)) {
                $items[] = array(
                    'label' => $this->menuLastItem,
                    'active' => false
                );
            }
            $this->_menu->items = $items;
        }

        /**
         * Has Expired?
         *
         * Returns a value indicating if the step has expired.
         *
         * @access protected
         * @return boolean "True if the step has expired, false if not."
         */
        protected function hasExpired()
        {
            return isset($this->_session[$this->_timeoutKey]) && $this->_session[$this->_timeoutKey] < time();
        }

        /**
         * Next Step
         *
         * Moves the wizard to the next step. If "autoAdvance" is true this will be the expectedStep, otherwise if
         * "autoAdvance" is false this will be the next step in the steps array.
         *
         * @access protected
         * @return void
         */
        protected function nextStep()
        {
            if($this->autoAdvance) {
                $step = $this->getExpectedStep();
            }
            else {
                $index = $this->_steps->indexOf($this->_currentStep) + 1;
                $step = ($index < $this->_steps->count() ? $this->_steps[$index] : null);
            }
            if($this->timeout) {
                $this->_session[$this->_timeoutKey] = time() + $this->timeout;
            }
            $this->redirect($step);
        }

        /**
         * Previous Step
         *
         * Moves the wizard to the previous step.
         *
         * @access protected
         * @return void
         */
        protected function previousStep()
        {
            $index = $this->_steps->indexOf($this->_currentStep) - 1;
            $this->redirect($this->_steps[($index > 0 ? $index : 0)]);
        }

        /**
         * Has Started?
         *
         * Returns a value indicating if the wizard has started.
         *
         * @access protected
         * @return boolean "True if the wizard has started, false if not."
         */
        protected function hasStarted()
        {
            return isset($this->_session[$this->_stepsKey]);
        }

        /**
         * Has Completed?
         *
         * Returns a value indicating if the wizard has completed or not.
         *
         * @access protected
         * @return boolean "True if the wizard has completed, false if not."
         */
        protected function hasCompleted()
        {
            return !(bool)$this->getExpectedStep();
        }

        /**
         * Redirect
         *
         * Handles Wizard redirection. A null url will redirect to the "expected" step.
         * See CController::redirect().
         *
         * @access protected
         * @param string $step "Step to redirect to."
         * @param boolean $terminate "If true, the application terminates after the redirect."
         * @param integer $statusCode "HTTP status code (eg 404)."
         * @return void
         */
        protected function redirect($step = null, $terminate = true, $statusCode = 302)
        {
            if(!is_string($step) || empty($string)) {
                $step = $this->getExpectedStep();
            }
            $url = array(
                $this->owner->id . '/' . $this->getOwner()->getAction()->getId(),
                $this->queryParam => $step,
            );
            $this->owner->redirect($url, $terminate, $statusCode);
        }

        /**
         * Branch
         *
         * Selects, skips, or deselects a branch or branches.
         * If the branch directives is a string it must be a name, or list of names, to select. If the branch directives
         * is an array, it must be a list of branch names to select, or an associative array of "branchName"=>directive
         * pairs (where the directive must be one of "self::BRANCH_SELECT|self::BRANCH_SKIP|self::BRANCH_DESELECT").
         *
         * @access public
         * @param mixed $branchDirectives
         * @return void
         */
        public function branch($branchDirectives)
        {
            if(is_string($branchDirectives)) {
                if(strpos($branchDirectives, ',')) {
                    $branchDirectives = explode(',', $branchDirectives);
                    foreach($branchDirectives as &$name) {
                        $name = trim($name);
                    }
                }
                else {
                    $branchDirectives = array($branchDirectives);
                }
            }
            $branches = $this->branches();
            foreach($branchDirectives as $name => $directive) {
                if($directive === self::BRANCH_DESELECT) {
                    $branches->remove($name);
                }
                else {
                    if(is_int($name)) {
                        $name = $directive;
                        $directive = self::BRANCH_SELECT;
                    }
                    $branches->add($name, $directive);
                }
            }
            $this->_session[$this->_branchKey] = $branches;
            $this->parseSteps();
        }

        /**
        * Returns a map of the current branch directives
        * @return CMap A map of the current branch directives
        */
        private function branches()
        {
            return isset($this->_session[$this->_branchKey])
                ? $this->_session[$this->_branchKey]
                : new Map;
        }

        /**
         * Is Invalid Step?
         *
         * Validates the $step in two ways: validates that the step exists in $this->_steps array; or validates that the
         * step is the expected step or, if "forwardsOnly" is false, before it.
         *
         * @access protected
         * @param string Step to validate.
         * @return boolean "Whether the step is valid; true if the step is valid, false if not."
         */
        protected function isValidStep($step)
        {
            $index = $this->_steps->indexOf($step);
            if($index >= 0) {
                if($this->forwardOnly) {
                    return $index === $this->_steps->indexOf($this->getExpectedStep());
                }
                return $index <= $this->_steps->indexOf($this->getExpectedStep());
            }
            return false;
        }

        /**
         * Get: Expected Step
         *
         * Returns the first unprocessed step (i.e. step data not saved in Session).
         *
         * @access protected
         * @return string "The first unprocessed step; null if all steps have been processed."
         */
        protected function getExpectedStep()
        {
            $steps = $this->_session[$this->_stepsKey];
            if(!is_null($steps)) {
                foreach($this->_steps->toArray() as $step) {
                    if(!isset($steps[$step])) {
                        return $step;
                    }
                }
            }
        }

        /**
         * Parse Steps
         *
         * Parse the steps into a flat array and get their labels.
         *
         * @access protected
         * @return void
         */
        protected function parseSteps()
        {
            $this->_steps = $this->_parseSteps($this->steps);
            $this->_stepLabels = new Map(array_flip($this->_steps), true);
            $this->_steps = new IndexedList($this->_steps, true);
        }

        /**
         * Parse Steps
         *
         * Parses the steps array into a "flat" array by resolving branches. Branches are resolved according the
         * setting.
         *
         * @access private
         * @param array $steps "The steps array."
         * @return array "Steps to take."
         */
        private function _parseSteps($steps)
        {
            $parsed = array();
            foreach ($steps as $label => $step) {
                $branch = '';
                if(is_array($step)) {
                    foreach(array_keys($step) as $branchName) {
                        $branchDirective = $this->branchDirective($branchName);
                        if(($branchDirective && $branchDirective === self::BRANCH_SELECT) || (empty($branch) && $this->defaultBranch)) {
                            $branch = $branchName;
                        }
                    }
                    if(!empty($branch)) {
                        if(is_array($step[$branch])) {
                            $parsed = array_merge($parsed, $this->_parseSteps($step[$branch]));
                        }
                        else {
                            $parsed[$label] = $step[$branch];
                        }
                    }
                }
                else {
                    $parsed[$label] = $step;
                }
            }
            return $parsed;
        }

        /**
         * Branch Directive
         *
         * Returns the directive for a given branch.
         *
         * @access private
         * @param string $branch "The branch name."
         * @return string "The branch directive or NULL if no directive for the branch."
         */
        private function branchDirective($branch)
        {
            return isset($this->_session[$this->_branchKey])
                ? $this->_session[$this->_branchKey][$branch]
                : null;
        }

        /**
         * Start
         *
         * Raises the "onStarted" event. The event handler must set the event::handled property TRUE for the wizard to
         * process steps.
         *
         * @access protected
         * @return boolean
         */
        protected function start()
        {
            $event = new WizardEvent($this);
            $this->onStart($event);
            if($event->handled) {
                $this->_session[$this->_stepsKey] = new Map();
            }
            return $event->handled;
        }

        /**
         * Cancelled
         *
         * Raises the "onCancelled" event. The event::data property contains data for processed steps.
         *
         * @access protected
         * @return void
         */
        protected function cancelled($step)
        {
            $event = new WizardEvent($this, $step, $this->read());
            $this->onCancelled($event);
            $this->reset();
            $this->owner->redirect($this->cancelledUrl);
        }

        /**
         * Expired
         *
         * Raises the "onExpired" event.
         *
         * @access protected
         * @return boolean
         */
        protected function expired($step)
        {
            $event = new WizardEvent($this, $step);
            $this->onExpiredStep($event);
            if($this->continueOnExpired) {
                return true;
            }
            $this->reset();
            $this->owner->redirect($this->expiredUrl);
        }

        /**
         * Finished
         *
         * Raises the "onFinished" event. The event::data property contains data for processed steps.
         *
         * @access protected
         * @return void
         */
        protected function finished($step)
        {
            $event = new WizardEvent($this, $step, $this->read());
            $this->onFinished($event);
            $this->reset();
            $this->owner->redirect($this->finishedUrl);
        }

        /**
         * Invalid Step
         *
         * Raises the "onInvalidStep" event.
         *
         * @access protected
         * @return void
         */
        protected function invalidStep($step)
        {
            $event = new WizardEvent($this, $step);
            $this->onInvalidStep($event);
            $this->redirect();
        }

        /**
         * Process Step
         *
         * Raises the "onProcessStep" event. The event::data property contains the current data for the step. The event
         * handler must set the event::handled property TRUE for the wizard to move to the next step.
         *
         * @access protected
         * @return boolean
         */
        protected function processStep()
        {
            $event = new WizardEvent($this, $this->_currentStep, $this->read($this->_currentStep));
            $this->onProcessStep($event);
            if($event->handled && $this->hasExpired()) {
                $this->expired($this->_currentStep);
            }
            return $event->handled;
        }

        /**
         * Reset Wizard
         *
         * Resets the wizard by deleting the wizard session.
         *
         * @access public
         * @return void
         */
        public function resetWizard($step)
        {
            $this->reset();
            $event = new WizardEvent($this, $step);
            $this->onReset($event);
        }

        /**
         * Save Draft
         *
         * Raises the "onSaveDraft" event. The event::data property contains the data to save.
         *
         * @access protected
         * @return void
         */
        protected function saveDraft($step)
        {
            $event = new WizardEvent($this, $step, array(
                $this->read(),
                $this->branches()->toArray(),
                $this->_session[$this->_timeoutKey],
            ));
            $this->onSaveDraft($event);
            $this->reset();
            $this->owner->redirect($this->draftSavedUrl);
        }

        /**
         * Event: onCancelled
         *
         * @access public
         * @return void
         */
        public function onCancelled($event)
        {
            $this->raiseEvent('onCancelled', $event);
        }

        /**
         * Event: onExpiredStep
         *
         * @access public
         * @return void
         */
        public function onExpiredStep($event)
        {
            $this->raiseEvent('onExpiredStep', $event);
        }

        /**
         * Event: onFinished
         *
         * @access public
         * @return void
         */
        public function onFinished($event)
        {
            $this->raiseEvent('onFinished', $event);
        }

        /**
         * Event: onInvalidStep
         *
         * @access public
         * @return void
         */
        public function onInvalidStep($event)
        {
            $this->raiseEvent('onInvalidStep', $event);
        }

        /**
         * Event: onProcessStep
         *
         * @access public
         * @return void
         */
        public function onProcessStep($event)
        {
            $this->raiseEvent('onProcessStep', $event);
        }

        /**
         * Event: onReset
         *
         * @access public
         * @return void
         */
        public function onReset($event)
        {
            $this->raiseEvent('onReset', $event);
        }

        /**
         * Event: onSaveDraft
         *
         * @access public
         * @return void
         */
        public function onSaveDraft($event)
        {
            $this->raiseEvent('onSaveDraft', $event);
        }

        /**
         * Event: onStart
         *
         * @access public
         * @return void
         */
        public function onStart($event)
        {
            $this->raiseEvent('onStart', $event);
        }

    }

    /**
    * Wizard event class.
    * This is the event raised by the wizard.
    */
    class WizardEvent extends Event
    {

        /**
         * @access private
         * @var mixed $data
         */
        private $data = array();

        /**
         * @access private
         * @var string $step
         */
        private $step;

        /**
         * Constructor
         *
         * @access public
         * @param object $sender
         * @param string $step
         * @param mixed $data
         * @return void
         */
        public function __construct($sender, $step = null, $data = null)
        {
            parent::__construct($sender);
            $this->step = $step;
            $this->data = $data;
        }

        /**
         * Get: Data
         *
         * @access public
         * @return mixed
         */
        public function getData() {
            return $this->data;
        }

        /**
         * Get: Step
         *
         * @access public
         * @return string
         */
        public function getStep() {
            return $this->step;
        }

    }

<?php
/**
 * DebugToolbar Test
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2009, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2009, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org
 * @package       debug_kit
 * @subpackage    debug_kit.tests.controllers.components
 * @since         DebugKit 0.1
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::import('Component', 'DebugKit.Toolbar');

class TestToolbarComponent extends ToolbarComponent {
	var $evalTest = false;
	var $evalCode = '';

	function loadPanels($panels, $settings = array()) {
		$this->_loadPanels($panels, $settings);
	}

	function _eval($code) {
		if ($this->evalTest) {
			$this->evalCode = $code;
			return;
		}
		eval($code);
	}
}

Mock::generate('DebugPanel');

if (!class_exists('AppController')) {
	class AppController extends Controller {

	}
}

class TestPanel extends DebugPanel {

}

/**
* DebugToolbar Test case
*/
class DebugToolbarTestCase extends CakeTestCase {
/**
 * fixtures.
 *
 * @var array
 **/
	var $fixtures = array('core.article');
/**
 * Start test callback
 *
 * @access public
 * @return void
 **/
	function startTest() {
		Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
		$this->Controller =& new Controller();
		$this->Controller->params = Router::parse('/');
		$this->Controller->params['url']['url'] = '/';
		$this->Controller->uses = array();
		$this->Controller->components = array('TestToolBar');
		$this->Controller->constructClasses();
		$this->Controller->Toolbar =& $this->Controller->TestToolBar;

		$this->_server = $_SERVER;
		$this->_paths = array();
		$this->_paths['plugin'] = Configure::read('pluginPaths');
		$this->_paths['view'] = Configure::read('viewPaths');
		$this->_paths['vendor'] = Configure::read('vendorPaths');
		$this->_paths['controller'] = Configure::read('controllerPaths');
		Configure::write('Cache.disable', false);
	}
/**
 * endTest
 *
 * @return void
 **/
	function endTest() {
		$_SERVER = $this->_server;
		Configure::write('pluginPaths', $this->_paths['plugin']);
		Configure::write('viewPaths', $this->_paths['view']);
		Configure::write('vendorPaths', $this->_paths['vendor']);
		Configure::write('controllerPaths', $this->_paths['controller']);
		Configure::write('Cache.disable', true);

		unset($this->Controller);
		if (class_exists('DebugKitDebugger')) {
			DebugKitDebugger::clearTimers();
			DebugKitDebugger::clearMemoryPoints();
		}
	}
/**
 * find the debug_kit path
 *
 * @return void
 **/
	function _findPlugin() {
		$paths = Configure::read('pluginPaths');
		foreach ($paths as $path) {
			if (is_dir($path . 'debug_kit')) {
				return $path . 'debug_kit' . DS;
			}
		}
	}
/**
 * test Loading of panel classes
 *
 * @return void
 **/
	function testLoadPanels() {
		$this->Controller->Toolbar->loadPanels(array('session', 'request'));
		$this->assertTrue(is_a($this->Controller->Toolbar->panels['session'], 'SessionPanel'));
		$this->assertTrue(is_a($this->Controller->Toolbar->panels['request'], 'RequestPanel'));

		$this->Controller->Toolbar->loadPanels(array('history'), array('history' => 10));
		$this->assertEqual($this->Controller->Toolbar->panels['history']->history, 10);

		$this->expectError();
		$this->Controller->Toolbar->loadPanels(array('randomNonExisting', 'request'));
	}
/**
 * test Loading of panel classes from a plugin
 *
 * @return void
 **/
	function testLoadPluginPanels() {
		$this->Controller->Toolbar->loadPanels(array('plugin.test'));
		$this->assertTrue(is_a($this->Controller->Toolbar->panels['plugin.test'], 'TestPanel'));
	}
/**
 * test generating a DoppelGangerView with a pluginView.
 *
 * @return void
 **/
	function testPluginViewParsing() {
		App::import('Vendor', 'DebugKit.DebugKitDebugger');
		$this->Controller->Toolbar->evalTest = true;
		$this->Controller->view = 'Plugin.OtherView';
		$this->Controller->Toolbar->startup($this->Controller);
		$this->assertPattern('/class DoppelGangerView extends OtherView/', $this->Controller->Toolbar->evalCode);
	}
/**
 * test loading of vendor panels from test_app folder
 *
 * @access public
 * @return void
 */
	function testVendorPanels() {
		$debugKitPath = $this->_findPlugin();
		$skip = $this->skipIf(empty($debugKitPath), 'Could not find debug_kit in plugin paths, skipping %s');
		if ($skip) {
			return;
		}

		Configure::write('vendorPaths', array($debugKitPath . 'tests' . DS . 'test_app' . DS . 'vendors' . DS));
		$this->Controller->components = array(
			'DebugKit.Toolbar' => array(
				'panels' => array('test'),
			)
		);
		$this->Controller->Component->init($this->Controller);
		$this->Controller->Component->initialize($this->Controller);
		$this->Controller->Component->startup($this->Controller);
		$this->assertTrue(isset($this->Controller->Toolbar->panels['test']));
		$this->assertTrue(is_a($this->Controller->Toolbar->panels['test'], 'TestPanel'));
	}
/**
 * test initialize
 *
 * @return void
 * @access public
 **/
	function testInitialize() {
		$this->Controller->components = array('DebugKit.Toolbar');
		$this->Controller->Component->init($this->Controller);
		$this->Controller->Component->initialize($this->Controller);

		$this->assertFalse(empty($this->Controller->Toolbar->panels));

		$timers = DebugKitDebugger::getTimers();
		$this->assertTrue(isset($timers['componentInit']));
		$memory = DebugKitDebugger::getMemoryPoints();
		$this->assertTrue(isset($memory['Component intitailization']));
	}
/**
 * test initialize w/ custom panels and defaults
 *
 * @return void
 * @access public
 **/
	function testInitializeCustomPanelsWithDefaults() {
		$this->Controller->components = array(
			'DebugKit.Toolbar' => array('panels' => array('test'))
		);
		$this->Controller->Component->init($this->Controller);
		$this->Controller->Component->initialize($this->Controller);

		$expected = array('history', 'session', 'request', 'sqlLog', 'timer', 'log', 'variables', 'test');
		$this->assertEqual($expected, array_keys($this->Controller->Toolbar->panels));
	}
/**
 * test syntax for removing panels
 *
 * @return void
 **/
	function testInitializeRemovingPanels() {
		$this->Controller->components = array(
			'DebugKit.Toolbar' => array('panels' => array('session' => false, 'history' => false, 'test'))
		);
		$this->Controller->Component->init($this->Controller);
		$this->Controller->Component->initialize($this->Controller);

		$expected = array('request', 'sqlLog', 'timer', 'log', 'variables', 'test');
		$this->assertEqual($expected, array_keys($this->Controller->Toolbar->panels));
	}
/**
 * ensure that enabled = false when debug == 0 on initialize
 *
 * @return void
 **/
	function testDebugDisableOnInitialize() {
		$_debug = Configure::read('debug');
		Configure::write('debug', 0);
		$this->Controller->components = array('DebugKit.Toolbar');
		$this->Controller->Component->init($this->Controller);
		$this->Controller->Component->initialize($this->Controller);
		$this->assertFalse($this->Controller->Toolbar->enabled);

		Configure::write('debug', $_debug);
	}
/**
 * test that passing in forceEnable will enable the toolbar even if debug = 0
 *
 * @return void
 **/
	function testForceEnable() {
		$_debug = Configure::read('debug');
		Configure::write('debug', 0);
		$this->Controller->components = array('DebugKit.Toolbar' => array('forceEnable' => true));
		$this->Controller->Component->init($this->Controller);
		$this->Controller->Component->initialize($this->Controller);
		$this->assertTrue($this->Controller->Toolbar->enabled);

		Configure::write('debug', $_debug);
	}
/**
 * Test disabling autoRunning of toolbar
 *
 * @return void
 **/
	function testAutoRunSettingFalse() {
		$this->Controller->components = array('DebugKit.Toolbar' => array('autoRun' => false));
		$this->Controller->Component->init($this->Controller);
		$this->Controller->Component->initialize($this->Controller);
		$this->assertFalse($this->Controller->Toolbar->enabled);
	}
/**
 * test autorun = false with query string param
 *
 * @return void
 **/
	function testAutoRunSettingWithQueryString() {
		$this->Controller->params['url']['debug'] = true;
		$this->Controller->components = array('DebugKit.Toolbar' => array('autoRun' => false));
		$this->Controller->Component->init($this->Controller);
		$this->Controller->Component->initialize($this->Controller);
		$this->assertTrue($this->Controller->Toolbar->enabled);
	}
/**
 * test startup
 *
 * @return void
 **/
	function testStartup() {
		$this->Controller->components = array(
			'DebugKit.Toolbar' => array(
				'panels' => array('MockDebug')
			)
		);
		$this->Controller->Component->init($this->Controller);
		$this->Controller->Component->initialize($this->Controller);
		$this->Controller->Toolbar->panels['MockDebug']->expectOnce('startup');
		$this->Controller->Toolbar->startup($this->Controller);

		$this->assertEqual($this->Controller->view, 'DebugKit.Debug');
		$this->assertTrue(isset($this->Controller->helpers['DebugKit.Toolbar']));

		$this->assertEqual($this->Controller->helpers['DebugKit.Toolbar']['output'], 'DebugKit.HtmlToolbar');
		$this->assertEqual($this->Controller->helpers['DebugKit.Toolbar']['cacheConfig'], 'debug_kit');
		$this->assertTrue(isset($this->Controller->helpers['DebugKit.Toolbar']['cacheKey']));

		$timers = DebugKitDebugger::getTimers();
		$this->assertTrue(isset($timers['controllerAction']));
		$memory = DebugKitDebugger::getMemoryPoints();
		$this->assertTrue(isset($memory['Controller action start']));
	}
/**
 * Test that cache config generation works.
 *
 * @return void
 **/
	function testCacheConfigGeneration() {
		$this->Controller->components = array('DebugKit.Toolbar');
		$this->Controller->Component->init($this->Controller);
		$this->Controller->Component->initialize($this->Controller);
		$this->Controller->Component->startup($this->Controller);

		$results = Cache::config('debug_kit');
		$this->assertTrue(is_array($results));
	}
/**
 * test state saving of toolbar
 *
 * @return void
 **/
	function testStateSaving() {
		$this->Controller->components = array('DebugKit.Toolbar');
		$this->Controller->Component->init($this->Controller);
		$this->Controller->Component->initialize($this->Controller);
		$configName = 'debug_kit';
		$this->Controller->Toolbar->cacheKey = 'toolbar_history';

		$this->Controller->Component->startup($this->Controller);
		$this->Controller->set('test', 'testing');
		$this->Controller->Component->beforeRender($this->Controller);

		$result = Cache::read('toolbar_history', $configName);
		$this->assertEqual($result[0]['variables']['content']['test'], 'testing');
		Cache::delete('toolbar_history', $configName);
	}
/**
 * Test Before Render callback
 *
 * @return void
 **/
	function testBeforeRender() {
		$this->Controller->components = array(
			'DebugKit.Toolbar' => array(
				'panels' => array('MockDebug', 'session')
			)
		);
		$this->Controller->Component->init($this->Controller);
		$this->Controller->Component->initialize($this->Controller);
		$this->Controller->Toolbar->panels['MockDebug']->expectOnce('beforeRender');
		$this->Controller->Toolbar->beforeRender($this->Controller);

		$this->assertTrue(isset($this->Controller->viewVars['debugToolbarPanels']));
		$vars = $this->Controller->viewVars['debugToolbarPanels'];

		$expected = array(
			'plugin' => 'debug_kit',
			'elementName' => 'session_panel',
			'content' => $this->Controller->Session->read(),
			'disableTimer' => true,
			'title' => ''
		);
		$this->assertEqual($expected, $vars['session']);

		$memory = DebugKitDebugger::getMemoryPoints();
		$this->assertTrue(isset($memory['Controller render start']));
	}
/**
 * test that vars are gathered and state is saved on beforeRedirect
 *
 * @return void
 **/
	function testBeforeRedirect() {
		$this->Controller->components = array(
			'DebugKit.Toolbar' => array(
				'panels' => array('MockDebug', 'session', 'history')
			)
		);
		$this->Controller->Component->init($this->Controller);
		$this->Controller->Component->initialize($this->Controller);

		$configName = 'debug_kit';
		$this->Controller->Toolbar->cacheKey = 'toolbar_history';
		Cache::delete('toolbar_history', $configName);

		DebugKitDebugger::startTimer('controllerAction', 'testing beforeRedirect');
		$this->Controller->Toolbar->panels['MockDebug']->expectOnce('beforeRender');
		$this->Controller->Toolbar->beforeRedirect($this->Controller);

		$result = Cache::read('toolbar_history', $configName);
		$this->assertTrue(isset($result[0]['session']));
		$this->assertTrue(isset($result[0]['mock_debug']));

		$timers = DebugKitDebugger::getTimers();
		$this->assertTrue(isset($timers['controllerAction']));
	}
/**
 * test that loading state (accessing cache) works.
 *
 * @return void
 **/
	function testLoadState() {
		$this->Controller->Toolbar->cacheKey = 'toolbar_history';

		$data = array(0 => array('my data'));
		Cache::write('toolbar_history', $data, 'debug_kit');
		$result = $this->Controller->Toolbar->loadState(0);
		$this->assertEqual($result, $data[0]);
	}
/**
 * test the Log panel log reading.
 *
 * @return void
 **/
	function testLogPanel() {
		usleep(20);
		$this->Controller->log('This is a log I made this request');
		$this->Controller->log('This is the second  log I made this request');
		$this->Controller->log('This time in the debug log!', LOG_DEBUG);

		$this->Controller->components = array(
			'DebugKit.Toolbar' => array(
				'panels' => array('log', 'session', 'history' => false, 'variables' => false, 'sqlLog' => false,
					'timer' => false)
			)
		);
		$this->Controller->Component->init($this->Controller);
		$this->Controller->Component->initialize($this->Controller);
		$this->Controller->Component->startup($this->Controller);
		$this->Controller->Component->beforeRender($this->Controller);
		$result = $this->Controller->viewVars['debugToolbarPanels']['log'];

		$this->assertEqual(count($result['content']), 2);
		$this->assertEqual(count($result['content']['error.log']), 4);
		$this->assertEqual(count($result['content']['debug.log']), 2);

		$this->assertEqual(trim($result['content']['debug.log'][1]), 'Debug: This time in the debug log!');
		$this->assertEqual(trim($result['content']['error.log'][1]), 'Error: This is a log I made this request');
	}
/**
 * Test that history state urls set prefix = null and admin = null so generated urls do not
 * adopt these params.
 *
 * @return void
 **/
	function testHistoryUrlGenerationWithPrefixes() {
		$configName = 'debug_kit';
		$this->Controller->params = array(
			'controller' => 'posts',
			'action' => 'edit',
			'admin' => 1,
			'prefix' => 'admin',
			'plugin' => 'cms',
			'url' => array(
				'url' => '/admin/cms/posts/edit/'
			)
		);
		$this->Controller->Component->initialize($this->Controller);
		$this->Controller->Toolbar->cacheKey = 'url_test';
		$this->Controller->Component->beforeRender($this->Controller);

		$result = $this->Controller->Toolbar->panels['history']->beforeRender($this->Controller);
		$expected = array(
			'plugin' => 'debug_kit', 'controller' => 'toolbar_access', 'action' => 'history_state',
			0 => 1, 'admin' => false
		);
		$this->assertEqual($result[0]['url'], $expected);
		Cache::delete('url_test', $configName);
	}
/**
 * Test that the FireCake toolbar is used on AJAX requests
 *
 * @return void
 **/
	function testAjaxToolbar() {
		$_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
		$this->Controller->components = array('DebugKit.Toolbar');
		$this->Controller->Component->init($this->Controller);
		$this->Controller->Component->initialize($this->Controller);
		$this->Controller->Component->startup($this->Controller);
		$this->assertEqual($this->Controller->helpers['DebugKit.Toolbar']['output'], 'DebugKit.FirePhpToolbar');
	}
/**
 * Test that the toolbar does not interfere with requestAction
 *
 * @return void
 **/
	function testNoRequestActionInterference() {
		$debugKitPath = $this->_findPlugin();
		$skip = $this->skipIf(empty($debugKitPath), 'Could not find debug_kit in plugin paths, skipping %s');
		if ($skip) {
			return;
		}

		$controllers = Configure::read('controllerPaths');
		$testapp = $debugKitPath . 'tests' . DS . 'test_app' . DS . 'controllers' . DS;
		array_unshift($controllers, $testapp);
		Configure::write('controllerPaths', $controllers);

		$views = Configure::read('viewPaths');
		$testapp = $debugKitPath . 'tests' . DS . 'test_app' . DS . 'views' . DS;
		array_unshift($views, $testapp);
		Configure::write('viewPaths', $views);

		$result = $this->Controller->requestAction('/debug_kit_test/request_action_return', array('return'));
		$this->assertEqual($result, 'I am some value from requestAction.');

		$result = $this->Controller->requestAction('/debug_kit_test/request_action_render', array('return'));
		$this->assertEqual($result, 'I have been rendered.');
	}
/**
 * test the sqlLog panel parsing of db->showLog
 *
 * @return void
 **/
	function testSqlLogPanel() {
		App::import('Core', 'Model');
		$Article = new Model(array('ds' => 'test_suite', 'name' => 'Article'));
		$Article->find('first', array('conditions' => array('Article.id' => 1)));

		$this->Controller->components = array(
			'DebugKit.Toolbar' => array(
				'panels' => array('SqlLog')
			)
		);
		$this->Controller->Component->init($this->Controller);
		$this->Controller->Component->initialize($this->Controller);
		$this->Controller->Component->startup($this->Controller);
		$this->Controller->Component->beforeRender($this->Controller);
		$result = $this->Controller->viewVars['debugToolbarPanels']['sql_log'];

		$this->assertTrue(isset($result['content']['test_suite']['queries']));
		$this->assertTrue(isset($result['content']['test_suite']['explains']));
		$query = array_pop($result['content']['test_suite']['queries']);

		$this->assertPattern('/\d/', $query[0], 'index not found. %s');
		$this->assertPattern('/SELECT `Article/', $query[1], 'query not found. %s');
		$this->assertEqual(count($query), 6, 'There are not 6 columns, something is wonky. %s');
		$this->assertEqual($query[3], 1);
		$this->assertEqual($query[4], 1);
	}
}
?>
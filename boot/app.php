<?php
use DebugDigger\App\Foundation\Application;
function bootApplication($file) {
	add_action('plugins_loaded', function() use ($file) {
		$application = new Application($file);
		do_action('debug-digger_plugin_loaded', $application);

		add_action('init', function () {
			load_plugin_textdomain('debug-digger', false, 'debug-digger/language/');
		});
	});
};

return fn($file) => bootApplication($file);
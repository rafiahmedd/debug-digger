<?php
namespace DebugDigger\App\Services;
use DebugDigger\App\Includes\ConfigTransformer;

class SettingService
{
    public function getSettings()
    {
        return [
            'WP_DEBUG' => [
                'label' => dd_trans('WP Debug'),
                'value' => defined('WP_DEBUG') && WP_DEBUG,
                'help_text' => dd_trans('Enable WP Debugging Mode.')
            ],
            'WP_DEBUG_LOG' => [
                'label' => dd_trans('WP Debug Log'),
                'value' => defined('WP_DEBUG_LOG') && WP_DEBUG_LOG,
                'help_text' => dd_trans('Store debug information in a file (wp-content/debug.log).')
            ],
            'SCRIPT_DEBUG' => [
                'label' => dd_trans('Script Debug'),
                'value' => defined('SCRIPT_DEBUG') && SCRIPT_DEBUG,
                'help_text' => dd_trans('SCRIPT_DEBUG is a related constant that will force WordPress to use the “dev” versions of core CSS and JavaScript files rather than the minified versions that are normally loaded. This is useful when you are testing modifications to any built-in .js or .css files.')
            ],
            'WP_DEBUG_DISPLAY' =>  [
                'label' => dd_trans('WP Debug Display'),
                'value' => defined('WP_DEBUG_DISPLAY') && WP_DEBUG_DISPLAY,
                'help_text' => dd_trans('WP_DEBUG_DISPLAY is another companion to WP_DEBUG that controls whether debug messages are shown inside the HTML of pages or not.')
            ],
            'SAVEQUERIES' => [
                'label' => dd_trans('Save Queries'),
                'value' => defined('SAVEQUERIES') && SAVEQUERIES,
                'help_text' => dd_trans('The SAVEQUERIES definition saves the database queries to an array and that array can be displayed to help analyze those queries. The constant defined as true causes each query to be saved, how long that query took to execute, and what function called it.')
            ]
        ];
    }

    public function updateSettings($key, $value)
    {
        $value = filter_var($value, FILTER_VALIDATE_BOOLEAN);
        $value = $value ? 'true' : 'false';
        
        $configTransformer = new ConfigTransformer(ABSPATH . 'wp-config.php');
        $configTransformer->update( 'constant', $key, $value );
    }
}
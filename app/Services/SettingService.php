<?php
namespace DebugDigger\App\Services;

class SettingService
{
    public function saveSettings()
    {
        
    }

    public function getSettings()
    {
        return [
            'WP_DEBUG' => [
                'label' => dd_trans('WP Debug'),
                'value' => defined('WP_DEBUG') && WP_DEBUG === true ?: false,
                'help_text' => dd_trans('Enable WP Debuffing Mode.')
            ],
            'WP_DEBUG_LOG' => [
                'label' => dd_trans('WP Debug Log'),
                'value' => defined('WP_DEBUG_LOG') && WP_DEBUG_LOG === true ?: false,
                'help_text' => dd_trans('Store debug information in a file (wp-content/debug.log).')
            ],
            'SCRIPT_DEBUG' => [
                'label' => dd_trans('Script Debug'),
                'value' => defined('SCRIPT_DEBUG') && SCRIPT_DEBUG === true ?: false,
                'help_text' => dd_trans('SCRIPT_DEBUG is a related constant that will force WordPress to use the “dev” versions of core CSS and JavaScript files rather than the minified versions that are normally loaded. This is useful when you are testing modifications to any built-in .js or .css files.')
            ],
            'WP_DEBUG_DISPLAY' =>  [
                'label' => dd_trans('WP Debug Display'),
                'value' => defined('WP_DEBUG_DISPLAY') && WP_DEBUG_DISPLAY === true ?: false,
                'help_text' => dd_trans('WP_DEBUG_DISPLAY is another companion to WP_DEBUG that controls whether debug messages are shown inside the HTML of pages or not.')
            ],
            'SAVEQUERIES' => [
                'label' => dd_trans('Save Queries'),
                'value' => defined('SAVEQUERIES') && SAVEQUERIES === true ?: false,
                'help_text' => dd_trans('The SAVEQUERIES definition saves the database queries to an array and that array can be displayed to help analyze those queries. The constant defined as true causes each query to be saved, how long that query took to execute, and what function called it.')
            ]
        ];
    }

    public function updateSettings($key, $value)
    {
        $value = filter_var($value, FILTER_VALIDATE_BOOLEAN);
        $searchValue = $value ? 'false' : 'true';
        $replaceValue = $value ? 'true' : 'false';

        // Read the current wp-config.php file.
        $wp_config_contents = file_get_contents(ABSPATH . 'wp-config.php');
        
        // Update the WP_DEBUG definition based on the user's choice.
        $wp_config_contents = str_replace("define( '$key', $searchValue );", "define( '$key', $replaceValue );", $wp_config_contents);

        // Write the modified content back to wp-config.php.
        file_put_contents(ABSPATH . 'wp-config.php', $wp_config_contents);

    }
}
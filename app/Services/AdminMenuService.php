<?php
namespace DebugDigger\App\Services;

class AdminMenuService
{
    public function addMenu()
    {
        $permission = apply_filters('duebug_digger/admin_menu_permission', 'manage_options');

        if (!current_user_can($permission) ) {
            return;
        }

        add_menu_page(
            dd_trans('Debug Digger'),
            dd_trans('Debug Digger'),
            $permission,
            DD_TEXT_DOMAIN,
            array( $this, 'render' ),
            $this->getMenuIcon(),
            14
        );

        add_submenu_page(
            DD_TEXT_DOMAIN,
            dd_trans('Logs'),
            dd_trans('Logs'),
            $permission,
            DD_TEXT_DOMAIN.'#/logs',
            array( $this, 'render' )
        );

        add_submenu_page(
            DD_TEXT_DOMAIN,
            dd_trans('Settings'),
            dd_trans('Settings'),
            $permission,
            DD_TEXT_DOMAIN.'#/settings',
            array( $this, 'render' )
        );
    }

    protected function enqueueAssets()
    {
        wp_enqueue_script('debug-digger-app', DD_PLUGIN_URL.'assets/main.js', array(), DD_VERSION, true);
        wp_localize_script('debug-digger-app', 'debugDiggerAdmin', array(
            'slug'      => 'debug-digger',
            'nonce'     => wp_create_nonce('debug-digger'),
            'rest'      => config('rest_api'),
            'asset_url' => DD_PLUGIN_URL . 'assets/',
        ));
    }

    public function render()
    {
        $this->enqueueAssets();
        echo '<div id="debug-digger-app"></div>';
    }

    private function getMenuIcon()
    {
        $icon = 'dashicons-admin-generic';
        $icon = apply_filters('duebug_digger/admin_menu_icon', $icon);

        return $icon;
    }
}
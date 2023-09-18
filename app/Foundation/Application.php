<?php
/**
 * This class is responsible for booting the application.
 * PHP version 7.4 or higher
 *
 * @category Application
 * @package  DebugDigger\App\Foundation
 * @author   Rafi Ahmed <rafi201822@gmail.com>
 * @license  GPL2+ <https://www.gnu.org/licenses/gpl-2.0.txt>
 * @since    1.0.0
 */
namespace DebugDigger\App\Foundation;

class Application extends Container
{

    /**
     * Application file
     *
     * @var null $file
     */
    protected $file = null;
    /**
     * Application base url
     *
     * @var null $baseUrl
     */
    protected $baseUrl = null;
    /**
     * Application base path
     *
     * @var null $basePath
     */
    protected $basePath = null;

    /**
     * Application constructor.
     *
     * @param $file string it recives the file path
     */
    public function __construct( $file )
    {
        $this->init($file);
        $this->bootstrapApplication();
    }

    /**
     * Initialize the application file, base path and base url
     *
     * @param $file string it recives the file path
     *
     * @return void
     */
    protected function init( $file )
    {
        $this->file     = $file;
        $this->basePath = plugin_dir_path($this->file);
        $this->baseUrl  = plugin_dir_url($this->file);
    }

    /**
     * Bootstrap the application
     *
     * @return void
     */
    protected function bootstrapApplication()
    {
        $this->bindAppInstance();
        $this->loadConfig();
        $this->registerTextdomain();
        $this->requireCommonFiles();
        $this->registerRestRoutes();
    }

    /**
     * Bind the application instance
     *
     * @return void
     */
    protected function bindAppInstance()
    {
        AppInstance::setInstance($this);
        $this->instance('app', $this);
        $this->instance(__CLASS__, $this);
    }

    /**
     * Load the config file
     *
     * @return void
     */
    protected function loadConfig()
    {
        if (file_exists($this->basePath . '/app/config.php')) {
            $config = include_once $this->basePath . '/app/config.php';
            $this->instance('config', $config);
        }
    }

    /**
     * Register the textdomain
     *
     * @return void
     */
    protected function registerTextdomain()
    {
        add_action('init', fn () => load_plugin_textdomain('debug-digger', false, 'debug-digger/language/'));
    }

    /**
     * Load required common files
     *
     * @return void
     */
    protected function requireCommonFiles()
    {
        $files = array(
            'helpers.php',
            'action-hooks.php',
            'filter-hooks.php',
        );

        foreach ( $files as $file ) {
            if (file_exists($this->basePath . '/app/Common/' . $file) ) {
                include_once $this->basePath . '/app/Common/' . $file;
            }
        }
    }

    /**
     * Register the rest routes
     *
     * @return void
     */
    protected function registerRestRoutes()
    {
        add_action(
            'rest_api_init',
            function () {
                include_once $this->basePath . '/app/Http/routes.php';
            }
        );
    }
}
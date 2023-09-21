<?php
namespace DebugDigger\App\Services;
use DebugDigger\App\Includes\ConfigTransformer;
class ActivationService
{
    public static function init()
    {  
       static::initDebugging();
    }

    private static function initDebugging()
    {
        $configTransformer = new ConfigTransformer(ABSPATH . 'wp-config.php');
        
        $configTransformer->update( 'constant', 'WP_DEBUG', 'true' );
        $configTransformer->update( 'constant', 'WP_DEBUG_LOG', 'true' );
        $configTransformer->update( 'constant', 'WP_DEBUG_DISPLAY', 'true' );
        $configTransformer->update( 'constant', 'SCRIPT_DEBUG', 'false' );
        $configTransformer->update( 'constant', 'SAVEQUERIES', 'false' );
        
    }
}
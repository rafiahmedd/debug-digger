<?php
/**
 * This class provide an Application instance inspiration taken from singleton pattern.
 * PHP version 7.4 or higher
 *
 * @category Class
 * @package  RafiAhmed\App\Foundation
 * @author   Rafi Ahmed <rafi201822@gmail.com>
 * @license  GPL2+ <https://www.gnu.org/licenses/gpl-2.0.txt>
 * @link     #link
 * @see      #see
 * @since    1.0.0
 */

 namespace DebugDigger\App\Foundation;

 /**
  * Class AppInstance
  *
  * @category Class
  * @package  RafiAhmed\App\Foundation
  * @author   Rafi Ahmed <rafi201822@gmail.com>
  * @license  GPL-2.0+ <https://opensource.org/licenses/gpl-2.0.php>
  * @link     #link
  */
 class AppInstance
 {
 
     /**
      * Application instance
      *
      * @var null $instance
      */
     protected static $instance = null;
 
     /**
      * Set the application instance
      *
      * @param $app mixed
      *
      * @return void
      */
     public static function setInstance( $app )
     {
         static::$instance = $app;
     }
 
     /**
      * Get the application instance
      *
      * @param $module mixed|null
      *
      * @return mixed|null
      */
     public static function getInstance( $module = null )
     {
         if ($module ) {
             return static::$instance[ $module ];
         }
 
         return static::$instance;
     }
 
     /**
      * Make instance of the application
      *
      * @param $module mixed|null
      *
      * @return mixed|null
      */
     public static function make( $module = null )
     {
         return static::getInstance($module);
     }
 
     /**
      * Magic method to call the application instance
      *
      * @param $method callable
      * @param $params mixed
      *
      * @return mixed|null
      */
     public static function __callStatic( $method, $params )
     {
         return static::getInstance($method);
     }
 }
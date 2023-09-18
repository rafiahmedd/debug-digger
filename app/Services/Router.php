<?php

namespace DebugDigger\App\Services;

class Router
{

    /**
     * Namespace for WordPress rest api
     *
     * @var string
     */
    private $namespace = 'debug-digger/v1';

    /**
     * Build the router and register all routes
     *
     * @param $method      string
     * @param $endpoint    string
     * @param $callback    callable
     * @param $permissions array
     *
     * @return $this Router
     */
    public function route( $method, $endpoint, $callback, $permissions = array() )
    {
        if (! $permissions ) {
            $permissions = array( 'manage_options' );
        }
        $endpoint = str_replace('{id}', '(?P<id>[\d]+)', $endpoint);

        register_rest_route(
            $this->namespace,
            $endpoint,
            array(
                'methods'             => $method,
                'callback'            => function ($request) use ($callback) {
                    return $this->handleCallback($request, $callback);
                },
                'permission_callback' => function ($request) use ($permissions) {
                   return $this->handlePermissionCallback($request, $permissions);
                },
            )
        );

        return $this;
    }

    private function handleCallback( $request, $callback )
    {
        $result = call_user_func($callback, $request);
        if (is_wp_error($result) ) {
            return $result;
        }
        return rest_ensure_response($result);
    }

    private function handlePermissionCallback($request, $permissions)
    {
        if (is_array($permissions) ) {
            if (count($permissions) ) {
                foreach ( $permissions as $permission ) {
                    if (current_user_can($permission) ) {
                        return true;
                    }
                }
                return false;
            }
            return true;
        }

        return call_user_func($permissions, $request);
    }

    /**
     * Method for GET request, it handle all get request
     *
     * @param $endpoint    string
     * @param $callback    callable
     * @param $permissions array
     *
     * @return $this
     */
    public function get( $endpoint, $callback, $permissions = array() )
    {
        $this->route(\WP_REST_Server::READABLE, $endpoint, $callback, $permissions);
        return $this;
    }

    public function post( $endpoint, $callback, $permissions = array() )
    {
        $this->route(\WP_REST_Server::CREATEABLE, $endpoint, $callback, $permissions);
        return $this;
    }

    /**
     * Method for PUT request. It handle all put request
     *
     * @param $endpoint    string
     * @param $callback    callable
     * @param $permissions array
     *
     * @return $this
     */
    public function put( $endpoint, $callback, $permissions = array() )
    {
        $this->route(\WP_REST_Server::EDITABLE, $endpoint, $callback, $permissions);
        return $this;
    }
}
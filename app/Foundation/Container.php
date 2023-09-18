<?php
/**
 * This class is the application container.
 * PHP version 7.4 or higher
 *
 * @category Container
 * @package  DebugDigger\App\Foundation
 * @author   Rafi Ahmed <rafi201822@gmail.com>
 * @license  GPL2+ <https://www.gnu.org/licenses/gpl-2.0.txt>
 * @since    1.0.0
 */
namespace DebugDigger\App\Foundation;

class Container
{

    /**
     * The container's bindings.
     *
     * @var array $bindings
     */
    private array $bindings = array();
    /**
     * The container's instances.
     */
    private array $instances = array();

    /**
     * Register a binding with the container.
     *
     * @param $abstract string
     * @param $concrete \Closure|string|null
     * @param $shared   bool
     *
     * @return void
     */
    public function bind( $abstract, $concrete = null, $shared = false )
    {
        if (! $concrete instanceof \Closure ) {
            $concrete = $this->_getClosure($abstract, $concrete);
        }

        $this->bindings[ $abstract ] = compact('concrete', 'shared');
    }

    /**
     * Register a shared binding in the container.
     *
     * @param $abstract string
     * @param $concrete \Closure|string|null
     *
     * @return void
     */
    public function singleton( $abstract, $concrete = null )
    {
        $this->bind($abstract, $concrete, true);
    }

    /**
     * Register an instance in the container.
     *
     * @param $abstract string
     * @param $instance mixed
     *
     * @return mixed
     */
    public function instance( $abstract, $instance )
    {
        $this->instances[ $abstract ] = $instance;
    }

    /**
     * Make a concrete instance of the given type.
     *
     * @param $abstract   string|callable
     * @param $parameters array
     *
     * @return mixed
     */
    public function make( $abstract, $parameters = array() )
    {
        if (isset($this->instances[ $abstract ]) ) {
            return $this->instances[ $abstract ];
        }

        if (isset($this->bindings[ $abstract ]) ) {
            return $this->_resolve($abstract, $parameters);
        }

        return $this->_resolve($abstract);
    }

    /**
     * Resolve the given type from the container.
     *
     * @param $abstract   string|callable
     * @param $parameters array
     *
     * @return mixed
     */
    private function _resolve( $abstract, $parameters = array() )
    {
        $concrete = $this->bindings[ $abstract ]['concrete'];

        if ($concrete instanceof \Closure ) {
            return $concrete($this, $parameters);
        }

        $reflector = new \ReflectionClass($concrete);

        if (! $reflector->isInstantiable() ) {
            throw new \Exception("Class {$concrete} is not instantiable");
        }

        $constructor = $reflector->getConstructor();

        if (is_null($constructor) ) {
            return new $concrete();
        }

        $dependencies = $constructor->getParameters();
        $instances    = $this->_getDependencies($dependencies);

        return $reflector->newInstanceArgs($instances);
    }

    /**
     * Get all dependencies for a given method.
     *
     * @param $parameters array
     *
     * @return array
     */
    private function _getDependencies( $parameters )
    {
        $dependencies = array();

        foreach ( $parameters as $parameter ) {
            $dependency = $parameter->getClass();

            if (is_null($dependency) ) {
                $dependencies[] = $this->_resolveNonClass($parameter);
            } else {
                $dependencies[] = $this->_resolve($dependency->name);
            }
        }

        return $dependencies;
    }

    /**
     * Resolve a non-class hinted dependency.
     *
     * @param $parameter \ReflectionParameter
     *
     * @return mixed
     *
     * @throws \Exception
     */
    private function _resolveNonClass( $parameter )
    {
        if ($parameter->isDefaultValueAvailable() ) {
            return $parameter->getDefaultValue();
        }

        throw new \Exception("Can not resolve the unknow! {$parameter->name}");
    }

    /**
     * Get the Closure to be used when building a type.
     *
     * @param $abstract string
     * @param $concrete string
     *
     * @return \Closure
     */
    private function _getClosure( $abstract, $concrete )
    {
        return function ( $c ) use ( $abstract, $concrete ) {
            $method = ( $abstract == $concrete ) ? 'build' : 'make';
            return $c->$method($concrete);
        };
    }

    /**
     * Call the given Closure.
     *
     * @param $callback   callable
     * @param $parameters array
     *
     * @return mixed
     */
    public function call( $callback, array $parameters = array() )
    {
        $dependencies = $this->getMethodDependencies($callback, $parameters);
        return call_user_func_array($callback, $dependencies);
    }

    /**
     * Get all dependencies for a given method.
     *
     * @param $callback   callable
     * @param $parameters array
     *
     * @return array
     */
    public function getMethodDependencies( $callback, array $parameters = array() )
    {
        $dependencies = array();
        foreach ( $this->getCallReflector($callback)->getParameters() as $key => $parameter ) {
            $this->addDependencyForCallParameter($parameter, $parameters, $dependencies);
        }
        return $dependencies;
    }

    /**
     * Add a dependency for a given call parameter.
     *
     * @param $parameter    \ReflectionParameter
     * @param $parameters   array
     * @param $dependencies array
     *
     * @return void
     */
    protected function addDependencyForCallParameter( \ReflectionParameter $parameter, array &$parameters, array &$dependencies )
    {
        if (array_key_exists($parameter->name, $parameters) ) {
            $dependencies[] = $parameters[ $parameter->name ];
            unset($parameters[ $parameter->name ]);
        } elseif ($parameter->getClass() ) {
            $dependencies[] = $this->make($parameter->getClass()->name);
        } elseif ($parameter->isDefaultValueAvailable() ) {
            $dependencies[] = $parameter->getDefaultValue();
        }
    }

    /**
     * Get the proper reflection instance for the given callback.
     *
     * @param $callback callable
     *
     * @return \ReflectionFunction|\ReflectionMethod
     * @throws \ReflectionException
     */
    protected function getCallReflector( $callback )
    {
        if (is_string($callback) && strpos($callback, '::') !== false ) {
            $callback = explode('::', $callback);
        }
        if (is_array($callback) ) {
            return new \ReflectionMethod($callback[0], $callback[1]);
        }
        return new \ReflectionFunction($callback);
    }
}
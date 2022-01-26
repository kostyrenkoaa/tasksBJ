<?php
namespace App\main;

use Symfony\Component\HttpFoundation\Request;

class Kernel
{
    public function __construct(
        protected array $config,
        protected Request $request
    )
    {
    }

    /**
     * @throws \Exception
     */
    public function start()
    {
        list($controller, $method) = $this->getControllersParams();
        if (!class_exists($controller)) {
            return '404';
        }

        $controller = new $controller($this->request);
        if (!method_exists($controller, $method)) {
            return '404';
        }

        $class = new \ReflectionClass($controller);
        $params = $class->getMethod($method)->getParameters();
        if (empty($params)) {
            return call_user_func_array([$controller, $method], []);
        }

        $paramsForClass = [];
        foreach ($params as $param) {
            $paramName = $param->getName();
            $paramClass = $param->getType()->getName();

            $paramsForClass[] = $this->getParamsForConstruct($paramClass, $paramName);
        }

        return call_user_func_array([$controller, $method], $paramsForClass);
    }

    protected function getParamsForConstruct($className, $paramName)
    {
        if (!class_exists($className) && isset($this->config[$paramName])) {
            return $this->config[$paramName];
        }

        $class = new \ReflectionClass($className);
        $constructor = $class->getConstructor();
        if (empty($constructor)) {
            return new $className();
        }

        $params = $constructor->getParameters();

        if (empty($params)) {
            return new $className();
        }

        $paramsForClass = [];
        foreach ($params as $param) {
            $paramNameForClass = $param->getName();
            $paramClassForClass = $param->getType()->getName();
            $paramsForClass[] = $this->getParamsForConstruct($paramClassForClass, $paramNameForClass);
        }

        return $class->newInstanceArgs($paramsForClass);
    }

    protected function getControllersParams(): array
    {
        $requestUri = $this->request->getRequestUri();
        $params = explode('/', $requestUri);
        $baseControllerName = 'home';
        if (!empty($params[1])) {
            $baseControllerName = $params[1];
        }

        $controllerName = 'App\\controllers\\' . ucfirst($baseControllerName) . 'Controller';

        $baseActionName = 'index';
        if (!empty($params[2])) {
            $baseActionName = $params[2];
        }

        $baseActionName .= 'Action';

        return [$controllerName, $baseActionName];
    }
}

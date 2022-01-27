<?php

namespace App\main;

use App\services\SessionService;
use \Symfony\Component\HttpFoundation\Request;

class Container
{
    protected array $components = [];
    protected string $requestClassName;

    public function __construct(
        protected array $config
    )
    {
        $this->initComponents();
    }

    protected function initComponents()
    {
        $request = Request::createFromGlobals();
        $this->requestClassName = get_class($request);
        $this->components[get_class($this)] = $this;
        $this->components[$this->requestClassName] = $request;
    }

    public function getSessionService()
    {
        if (empty($this->components[SessionService::class])) {
            $this->components[SessionService::class] = new SessionService();
        }

        return $this->components[SessionService::class];
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->components[$this->requestClassName];
    }


    public function getParamsForConstruct($className, $paramName)
    {
        if (!class_exists($className) && isset($this->config[$paramName])) {
            return $this->config[$paramName];
        }

        if (isset($this->components[$className])) {
            return $this->components[$className];
        }


        $class = new \ReflectionClass($className);
        $constructor = $class->getConstructor();
        if (empty($constructor)) {
            $this->components[$className] = new $className();
            return $this->components[$className];
        }

        $params = $constructor->getParameters();
        if (empty($params)) {
            $this->components[$className] = new $className();
            return $this->components[$className];
        }

        $paramsForClass = [];
        foreach ($params as $param) {
            $paramNameForClass = $param->getName();
            $paramClassForClass = $param->getType()->getName();
            $paramsForClass[] = $this->getParamsForConstruct($paramClassForClass, $paramNameForClass);
        }

        $this->components[$className] = $class->newInstanceArgs($paramsForClass);
        return $this->components[$className];
    }
}
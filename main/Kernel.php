<?php

namespace App\main;

use App\exceptions\RedirectException;

class Kernel
{
    public function __construct(
        protected Container $container
    )
    {
    }

    /**
     * Начало работы приложения
     *
     * @throws \Exception
     */
    public function start()
    {
        list($controller, $method) = $this->getControllersParams();
        if (!class_exists($controller)) {
            return '404';
        }

        $controller = new $controller($this->container->getRequest());
        if (!method_exists($controller, $method)) {
            return '404';
        }

        $class = new \ReflectionClass($controller);
        $params = $class->getMethod($method)->getParameters();
        if (empty($params)) {
            return $this->callController($controller, $method, []);
        }

        $paramsForClass = [];
        foreach ($params as $param) {
            $paramName = $param->getName();
            $paramClass = $param->getType()->getName();

            $paramsForClass[] = $this->container->getParamsForConstruct($paramClass, $paramName);
        }

        return $this->callController($controller, $method, $paramsForClass);
    }

    /**
     * Вызов контроллера
     *
     * @param object $controller
     * @param string $method
     * @param $paramsForClass
     * @return false|mixed|string
     */
    protected function callController(object $controller, string $method, $paramsForClass)
    {
        try {
            return call_user_func_array([$controller, $method], $paramsForClass);
        } catch (RedirectException $redirectException) {
            $errors = $redirectException->getErrors();
            if (!empty($errors)) {
                $this->container->getSessionService()->setFlashErrors($errors);
            }

            header('Location: ' . $redirectException->getUrl());
            return '';
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    /**
     * Получение параметров для определения вызываемого контроллера и метода в нем
     *
     * @return string[]
     */
    protected function getControllersParams(): array
    {
        $requestUri = $this->container->getRequest()->getRequestUri();
        $startParams = strpos($requestUri, '?');
        if ($startParams !== false) {
            $requestUri = substr($requestUri, 0, $startParams);
        }
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

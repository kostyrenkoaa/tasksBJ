<?php

namespace App\forms;

use App\dto\DTO;
use App\main\Container;
use \Symfony\Component\HttpFoundation\Request;
use Webmozart\Assert\Assert;

abstract class Form
{
    protected DTO $formData;
    protected $errors;

    /**
     * Правила валидации запроса
     *
     * @var array
     */
    protected array $validateRules = [];

    public function __construct(
        protected Container $container
    )
    {
    }

    /**
     * @return string Определяет какой объект будет наполняться
     */
    abstract public function getDTOClass(): string;

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->container->getRequest();
    }

    public function getErrorsForm()
    {
        if (!is_null($this->errors)) {
            return $this->errors;
        }

        $formData = $this->getDataForm();
        $this->errors = [];
        if (empty($this->validateRules)) {
            return $this->errors;
        }

        foreach ($this->validateRules as $fieldName => $rules) {
            if (empty($rules)) {
                continue;
            }

            foreach ($rules as $rule => $paramValidate) {
                $value = null;
                if (isset($formData->$fieldName)) {
                    $value = $formData->$fieldName;
                }

                try {
                    if (is_array($paramValidate)) {
                        Assert::$rule($value, $paramValidate[0], [1]);
                    } else {
                        Assert::$rule($value, $paramValidate);
                    }

                } catch (\Exception $exception) {
                    $this->errors[$fieldName] = $exception->getMessage();
                }
            }
        }

        return $this->errors;
    }

    /**
     * Возвращает наполненнный объект данными
     *
     * @return mixed
     */
    public function getDataForm()
    {
        return $this->fillData();
    }

    /**
     * Заполнение данными указанного объекта
     *
     * @return mixed
     */
    protected function fillData()
    {
        if (!empty($this->formData)) {
            return $this->formData;
        }
        $className = $this->getDTOClass();
        $this->formData = new $className();

        foreach ($this->formData as $key => $value) {
            $valueForAdd = $this->getRequest()->get($key);
            if (!isset($valueForAdd) && isset($value)) {
                $valueForAdd = $value;
            }
            $this->formData->$key = $valueForAdd;
        }

        return $this->formData;
    }
}
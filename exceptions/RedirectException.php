<?php

namespace App\exceptions;

/**
 * Класс для вызывания прерывания текущего метода и триггера пере запроса страницы
 */
class RedirectException extends \Exception
{
    public function __construct(
        protected string $url,
        protected array  $errors = [],
        string           $message = "",
        int              $code = 0,
        ?\Throwable      $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Возвращает url для редиректа
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Возвращает список ошибок для сохранения в сессии
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
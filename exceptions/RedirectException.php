<?php

namespace App\exceptions;


class RedirectException extends \Exception
{
    public function __construct(
        protected string $url,
        protected array $errors = [],
        string $message = "",
        int $code = 0,
        ?\Throwable $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
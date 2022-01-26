<?php
namespace App\services;

use Twig\Environment;

class TwigRenderService
{
    protected Environment $renderer;

    /**
     * @param $template
     * @param $params
     * @return string
     * @throws
     */
    public function render($template, $params)
    {
        $template .= '.twig';
        return $this->getRenderer()->render($template, $params);
    }

    protected function getRenderer(): Environment
    {
        if (empty($this->renderer)) {
            $loader = new \Twig\Loader\FilesystemLoader([
                dirname(__DIR__ ) . "/views/twig/",
                dirname(__DIR__ ) . "/views/",
            ]);
            $this->renderer = new \Twig\Environment($loader);
        }

        return $this->renderer;
    }
}

<?php

namespace Core\View;

use App;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class View implements ViewInterface
{
    protected Environment $twig;

    public function init(): void
    {
        $config = App::getContainer()->get('config')->get('view');

        $this->twig = new Environment(
            new FilesystemLoader($config['view_path']),
            [
                'cache' => $config['cache_path'],
            ]
        );
    }

    public function render($path, $params = []): string
    {
        return $this->twig->render($path, $params);
    }
}

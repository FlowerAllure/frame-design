<?php

namespace Core\View;

interface ViewInterface
{
    public function init();

    public function render($path, $params = []);
}

<?php

use Twig\Environment;
use Twig\Source;
use Twig\Template;

// index.html
class __TwigTemplate_0eab8c9e7cfbafe438459e06587ff075 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    public function getTemplateName()
    {
        return 'index.html';
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return [37 => 1];
    }

    public function getSourceContext()
    {
        return new Source('', 'index.html', '/mnt/share/LearnSpace/frame-design/views/index.html');
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo '<h2>';
        echo twig_escape_filter($this->env, $context['name'] ?? null, 'html', null, true);
        echo '</h2>
';
    }
}

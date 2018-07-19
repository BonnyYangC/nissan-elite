<?php

/* layout/reusable_elements/head.twig */
class __TwigTemplate_a1322f49947cf8c7306c84726e60062fc0ed338b9db7c5ed38de1511a2dab70f extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<head>
    <title>The title</title>
</head>";
    }

    public function getTemplateName()
    {
        return "layout/reusable_elements/head.twig";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<head>
    <title>The title</title>
</head>", "layout/reusable_elements/head.twig", "/Users/justinwang/Documents/workspace/gekko-projects/2018-nissanac/app/views/layout/reusable_elements/head.twig");
    }
}

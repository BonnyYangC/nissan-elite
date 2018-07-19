<?php

/* layout/frontend.twig */
class __TwigTemplate_5826a0e01127b4eb16886d4eb90bb53133d65adc4a5b6654fdc764f8e9d80d0a extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
    ";
        // line 3
        echo twig_include($this->env, $context, "layout/reusable_elements/head.twig");
        echo "
    <body>
    ";
        // line 5
        $this->displayBlock('content', $context, $blocks);
        // line 6
        echo "    ";
        echo twig_include($this->env, $context, "layout/reusable_elements/footer.twig");
        echo "
    </body>
</html>";
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "layout/frontend.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  39 => 5,  31 => 6,  29 => 5,  24 => 3,  20 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<!DOCTYPE html>
<html>
    {{ include('layout/reusable_elements/head.twig') }}
    <body>
    {% block content %}{% endblock %}
    {{ include('layout/reusable_elements/footer.twig') }}
    </body>
</html>", "layout/frontend.twig", "/Users/justinwang/Documents/workspace/gekko-projects/2018-nissanac/app/views/layout/frontend.twig");
    }
}

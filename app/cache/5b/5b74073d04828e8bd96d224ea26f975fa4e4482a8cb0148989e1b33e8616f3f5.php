<?php

/* layout/login.twig */
class __TwigTemplate_02d2f95414966d3140519b3e87dfc84510b3657f696346cf26752bb8f6530354 extends Twig_Template
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
        echo twig_include($this->env, $context, "layout/reusable_elements/head_login.twig");
        echo "
    <body id=\"page\">
    ";
        // line 5
        $this->displayBlock('content', $context, $blocks);
        // line 6
        echo "    ";
        echo twig_include($this->env, $context, "layout/reusable_elements/footer_login.twig");
        echo "
    </body>
</html>
";
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "layout/login.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  40 => 5,  31 => 6,  29 => 5,  24 => 3,  20 => 1,);
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
    {{ include('layout/reusable_elements/head_login.twig') }}
    <body id=\"page\">
    {% block content %}{% endblock %}
    {{ include('layout/reusable_elements/footer_login.twig') }}
    </body>
</html>
", "layout/login.twig", "/Users/justinwang/Documents/workspace/gekko-projects/2018-nissanac/app/views/layout/login.twig");
    }
}

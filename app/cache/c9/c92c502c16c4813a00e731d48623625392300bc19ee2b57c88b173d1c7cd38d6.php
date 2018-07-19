<?php

/* layout/reusable_elements/footer.twig */
class __TwigTemplate_0f3a8d9eb5080bbf2c055c480e0849e29729d58e225e966040527cf5693d0aba extends Twig_Template
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
        echo "<p>footer</p>";
    }

    public function getTemplateName()
    {
        return "layout/reusable_elements/footer.twig";
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
        return new Twig_Source("<p>footer</p>", "layout/reusable_elements/footer.twig", "/Users/justinwang/Documents/workspace/gekko-projects/2018-nissanac/app/views/layout/reusable_elements/footer.twig");
    }
}

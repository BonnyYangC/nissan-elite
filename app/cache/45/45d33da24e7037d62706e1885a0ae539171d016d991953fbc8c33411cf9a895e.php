<?php

/* layout/reusable_elements/head_login.twig */
class __TwigTemplate_da5311f61d7641951eebac5ab9c1a6efd05b0acd0d9c26fa631cf46734f43788 extends Twig_Template
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
    <meta charset=\"UTF-8\" />
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge,chrome=1\">
    <title>Nissan: Ambassador Club 2017</title>
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <meta name=\"description\" content=\"Fullscreen Background Image Slideshow with CSS3 - A Css-only fullscreen background image slideshow\" />
    <meta name=\"keywords\" content=\"css3, css-only, fullscreen, background, slideshow, images, content\" />
    <link rel=\"shortcut icon\" type=\"image/png\" href=\"";
        // line 8
        echo twig_escape_filter($this->env, asset("/images/favicon.png"), "html", null, true);
        echo "\" />
    <link href=\"";
        // line 9
        echo twig_escape_filter($this->env, asset("/includes/jalert/dist/jAlert.css"), "html", null, true);
        echo "\" rel=\"stylesheet\">
    <link rel=\"stylesheet\" type=\"text/css\" href=\"";
        // line 10
        echo twig_escape_filter($this->env, asset("/includes/jconfirm/css/jquery-confirm.css"), "html", null, true);
        echo "\"/>
    <link href=\"";
        // line 11
        echo twig_escape_filter($this->env, asset("css/fonts.css"), "html", null, true);
        echo "\" rel=\"stylesheet\">
    <link href=\"";
        // line 12
        echo twig_escape_filter($this->env, asset("css/demo.css"), "html", null, true);
        echo "\" rel=\"stylesheet\">
    <link href=\"";
        // line 13
        echo twig_escape_filter($this->env, asset("css/style.css"), "html", null, true);
        echo "\" rel=\"stylesheet\">
    <link href=\"";
        // line 14
        echo twig_escape_filter($this->env, asset("css/bootstrap.min.css"), "html", null, true);
        echo "\" rel=\"stylesheet\">
    <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css\">
</head>";
    }

    public function getTemplateName()
    {
        return "layout/reusable_elements/head_login.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  52 => 14,  48 => 13,  44 => 12,  40 => 11,  36 => 10,  32 => 9,  28 => 8,  19 => 1,);
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
    <meta charset=\"UTF-8\" />
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge,chrome=1\">
    <title>Nissan: Ambassador Club 2017</title>
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <meta name=\"description\" content=\"Fullscreen Background Image Slideshow with CSS3 - A Css-only fullscreen background image slideshow\" />
    <meta name=\"keywords\" content=\"css3, css-only, fullscreen, background, slideshow, images, content\" />
    <link rel=\"shortcut icon\" type=\"image/png\" href=\"{{ asset('/images/favicon.png') }}\" />
    <link href=\"{{ asset('/includes/jalert/dist/jAlert.css') }}\" rel=\"stylesheet\">
    <link rel=\"stylesheet\" type=\"text/css\" href=\"{{ asset('/includes/jconfirm/css/jquery-confirm.css') }}\"/>
    <link href=\"{{ asset('css/fonts.css') }}\" rel=\"stylesheet\">
    <link href=\"{{ asset('css/demo.css') }}\" rel=\"stylesheet\">
    <link href=\"{{ asset('css/style.css') }}\" rel=\"stylesheet\">
    <link href=\"{{ asset('css/bootstrap.min.css') }}\" rel=\"stylesheet\">
    <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css\">
</head>", "layout/reusable_elements/head_login.twig", "/Users/justinwang/Documents/workspace/gekko-projects/2018-nissanac/app/views/layout/reusable_elements/head_login.twig");
    }
}

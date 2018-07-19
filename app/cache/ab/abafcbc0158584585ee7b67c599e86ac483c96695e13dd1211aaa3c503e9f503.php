<?php

/* layout/reusable_elements/footer_login.twig */
class __TwigTemplate_794963447d7856d77b6e5ea0068d581214504fc54bcf3e744daa04f0df029e53 extends Twig_Template
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
        echo "<script src=\"http://lib.gekkocreations.com.au/jquery/jquery.min.js\"></script>
<script src=\"http://lib.gekkocreations.com.au/bootstrap/js/bootstrap.bundle.min.js\"></script>
<script src=\"";
        // line 3
        echo twig_escape_filter($this->env, asset("/includes/jalert/dist/jAlert.min.js"), "html", null, true);
        echo "\"></script>
<script src=\"";
        // line 4
        echo twig_escape_filter($this->env, asset("/includes/jalert/dist/jAlert-functions.min.js"), "html", null, true);
        echo "\"></script>
<script src=\"";
        // line 5
        echo twig_escape_filter($this->env, asset("/includes/jconfirm/js/jquery-confirm.js"), "html", null, true);
        echo "\"></script>
<script src=\"";
        // line 6
        echo twig_escape_filter($this->env, asset("js/modernizr.custom.86080.js"), "html", null, true);
        echo "\"></script>
<script>
    function MultipleLogins()
    {
        \$.confirm ({
            boxWidth: '450',
            useBootstrap: false,
            title: 'Multiple Logins Detected',
            content: '<p>Another computer is currently signed on using this email.</p><p>Click Continue to log out the other sessions and continue with this session.</p>',
            autoClose: 'cancelAction|10000',
            escapeKey: 'cancelAction',
            buttons: {
                confirm: {
                    btnClass: 'btn',
                    text: 'Continue',
                    action: function () {

                        \$.post(\"post.php\",
                            {
                                action: 'UseSession'
                            },
                            function(response){
                                \$(\"#debug\").html(response);
                                self.location=\"./\";

                            });
                    }
                },
                cancelAction: {
                    btnClass: 'btn',
                    text: 'Cancel Login',
                    action: function () {
                        \$.post(\"post.php\",
                            {
                                action: 'logout'
                            }
                        );
                    }
                }
            }
        });
    }
</script>";
    }

    public function getTemplateName()
    {
        return "layout/reusable_elements/footer_login.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  35 => 6,  31 => 5,  27 => 4,  23 => 3,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<script src=\"http://lib.gekkocreations.com.au/jquery/jquery.min.js\"></script>
<script src=\"http://lib.gekkocreations.com.au/bootstrap/js/bootstrap.bundle.min.js\"></script>
<script src=\"{{ asset('/includes/jalert/dist/jAlert.min.js') }}\"></script>
<script src=\"{{ asset('/includes/jalert/dist/jAlert-functions.min.js') }}\"></script>
<script src=\"{{ asset('/includes/jconfirm/js/jquery-confirm.js') }}\"></script>
<script src=\"{{ asset('js/modernizr.custom.86080.js') }}\"></script>
<script>
    function MultipleLogins()
    {
        \$.confirm ({
            boxWidth: '450',
            useBootstrap: false,
            title: 'Multiple Logins Detected',
            content: '<p>Another computer is currently signed on using this email.</p><p>Click Continue to log out the other sessions and continue with this session.</p>',
            autoClose: 'cancelAction|10000',
            escapeKey: 'cancelAction',
            buttons: {
                confirm: {
                    btnClass: 'btn',
                    text: 'Continue',
                    action: function () {

                        \$.post(\"post.php\",
                            {
                                action: 'UseSession'
                            },
                            function(response){
                                \$(\"#debug\").html(response);
                                self.location=\"./\";

                            });
                    }
                },
                cancelAction: {
                    btnClass: 'btn',
                    text: 'Cancel Login',
                    action: function () {
                        \$.post(\"post.php\",
                            {
                                action: 'logout'
                            }
                        );
                    }
                }
            }
        });
    }
</script>", "layout/reusable_elements/footer_login.twig", "/Users/justinwang/Documents/workspace/gekko-projects/2018-nissanac/app/views/layout/reusable_elements/footer_login.twig");
    }
}

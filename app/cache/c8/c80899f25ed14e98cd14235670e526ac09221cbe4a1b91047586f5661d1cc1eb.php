<?php

/* user/login.twig */
class __TwigTemplate_8ae752826fc673b7e2c7fee7f6e79777db5a5f5567315fd0223c1019c86c42eb extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layout/login.twig", "user/login.twig", 1);
        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "layout/login.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_content($context, array $blocks = array())
    {
        // line 3
        echo "    <section>
        <ul class=\"cb-slideshow\">
            <li><span></span></li>
            <li><span></span></li>
            <li><span></span></li>
            <li><span></span></li>
            <li><span></span></li>
            <li><span></span></li>
        </ul>





        <div class=\"container-loop\">

            <div class=\"codrops-top\">


                <a href=\"#\">
                    <!--<img alt=\"Nissan\" src=\"images/NT_logo.jpg\" width=\"120px\" /> -->
                </a>



                <span class=\"right\">
                    </span>
                <div class=\"clr\"></div>
            </div><!--Codrops top bar -->

            <header>


                <div class=\"login-form\">

                    <!-- <h1 class=\"title text-center\">Welcome</h1>-->

                    <form id=\"login-form\" method=\"post\" action=\"/post.php\" target=\"hf\" class=\"form-signin\" role=\"form\" >
                        <input type=\"hidden\" name=\"action\" value=\"login\">

                        <div align=\"center\"><img src=\"images/nissanac-logo-footer.png\" width=\"240px\" style=\"padding-bottom:20px\"></div>

                        <input name=\"email\" id=\"email\" type=\"email\" class=\"form-control\"placeholder=\"Email\" autofocus>
                        <input name=\"password\" id=\"password\" type=\"password\" class=\"form-control\" placeholder=\"Password\">
                        <input class=\"btn btn-block bt-login\" type=\"submit\">Sign In</input>
                    </form>

                    <iframe id=\"hf\" name=\"hf\" style=\"height:1px; width:1px; visibility: hidden; position:absolute; z-index: 1\"></iframe>

                    <div class=\"form-footer\">
                        <div class=\"row\">
                            <div class=\"col-xs-6 col-sm-6 col-md-7\">
                                <!-- <i class=\"fa fa-lock\"></i> -->
                                <a style=\"color:#999999;\" href=\"#forgotpassword\" > Forgot password? </a>
                            </div>
                            <div class=\"col-xs-6 col-sm-6 col-md-5\">
                                <!-- <i class=\"fa fa-check\"></i> -->


                                <script>
                                    /*function scrollToAnchor(aid){
                                    var aTag = \$(\"a[name='\"+ aid +\"']\");
                                    \$('html,body').animate({scrollTop: aTag.offset().top},'slow');
                                    }

                                    \$(\"#register\").click(function() {
                                    scrollToAnchor('id3');
                                    });*/
                                </script>


                                <a style=\"color:#999999;\"  href=\"#eligible\">New to Nissan?</a>
                            </div>
                        </div>
                    </div>
                </div>


                <!--
                 <h1>CSS3 <span>Fullscreen Slideshow</span></h1>
                 <h2>A CSS-only slideshow for background images</h2>
                 <p class=\"codrops-demos\">
                     <a href=\"#\" class=\"current-demo\">Demo 1</a>
                     <a href=\"index2.html\">Demo 2</a>
                     <a href=\"index3.html\">Demo 3</a>
                     <a href=\"index4.html\">Demo 4</a>
                 </p>
                 -->


            </header>
        </div>




    </section>






    <!--start portfolio -->
    <section id=\"eligible\" >


        <div class=\"container\">

            <div style=\"margin:0 auto; height: 600px; padding-top:200px; text-align: center; font-size:16px; margin-bottom:200px;\">


                <!--
               <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\" integrity=\"sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u\" crossorigin=\"anonymous\">
               <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css\" integrity=\"sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp\" crossorigin=\"anonymous\">
               -->

                <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js\" integrity=\"sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa\" crossorigin=\"anonymous\"></script>

                <span style=\"font-size:50px; color:#FFFFFF;\">New to Nissan? </span> <br><br>



                <div class=\"bs-example\">
                    <div class=\"panel-group\" id=\"accordion\">
                        <div class=\"panel panel-default\">
                            <div class=\"panel-heading\">
                                <h4 class=\"panel-title\">
                                    <a data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapseOne\">1. Can I join Ambassador Club?</a>
                                </h4>
                            </div>
                            <div id=\"collapseOne\" class=\"panel-collapse collapse\">
                                <div class=\"panel-body\">
                                    <p>If you are currently employed by Nissan Australia in one of the following job functions at a Nissan Dealership in Australia you are automatically invited to register and participate in the program:<br>

                                        • Sales Manager<br>
                                        • F&I Manager<br>
                                        • Financial Controller<br>
                                        • Retail Sales Consultant<br>
                                        • Fleet Manager / Fleet Sales Consultant<br>
                                        • Service Manager<br>
                                        • Service Advisor<br>
                                        • Stock Controllers<br>
                                        • Parts Manager<br>
                                        • Parts Sales Representative<br>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class=\"panel panel-default\">
                            <div class=\"panel-heading\">
                                <h4 class=\"panel-title\">
                                    <a data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapseTwo\">2. How do I register for Ambassador Club?</a>
                                </h4>
                            </div>
                            <div id=\"collapseTwo\" class=\"panel-collapse collapse\">
                                <div class=\"panel-body\">
                                    <p>Go to <a href=\"http://nissan-events.com.au/ac2017/reg\" target=\"_blank\">www.nissanevents.com.au/ac2017/reg</a> and successfully complete the 2017 Nissan Ambassador Club registration form including a requirement to accept the program terms and conditions as directed.
                                        On completion, you will receive a confirmation e-Mail for your Nissan Ambassador Club registration. </p>
                                </div>
                            </div>
                        </div>
                        <div class=\"panel panel-default\">
                            <div class=\"panel-heading\">
                                <h4 class=\"panel-title\">
                                    <a data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapseThree\">3. Further queries?</a>
                                </h4>
                            </div>
                            <div id=\"collapseThree\" class=\"panel-collapse collapse\">
                                <div class=\"panel-body\">
                                    <p>The Nissan Ambassador Club Service Centre can be contacted on:<br><br>

                                        Telephone:  \t03 9544 9054<br>
                                        Facsimile:  \t03 9544 9045<br>
                                        Email: \t\tinfo@nissanac.com.au
                                    </p>
                                </div>
                            </div>
                        </div>


                    </div>
                    <p style=\"color:#FFFFFF;\" ><strong>Note:</strong> Click on any of the above tabs to see more information. Go back to <a href=\"#\">login</a> </p>



                </div>


            </div>




        </div>

    </section>
    <!--end portfolio-->

    <!--start portfolio -->
    <section id=\"forgotpassword\">


        <div class=\"container\">

            <div style=\"margin:0 auto; height: 600px; width:500px; padding-top:200px; text-align: center; font-size:50px; margin-bottom:100px;\">


                <p style=\"color:#FFFFFF;\">Forgot Password?</p>

                <p style=\"font-size:14px; color:#FFFFFF\">Please enter your registered email address.</p>

                <input name=\"Email\" id=\"Email\" type=\"password\" class=\"form-control\" placeholder=\"Email Address\" style=\"margin:10px 0px\">
                <button style=\"background-color:#000000;\" class=\"btn btn-block bt-login\" type=\"submit\">Submit</button>



                <p style=\"color:#FFFFFF; font-size:14px; padding-top:10px;\" ><strong>Note:</strong> Go back to <a href=\"#\">login</a> </p>
            </div>



        </div>




    </section>
    <!--end portfolio-->
";
    }

    public function getTemplateName()
    {
        return "user/login.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  31 => 3,  28 => 2,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends 'layout/login.twig' %}
{% block content %}
    <section>
        <ul class=\"cb-slideshow\">
            <li><span></span></li>
            <li><span></span></li>
            <li><span></span></li>
            <li><span></span></li>
            <li><span></span></li>
            <li><span></span></li>
        </ul>





        <div class=\"container-loop\">

            <div class=\"codrops-top\">


                <a href=\"#\">
                    <!--<img alt=\"Nissan\" src=\"images/NT_logo.jpg\" width=\"120px\" /> -->
                </a>



                <span class=\"right\">
                    </span>
                <div class=\"clr\"></div>
            </div><!--Codrops top bar -->

            <header>


                <div class=\"login-form\">

                    <!-- <h1 class=\"title text-center\">Welcome</h1>-->

                    <form id=\"login-form\" method=\"post\" action=\"/post.php\" target=\"hf\" class=\"form-signin\" role=\"form\" >
                        <input type=\"hidden\" name=\"action\" value=\"login\">

                        <div align=\"center\"><img src=\"images/nissanac-logo-footer.png\" width=\"240px\" style=\"padding-bottom:20px\"></div>

                        <input name=\"email\" id=\"email\" type=\"email\" class=\"form-control\"placeholder=\"Email\" autofocus>
                        <input name=\"password\" id=\"password\" type=\"password\" class=\"form-control\" placeholder=\"Password\">
                        <input class=\"btn btn-block bt-login\" type=\"submit\">Sign In</input>
                    </form>

                    <iframe id=\"hf\" name=\"hf\" style=\"height:1px; width:1px; visibility: hidden; position:absolute; z-index: 1\"></iframe>

                    <div class=\"form-footer\">
                        <div class=\"row\">
                            <div class=\"col-xs-6 col-sm-6 col-md-7\">
                                <!-- <i class=\"fa fa-lock\"></i> -->
                                <a style=\"color:#999999;\" href=\"#forgotpassword\" > Forgot password? </a>
                            </div>
                            <div class=\"col-xs-6 col-sm-6 col-md-5\">
                                <!-- <i class=\"fa fa-check\"></i> -->


                                <script>
                                    /*function scrollToAnchor(aid){
                                    var aTag = \$(\"a[name='\"+ aid +\"']\");
                                    \$('html,body').animate({scrollTop: aTag.offset().top},'slow');
                                    }

                                    \$(\"#register\").click(function() {
                                    scrollToAnchor('id3');
                                    });*/
                                </script>


                                <a style=\"color:#999999;\"  href=\"#eligible\">New to Nissan?</a>
                            </div>
                        </div>
                    </div>
                </div>


                <!--
                 <h1>CSS3 <span>Fullscreen Slideshow</span></h1>
                 <h2>A CSS-only slideshow for background images</h2>
                 <p class=\"codrops-demos\">
                     <a href=\"#\" class=\"current-demo\">Demo 1</a>
                     <a href=\"index2.html\">Demo 2</a>
                     <a href=\"index3.html\">Demo 3</a>
                     <a href=\"index4.html\">Demo 4</a>
                 </p>
                 -->


            </header>
        </div>




    </section>






    <!--start portfolio -->
    <section id=\"eligible\" >


        <div class=\"container\">

            <div style=\"margin:0 auto; height: 600px; padding-top:200px; text-align: center; font-size:16px; margin-bottom:200px;\">


                <!--
               <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\" integrity=\"sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u\" crossorigin=\"anonymous\">
               <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css\" integrity=\"sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp\" crossorigin=\"anonymous\">
               -->

                <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js\" integrity=\"sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa\" crossorigin=\"anonymous\"></script>

                <span style=\"font-size:50px; color:#FFFFFF;\">New to Nissan? </span> <br><br>



                <div class=\"bs-example\">
                    <div class=\"panel-group\" id=\"accordion\">
                        <div class=\"panel panel-default\">
                            <div class=\"panel-heading\">
                                <h4 class=\"panel-title\">
                                    <a data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapseOne\">1. Can I join Ambassador Club?</a>
                                </h4>
                            </div>
                            <div id=\"collapseOne\" class=\"panel-collapse collapse\">
                                <div class=\"panel-body\">
                                    <p>If you are currently employed by Nissan Australia in one of the following job functions at a Nissan Dealership in Australia you are automatically invited to register and participate in the program:<br>

                                        • Sales Manager<br>
                                        • F&I Manager<br>
                                        • Financial Controller<br>
                                        • Retail Sales Consultant<br>
                                        • Fleet Manager / Fleet Sales Consultant<br>
                                        • Service Manager<br>
                                        • Service Advisor<br>
                                        • Stock Controllers<br>
                                        • Parts Manager<br>
                                        • Parts Sales Representative<br>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class=\"panel panel-default\">
                            <div class=\"panel-heading\">
                                <h4 class=\"panel-title\">
                                    <a data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapseTwo\">2. How do I register for Ambassador Club?</a>
                                </h4>
                            </div>
                            <div id=\"collapseTwo\" class=\"panel-collapse collapse\">
                                <div class=\"panel-body\">
                                    <p>Go to <a href=\"http://nissan-events.com.au/ac2017/reg\" target=\"_blank\">www.nissanevents.com.au/ac2017/reg</a> and successfully complete the 2017 Nissan Ambassador Club registration form including a requirement to accept the program terms and conditions as directed.
                                        On completion, you will receive a confirmation e-Mail for your Nissan Ambassador Club registration. </p>
                                </div>
                            </div>
                        </div>
                        <div class=\"panel panel-default\">
                            <div class=\"panel-heading\">
                                <h4 class=\"panel-title\">
                                    <a data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapseThree\">3. Further queries?</a>
                                </h4>
                            </div>
                            <div id=\"collapseThree\" class=\"panel-collapse collapse\">
                                <div class=\"panel-body\">
                                    <p>The Nissan Ambassador Club Service Centre can be contacted on:<br><br>

                                        Telephone:  \t03 9544 9054<br>
                                        Facsimile:  \t03 9544 9045<br>
                                        Email: \t\tinfo@nissanac.com.au
                                    </p>
                                </div>
                            </div>
                        </div>


                    </div>
                    <p style=\"color:#FFFFFF;\" ><strong>Note:</strong> Click on any of the above tabs to see more information. Go back to <a href=\"#\">login</a> </p>



                </div>


            </div>




        </div>

    </section>
    <!--end portfolio-->

    <!--start portfolio -->
    <section id=\"forgotpassword\">


        <div class=\"container\">

            <div style=\"margin:0 auto; height: 600px; width:500px; padding-top:200px; text-align: center; font-size:50px; margin-bottom:100px;\">


                <p style=\"color:#FFFFFF;\">Forgot Password?</p>

                <p style=\"font-size:14px; color:#FFFFFF\">Please enter your registered email address.</p>

                <input name=\"Email\" id=\"Email\" type=\"password\" class=\"form-control\" placeholder=\"Email Address\" style=\"margin:10px 0px\">
                <button style=\"background-color:#000000;\" class=\"btn btn-block bt-login\" type=\"submit\">Submit</button>



                <p style=\"color:#FFFFFF; font-size:14px; padding-top:10px;\" ><strong>Note:</strong> Go back to <a href=\"#\">login</a> </p>
            </div>



        </div>




    </section>
    <!--end portfolio-->
{% endblock %}", "user/login.twig", "/Users/justinwang/Documents/workspace/gekko-projects/2018-nissanac/app/views/user/login.twig");
    }
}

<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* base.html.twig */
class __TwigTemplate_233b3b6144f518563049f9f0ef7d32b7 extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'stylesheets' => [$this, 'block_stylesheets'],
            'body' => [$this, 'block_body'],
            'javascripts' => [$this, 'block_javascripts'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "base.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "base.html.twig"));

        // line 1
        yield "<!DOCTYPE html>
<html lang=\"fr\">
<head>
    <meta charset=\"UTF-8\">
    <title>";
        // line 5
        yield from $this->unwrap()->yieldBlock('title', $context, $blocks);
        yield "</title>

    <link href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css\" rel=\"stylesheet\">
    <link href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css\" rel=\"stylesheet\">
    <link rel=\"stylesheet\" href=\"https://unpkg.com/leaflet/dist/leaflet.css\"/>
    ";
        // line 10
        yield from $this->unwrap()->yieldBlock('stylesheets', $context, $blocks);
        // line 11
        yield "
    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: #f4f6f5;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            min-height: 100vh;
            background: #1a3a2a;
            color: white;
            padding: 0;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            height: 100vh;
        }

        .sidebar-header {
            padding: 30px 25px;
            background: rgba(0,0,0,0.1);
        }

        .sidebar h3 {
            font-weight: 800;
            font-size: 1.5rem;
            margin: 0;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
        }

        .sidebar h3 i {
            color: #8bd22f;
        }

        .sidebar-menu {
            padding: 20px 15px;
            flex-grow: 1;
            overflow-y: auto;
        }

        .menu-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            font-weight: 700;
            color: rgba(255,255,255,0.4);
            margin: 20px 0 10px 15px;
            letter-spacing: 1px;
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,0.7);
            padding: 12px 18px;
            border-radius: 12px;
            margin-bottom: 5px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            font-weight: 500;
            font-size: 0.95rem;
            text-decoration: none;
        }

        .sidebar .nav-link i {
            width: 24px;
            font-size: 1.1rem;
            margin-right: 12px;
            transition: 0.3s;
        }

        .sidebar .nav-link:hover {
            background: rgba(139, 210, 47, 0.1);
            color: #8bd22f;
            transform: translateX(5px);
        }

        .sidebar .nav-link:hover i {
            color: #8bd22f;
        }

        .sidebar .nav-link.active {
            background: #8bd22f;
            color: #1a3a2a;
            box-shadow: 0 4px 12px rgba(139, 210, 47, 0.3);
        }

        .sidebar .nav-link.active i {
            color: #1a3a2a;
        }

        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid rgba(255,255,255,0.05);
            background: rgba(0,0,0,0.1);
        }

        .extra-small {
            font-size: 0.75rem;
        }

        /* Header */
        .top-header {
            background: white;
            padding: 15px 30px;
            border-bottom: 1px solid #e5e5e5;
        }

        .breadcrumb-item + .breadcrumb-item::before {
            content: \">\";
            color: #6c757d;
        }

        .main-content {
            padding: 30px;
            flex: 1;
            overflow-x: auto;
        }

        .container {
            max-width: 100% !important;
        }

        /* Hero Banner */
        .hero {
            background: linear-gradient(90deg, #2f6b4f, #8bd22f);
            color: white;
            padding: 40px;
            border-radius: 20px;
            margin-bottom: 30px;
        }

        /* Stats cards */
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card h3 {
            font-weight: 700;
            color: #2f6b4f;
        }

        .stat-icon {
            background: #e9f5ee;
            padding: 12px;
            border-radius: 12px;
            color: #2f6b4f;
        }

        /* Big cards */
        .big-card {
            background: white;
            border-radius: 18px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }

        .btn-green {
            background: #8bd22f;
            border: none;
            padding: 12px 25px;
            border-radius: 12px;
            font-weight: 600;
            color: #1a3a2a;
            text-decoration: none;
            display: inline-block;
        }

        .btn-green:hover {
            background: #76c023;
        }

        .btn-outline-custom {
            border: 1px solid #ddd;
            border-radius: 12px;
            padding: 12px 25px;
            font-weight: 500;
            background: white;
            color: #333;
            text-decoration: none;
            display: inline-block;
        }

        /* Validation styles */
        .form-control.is-invalid {
            border-color: #dc3545;
            background-image: none;
        }

        .form-control.is-valid {
            border-color: #28a745;
            background-image: none;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: none;
        }

        .error-message.show {
            display: block;
        }

        .char-counter {
            color: #6c757d;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .char-counter.invalid {
            color: #dc3545;
            font-weight: bold;
        }

        .file-error {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: none;
        }

        .file-error.show {
            display: block;
        }

        /* Symfony form errors */
        .form-error {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: block;
        }

        .form_error_list {
            list-style: none;
            padding: 0;
            margin: 0.5rem 0 0 0;
        }

        .form_error_list li {
            color: #dc3545;
            font-size: 0.875rem;
            margin-bottom: 0.25rem;
        }

    </style>
</head>
<body>
    <!-- The sidebar will be included in each page's body block -->
    ";
        // line 275
        yield from $this->unwrap()->yieldBlock('body', $context, $blocks);
        // line 276
        yield "    
    <script src=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js\"></script>
    <script src=\"https://unpkg.com/leaflet/dist/leaflet.js\"></script>
    ";
        // line 279
        yield from $this->unwrap()->yieldBlock('javascripts', $context, $blocks);
        // line 280
        yield "</body>
</html>";
        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 5
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        yield "WasteWise";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        yield from [];
    }

    // line 10
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_stylesheets(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "stylesheets"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "stylesheets"));

        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        yield from [];
    }

    // line 275
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_body(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        yield from [];
    }

    // line 279
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_javascripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "javascripts"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "javascripts"));

        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "base.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  422 => 279,  400 => 275,  378 => 10,  355 => 5,  343 => 280,  341 => 279,  336 => 276,  334 => 275,  68 => 11,  66 => 10,  58 => 5,  52 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<!DOCTYPE html>
<html lang=\"fr\">
<head>
    <meta charset=\"UTF-8\">
    <title>{% block title %}WasteWise{% endblock %}</title>

    <link href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css\" rel=\"stylesheet\">
    <link href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css\" rel=\"stylesheet\">
    <link rel=\"stylesheet\" href=\"https://unpkg.com/leaflet/dist/leaflet.css\"/>
    {% block stylesheets %}{% endblock %}

    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: #f4f6f5;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            min-height: 100vh;
            background: #1a3a2a;
            color: white;
            padding: 0;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            height: 100vh;
        }

        .sidebar-header {
            padding: 30px 25px;
            background: rgba(0,0,0,0.1);
        }

        .sidebar h3 {
            font-weight: 800;
            font-size: 1.5rem;
            margin: 0;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
        }

        .sidebar h3 i {
            color: #8bd22f;
        }

        .sidebar-menu {
            padding: 20px 15px;
            flex-grow: 1;
            overflow-y: auto;
        }

        .menu-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            font-weight: 700;
            color: rgba(255,255,255,0.4);
            margin: 20px 0 10px 15px;
            letter-spacing: 1px;
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,0.7);
            padding: 12px 18px;
            border-radius: 12px;
            margin-bottom: 5px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            font-weight: 500;
            font-size: 0.95rem;
            text-decoration: none;
        }

        .sidebar .nav-link i {
            width: 24px;
            font-size: 1.1rem;
            margin-right: 12px;
            transition: 0.3s;
        }

        .sidebar .nav-link:hover {
            background: rgba(139, 210, 47, 0.1);
            color: #8bd22f;
            transform: translateX(5px);
        }

        .sidebar .nav-link:hover i {
            color: #8bd22f;
        }

        .sidebar .nav-link.active {
            background: #8bd22f;
            color: #1a3a2a;
            box-shadow: 0 4px 12px rgba(139, 210, 47, 0.3);
        }

        .sidebar .nav-link.active i {
            color: #1a3a2a;
        }

        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid rgba(255,255,255,0.05);
            background: rgba(0,0,0,0.1);
        }

        .extra-small {
            font-size: 0.75rem;
        }

        /* Header */
        .top-header {
            background: white;
            padding: 15px 30px;
            border-bottom: 1px solid #e5e5e5;
        }

        .breadcrumb-item + .breadcrumb-item::before {
            content: \">\";
            color: #6c757d;
        }

        .main-content {
            padding: 30px;
            flex: 1;
            overflow-x: auto;
        }

        .container {
            max-width: 100% !important;
        }

        /* Hero Banner */
        .hero {
            background: linear-gradient(90deg, #2f6b4f, #8bd22f);
            color: white;
            padding: 40px;
            border-radius: 20px;
            margin-bottom: 30px;
        }

        /* Stats cards */
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card h3 {
            font-weight: 700;
            color: #2f6b4f;
        }

        .stat-icon {
            background: #e9f5ee;
            padding: 12px;
            border-radius: 12px;
            color: #2f6b4f;
        }

        /* Big cards */
        .big-card {
            background: white;
            border-radius: 18px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }

        .btn-green {
            background: #8bd22f;
            border: none;
            padding: 12px 25px;
            border-radius: 12px;
            font-weight: 600;
            color: #1a3a2a;
            text-decoration: none;
            display: inline-block;
        }

        .btn-green:hover {
            background: #76c023;
        }

        .btn-outline-custom {
            border: 1px solid #ddd;
            border-radius: 12px;
            padding: 12px 25px;
            font-weight: 500;
            background: white;
            color: #333;
            text-decoration: none;
            display: inline-block;
        }

        /* Validation styles */
        .form-control.is-invalid {
            border-color: #dc3545;
            background-image: none;
        }

        .form-control.is-valid {
            border-color: #28a745;
            background-image: none;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: none;
        }

        .error-message.show {
            display: block;
        }

        .char-counter {
            color: #6c757d;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .char-counter.invalid {
            color: #dc3545;
            font-weight: bold;
        }

        .file-error {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: none;
        }

        .file-error.show {
            display: block;
        }

        /* Symfony form errors */
        .form-error {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: block;
        }

        .form_error_list {
            list-style: none;
            padding: 0;
            margin: 0.5rem 0 0 0;
        }

        .form_error_list li {
            color: #dc3545;
            font-size: 0.875rem;
            margin-bottom: 0.25rem;
        }

    </style>
</head>
<body>
    <!-- The sidebar will be included in each page's body block -->
    {% block body %}{% endblock %}
    
    <script src=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js\"></script>
    <script src=\"https://unpkg.com/leaflet/dist/leaflet.js\"></script>
    {% block javascripts %}{% endblock %}
</body>
</html>", "base.html.twig", "C:\\Users\\Mega-PC\\Desktop\\mon-projet\\templates\\base.html.twig");
    }
}

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

/* zone_polluee/qr.html.twig */
class __TwigTemplate_c1976f35a566b2a06113149b02098097 extends Template
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

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doGetParent(array $context): bool|string|Template|TemplateWrapper
    {
        // line 1
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "zone_polluee/qr.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "zone_polluee/qr.html.twig"));

        $this->parent = $this->load("base.html.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

    }

    // line 3
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

        yield "QR Code - ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["zone"]) || array_key_exists("zone", $context) ? $context["zone"] : (function () { throw new RuntimeError('Variable "zone" does not exist.', 3, $this->source); })()), "nomZone", [], "any", false, false, false, 3), "html", null, true);
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        yield from [];
    }

    // line 5
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

        // line 6
        yield "<div class=\"d-flex\">
    <!-- Sidebar -->
    <div class=\"sidebar\">
        <div class=\"sidebar-header\">
            <h3>
                <i class=\"fas fa-recycle me-2\"></i>
                WasteWise
            </h3>
        </div>
        
        <div class=\"sidebar-menu\">
            <div class=\"menu-label\">MAIN</div>
            <a href=\"";
        // line 18
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_dashboard");
        yield "\" class=\"nav-link\">
                <i class=\"fas fa-chart-pie\"></i>
                <span>Dashboard</span>
            </a>
            <a href=\"";
        // line 22
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_zone_polluee_index");
        yield "\" class=\"nav-link active\">
                <i class=\"fas fa-map-marker-alt\"></i>
                <span>Zones Polluées</span>
            </a>
            <a href=\"";
        // line 26
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_indicateur_impact_index");
        yield "\" class=\"nav-link\">
                <i class=\"fas fa-chart-line\"></i>
                <span>Indicateurs</span>
            </a>
            <a href=\"";
        // line 30
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_map");
        yield "\" class=\"nav-link\">
                <i class=\"fas fa-map\"></i>
                <span>Carte</span>
            </a>
        </div>
        
        <div class=\"sidebar-footer\">
            <div class=\"d-flex align-items-center\">
                <i class=\"fas fa-circle text-success me-2\"></i>
                <span class=\"small\">Admin</span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class=\"w-100\">
        <div class=\"top-header d-flex justify-content-between align-items-center\">
            <nav aria-label=\"breadcrumb\">
                <ol class=\"breadcrumb mb-0\">
                    <li class=\"breadcrumb-item\"><a href=\"";
        // line 49
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_dashboard");
        yield "\">Dashboard</a></li>
                    <li class=\"breadcrumb-item\"><a href=\"";
        // line 50
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_zone_polluee_index");
        yield "\">Zones</a></li>
                    <li class=\"breadcrumb-item\"><a href=\"";
        // line 51
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_zone_polluee_show", ["id" => CoreExtension::getAttribute($this->env, $this->source, (isset($context["zone"]) || array_key_exists("zone", $context) ? $context["zone"] : (function () { throw new RuntimeError('Variable "zone" does not exist.', 51, $this->source); })()), "id", [], "any", false, false, false, 51)]), "html", null, true);
        yield "\">";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["zone"]) || array_key_exists("zone", $context) ? $context["zone"] : (function () { throw new RuntimeError('Variable "zone" does not exist.', 51, $this->source); })()), "nomZone", [], "any", false, false, false, 51), "html", null, true);
        yield "</a></li>
                    <li class=\"breadcrumb-item active\">QR Code</li>
                </ol>
            </nav>
            <div>
                <i class=\"fas fa-bell text-muted me-3\"></i>
                <i class=\"fas fa-user-circle text-muted fs-4\"></i>
            </div>
        </div>

        <div class=\"main-content\">
            <div class=\"row justify-content-center\">
                <div class=\"col-md-8\">
                    <div class=\"big-card text-center\">
                        <h4 class=\"mb-3\">QR Code pour \"";
        // line 65
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["zone"]) || array_key_exists("zone", $context) ? $context["zone"] : (function () { throw new RuntimeError('Variable "zone" does not exist.', 65, $this->source); })()), "nomZone", [], "any", false, false, false, 65), "html", null, true);
        yield "\"</h4>
                        
                        <!-- Pollution level badge -->
                        <div class=\"mb-4\">
                            <span class=\"badge bg-";
        // line 69
        yield (((CoreExtension::getAttribute($this->env, $this->source, (isset($context["zone"]) || array_key_exists("zone", $context) ? $context["zone"] : (function () { throw new RuntimeError('Variable "zone" does not exist.', 69, $this->source); })()), "niveauPollution", [], "any", false, false, false, 69) >= 7)) ? ("danger") : ((((CoreExtension::getAttribute($this->env, $this->source, (isset($context["zone"]) || array_key_exists("zone", $context) ? $context["zone"] : (function () { throw new RuntimeError('Variable "zone" does not exist.', 69, $this->source); })()), "niveauPollution", [], "any", false, false, false, 69) >= 4)) ? ("warning") : ("success"))));
        yield " fs-6 p-2\">
                                Niveau ";
        // line 70
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["zone"]) || array_key_exists("zone", $context) ? $context["zone"] : (function () { throw new RuntimeError('Variable "zone" does not exist.', 70, $this->source); })()), "niveauPollution", [], "any", false, false, false, 70), "html", null, true);
        yield "/10
                            </span>
                        </div>
                        
                        <!-- QR Code display -->
                        <div class=\"mb-4 p-4 bg-light rounded-3 d-inline-block\">
                            <img src=\"data:image/png;base64,";
        // line 76
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["qr_png"]) || array_key_exists("qr_png", $context) ? $context["qr_png"] : (function () { throw new RuntimeError('Variable "qr_png" does not exist.', 76, $this->source); })()), "html", null, true);
        yield "\" 
                                 alt=\"QR Code pour ";
        // line 77
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["zone"]) || array_key_exists("zone", $context) ? $context["zone"] : (function () { throw new RuntimeError('Variable "zone" does not exist.', 77, $this->source); })()), "nomZone", [], "any", false, false, false, 77), "html", null, true);
        yield "\"
                                 style=\"border: 5px solid ";
        // line 78
        yield (((CoreExtension::getAttribute($this->env, $this->source, (isset($context["zone"]) || array_key_exists("zone", $context) ? $context["zone"] : (function () { throw new RuntimeError('Variable "zone" does not exist.', 78, $this->source); })()), "niveauPollution", [], "any", false, false, false, 78) >= 7)) ? ("#dc3545") : ((((CoreExtension::getAttribute($this->env, $this->source, (isset($context["zone"]) || array_key_exists("zone", $context) ? $context["zone"] : (function () { throw new RuntimeError('Variable "zone" does not exist.', 78, $this->source); })()), "niveauPollution", [], "any", false, false, false, 78) >= 4)) ? ("#ffc107") : ("#28a745"))));
        yield "; 
                                        border-radius: 10px;
                                        max-width: 100%;\">
                        </div>
                        
                        <!-- Scan info -->
                        <div class=\"alert alert-info mb-4\">
                            <i class=\"fas fa-info-circle me-2\"></i>
                            Scannez ce code pour voir la zone sur Google Maps
                        </div>
                        
                        <!-- Zone coordinates -->
                        <div class=\"bg-light p-3 rounded-3 mb-4\">
                            <p class=\"mb-1\"><strong>Coordonnées GPS:</strong></p>
                            <code class=\"fs-5\">";
        // line 92
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["zone"]) || array_key_exists("zone", $context) ? $context["zone"] : (function () { throw new RuntimeError('Variable "zone" does not exist.', 92, $this->source); })()), "coordonneesGps", [], "any", false, false, false, 92), "html", null, true);
        yield "</code>
                        </div>
                        
                        <!-- Download buttons -->
                        <div class=\"d-flex gap-2 justify-content-center\">
                            <a href=\"";
        // line 97
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_zone_polluee_qr_download_png", ["id" => CoreExtension::getAttribute($this->env, $this->source, (isset($context["zone"]) || array_key_exists("zone", $context) ? $context["zone"] : (function () { throw new RuntimeError('Variable "zone" does not exist.', 97, $this->source); })()), "id", [], "any", false, false, false, 97)]), "html", null, true);
        yield "\" 
                               class=\"btn btn-green\">
                                <i class=\"fas fa-download me-2\"></i>
                                Télécharger QR Code
                            </a>
                            <a href=\"";
        // line 102
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_zone_polluee_show", ["id" => CoreExtension::getAttribute($this->env, $this->source, (isset($context["zone"]) || array_key_exists("zone", $context) ? $context["zone"] : (function () { throw new RuntimeError('Variable "zone" does not exist.', 102, $this->source); })()), "id", [], "any", false, false, false, 102)]), "html", null, true);
        yield "\" 
                               class=\"btn btn-outline-custom\">
                                <i class=\"fas fa-arrow-left me-2\"></i>
                                Retour
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "zone_polluee/qr.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  246 => 102,  238 => 97,  230 => 92,  213 => 78,  209 => 77,  205 => 76,  196 => 70,  192 => 69,  185 => 65,  166 => 51,  162 => 50,  158 => 49,  136 => 30,  129 => 26,  122 => 22,  115 => 18,  101 => 6,  88 => 5,  64 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}QR Code - {{ zone.nomZone }}{% endblock %}

{% block body %}
<div class=\"d-flex\">
    <!-- Sidebar -->
    <div class=\"sidebar\">
        <div class=\"sidebar-header\">
            <h3>
                <i class=\"fas fa-recycle me-2\"></i>
                WasteWise
            </h3>
        </div>
        
        <div class=\"sidebar-menu\">
            <div class=\"menu-label\">MAIN</div>
            <a href=\"{{ path('admin_dashboard') }}\" class=\"nav-link\">
                <i class=\"fas fa-chart-pie\"></i>
                <span>Dashboard</span>
            </a>
            <a href=\"{{ path('app_zone_polluee_index') }}\" class=\"nav-link active\">
                <i class=\"fas fa-map-marker-alt\"></i>
                <span>Zones Polluées</span>
            </a>
            <a href=\"{{ path('app_indicateur_impact_index') }}\" class=\"nav-link\">
                <i class=\"fas fa-chart-line\"></i>
                <span>Indicateurs</span>
            </a>
            <a href=\"{{ path('app_map') }}\" class=\"nav-link\">
                <i class=\"fas fa-map\"></i>
                <span>Carte</span>
            </a>
        </div>
        
        <div class=\"sidebar-footer\">
            <div class=\"d-flex align-items-center\">
                <i class=\"fas fa-circle text-success me-2\"></i>
                <span class=\"small\">Admin</span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class=\"w-100\">
        <div class=\"top-header d-flex justify-content-between align-items-center\">
            <nav aria-label=\"breadcrumb\">
                <ol class=\"breadcrumb mb-0\">
                    <li class=\"breadcrumb-item\"><a href=\"{{ path('admin_dashboard') }}\">Dashboard</a></li>
                    <li class=\"breadcrumb-item\"><a href=\"{{ path('app_zone_polluee_index') }}\">Zones</a></li>
                    <li class=\"breadcrumb-item\"><a href=\"{{ path('app_zone_polluee_show', {'id': zone.id}) }}\">{{ zone.nomZone }}</a></li>
                    <li class=\"breadcrumb-item active\">QR Code</li>
                </ol>
            </nav>
            <div>
                <i class=\"fas fa-bell text-muted me-3\"></i>
                <i class=\"fas fa-user-circle text-muted fs-4\"></i>
            </div>
        </div>

        <div class=\"main-content\">
            <div class=\"row justify-content-center\">
                <div class=\"col-md-8\">
                    <div class=\"big-card text-center\">
                        <h4 class=\"mb-3\">QR Code pour \"{{ zone.nomZone }}\"</h4>
                        
                        <!-- Pollution level badge -->
                        <div class=\"mb-4\">
                            <span class=\"badge bg-{{ zone.niveauPollution >= 7 ? 'danger' : (zone.niveauPollution >= 4 ? 'warning' : 'success') }} fs-6 p-2\">
                                Niveau {{ zone.niveauPollution }}/10
                            </span>
                        </div>
                        
                        <!-- QR Code display -->
                        <div class=\"mb-4 p-4 bg-light rounded-3 d-inline-block\">
                            <img src=\"data:image/png;base64,{{ qr_png }}\" 
                                 alt=\"QR Code pour {{ zone.nomZone }}\"
                                 style=\"border: 5px solid {{ zone.niveauPollution >= 7 ? '#dc3545' : (zone.niveauPollution >= 4 ? '#ffc107' : '#28a745') }}; 
                                        border-radius: 10px;
                                        max-width: 100%;\">
                        </div>
                        
                        <!-- Scan info -->
                        <div class=\"alert alert-info mb-4\">
                            <i class=\"fas fa-info-circle me-2\"></i>
                            Scannez ce code pour voir la zone sur Google Maps
                        </div>
                        
                        <!-- Zone coordinates -->
                        <div class=\"bg-light p-3 rounded-3 mb-4\">
                            <p class=\"mb-1\"><strong>Coordonnées GPS:</strong></p>
                            <code class=\"fs-5\">{{ zone.coordonneesGps }}</code>
                        </div>
                        
                        <!-- Download buttons -->
                        <div class=\"d-flex gap-2 justify-content-center\">
                            <a href=\"{{ path('app_zone_polluee_qr_download_png', {'id': zone.id}) }}\" 
                               class=\"btn btn-green\">
                                <i class=\"fas fa-download me-2\"></i>
                                Télécharger QR Code
                            </a>
                            <a href=\"{{ path('app_zone_polluee_show', {'id': zone.id}) }}\" 
                               class=\"btn btn-outline-custom\">
                                <i class=\"fas fa-arrow-left me-2\"></i>
                                Retour
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{% endblock %}", "zone_polluee/qr.html.twig", "C:\\Users\\Mega-PC\\Desktop\\mon-projet\\templates\\zone_polluee\\qr.html.twig");
    }
}

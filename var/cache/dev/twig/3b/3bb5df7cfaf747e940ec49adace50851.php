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

/* zone_polluee/show.html.twig */
class __TwigTemplate_e4d43915cdf16faa72098e7cbecdc04a extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "zone_polluee/show.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "zone_polluee/show.html.twig"));

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

        yield "Détails de la zone";
        
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
        <!-- Top Header -->
        <div class=\"top-header d-flex justify-content-between align-items-center\">
            <nav aria-label=\"breadcrumb\">
                <ol class=\"breadcrumb mb-0\">
                    <li class=\"breadcrumb-item\"><a href=\"";
        // line 46
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_dashboard");
        yield "\">Dashboard</a></li>
                    <li class=\"breadcrumb-item\"><a href=\"";
        // line 47
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_zone_polluee_index");
        yield "\">Zones</a></li>
                    <li class=\"breadcrumb-item active\">Détails</li>
                </ol>
            </nav>
            <div>
                <i class=\"fas fa-bell text-muted me-3\"></i>
                <i class=\"fas fa-user-circle text-muted fs-4\"></i>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class=\"main-content\">
            <div class=\"row justify-content-center\">
                <div class=\"col-md-8\">
                    <div class=\"big-card\">
                        <div class=\"d-flex justify-content-between align-items-center mb-4\">
                            <h4 class=\"mb-0\">";
        // line 63
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["zone"]) || array_key_exists("zone", $context) ? $context["zone"] : (function () { throw new RuntimeError('Variable "zone" does not exist.', 63, $this->source); })()), "nomZone", [], "any", false, false, false, 63), "html", null, true);
        yield "</h4>
                            <span class=\"badge bg-";
        // line 64
        yield (((CoreExtension::getAttribute($this->env, $this->source, (isset($context["zone"]) || array_key_exists("zone", $context) ? $context["zone"] : (function () { throw new RuntimeError('Variable "zone" does not exist.', 64, $this->source); })()), "niveauPollution", [], "any", false, false, false, 64) <= 3)) ? ("success") : ((((CoreExtension::getAttribute($this->env, $this->source, (isset($context["zone"]) || array_key_exists("zone", $context) ? $context["zone"] : (function () { throw new RuntimeError('Variable "zone" does not exist.', 64, $this->source); })()), "niveauPollution", [], "any", false, false, false, 64) <= 6)) ? ("warning") : ("danger"))));
        yield " fs-6 p-2\">
                                Niveau ";
        // line 65
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["zone"]) || array_key_exists("zone", $context) ? $context["zone"] : (function () { throw new RuntimeError('Variable "zone" does not exist.', 65, $this->source); })()), "niveauPollution", [], "any", false, false, false, 65), "html", null, true);
        yield "/10
                            </span>
                        </div>
                        
                        <div class=\"row g-4\">
                            <div class=\"col-md-6\">
                                <div class=\"stat-card\">
                                    <div class=\"d-flex align-items-center\">
                                        <div class=\"stat-icon me-3\">
                                            <i class=\"fas fa-map-pin fs-4\"></i>
                                        </div>
                                        <div>
                                            <small class=\"text-muted d-block\">Coordonnées GPS</small>
                                            <h5 class=\"mb-0\">";
        // line 78
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["zone"]) || array_key_exists("zone", $context) ? $context["zone"] : (function () { throw new RuntimeError('Variable "zone" does not exist.', 78, $this->source); })()), "coordonneesGps", [], "any", false, false, false, 78), "html", null, true);
        yield "</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class=\"col-md-6\">
                                <div class=\"stat-card\">
                                    <div class=\"d-flex align-items-center\">
                                        <div class=\"stat-icon me-3\">
                                            <i class=\"fas fa-calendar fs-4\"></i>
                                        </div>
                                        <div>
                                            <small class=\"text-muted d-block\">Date d'identification</small>
                                            <h5 class=\"mb-0\">";
        // line 91
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, (isset($context["zone"]) || array_key_exists("zone", $context) ? $context["zone"] : (function () { throw new RuntimeError('Variable "zone" does not exist.', 91, $this->source); })()), "dateIdentification", [], "any", false, false, false, 91), "d/m/Y"), "html", null, true);
        yield "</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        ";
        // line 98
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, (isset($context["zone"]) || array_key_exists("zone", $context) ? $context["zone"] : (function () { throw new RuntimeError('Variable "zone" does not exist.', 98, $this->source); })()), "indicateur", [], "any", false, false, false, 98)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 99
            yield "                            <hr class=\"my-4\">
                            <h5 class=\"mb-3\">Indicateur associé</h5>
                            <div class=\"row g-3\">
                                <div class=\"col-md-4\">
                                    <div class=\"bg-light p-3 rounded-3\">
                                        <small class=\"text-muted d-block\">Déchets récoltés</small>
                                        <h5 class=\"mb-0\">";
            // line 105
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["zone"]) || array_key_exists("zone", $context) ? $context["zone"] : (function () { throw new RuntimeError('Variable "zone" does not exist.', 105, $this->source); })()), "indicateur", [], "any", false, false, false, 105), "totalKgRecoltes", [], "any", false, false, false, 105), "html", null, true);
            yield " kg</h5>
                                    </div>
                                </div>
                                <div class=\"col-md-4\">
                                    <div class=\"bg-light p-3 rounded-3\">
                                        <small class=\"text-muted d-block\">CO2 évité</small>
                                        <h5 class=\"mb-0\">";
            // line 111
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["zone"]) || array_key_exists("zone", $context) ? $context["zone"] : (function () { throw new RuntimeError('Variable "zone" does not exist.', 111, $this->source); })()), "indicateur", [], "any", false, false, false, 111), "co2Evite", [], "any", false, false, false, 111), "html", null, true);
            yield " kg</h5>
                                    </div>
                                </div>
                                <div class=\"col-md-4\">
                                    <div class=\"bg-light p-3 rounded-3\">
                                        <small class=\"text-muted d-block\">Date de calcul</small>
                                        <h5 class=\"mb-0\">";
            // line 117
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["zone"]) || array_key_exists("zone", $context) ? $context["zone"] : (function () { throw new RuntimeError('Variable "zone" does not exist.', 117, $this->source); })()), "indicateur", [], "any", false, false, false, 117), "dateCalcul", [], "any", false, false, false, 117), "d/m/Y"), "html", null, true);
            yield "</h5>
                                    </div>
                                </div>
                            </div>
                        ";
        }
        // line 122
        yield "                        
                        <div class=\"d-flex gap-2 mt-4\">
                            <a href=\"";
        // line 124
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_zone_polluee_index");
        yield "\" class=\"btn-outline-custom\">
                                <i class=\"fas fa-arrow-left me-2\"></i>Retour
                            </a>
                            <a href=\"";
        // line 127
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_zone_polluee_edit", ["id" => CoreExtension::getAttribute($this->env, $this->source, (isset($context["zone"]) || array_key_exists("zone", $context) ? $context["zone"] : (function () { throw new RuntimeError('Variable "zone" does not exist.', 127, $this->source); })()), "id", [], "any", false, false, false, 127)]), "html", null, true);
        yield "\" class=\"btn btn-green\">
                                <i class=\"fas fa-edit me-2\"></i>Modifier
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
        return "zone_polluee/show.html.twig";
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
        return array (  270 => 127,  264 => 124,  260 => 122,  252 => 117,  243 => 111,  234 => 105,  226 => 99,  224 => 98,  214 => 91,  198 => 78,  182 => 65,  178 => 64,  174 => 63,  155 => 47,  151 => 46,  128 => 26,  121 => 22,  114 => 18,  100 => 6,  87 => 5,  64 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Détails de la zone{% endblock %}

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
        <!-- Top Header -->
        <div class=\"top-header d-flex justify-content-between align-items-center\">
            <nav aria-label=\"breadcrumb\">
                <ol class=\"breadcrumb mb-0\">
                    <li class=\"breadcrumb-item\"><a href=\"{{ path('admin_dashboard') }}\">Dashboard</a></li>
                    <li class=\"breadcrumb-item\"><a href=\"{{ path('app_zone_polluee_index') }}\">Zones</a></li>
                    <li class=\"breadcrumb-item active\">Détails</li>
                </ol>
            </nav>
            <div>
                <i class=\"fas fa-bell text-muted me-3\"></i>
                <i class=\"fas fa-user-circle text-muted fs-4\"></i>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class=\"main-content\">
            <div class=\"row justify-content-center\">
                <div class=\"col-md-8\">
                    <div class=\"big-card\">
                        <div class=\"d-flex justify-content-between align-items-center mb-4\">
                            <h4 class=\"mb-0\">{{ zone.nomZone }}</h4>
                            <span class=\"badge bg-{{ zone.niveauPollution <= 3 ? 'success' : (zone.niveauPollution <= 6 ? 'warning' : 'danger') }} fs-6 p-2\">
                                Niveau {{ zone.niveauPollution }}/10
                            </span>
                        </div>
                        
                        <div class=\"row g-4\">
                            <div class=\"col-md-6\">
                                <div class=\"stat-card\">
                                    <div class=\"d-flex align-items-center\">
                                        <div class=\"stat-icon me-3\">
                                            <i class=\"fas fa-map-pin fs-4\"></i>
                                        </div>
                                        <div>
                                            <small class=\"text-muted d-block\">Coordonnées GPS</small>
                                            <h5 class=\"mb-0\">{{ zone.coordonneesGps }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class=\"col-md-6\">
                                <div class=\"stat-card\">
                                    <div class=\"d-flex align-items-center\">
                                        <div class=\"stat-icon me-3\">
                                            <i class=\"fas fa-calendar fs-4\"></i>
                                        </div>
                                        <div>
                                            <small class=\"text-muted d-block\">Date d'identification</small>
                                            <h5 class=\"mb-0\">{{ zone.dateIdentification|date('d/m/Y') }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        {% if zone.indicateur %}
                            <hr class=\"my-4\">
                            <h5 class=\"mb-3\">Indicateur associé</h5>
                            <div class=\"row g-3\">
                                <div class=\"col-md-4\">
                                    <div class=\"bg-light p-3 rounded-3\">
                                        <small class=\"text-muted d-block\">Déchets récoltés</small>
                                        <h5 class=\"mb-0\">{{ zone.indicateur.totalKgRecoltes }} kg</h5>
                                    </div>
                                </div>
                                <div class=\"col-md-4\">
                                    <div class=\"bg-light p-3 rounded-3\">
                                        <small class=\"text-muted d-block\">CO2 évité</small>
                                        <h5 class=\"mb-0\">{{ zone.indicateur.co2Evite }} kg</h5>
                                    </div>
                                </div>
                                <div class=\"col-md-4\">
                                    <div class=\"bg-light p-3 rounded-3\">
                                        <small class=\"text-muted d-block\">Date de calcul</small>
                                        <h5 class=\"mb-0\">{{ zone.indicateur.dateCalcul|date('d/m/Y') }}</h5>
                                    </div>
                                </div>
                            </div>
                        {% endif %}
                        
                        <div class=\"d-flex gap-2 mt-4\">
                            <a href=\"{{ path('app_zone_polluee_index') }}\" class=\"btn-outline-custom\">
                                <i class=\"fas fa-arrow-left me-2\"></i>Retour
                            </a>
                            <a href=\"{{ path('app_zone_polluee_edit', {'id': zone.id}) }}\" class=\"btn btn-green\">
                                <i class=\"fas fa-edit me-2\"></i>Modifier
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{% endblock %}", "zone_polluee/show.html.twig", "C:\\Users\\Mega-PC\\Desktop\\mon-projet\\templates\\zone_polluee\\show.html.twig");
    }
}

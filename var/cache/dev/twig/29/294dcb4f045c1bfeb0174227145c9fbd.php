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

/* admin/dashboard.html.twig */
class __TwigTemplate_260a340f9bad3a1024f97cf03134c94d extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "admin/dashboard.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "admin/dashboard.html.twig"));

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

        yield "Dashboard Admin - WasteWise TN";
        
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
        // line 19
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_dashboard");
        yield "\" class=\"nav-link active\">
                <i class=\"fas fa-chart-pie\"></i>
                <span>Dashboard</span>
            </a>
            
            <a href=\"";
        // line 24
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_zone_polluee_index");
        yield "\" class=\"nav-link\">
                <i class=\"fas fa-map-marker-alt\"></i>
                <span>Zones Polluées</span>
            </a>
            
            <a href=\"";
        // line 29
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_indicateur_impact_index");
        yield "\" class=\"nav-link\">
                <i class=\"fas fa-chart-line\"></i>
                <span>Indicateurs d'Impact</span>
            </a>

            <a href=\"";
        // line 34
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_map");
        yield "\" class=\"nav-link\">
                <i class=\"fas fa-map\"></i>
                <span>Carte</span>
            </a>

            <!-- ADD THIS NEW SECTION -->
            <div class=\"menu-label\">ANALYTICS</div>

            <a href=\"";
        // line 42
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_qr_dashboard");
        yield "\" class=\"nav-link\">
                <i class=\"fas fa-qrcode\"></i>
                <span>QR Analytics</span>
            </a>
        </div>
        
        <div class=\"sidebar-footer\">
            <div class=\"d-flex align-items-center\">
                <i class=\"fas fa-circle text-success me-2\" style=\"font-size: 10px;\"></i>
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
                    <li class=\"breadcrumb-item\"><a href=\"#\" class=\"text-decoration-none\">Admin</a></li>
                    <li class=\"breadcrumb-item active\" aria-current=\"page\">Dashboard</li>
                </ol>
            </nav>
            
            <div class=\"d-flex align-items-center gap-3\">
                <i class=\"fas fa-bell text-muted\"></i>
                <i class=\"fas fa-user-circle text-muted\" style=\"font-size: 1.5rem;\"></i>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class=\"main-content\">
            <!-- Hero Banner -->
            <div class=\"hero\">
                <h1 class=\"display-6 fw-bold mb-3\">Dashboard Administrateur</h1>
                <p class=\"mb-0 opacity-75\">Module 6 - Gestion de l'Impact et des Zones Polluées</p>
            </div>

            ";
        // line 81
        $context["totalZones"] = Twig\Extension\CoreExtension::length($this->env->getCharset(), ((array_key_exists("zones", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["zones"]) || array_key_exists("zones", $context) ? $context["zones"] : (function () { throw new RuntimeError('Variable "zones" does not exist.', 81, $this->source); })()), [])) : ([])));
        // line 82
        yield "            ";
        $context["totalIndicateurs"] = Twig\Extension\CoreExtension::length($this->env->getCharset(), ((array_key_exists("indicateurs", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["indicateurs"]) || array_key_exists("indicateurs", $context) ? $context["indicateurs"] : (function () { throw new RuntimeError('Variable "indicateurs" does not exist.', 82, $this->source); })()), [])) : ([])));
        // line 83
        yield "            ";
        $context["totalKg"] = Twig\Extension\CoreExtension::reduce($this->env, (isset($context["indicateurs"]) || array_key_exists("indicateurs", $context) ? $context["indicateurs"] : (function () { throw new RuntimeError('Variable "indicateurs" does not exist.', 83, $this->source); })()), function ($__carry__, $__i__) use ($context, $macros) { $context["carry"] = $__carry__; $context["i"] = $__i__; return ((isset($context["carry"]) || array_key_exists("carry", $context) ? $context["carry"] : (function () { throw new RuntimeError('Variable "carry" does not exist.', 83, $this->source); })()) + CoreExtension::getAttribute($this->env, $this->source, (isset($context["i"]) || array_key_exists("i", $context) ? $context["i"] : (function () { throw new RuntimeError('Variable "i" does not exist.', 83, $this->source); })()), "totalKgRecoltes", [], "any", false, false, false, 83)); }, 0);
        // line 84
        yield "            ";
        $context["totalCo2"] = Twig\Extension\CoreExtension::reduce($this->env, (isset($context["indicateurs"]) || array_key_exists("indicateurs", $context) ? $context["indicateurs"] : (function () { throw new RuntimeError('Variable "indicateurs" does not exist.', 84, $this->source); })()), function ($__carry__, $__i__) use ($context, $macros) { $context["carry"] = $__carry__; $context["i"] = $__i__; return ((isset($context["carry"]) || array_key_exists("carry", $context) ? $context["carry"] : (function () { throw new RuntimeError('Variable "carry" does not exist.', 84, $this->source); })()) + CoreExtension::getAttribute($this->env, $this->source, (isset($context["i"]) || array_key_exists("i", $context) ? $context["i"] : (function () { throw new RuntimeError('Variable "i" does not exist.', 84, $this->source); })()), "co2Evite", [], "any", false, false, false, 84)); }, 0);
        // line 85
        yield "            ";
        $context["moyennePollution"] = (Twig\Extension\CoreExtension::reduce($this->env, (isset($context["zones"]) || array_key_exists("zones", $context) ? $context["zones"] : (function () { throw new RuntimeError('Variable "zones" does not exist.', 85, $this->source); })()), function ($__carry__, $__z__) use ($context, $macros) { $context["carry"] = $__carry__; $context["z"] = $__z__; return ((isset($context["carry"]) || array_key_exists("carry", $context) ? $context["carry"] : (function () { throw new RuntimeError('Variable "carry" does not exist.', 85, $this->source); })()) + CoreExtension::getAttribute($this->env, $this->source, (isset($context["z"]) || array_key_exists("z", $context) ? $context["z"] : (function () { throw new RuntimeError('Variable "z" does not exist.', 85, $this->source); })()), "niveauPollution", [], "any", false, false, false, 85)); }, 0) / (((isset($context["totalZones"]) || array_key_exists("totalZones", $context) ? $context["totalZones"] : (function () { throw new RuntimeError('Variable "totalZones" does not exist.', 85, $this->source); })())) ? ($context["totalZones"]) : (1)));
        // line 86
        yield "            ";
        $context["zonesCritiques"] = Twig\Extension\CoreExtension::length($this->env->getCharset(), Twig\Extension\CoreExtension::filter($this->env, (isset($context["zones"]) || array_key_exists("zones", $context) ? $context["zones"] : (function () { throw new RuntimeError('Variable "zones" does not exist.', 86, $this->source); })()), function ($__z__) use ($context, $macros) { $context["z"] = $__z__; return (CoreExtension::getAttribute($this->env, $this->source, (isset($context["z"]) || array_key_exists("z", $context) ? $context["z"] : (function () { throw new RuntimeError('Variable "z" does not exist.', 86, $this->source); })()), "niveauPollution", [], "any", false, false, false, 86) >= 7); }));
        // line 87
        yield "
            <!-- Cartes de statistiques -->
            <div class=\"row g-4 mb-4\">
                <div class=\"col-sm-6 col-lg-3\">
                    <div class=\"stat-card d-flex justify-content-between align-items-center\">
                        <div>
                            <span class=\"text-muted\">Zones Polluées</span>
                            <h3 class=\"mb-0 mt-2\">";
        // line 94
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["totalZones"]) || array_key_exists("totalZones", $context) ? $context["totalZones"] : (function () { throw new RuntimeError('Variable "totalZones" does not exist.', 94, $this->source); })()), "html", null, true);
        yield "</h3>
                        </div>
                        <div class=\"stat-icon\">
                            <i class=\"fas fa-map-marker-alt fa-2x\"></i>
                        </div>
                    </div>
                </div>
                
                <div class=\"col-sm-6 col-lg-3\">
                    <div class=\"stat-card d-flex justify-content-between align-items-center\">
                        <div>
                            <span class=\"text-muted\">Indicateurs</span>
                            <h3 class=\"mb-0 mt-2\">";
        // line 106
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["totalIndicateurs"]) || array_key_exists("totalIndicateurs", $context) ? $context["totalIndicateurs"] : (function () { throw new RuntimeError('Variable "totalIndicateurs" does not exist.', 106, $this->source); })()), "html", null, true);
        yield "</h3>
                        </div>
                        <div class=\"stat-icon\">
                            <i class=\"fas fa-chart-line fa-2x\"></i>
                        </div>
                    </div>
                </div>
                
                <div class=\"col-sm-6 col-lg-3\">
                    <div class=\"stat-card d-flex justify-content-between align-items-center\">
                        <div>
                            <span class=\"text-muted\">Déchets collectés</span>
                            <h3 class=\"mb-0 mt-2\">";
        // line 118
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::round((isset($context["totalKg"]) || array_key_exists("totalKg", $context) ? $context["totalKg"] : (function () { throw new RuntimeError('Variable "totalKg" does not exist.', 118, $this->source); })())), "html", null, true);
        yield " kg</h3>
                        </div>
                        <div class=\"stat-icon\">
                            <i class=\"fas fa-trash-alt fa-2x\"></i>
                        </div>
                    </div>
                </div>
                
                <div class=\"col-sm-6 col-lg-3\">
                    <div class=\"stat-card d-flex justify-content-between align-items-center\">
                        <div>
                            <span class=\"text-muted\">CO₂ évité</span>
                            <h3 class=\"mb-0 mt-2\">";
        // line 130
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::round((isset($context["totalCo2"]) || array_key_exists("totalCo2", $context) ? $context["totalCo2"] : (function () { throw new RuntimeError('Variable "totalCo2" does not exist.', 130, $this->source); })())), "html", null, true);
        yield " kg</h3>
                        </div>
                        <div class=\"stat-icon\">
                            <i class=\"fas fa-leaf fa-2x\"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cartes d'accès rapide -->
            <div class=\"row g-4\">
                <div class=\"col-md-6\">
                    <div class=\"big-card h-100\">
                        <div class=\"d-flex align-items-center mb-3\">
                            <div class=\"stat-icon me-3\">
                                <i class=\"fas fa-map-marker-alt fs-3\"></i>
                            </div>
                            <h4 class=\"mb-0\">Zones Polluées</h4>
                        </div>
                        <p class=\"text-muted mb-3\">Gérez les zones à risque, consultez les niveaux de pollution.</p>
                        <div class=\"d-flex gap-2\">
                            <a href=\"";
        // line 151
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_zone_polluee_index");
        yield "\" class=\"btn btn-green\">Voir toutes</a>
                            <a href=\"";
        // line 152
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_zone_polluee_new");
        yield "\" class=\"btn-outline-custom\">Ajouter</a>
                        </div>
                    </div>
                </div>
                <div class=\"col-md-6\">
                    <div class=\"big-card h-100\">
                        <div class=\"d-flex align-items-center mb-3\">
                            <div class=\"stat-icon me-3\">
                                <i class=\"fas fa-chart-line fs-3\"></i>
                            </div>
                            <h4 class=\"mb-0\">Indicateurs d'Impact</h4>
                        </div>
                        <p class=\"text-muted mb-3\">Suivez les déchets collectés et le CO₂ évité.</p>
                        <div class=\"d-flex gap-2\">
                            <a href=\"";
        // line 166
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_indicateur_impact_index");
        yield "\" class=\"btn btn-green\">Voir tous</a>
                            <a href=\"";
        // line 167
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_indicateur_impact_new");
        yield "\" class=\"btn-outline-custom\">Ajouter</a>
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
        return "admin/dashboard.html.twig";
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
        return array (  312 => 167,  308 => 166,  291 => 152,  287 => 151,  263 => 130,  248 => 118,  233 => 106,  218 => 94,  209 => 87,  206 => 86,  203 => 85,  200 => 84,  197 => 83,  194 => 82,  192 => 81,  150 => 42,  139 => 34,  131 => 29,  123 => 24,  115 => 19,  100 => 6,  87 => 5,  64 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Dashboard Admin - WasteWise TN{% endblock %}

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
            
            <a href=\"{{ path('admin_dashboard') }}\" class=\"nav-link active\">
                <i class=\"fas fa-chart-pie\"></i>
                <span>Dashboard</span>
            </a>
            
            <a href=\"{{ path('app_zone_polluee_index') }}\" class=\"nav-link\">
                <i class=\"fas fa-map-marker-alt\"></i>
                <span>Zones Polluées</span>
            </a>
            
            <a href=\"{{ path('app_indicateur_impact_index') }}\" class=\"nav-link\">
                <i class=\"fas fa-chart-line\"></i>
                <span>Indicateurs d'Impact</span>
            </a>

            <a href=\"{{ path('app_map') }}\" class=\"nav-link\">
                <i class=\"fas fa-map\"></i>
                <span>Carte</span>
            </a>

            <!-- ADD THIS NEW SECTION -->
            <div class=\"menu-label\">ANALYTICS</div>

            <a href=\"{{ path('app_qr_dashboard') }}\" class=\"nav-link\">
                <i class=\"fas fa-qrcode\"></i>
                <span>QR Analytics</span>
            </a>
        </div>
        
        <div class=\"sidebar-footer\">
            <div class=\"d-flex align-items-center\">
                <i class=\"fas fa-circle text-success me-2\" style=\"font-size: 10px;\"></i>
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
                    <li class=\"breadcrumb-item\"><a href=\"#\" class=\"text-decoration-none\">Admin</a></li>
                    <li class=\"breadcrumb-item active\" aria-current=\"page\">Dashboard</li>
                </ol>
            </nav>
            
            <div class=\"d-flex align-items-center gap-3\">
                <i class=\"fas fa-bell text-muted\"></i>
                <i class=\"fas fa-user-circle text-muted\" style=\"font-size: 1.5rem;\"></i>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class=\"main-content\">
            <!-- Hero Banner -->
            <div class=\"hero\">
                <h1 class=\"display-6 fw-bold mb-3\">Dashboard Administrateur</h1>
                <p class=\"mb-0 opacity-75\">Module 6 - Gestion de l'Impact et des Zones Polluées</p>
            </div>

            {% set totalZones = zones|default([])|length %}
            {% set totalIndicateurs = indicateurs|default([])|length %}
            {% set totalKg = indicateurs|reduce((carry, i) => carry + i.totalKgRecoltes, 0) %}
            {% set totalCo2 = indicateurs|reduce((carry, i) => carry + i.co2Evite, 0) %}
            {% set moyennePollution = zones|reduce((carry, z) => carry + z.niveauPollution, 0) / (totalZones ?: 1) %}
            {% set zonesCritiques = zones|filter(z => z.niveauPollution >= 7)|length %}

            <!-- Cartes de statistiques -->
            <div class=\"row g-4 mb-4\">
                <div class=\"col-sm-6 col-lg-3\">
                    <div class=\"stat-card d-flex justify-content-between align-items-center\">
                        <div>
                            <span class=\"text-muted\">Zones Polluées</span>
                            <h3 class=\"mb-0 mt-2\">{{ totalZones }}</h3>
                        </div>
                        <div class=\"stat-icon\">
                            <i class=\"fas fa-map-marker-alt fa-2x\"></i>
                        </div>
                    </div>
                </div>
                
                <div class=\"col-sm-6 col-lg-3\">
                    <div class=\"stat-card d-flex justify-content-between align-items-center\">
                        <div>
                            <span class=\"text-muted\">Indicateurs</span>
                            <h3 class=\"mb-0 mt-2\">{{ totalIndicateurs }}</h3>
                        </div>
                        <div class=\"stat-icon\">
                            <i class=\"fas fa-chart-line fa-2x\"></i>
                        </div>
                    </div>
                </div>
                
                <div class=\"col-sm-6 col-lg-3\">
                    <div class=\"stat-card d-flex justify-content-between align-items-center\">
                        <div>
                            <span class=\"text-muted\">Déchets collectés</span>
                            <h3 class=\"mb-0 mt-2\">{{ totalKg|round }} kg</h3>
                        </div>
                        <div class=\"stat-icon\">
                            <i class=\"fas fa-trash-alt fa-2x\"></i>
                        </div>
                    </div>
                </div>
                
                <div class=\"col-sm-6 col-lg-3\">
                    <div class=\"stat-card d-flex justify-content-between align-items-center\">
                        <div>
                            <span class=\"text-muted\">CO₂ évité</span>
                            <h3 class=\"mb-0 mt-2\">{{ totalCo2|round }} kg</h3>
                        </div>
                        <div class=\"stat-icon\">
                            <i class=\"fas fa-leaf fa-2x\"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cartes d'accès rapide -->
            <div class=\"row g-4\">
                <div class=\"col-md-6\">
                    <div class=\"big-card h-100\">
                        <div class=\"d-flex align-items-center mb-3\">
                            <div class=\"stat-icon me-3\">
                                <i class=\"fas fa-map-marker-alt fs-3\"></i>
                            </div>
                            <h4 class=\"mb-0\">Zones Polluées</h4>
                        </div>
                        <p class=\"text-muted mb-3\">Gérez les zones à risque, consultez les niveaux de pollution.</p>
                        <div class=\"d-flex gap-2\">
                            <a href=\"{{ path('app_zone_polluee_index') }}\" class=\"btn btn-green\">Voir toutes</a>
                            <a href=\"{{ path('app_zone_polluee_new') }}\" class=\"btn-outline-custom\">Ajouter</a>
                        </div>
                    </div>
                </div>
                <div class=\"col-md-6\">
                    <div class=\"big-card h-100\">
                        <div class=\"d-flex align-items-center mb-3\">
                            <div class=\"stat-icon me-3\">
                                <i class=\"fas fa-chart-line fs-3\"></i>
                            </div>
                            <h4 class=\"mb-0\">Indicateurs d'Impact</h4>
                        </div>
                        <p class=\"text-muted mb-3\">Suivez les déchets collectés et le CO₂ évité.</p>
                        <div class=\"d-flex gap-2\">
                            <a href=\"{{ path('app_indicateur_impact_index') }}\" class=\"btn btn-green\">Voir tous</a>
                            <a href=\"{{ path('app_indicateur_impact_new') }}\" class=\"btn-outline-custom\">Ajouter</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{% endblock %}", "admin/dashboard.html.twig", "C:\\Users\\Mega-PC\\Desktop\\mon-projet\\templates\\admin\\dashboard.html.twig");
    }
}

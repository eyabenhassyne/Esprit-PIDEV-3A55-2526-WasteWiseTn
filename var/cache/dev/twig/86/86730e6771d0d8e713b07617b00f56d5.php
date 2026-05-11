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

/* indicateur_impact/show.html.twig */
class __TwigTemplate_208755922d0432c1ec71ffa73cd9cd77 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "indicateur_impact/show.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "indicateur_impact/show.html.twig"));

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

        yield "Détails de l'indicateur";
        
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
        yield "\" class=\"nav-link\">
                <i class=\"fas fa-map-marker-alt\"></i>
                <span>Zones Polluées</span>
            </a>
            <a href=\"";
        // line 26
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_indicateur_impact_index");
        yield "\" class=\"nav-link active\">
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
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_indicateur_impact_index");
        yield "\">Indicateurs</a></li>
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
                        <h4 class=\"mb-4\">Indicateur #";
        // line 62
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["indicateur"]) || array_key_exists("indicateur", $context) ? $context["indicateur"] : (function () { throw new RuntimeError('Variable "indicateur" does not exist.', 62, $this->source); })()), "id", [], "any", false, false, false, 62), "html", null, true);
        yield "</h4>
                        
                        <div class=\"row g-4\">
                            <div class=\"col-md-6\">
                                <div class=\"stat-card\">
                                    <div class=\"d-flex align-items-center\">
                                        <div class=\"stat-icon me-3\">
                                            <i class=\"fas fa-trash-alt fs-4\"></i>
                                        </div>
                                        <div>
                                            <small class=\"text-muted\">Déchets récoltés</small>
                                            <h3 class=\"mb-0\">";
        // line 73
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["indicateur"]) || array_key_exists("indicateur", $context) ? $context["indicateur"] : (function () { throw new RuntimeError('Variable "indicateur" does not exist.', 73, $this->source); })()), "totalKgRecoltes", [], "any", false, false, false, 73), "html", null, true);
        yield " kg</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class=\"col-md-6\">
                                <div class=\"stat-card\">
                                    <div class=\"d-flex align-items-center\">
                                        <div class=\"stat-icon me-3\">
                                            <i class=\"fas fa-cloud fs-4\"></i>
                                        </div>
                                        <div>
                                            <small class=\"text-muted\">CO2 évité</small>
                                            <h3 class=\"mb-0\">";
        // line 86
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["indicateur"]) || array_key_exists("indicateur", $context) ? $context["indicateur"] : (function () { throw new RuntimeError('Variable "indicateur" does not exist.', 86, $this->source); })()), "co2Evite", [], "any", false, false, false, 86), "html", null, true);
        yield " kg</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class=\"row mt-4\">
                            <div class=\"col-12\">
                                <div class=\"stat-card\">
                                    <div class=\"d-flex align-items-center\">
                                        <div class=\"stat-icon me-3\">
                                            <i class=\"fas fa-calendar fs-4\"></i>
                                        </div>
                                        <div>
                                            <small class=\"text-muted\">Date de calcul</small>
                                            <h3 class=\"mb-0\">";
        // line 102
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, (isset($context["indicateur"]) || array_key_exists("indicateur", $context) ? $context["indicateur"] : (function () { throw new RuntimeError('Variable "indicateur" does not exist.', 102, $this->source); })()), "dateCalcul", [], "any", false, false, false, 102), "d/m/Y H:i"), "html", null, true);
        yield "</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <hr class=\"my-4\">
                        
                        <h5 class=\"mb-3\">Zones associées</h5>
                        ";
        // line 112
        if ((($tmp =  !Twig\Extension\CoreExtension::testEmpty(CoreExtension::getAttribute($this->env, $this->source, (isset($context["indicateur"]) || array_key_exists("indicateur", $context) ? $context["indicateur"] : (function () { throw new RuntimeError('Variable "indicateur" does not exist.', 112, $this->source); })()), "zonePolluees", [], "any", false, false, false, 112))) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 113
            yield "                            <div class=\"table-responsive\">
                                <table class=\"table table-hover\">
                                    <thead>
                                        <tr>
                                            <th>Zone</th>
                                            <th>Niveau</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ";
            // line 123
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["indicateur"]) || array_key_exists("indicateur", $context) ? $context["indicateur"] : (function () { throw new RuntimeError('Variable "indicateur" does not exist.', 123, $this->source); })()), "zonePolluees", [], "any", false, false, false, 123));
            foreach ($context['_seq'] as $context["_key"] => $context["zone"]) {
                // line 124
                yield "                                        <tr>
                                            <td>";
                // line 125
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["zone"], "nomZone", [], "any", false, false, false, 125), "html", null, true);
                yield "</td>
                                            <td>
                                                <span class=\"badge bg-";
                // line 127
                yield (((CoreExtension::getAttribute($this->env, $this->source, $context["zone"], "niveauPollution", [], "any", false, false, false, 127) <= 3)) ? ("success") : ((((CoreExtension::getAttribute($this->env, $this->source, $context["zone"], "niveauPollution", [], "any", false, false, false, 127) <= 6)) ? ("warning") : ("danger"))));
                yield "\">
                                                    ";
                // line 128
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["zone"], "niveauPollution", [], "any", false, false, false, 128), "html", null, true);
                yield "/10
                                                </span>
                                            </td>
                                            <td>
                                                <a href=\"";
                // line 132
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_zone_polluee_show", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["zone"], "id", [], "any", false, false, false, 132)]), "html", null, true);
                yield "\" class=\"btn btn-sm btn-outline-custom\">
                                                    <i class=\"fas fa-eye\"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['zone'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 138
            yield "                                    </tbody>
                                </table>
                            </div>
                        ";
        } else {
            // line 142
            yield "                            <p class=\"text-muted text-center py-3\">Aucune zone associée</p>
                        ";
        }
        // line 144
        yield "                        
                        <div class=\"d-flex gap-2 mt-4\">
                            <a href=\"";
        // line 146
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_indicateur_impact_index");
        yield "\" class=\"btn-outline-custom\">
                                <i class=\"fas fa-arrow-left me-2\"></i>Retour
                            </a>
                            <a href=\"";
        // line 149
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_indicateur_impact_edit", ["id" => CoreExtension::getAttribute($this->env, $this->source, (isset($context["indicateur"]) || array_key_exists("indicateur", $context) ? $context["indicateur"] : (function () { throw new RuntimeError('Variable "indicateur" does not exist.', 149, $this->source); })()), "id", [], "any", false, false, false, 149)]), "html", null, true);
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
        return "indicateur_impact/show.html.twig";
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
        return array (  304 => 149,  298 => 146,  294 => 144,  290 => 142,  284 => 138,  272 => 132,  265 => 128,  261 => 127,  256 => 125,  253 => 124,  249 => 123,  237 => 113,  235 => 112,  222 => 102,  203 => 86,  187 => 73,  173 => 62,  155 => 47,  151 => 46,  128 => 26,  121 => 22,  114 => 18,  100 => 6,  87 => 5,  64 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Détails de l'indicateur{% endblock %}

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
            <a href=\"{{ path('app_zone_polluee_index') }}\" class=\"nav-link\">
                <i class=\"fas fa-map-marker-alt\"></i>
                <span>Zones Polluées</span>
            </a>
            <a href=\"{{ path('app_indicateur_impact_index') }}\" class=\"nav-link active\">
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
                    <li class=\"breadcrumb-item\"><a href=\"{{ path('app_indicateur_impact_index') }}\">Indicateurs</a></li>
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
                        <h4 class=\"mb-4\">Indicateur #{{ indicateur.id }}</h4>
                        
                        <div class=\"row g-4\">
                            <div class=\"col-md-6\">
                                <div class=\"stat-card\">
                                    <div class=\"d-flex align-items-center\">
                                        <div class=\"stat-icon me-3\">
                                            <i class=\"fas fa-trash-alt fs-4\"></i>
                                        </div>
                                        <div>
                                            <small class=\"text-muted\">Déchets récoltés</small>
                                            <h3 class=\"mb-0\">{{ indicateur.totalKgRecoltes }} kg</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class=\"col-md-6\">
                                <div class=\"stat-card\">
                                    <div class=\"d-flex align-items-center\">
                                        <div class=\"stat-icon me-3\">
                                            <i class=\"fas fa-cloud fs-4\"></i>
                                        </div>
                                        <div>
                                            <small class=\"text-muted\">CO2 évité</small>
                                            <h3 class=\"mb-0\">{{ indicateur.co2Evite }} kg</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class=\"row mt-4\">
                            <div class=\"col-12\">
                                <div class=\"stat-card\">
                                    <div class=\"d-flex align-items-center\">
                                        <div class=\"stat-icon me-3\">
                                            <i class=\"fas fa-calendar fs-4\"></i>
                                        </div>
                                        <div>
                                            <small class=\"text-muted\">Date de calcul</small>
                                            <h3 class=\"mb-0\">{{ indicateur.dateCalcul|date('d/m/Y H:i') }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <hr class=\"my-4\">
                        
                        <h5 class=\"mb-3\">Zones associées</h5>
                        {% if indicateur.zonePolluees is not empty %}
                            <div class=\"table-responsive\">
                                <table class=\"table table-hover\">
                                    <thead>
                                        <tr>
                                            <th>Zone</th>
                                            <th>Niveau</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {% for zone in indicateur.zonePolluees %}
                                        <tr>
                                            <td>{{ zone.nomZone }}</td>
                                            <td>
                                                <span class=\"badge bg-{{ zone.niveauPollution <= 3 ? 'success' : (zone.niveauPollution <= 6 ? 'warning' : 'danger') }}\">
                                                    {{ zone.niveauPollution }}/10
                                                </span>
                                            </td>
                                            <td>
                                                <a href=\"{{ path('app_zone_polluee_show', {'id': zone.id}) }}\" class=\"btn btn-sm btn-outline-custom\">
                                                    <i class=\"fas fa-eye\"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        {% endfor %}
                                    </tbody>
                                </table>
                            </div>
                        {% else %}
                            <p class=\"text-muted text-center py-3\">Aucune zone associée</p>
                        {% endif %}
                        
                        <div class=\"d-flex gap-2 mt-4\">
                            <a href=\"{{ path('app_indicateur_impact_index') }}\" class=\"btn-outline-custom\">
                                <i class=\"fas fa-arrow-left me-2\"></i>Retour
                            </a>
                            <a href=\"{{ path('app_indicateur_impact_edit', {'id': indicateur.id}) }}\" class=\"btn btn-green\">
                                <i class=\"fas fa-edit me-2\"></i>Modifier
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{% endblock %}", "indicateur_impact/show.html.twig", "C:\\Users\\Mega-PC\\Desktop\\mon-projet\\templates\\indicateur_impact\\show.html.twig");
    }
}

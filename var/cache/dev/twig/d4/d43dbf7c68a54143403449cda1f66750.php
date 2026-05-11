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

/* qr_dashboard/index.html.twig */
class __TwigTemplate_98e69d904f2eb7794399907c6f0f4a73 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "qr_dashboard/index.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "qr_dashboard/index.html.twig"));

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

        yield "QR Code Dashboard";
        
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
            <a href=\"";
        // line 34
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_qr_dashboard");
        yield "\" class=\"nav-link active\">
                <i class=\"fas fa-qrcode\"></i>
                <span>QR Stats</span>
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
        // line 53
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_dashboard");
        yield "\">Dashboard</a></li>
                    <li class=\"breadcrumb-item active\">QR Analytics</li>
                </ol>
            </nav>
            <div>
                <i class=\"fas fa-bell text-muted me-3\"></i>
                <i class=\"fas fa-user-circle text-muted fs-4\"></i>
            </div>
        </div>

        <div class=\"main-content\">
            <h2 class=\"mb-4\">📊 QR Code Analytics Dashboard</h2>
            
            <!-- Stats Cards -->
            <div class=\"row g-4 mb-4\">
                <div class=\"col-md-4\">
                    <div class=\"stat-card\">
                        <div class=\"d-flex align-items-center\">
                            <div class=\"stat-icon me-3\">
                                <i class=\"fas fa-qrcode fs-3\"></i>
                            </div>
                            <div>
                                <h6 class=\"text-muted mb-1\">Total Scans</h6>
                                <h3 class=\"mb-0 fw-bold\">";
        // line 76
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["totalScans"]) || array_key_exists("totalScans", $context) ? $context["totalScans"] : (function () { throw new RuntimeError('Variable "totalScans" does not exist.', 76, $this->source); })()), "html", null, true);
        yield "</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=\"col-md-4\">
                    <div class=\"stat-card\">
                        <div class=\"d-flex align-items-center\">
                            <div class=\"stat-icon me-3\">
                                <i class=\"fas fa-map-marker-alt fs-3\"></i>
                            </div>
                            <div>
                                <h6 class=\"text-muted mb-1\">Zones Actives</h6>
                                <h3 class=\"mb-0 fw-bold\">";
        // line 89
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), (isset($context["zoneStats"]) || array_key_exists("zoneStats", $context) ? $context["zoneStats"] : (function () { throw new RuntimeError('Variable "zoneStats" does not exist.', 89, $this->source); })())), "html", null, true);
        yield "</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=\"col-md-4\">
                    <div class=\"stat-card\">
                        <div class=\"d-flex align-items-center\">
                            <div class=\"stat-icon me-3\">
                                <i class=\"fas fa-clock fs-3\"></i>
                            </div>
                            <div>
                                <h6 class=\"text-muted mb-1\">Scans Récents</h6>
                                <h3 class=\"mb-0 fw-bold\">";
        // line 102
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), (isset($context["recentScans"]) || array_key_exists("recentScans", $context) ? $context["recentScans"] : (function () { throw new RuntimeError('Variable "recentScans" does not exist.', 102, $this->source); })())), "html", null, true);
        yield "</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Scans -->
            <div class=\"big-card mb-4\">
                <h4 class=\"mb-3\">Scans Récents</h4>
                <div class=\"table-responsive\">
                    <table class=\"table table-hover align-middle\">
                        <thead class=\"table-light\">
                            <tr>
                                <th>Zone</th>
                                <th>Date</th>
                                <th>Appareil</th>
                                <th>IP</th>
                            </tr>
                        </thead>
                        <tbody>
                            ";
        // line 123
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["recentScans"]) || array_key_exists("recentScans", $context) ? $context["recentScans"] : (function () { throw new RuntimeError('Variable "recentScans" does not exist.', 123, $this->source); })()));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["scan"]) {
            // line 124
            yield "                            <tr>
                                <td>";
            // line 125
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["scan"], "zone", [], "any", false, false, false, 125), "nomZone", [], "any", false, false, false, 125), "html", null, true);
            yield "</td>
                                <td>";
            // line 126
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["scan"], "scannedAt", [], "any", false, false, false, 126), "d/m/Y H:i:s"), "html", null, true);
            yield "</td>
                                <td>
                                    ";
            // line 128
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["scan"], "deviceType", [], "any", false, false, false, 128) == "iPhone")) {
                // line 129
                yield "                                        <i class=\"fab fa-apple text-secondary me-1\"></i>
                                    ";
            } elseif ((CoreExtension::getAttribute($this->env, $this->source,             // line 130
$context["scan"], "deviceType", [], "any", false, false, false, 130) == "Android")) {
                // line 131
                yield "                                        <i class=\"fab fa-android text-success me-1\"></i>
                                    ";
            }
            // line 133
            yield "                                    ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["scan"], "deviceType", [], "any", false, false, false, 133), "html", null, true);
            yield "
                                </td>
                                <td><small>";
            // line 135
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["scan"], "ipAddress", [], "any", false, false, false, 135), "html", null, true);
            yield "</small></td>
                            </tr>
                            ";
            $context['_iterated'] = true;
        }
        // line 137
        if (!$context['_iterated']) {
            // line 138
            yield "                            <tr>
                                <td colspan=\"4\" class=\"text-center py-4\">
                                    <i class=\"fas fa-qrcode fs-2 text-muted mb-2\"></i>
                                    <p class=\"text-muted\">Aucun scan pour le moment</p>
                                </td>
                            </tr>
                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['scan'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 145
        yield "                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Zone Stats -->
            <div class=\"big-card\">
                <h4 class=\"mb-3\">Statistiques par Zone</h4>
                <div class=\"table-responsive\">
                    <table class=\"table table-hover align-middle\">
                        <thead class=\"table-light\">
                            <tr>
                                <th>Zone</th>
                                <th>Niveau</th>
                                <th>Scans</th>
                                <th>Dernier Scan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            ";
        // line 165
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["zoneStats"]) || array_key_exists("zoneStats", $context) ? $context["zoneStats"] : (function () { throw new RuntimeError('Variable "zoneStats" does not exist.', 165, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["stat"]) {
            // line 166
            yield "                            <tr>
                                <td class=\"fw-bold\">";
            // line 167
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["stat"], "zone", [], "any", false, false, false, 167), "nomZone", [], "any", false, false, false, 167), "html", null, true);
            yield "</td>
                                <td>
                                    <span class=\"badge bg-";
            // line 169
            yield (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["stat"], "zone", [], "any", false, false, false, 169), "niveauPollution", [], "any", false, false, false, 169) >= 7)) ? ("danger") : ((((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["stat"], "zone", [], "any", false, false, false, 169), "niveauPollution", [], "any", false, false, false, 169) >= 4)) ? ("warning") : ("success"))));
            yield "\">
                                        ";
            // line 170
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["stat"], "zone", [], "any", false, false, false, 170), "niveauPollution", [], "any", false, false, false, 170), "html", null, true);
            yield "/10
                                    </span>
                                </td>
                                <td>";
            // line 173
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["stat"], "count", [], "any", false, false, false, 173), "html", null, true);
            yield "</td>
                                <td>";
            // line 174
            yield (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["stat"], "lastScan", [], "any", false, false, false, 174)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["stat"], "lastScan", [], "any", false, false, false, 174), "scannedAt", [], "any", false, false, false, 174), "d/m/Y H:i"), "html", null, true)) : ("Jamais"));
            yield "</td>
                                <td>
                                    <a href=\"";
            // line 176
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_zone_polluee_qr", ["id" => CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["stat"], "zone", [], "any", false, false, false, 176), "id", [], "any", false, false, false, 176)]), "html", null, true);
            yield "\" class=\"btn btn-sm btn-outline-custom\">
                                        <i class=\"fas fa-qrcode\"></i>
                                    </a>
                                </td>
                            </tr>
                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['stat'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 182
        yield "                        </tbody>
                    </table>
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
        return "qr_dashboard/index.html.twig";
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
        return array (  366 => 182,  354 => 176,  349 => 174,  345 => 173,  339 => 170,  335 => 169,  330 => 167,  327 => 166,  323 => 165,  301 => 145,  289 => 138,  287 => 137,  280 => 135,  274 => 133,  270 => 131,  268 => 130,  265 => 129,  263 => 128,  258 => 126,  254 => 125,  251 => 124,  246 => 123,  222 => 102,  206 => 89,  190 => 76,  164 => 53,  142 => 34,  135 => 30,  128 => 26,  121 => 22,  114 => 18,  100 => 6,  87 => 5,  64 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}QR Code Dashboard{% endblock %}

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
            <a href=\"{{ path('app_indicateur_impact_index') }}\" class=\"nav-link\">
                <i class=\"fas fa-chart-line\"></i>
                <span>Indicateurs</span>
            </a>
            <a href=\"{{ path('app_map') }}\" class=\"nav-link\">
                <i class=\"fas fa-map\"></i>
                <span>Carte</span>
            </a>
            <a href=\"{{ path('app_qr_dashboard') }}\" class=\"nav-link active\">
                <i class=\"fas fa-qrcode\"></i>
                <span>QR Stats</span>
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
                    <li class=\"breadcrumb-item active\">QR Analytics</li>
                </ol>
            </nav>
            <div>
                <i class=\"fas fa-bell text-muted me-3\"></i>
                <i class=\"fas fa-user-circle text-muted fs-4\"></i>
            </div>
        </div>

        <div class=\"main-content\">
            <h2 class=\"mb-4\">📊 QR Code Analytics Dashboard</h2>
            
            <!-- Stats Cards -->
            <div class=\"row g-4 mb-4\">
                <div class=\"col-md-4\">
                    <div class=\"stat-card\">
                        <div class=\"d-flex align-items-center\">
                            <div class=\"stat-icon me-3\">
                                <i class=\"fas fa-qrcode fs-3\"></i>
                            </div>
                            <div>
                                <h6 class=\"text-muted mb-1\">Total Scans</h6>
                                <h3 class=\"mb-0 fw-bold\">{{ totalScans }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=\"col-md-4\">
                    <div class=\"stat-card\">
                        <div class=\"d-flex align-items-center\">
                            <div class=\"stat-icon me-3\">
                                <i class=\"fas fa-map-marker-alt fs-3\"></i>
                            </div>
                            <div>
                                <h6 class=\"text-muted mb-1\">Zones Actives</h6>
                                <h3 class=\"mb-0 fw-bold\">{{ zoneStats|length }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=\"col-md-4\">
                    <div class=\"stat-card\">
                        <div class=\"d-flex align-items-center\">
                            <div class=\"stat-icon me-3\">
                                <i class=\"fas fa-clock fs-3\"></i>
                            </div>
                            <div>
                                <h6 class=\"text-muted mb-1\">Scans Récents</h6>
                                <h3 class=\"mb-0 fw-bold\">{{ recentScans|length }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Scans -->
            <div class=\"big-card mb-4\">
                <h4 class=\"mb-3\">Scans Récents</h4>
                <div class=\"table-responsive\">
                    <table class=\"table table-hover align-middle\">
                        <thead class=\"table-light\">
                            <tr>
                                <th>Zone</th>
                                <th>Date</th>
                                <th>Appareil</th>
                                <th>IP</th>
                            </tr>
                        </thead>
                        <tbody>
                            {% for scan in recentScans %}
                            <tr>
                                <td>{{ scan.zone.nomZone }}</td>
                                <td>{{ scan.scannedAt|date('d/m/Y H:i:s') }}</td>
                                <td>
                                    {% if scan.deviceType == 'iPhone' %}
                                        <i class=\"fab fa-apple text-secondary me-1\"></i>
                                    {% elseif scan.deviceType == 'Android' %}
                                        <i class=\"fab fa-android text-success me-1\"></i>
                                    {% endif %}
                                    {{ scan.deviceType }}
                                </td>
                                <td><small>{{ scan.ipAddress }}</small></td>
                            </tr>
                            {% else %}
                            <tr>
                                <td colspan=\"4\" class=\"text-center py-4\">
                                    <i class=\"fas fa-qrcode fs-2 text-muted mb-2\"></i>
                                    <p class=\"text-muted\">Aucun scan pour le moment</p>
                                </td>
                            </tr>
                            {% endfor %}
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Zone Stats -->
            <div class=\"big-card\">
                <h4 class=\"mb-3\">Statistiques par Zone</h4>
                <div class=\"table-responsive\">
                    <table class=\"table table-hover align-middle\">
                        <thead class=\"table-light\">
                            <tr>
                                <th>Zone</th>
                                <th>Niveau</th>
                                <th>Scans</th>
                                <th>Dernier Scan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {% for stat in zoneStats %}
                            <tr>
                                <td class=\"fw-bold\">{{ stat.zone.nomZone }}</td>
                                <td>
                                    <span class=\"badge bg-{{ stat.zone.niveauPollution >= 7 ? 'danger' : (stat.zone.niveauPollution >= 4 ? 'warning' : 'success') }}\">
                                        {{ stat.zone.niveauPollution }}/10
                                    </span>
                                </td>
                                <td>{{ stat.count }}</td>
                                <td>{{ stat.lastScan ? stat.lastScan.scannedAt|date('d/m/Y H:i') : 'Jamais' }}</td>
                                <td>
                                    <a href=\"{{ path('app_zone_polluee_qr', {'id': stat.zone.id}) }}\" class=\"btn btn-sm btn-outline-custom\">
                                        <i class=\"fas fa-qrcode\"></i>
                                    </a>
                                </td>
                            </tr>
                            {% endfor %}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
{% endblock %}", "qr_dashboard/index.html.twig", "C:\\Users\\Mega-PC\\Desktop\\mon-projet\\templates\\qr_dashboard\\index.html.twig");
    }
}

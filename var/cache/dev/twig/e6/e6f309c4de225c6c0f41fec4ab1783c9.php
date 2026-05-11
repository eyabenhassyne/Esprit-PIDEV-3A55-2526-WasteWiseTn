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

/* zone_polluee/qr_batch.html.twig */
class __TwigTemplate_ce1d14206f4467411246e3c5f5392da1 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "zone_polluee/qr_batch.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "zone_polluee/qr_batch.html.twig"));

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

        yield "Tous les QR Codes - Google Maps";
        
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
                    <li class=\"breadcrumb-item active\">Tous les QR Codes</li>
                </ol>
            </nav>
            <div>
                <i class=\"fas fa-bell text-muted me-3\"></i>
                <i class=\"fas fa-user-circle text-muted fs-4\"></i>
            </div>
        </div>

        <div class=\"main-content\">
            <div class=\"big-card\">
                <div class=\"d-flex justify-content-between align-items-center mb-4\">
                    <h4 class=\"mb-0\">Tous les QR Codes - Google Maps</h4>
                    <button class=\"btn btn-green\" onclick=\"window.print()\">
                        <i class=\"fas fa-print me-2\"></i>Imprimer
                    </button>
                </div>
                
                <!-- Explanation -->
                <div class=\"alert alert-success mb-4\">
                    <i class=\"fas fa-map-marked-alt me-2\"></i>
                    <strong>Scannez ces QR codes</strong> pour voir chaque zone sur Google Maps directement !
                </div>
                
                <div class=\"row g-4\">
                    ";
        // line 76
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["qrCodes"]) || array_key_exists("qrCodes", $context) ? $context["qrCodes"] : (function () { throw new RuntimeError('Variable "qrCodes" does not exist.', 76, $this->source); })()));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 77
            yield "                    <div class=\"col-md-4 col-sm-6\">
                        <div class=\"card border-0 shadow-sm h-100\">
                            <div class=\"card-body text-center\">
                                <h6 class=\"mb-2 fw-bold\">";
            // line 80
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "zone", [], "any", false, false, false, 80), "nomZone", [], "any", false, false, false, 80), "html", null, true);
            yield "</h6>
                                <span class=\"badge bg-";
            // line 81
            yield (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "zone", [], "any", false, false, false, 81), "niveauPollution", [], "any", false, false, false, 81) >= 7)) ? ("danger") : ((((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "zone", [], "any", false, false, false, 81), "niveauPollution", [], "any", false, false, false, 81) >= 4)) ? ("warning") : ("success"))));
            yield " mb-3\">
                                    Niveau ";
            // line 82
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "zone", [], "any", false, false, false, 82), "niveauPollution", [], "any", false, false, false, 82), "html", null, true);
            yield "/10
                                </span>
                                
                                <img src=\"data:image/png;base64,";
            // line 85
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "qr", [], "any", false, false, false, 85), "html", null, true);
            yield "\" 
                                     alt=\"QR Code pour ";
            // line 86
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "zone", [], "any", false, false, false, 86), "nomZone", [], "any", false, false, false, 86), "html", null, true);
            yield "\"
                                     style=\"width: 150px; height: 150px; margin: 0 auto; display: block;
                                            border: 3px solid ";
            // line 88
            yield (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "zone", [], "any", false, false, false, 88), "niveauPollution", [], "any", false, false, false, 88) >= 7)) ? ("#dc3545") : ((((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "zone", [], "any", false, false, false, 88), "niveauPollution", [], "any", false, false, false, 88) >= 4)) ? ("#ffc107") : ("#28a745"))));
            yield "; 
                                            border-radius: 8px;
                                            padding: 5px;\">
                                
                                <p class=\"mt-2 small text-muted\">
                                    <i class=\"fas fa-map-pin me-1\"></i>
                                    ";
            // line 94
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "zone", [], "any", false, false, false, 94), "coordonneesGps", [], "any", false, false, false, 94), "html", null, true);
            yield "
                                </p>
                                
                                <div class=\"mt-3 d-flex justify-content-center gap-2\">
                                    <a href=\"";
            // line 98
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_zone_polluee_qr_download_png", ["id" => CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "zone", [], "any", false, false, false, 98), "id", [], "any", false, false, false, 98)]), "html", null, true);
            yield "\" 
                                       class=\"btn btn-sm btn-outline-custom\">
                                        <i class=\"fas fa-download me-1\"></i> QR
                                    </a>
                                    <a href=\"";
            // line 102
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_zone_polluee_qr", ["id" => CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "zone", [], "any", false, false, false, 102), "id", [], "any", false, false, false, 102)]), "html", null, true);
            yield "\" 
                                       class=\"btn btn-sm btn-outline-custom\">
                                        <i class=\"fas fa-qrcode me-1\"></i> Voir
                                    </a>
                                    <a href=\"https://www.google.com/maps/search/?api=1&query=";
            // line 106
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::replace(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "zone", [], "any", false, false, false, 106), "coordonneesGps", [], "any", false, false, false, 106), [" " => ""]), "html", null, true);
            yield "\" 
                                       target=\"_blank\"
                                       class=\"btn btn-sm btn-outline-custom\">
                                        <i class=\"fas fa-map-marked-alt\"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    ";
            $context['_iterated'] = true;
        }
        // line 115
        if (!$context['_iterated']) {
            // line 116
            yield "                    <div class=\"col-12\">
                        <div class=\"text-center py-5\">
                            <i class=\"fas fa-qrcode fs-1 text-muted mb-3\"></i>
                            <h6 class=\"text-muted\">Aucune zone trouvée</h6>
                            <p class=\"text-muted small\">Ajoutez des zones pour générer des QR codes</p>
                        </div>
                    </div>
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['item'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 124
        yield "                </div>
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
        return "zone_polluee/qr_batch.html.twig";
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
        return array (  282 => 124,  269 => 116,  267 => 115,  253 => 106,  246 => 102,  239 => 98,  232 => 94,  223 => 88,  218 => 86,  214 => 85,  208 => 82,  204 => 81,  200 => 80,  195 => 77,  190 => 76,  161 => 50,  157 => 49,  135 => 30,  128 => 26,  121 => 22,  114 => 18,  100 => 6,  87 => 5,  64 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Tous les QR Codes - Google Maps{% endblock %}

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
                    <li class=\"breadcrumb-item active\">Tous les QR Codes</li>
                </ol>
            </nav>
            <div>
                <i class=\"fas fa-bell text-muted me-3\"></i>
                <i class=\"fas fa-user-circle text-muted fs-4\"></i>
            </div>
        </div>

        <div class=\"main-content\">
            <div class=\"big-card\">
                <div class=\"d-flex justify-content-between align-items-center mb-4\">
                    <h4 class=\"mb-0\">Tous les QR Codes - Google Maps</h4>
                    <button class=\"btn btn-green\" onclick=\"window.print()\">
                        <i class=\"fas fa-print me-2\"></i>Imprimer
                    </button>
                </div>
                
                <!-- Explanation -->
                <div class=\"alert alert-success mb-4\">
                    <i class=\"fas fa-map-marked-alt me-2\"></i>
                    <strong>Scannez ces QR codes</strong> pour voir chaque zone sur Google Maps directement !
                </div>
                
                <div class=\"row g-4\">
                    {% for item in qrCodes %}
                    <div class=\"col-md-4 col-sm-6\">
                        <div class=\"card border-0 shadow-sm h-100\">
                            <div class=\"card-body text-center\">
                                <h6 class=\"mb-2 fw-bold\">{{ item.zone.nomZone }}</h6>
                                <span class=\"badge bg-{{ item.zone.niveauPollution >= 7 ? 'danger' : (item.zone.niveauPollution >= 4 ? 'warning' : 'success') }} mb-3\">
                                    Niveau {{ item.zone.niveauPollution }}/10
                                </span>
                                
                                <img src=\"data:image/png;base64,{{ item.qr }}\" 
                                     alt=\"QR Code pour {{ item.zone.nomZone }}\"
                                     style=\"width: 150px; height: 150px; margin: 0 auto; display: block;
                                            border: 3px solid {{ item.zone.niveauPollution >= 7 ? '#dc3545' : (item.zone.niveauPollution >= 4 ? '#ffc107' : '#28a745') }}; 
                                            border-radius: 8px;
                                            padding: 5px;\">
                                
                                <p class=\"mt-2 small text-muted\">
                                    <i class=\"fas fa-map-pin me-1\"></i>
                                    {{ item.zone.coordonneesGps }}
                                </p>
                                
                                <div class=\"mt-3 d-flex justify-content-center gap-2\">
                                    <a href=\"{{ path('app_zone_polluee_qr_download_png', {'id': item.zone.id}) }}\" 
                                       class=\"btn btn-sm btn-outline-custom\">
                                        <i class=\"fas fa-download me-1\"></i> QR
                                    </a>
                                    <a href=\"{{ path('app_zone_polluee_qr', {'id': item.zone.id}) }}\" 
                                       class=\"btn btn-sm btn-outline-custom\">
                                        <i class=\"fas fa-qrcode me-1\"></i> Voir
                                    </a>
                                    <a href=\"https://www.google.com/maps/search/?api=1&query={{ item.zone.coordonneesGps|replace({' ': ''}) }}\" 
                                       target=\"_blank\"
                                       class=\"btn btn-sm btn-outline-custom\">
                                        <i class=\"fas fa-map-marked-alt\"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {% else %}
                    <div class=\"col-12\">
                        <div class=\"text-center py-5\">
                            <i class=\"fas fa-qrcode fs-1 text-muted mb-3\"></i>
                            <h6 class=\"text-muted\">Aucune zone trouvée</h6>
                            <p class=\"text-muted small\">Ajoutez des zones pour générer des QR codes</p>
                        </div>
                    </div>
                    {% endfor %}
                </div>
            </div>
        </div>
    </div>
</div>
{% endblock %}", "zone_polluee/qr_batch.html.twig", "C:\\Users\\Mega-PC\\Desktop\\mon-projet\\templates\\zone_polluee\\qr_batch.html.twig");
    }
}

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

/* zone_polluee/index.html.twig */
class __TwigTemplate_fcde85d0f1140a94ece64d09d9e746a9 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "zone_polluee/index.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "zone_polluee/index.html.twig"));

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

        yield "Gestion des Zones Polluées";
        
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
        yield "\" class=\"nav-link\">
                <i class=\"fas fa-chart-pie\"></i>
                <span>Dashboard</span>
            </a>
            
            <a href=\"";
        // line 24
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_zone_polluee_index");
        yield "\" class=\"nav-link active\">
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

            <!-- Assistant IA -->
            <a href=\"";
        // line 40
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_chatbot");
        yield "\" class=\"nav-link\">
                <i class=\"fas fa-robot\"></i>
                <span>Assistant IA</span>
            </a>

            <!-- DASHBOARD IA - AJOUTÉ ICI -->
            <a href=\"";
        // line 46
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_dashboard_intelligent");
        yield "\" class=\"nav-link\">
                <i class=\"fas fa-brain\"></i>
                <span>Dashboard IA</span>
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
                    <li class=\"breadcrumb-item\"><a href=\"";
        // line 66
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_dashboard");
        yield "\" class=\"text-decoration-none\">Dashboard</a></li>
                    <li class=\"breadcrumb-item active\">Zones Polluées</li>
                </ol>
            </nav>
            
            <div class=\"d-flex align-items-center gap-3\">
                <i class=\"fas fa-bell text-muted\"></i>
                <i class=\"fas fa-user-circle text-muted\" style=\"font-size: 1.5rem;\"></i>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class=\"main-content\">
            <!-- Page Header -->
            <div class=\"d-flex justify-content-between align-items-center mb-4\">
                <h2 class=\"h3 mb-0\">Zones Polluées</h2>
                <div>
                    <a href=\"";
        // line 83
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_zone_polluee_qr_batch");
        yield "\" class=\"btn btn-outline-custom me-2\">
                        <i class=\"fas fa-qrcode me-2\"></i>Tous les QR
                    </a>
                    <a href=\"";
        // line 86
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_zone_polluee_new");
        yield "\" class=\"btn btn-green\">
                        <i class=\"fas fa-plus me-2\"></i>Nouvelle Zone
                    </a>
                </div>
            </div>

            <!-- Flash Messages -->
            ";
        // line 93
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 93, $this->source); })()), "flashes", ["success"], "method", false, false, false, 93));
        foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
            // line 94
            yield "                <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
                    <i class=\"fas fa-check-circle me-2\"></i>";
            // line 95
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["message"], "html", null, true);
            yield "
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                </div>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['message'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 99
        yield "
            <!-- Stats Cards -->
            <div class=\"row g-3 mb-4\">
                <div class=\"col-md-4\">
                    <div class=\"stat-card\">
                        <div class=\"d-flex align-items-center\">
                            <div class=\"stat-icon me-3\">
                                <i class=\"fas fa-map-marker-alt fs-3\"></i>
                            </div>
                            <div>
                                <h6 class=\"text-muted mb-1\">Total Zones</h6>
                                <h3 class=\"mb-0 fw-bold\">";
        // line 110
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((array_key_exists("total_zones", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["total_zones"]) || array_key_exists("total_zones", $context) ? $context["total_zones"] : (function () { throw new RuntimeError('Variable "total_zones" does not exist.', 110, $this->source); })()), 0)) : (0)), "html", null, true);
        yield "</h3>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class=\"col-md-4\">
                    <div class=\"stat-card\">
                        <div class=\"d-flex align-items-center\">
                            <div class=\"stat-icon me-3\">
                                <i class=\"fas fa-exclamation-triangle fs-3 text-danger\"></i>
                            </div>
                            <div>
                                <h6 class=\"text-muted mb-1\">Haut Risque</h6>
                                <h3 class=\"mb-0 fw-bold text-danger\">";
        // line 124
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((array_key_exists("haut_risque", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["haut_risque"]) || array_key_exists("haut_risque", $context) ? $context["haut_risque"] : (function () { throw new RuntimeError('Variable "haut_risque" does not exist.', 124, $this->source); })()), 0)) : (0)), "html", null, true);
        yield "</h3>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class=\"col-md-4\">
                    <div class=\"stat-card\">
                        <div class=\"d-flex align-items-center\">
                            <div class=\"stat-icon me-3\">
                                <i class=\"fas fa-calendar-plus fs-3 text-success\"></i>
                            </div>
                            <div>
                                <h6 class=\"text-muted mb-1\">Nouvelles Zones (7j)</h6>
                                <h3 class=\"mb-0 fw-bold\">";
        // line 138
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((array_key_exists("nouvelles_zones", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["nouvelles_zones"]) || array_key_exists("nouvelles_zones", $context) ? $context["nouvelles_zones"] : (function () { throw new RuntimeError('Variable "nouvelles_zones" does not exist.', 138, $this->source); })()), 0)) : (0)), "html", null, true);
        yield "</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and Filters -->
            <div class=\"row mb-4\">
                <div class=\"col-12\">
                    <form method=\"get\" class=\"bg-light p-4 rounded-3\">
                        <div class=\"row g-3\">
                            <!-- Search -->
                            <div class=\"col-md-4\">
                                <label class=\"form-label fw-medium\">Recherche</label>
                                <div class=\"position-relative\">
                                    <i class=\"fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-secondary\"></i>
                                    <input type=\"text\" name=\"search\" class=\"form-control ps-5\" placeholder=\"Nom ou GPS...\" value=\"";
        // line 155
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((array_key_exists("search", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["search"]) || array_key_exists("search", $context) ? $context["search"] : (function () { throw new RuntimeError('Variable "search" does not exist.', 155, $this->source); })()), "")) : ("")), "html", null, true);
        yield "\">
                                </div>
                            </div>
                            
                            <!-- Filter by niveau -->
                            <div class=\"col-md-3\">
                                <label class=\"form-label fw-medium\">Filtrer par niveau</label>
                                <select name=\"filter\" class=\"form-select\">
                                    <option value=\"\">Tous les niveaux</option>
                                    <option value=\"sup_5\" ";
        // line 164
        yield ((((isset($context["current_filter"]) || array_key_exists("current_filter", $context) ? $context["current_filter"] : (function () { throw new RuntimeError('Variable "current_filter" does not exist.', 164, $this->source); })()) == "sup_5")) ? ("selected") : (""));
        yield ">Supérieur à 5</option>
                                    <option value=\"inf_5\" ";
        // line 165
        yield ((((isset($context["current_filter"]) || array_key_exists("current_filter", $context) ? $context["current_filter"] : (function () { throw new RuntimeError('Variable "current_filter" does not exist.', 165, $this->source); })()) == "inf_5")) ? ("selected") : (""));
        yield ">Inférieur ou égal à 5</option>
                                    <option value=\"critique\" ";
        // line 166
        yield ((((isset($context["current_filter"]) || array_key_exists("current_filter", $context) ? $context["current_filter"] : (function () { throw new RuntimeError('Variable "current_filter" does not exist.', 166, $this->source); })()) == "critique")) ? ("selected") : (""));
        yield ">Critique (≥ 7)</option>
                                    <option value=\"modere\" ";
        // line 167
        yield ((((isset($context["current_filter"]) || array_key_exists("current_filter", $context) ? $context["current_filter"] : (function () { throw new RuntimeError('Variable "current_filter" does not exist.', 167, $this->source); })()) == "modere")) ? ("selected") : (""));
        yield ">Modéré (4-6)</option>
                                    <option value=\"faible\" ";
        // line 168
        yield ((((isset($context["current_filter"]) || array_key_exists("current_filter", $context) ? $context["current_filter"] : (function () { throw new RuntimeError('Variable "current_filter" does not exist.', 168, $this->source); })()) == "faible")) ? ("selected") : (""));
        yield ">Faible (≤ 3)</option>
                                </select>
                            </div>
                            
                            <!-- Sort -->
                            <div class=\"col-md-3\">
                                <label class=\"form-label fw-medium\">Trier par</label>
                                <select name=\"sort\" class=\"form-select\">
                                    <option value=\"date_desc\" ";
        // line 176
        yield ((((isset($context["current_sort"]) || array_key_exists("current_sort", $context) ? $context["current_sort"] : (function () { throw new RuntimeError('Variable "current_sort" does not exist.', 176, $this->source); })()) == "date_desc")) ? ("selected") : (""));
        yield ">Plus récent</option>
                                    <option value=\"date_asc\" ";
        // line 177
        yield ((((isset($context["current_sort"]) || array_key_exists("current_sort", $context) ? $context["current_sort"] : (function () { throw new RuntimeError('Variable "current_sort" does not exist.', 177, $this->source); })()) == "date_asc")) ? ("selected") : (""));
        yield ">Plus ancien</option>
                                    <option value=\"nom_asc\" ";
        // line 178
        yield ((((isset($context["current_sort"]) || array_key_exists("current_sort", $context) ? $context["current_sort"] : (function () { throw new RuntimeError('Variable "current_sort" does not exist.', 178, $this->source); })()) == "nom_asc")) ? ("selected") : (""));
        yield ">Nom (A-Z)</option>
                                    <option value=\"nom_desc\" ";
        // line 179
        yield ((((isset($context["current_sort"]) || array_key_exists("current_sort", $context) ? $context["current_sort"] : (function () { throw new RuntimeError('Variable "current_sort" does not exist.', 179, $this->source); })()) == "nom_desc")) ? ("selected") : (""));
        yield ">Nom (Z-A)</option>
                                    <option value=\"niveau_desc\" ";
        // line 180
        yield ((((isset($context["current_sort"]) || array_key_exists("current_sort", $context) ? $context["current_sort"] : (function () { throw new RuntimeError('Variable "current_sort" does not exist.', 180, $this->source); })()) == "niveau_desc")) ? ("selected") : (""));
        yield ">Niveau (plus élevé)</option>
                                    <option value=\"niveau_asc\" ";
        // line 181
        yield ((((isset($context["current_sort"]) || array_key_exists("current_sort", $context) ? $context["current_sort"] : (function () { throw new RuntimeError('Variable "current_sort" does not exist.', 181, $this->source); })()) == "niveau_asc")) ? ("selected") : (""));
        yield ">Niveau (plus faible)</option>
                                </select>
                            </div>
                            
                            <!-- Buttons -->
                            <div class=\"col-md-2 d-flex align-items-end\">
                                <div class=\"d-flex gap-2 w-100\">
                                    <button type=\"submit\" class=\"btn btn-green flex-grow-1\">
                                        <i class=\"fas fa-filter me-2\"></i>Filtrer
                                    </button>
                                    <a href=\"";
        // line 191
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_zone_polluee_index");
        yield "\" class=\"btn btn-outline-custom\">
                                        <i class=\"fas fa-redo\"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Main Card -->
            <div class=\"big-card\">
                <div class=\"table-responsive\">
                    <table class=\"table table-hover align-middle\">
                        <thead class=\"table-light\">
                            <tr>
                                <th>Zone</th>
                                <th>Coordonnées</th>
                                <th>Niveau</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            ";
        // line 215
        if ((array_key_exists("zones", $context) && (Twig\Extension\CoreExtension::length($this->env->getCharset(), (isset($context["zones"]) || array_key_exists("zones", $context) ? $context["zones"] : (function () { throw new RuntimeError('Variable "zones" does not exist.', 215, $this->source); })())) > 0))) {
            // line 216
            yield "                                ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable((isset($context["zones"]) || array_key_exists("zones", $context) ? $context["zones"] : (function () { throw new RuntimeError('Variable "zones" does not exist.', 216, $this->source); })()));
            foreach ($context['_seq'] as $context["_key"] => $context["zone"]) {
                // line 217
                yield "                                <tr>
                                    <td class=\"fw-bold\">";
                // line 218
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["zone"], "nomZone", [], "any", false, false, false, 218), "html", null, true);
                yield "</td>
                                    <td>";
                // line 219
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["zone"], "coordonneesGps", [], "any", false, false, false, 219), "html", null, true);
                yield "</td>
                                    <td>
                                        ";
                // line 221
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["zone"], "niveauPollution", [], "any", false, false, false, 221) <= 3)) {
                    // line 222
                    yield "                                            <span class=\"badge bg-success\">";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["zone"], "niveauPollution", [], "any", false, false, false, 222), "html", null, true);
                    yield "/10</span>
                                        ";
                } elseif ((CoreExtension::getAttribute($this->env, $this->source,                 // line 223
$context["zone"], "niveauPollution", [], "any", false, false, false, 223) <= 6)) {
                    // line 224
                    yield "                                            <span class=\"badge bg-warning text-dark\">";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["zone"], "niveauPollution", [], "any", false, false, false, 224), "html", null, true);
                    yield "/10</span>
                                        ";
                } else {
                    // line 226
                    yield "                                            <span class=\"badge bg-danger\">";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["zone"], "niveauPollution", [], "any", false, false, false, 226), "html", null, true);
                    yield "/10</span>
                                        ";
                }
                // line 228
                yield "                                    </td>
                                    <td>";
                // line 229
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["zone"], "dateIdentification", [], "any", false, false, false, 229), "d/m/Y"), "html", null, true);
                yield "</td>
                                    <td>
                                        <div class=\"d-flex gap-2\">
                                            <a href=\"";
                // line 232
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_zone_polluee_show", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["zone"], "id", [], "any", false, false, false, 232)]), "html", null, true);
                yield "\" class=\"btn btn-sm btn-outline-custom\">
                                                <i class=\"fas fa-eye\"></i>
                                            </a>
                                            <a href=\"";
                // line 235
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_zone_polluee_edit", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["zone"], "id", [], "any", false, false, false, 235)]), "html", null, true);
                yield "\" class=\"btn btn-sm btn-outline-custom\">
                                                <i class=\"fas fa-edit\"></i>
                                            </a>
                                            <a href=\"";
                // line 238
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_zone_polluee_qr", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["zone"], "id", [], "any", false, false, false, 238)]), "html", null, true);
                yield "\" class=\"btn btn-sm btn-outline-custom\">
                                                <i class=\"fas fa-qrcode\"></i>
                                            </a>
                                            <form method=\"post\" action=\"";
                // line 241
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_zone_polluee_delete", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["zone"], "id", [], "any", false, false, false, 241)]), "html", null, true);
                yield "\" style=\"display:inline;\">
                                                <input type=\"hidden\" name=\"_token\" value=\"";
                // line 242
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderCsrfToken(("delete" . CoreExtension::getAttribute($this->env, $this->source, $context["zone"], "id", [], "any", false, false, false, 242))), "html", null, true);
                yield "\">
                                                <button type=\"submit\" class=\"btn btn-sm btn-outline-custom text-danger\" onclick=\"return confirm('Supprimer cette zone ?')\">
                                                    <i class=\"fas fa-trash\"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['zone'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 251
            yield "                            ";
        } else {
            // line 252
            yield "                                <tr>
                                    <td colspan=\"5\" class=\"text-center py-5\">
                                        <i class=\"fas fa-map-marker-alt fs-1 text-muted mb-3\"></i>
                                        <h6 class=\"text-muted\">Aucune zone polluée</h6>
                                        <p class=\"text-muted small\">Cliquez sur \"Nouvelle Zone\" pour ajouter</p>
                                    </td>
                                </tr>
                            ";
        }
        // line 260
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
        return "zone_polluee/index.html.twig";
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
        return array (  498 => 260,  488 => 252,  485 => 251,  470 => 242,  466 => 241,  460 => 238,  454 => 235,  448 => 232,  442 => 229,  439 => 228,  433 => 226,  427 => 224,  425 => 223,  420 => 222,  418 => 221,  413 => 219,  409 => 218,  406 => 217,  401 => 216,  399 => 215,  372 => 191,  359 => 181,  355 => 180,  351 => 179,  347 => 178,  343 => 177,  339 => 176,  328 => 168,  324 => 167,  320 => 166,  316 => 165,  312 => 164,  300 => 155,  280 => 138,  263 => 124,  246 => 110,  233 => 99,  223 => 95,  220 => 94,  216 => 93,  206 => 86,  200 => 83,  180 => 66,  157 => 46,  148 => 40,  139 => 34,  131 => 29,  123 => 24,  115 => 19,  100 => 6,  87 => 5,  64 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Gestion des Zones Polluées{% endblock %}

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
                <span>Indicateurs d'Impact</span>
            </a>

            <a href=\"{{ path('app_map') }}\" class=\"nav-link\">
                <i class=\"fas fa-map\"></i>
                <span>Carte</span>
            </a>

            <!-- Assistant IA -->
            <a href=\"{{ path('app_chatbot') }}\" class=\"nav-link\">
                <i class=\"fas fa-robot\"></i>
                <span>Assistant IA</span>
            </a>

            <!-- DASHBOARD IA - AJOUTÉ ICI -->
            <a href=\"{{ path('app_dashboard_intelligent') }}\" class=\"nav-link\">
                <i class=\"fas fa-brain\"></i>
                <span>Dashboard IA</span>
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
                    <li class=\"breadcrumb-item\"><a href=\"{{ path('admin_dashboard') }}\" class=\"text-decoration-none\">Dashboard</a></li>
                    <li class=\"breadcrumb-item active\">Zones Polluées</li>
                </ol>
            </nav>
            
            <div class=\"d-flex align-items-center gap-3\">
                <i class=\"fas fa-bell text-muted\"></i>
                <i class=\"fas fa-user-circle text-muted\" style=\"font-size: 1.5rem;\"></i>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class=\"main-content\">
            <!-- Page Header -->
            <div class=\"d-flex justify-content-between align-items-center mb-4\">
                <h2 class=\"h3 mb-0\">Zones Polluées</h2>
                <div>
                    <a href=\"{{ path('app_zone_polluee_qr_batch') }}\" class=\"btn btn-outline-custom me-2\">
                        <i class=\"fas fa-qrcode me-2\"></i>Tous les QR
                    </a>
                    <a href=\"{{ path('app_zone_polluee_new') }}\" class=\"btn btn-green\">
                        <i class=\"fas fa-plus me-2\"></i>Nouvelle Zone
                    </a>
                </div>
            </div>

            <!-- Flash Messages -->
            {% for message in app.flashes('success') %}
                <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
                    <i class=\"fas fa-check-circle me-2\"></i>{{ message }}
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                </div>
            {% endfor %}

            <!-- Stats Cards -->
            <div class=\"row g-3 mb-4\">
                <div class=\"col-md-4\">
                    <div class=\"stat-card\">
                        <div class=\"d-flex align-items-center\">
                            <div class=\"stat-icon me-3\">
                                <i class=\"fas fa-map-marker-alt fs-3\"></i>
                            </div>
                            <div>
                                <h6 class=\"text-muted mb-1\">Total Zones</h6>
                                <h3 class=\"mb-0 fw-bold\">{{ total_zones|default(0) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class=\"col-md-4\">
                    <div class=\"stat-card\">
                        <div class=\"d-flex align-items-center\">
                            <div class=\"stat-icon me-3\">
                                <i class=\"fas fa-exclamation-triangle fs-3 text-danger\"></i>
                            </div>
                            <div>
                                <h6 class=\"text-muted mb-1\">Haut Risque</h6>
                                <h3 class=\"mb-0 fw-bold text-danger\">{{ haut_risque|default(0) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class=\"col-md-4\">
                    <div class=\"stat-card\">
                        <div class=\"d-flex align-items-center\">
                            <div class=\"stat-icon me-3\">
                                <i class=\"fas fa-calendar-plus fs-3 text-success\"></i>
                            </div>
                            <div>
                                <h6 class=\"text-muted mb-1\">Nouvelles Zones (7j)</h6>
                                <h3 class=\"mb-0 fw-bold\">{{ nouvelles_zones|default(0) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and Filters -->
            <div class=\"row mb-4\">
                <div class=\"col-12\">
                    <form method=\"get\" class=\"bg-light p-4 rounded-3\">
                        <div class=\"row g-3\">
                            <!-- Search -->
                            <div class=\"col-md-4\">
                                <label class=\"form-label fw-medium\">Recherche</label>
                                <div class=\"position-relative\">
                                    <i class=\"fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-secondary\"></i>
                                    <input type=\"text\" name=\"search\" class=\"form-control ps-5\" placeholder=\"Nom ou GPS...\" value=\"{{ search|default('') }}\">
                                </div>
                            </div>
                            
                            <!-- Filter by niveau -->
                            <div class=\"col-md-3\">
                                <label class=\"form-label fw-medium\">Filtrer par niveau</label>
                                <select name=\"filter\" class=\"form-select\">
                                    <option value=\"\">Tous les niveaux</option>
                                    <option value=\"sup_5\" {{ current_filter == 'sup_5' ? 'selected' : '' }}>Supérieur à 5</option>
                                    <option value=\"inf_5\" {{ current_filter == 'inf_5' ? 'selected' : '' }}>Inférieur ou égal à 5</option>
                                    <option value=\"critique\" {{ current_filter == 'critique' ? 'selected' : '' }}>Critique (≥ 7)</option>
                                    <option value=\"modere\" {{ current_filter == 'modere' ? 'selected' : '' }}>Modéré (4-6)</option>
                                    <option value=\"faible\" {{ current_filter == 'faible' ? 'selected' : '' }}>Faible (≤ 3)</option>
                                </select>
                            </div>
                            
                            <!-- Sort -->
                            <div class=\"col-md-3\">
                                <label class=\"form-label fw-medium\">Trier par</label>
                                <select name=\"sort\" class=\"form-select\">
                                    <option value=\"date_desc\" {{ current_sort == 'date_desc' ? 'selected' : '' }}>Plus récent</option>
                                    <option value=\"date_asc\" {{ current_sort == 'date_asc' ? 'selected' : '' }}>Plus ancien</option>
                                    <option value=\"nom_asc\" {{ current_sort == 'nom_asc' ? 'selected' : '' }}>Nom (A-Z)</option>
                                    <option value=\"nom_desc\" {{ current_sort == 'nom_desc' ? 'selected' : '' }}>Nom (Z-A)</option>
                                    <option value=\"niveau_desc\" {{ current_sort == 'niveau_desc' ? 'selected' : '' }}>Niveau (plus élevé)</option>
                                    <option value=\"niveau_asc\" {{ current_sort == 'niveau_asc' ? 'selected' : '' }}>Niveau (plus faible)</option>
                                </select>
                            </div>
                            
                            <!-- Buttons -->
                            <div class=\"col-md-2 d-flex align-items-end\">
                                <div class=\"d-flex gap-2 w-100\">
                                    <button type=\"submit\" class=\"btn btn-green flex-grow-1\">
                                        <i class=\"fas fa-filter me-2\"></i>Filtrer
                                    </button>
                                    <a href=\"{{ path('app_zone_polluee_index') }}\" class=\"btn btn-outline-custom\">
                                        <i class=\"fas fa-redo\"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Main Card -->
            <div class=\"big-card\">
                <div class=\"table-responsive\">
                    <table class=\"table table-hover align-middle\">
                        <thead class=\"table-light\">
                            <tr>
                                <th>Zone</th>
                                <th>Coordonnées</th>
                                <th>Niveau</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {% if zones is defined and zones|length > 0 %}
                                {% for zone in zones %}
                                <tr>
                                    <td class=\"fw-bold\">{{ zone.nomZone }}</td>
                                    <td>{{ zone.coordonneesGps }}</td>
                                    <td>
                                        {% if zone.niveauPollution <= 3 %}
                                            <span class=\"badge bg-success\">{{ zone.niveauPollution }}/10</span>
                                        {% elseif zone.niveauPollution <= 6 %}
                                            <span class=\"badge bg-warning text-dark\">{{ zone.niveauPollution }}/10</span>
                                        {% else %}
                                            <span class=\"badge bg-danger\">{{ zone.niveauPollution }}/10</span>
                                        {% endif %}
                                    </td>
                                    <td>{{ zone.dateIdentification|date('d/m/Y') }}</td>
                                    <td>
                                        <div class=\"d-flex gap-2\">
                                            <a href=\"{{ path('app_zone_polluee_show', {'id': zone.id}) }}\" class=\"btn btn-sm btn-outline-custom\">
                                                <i class=\"fas fa-eye\"></i>
                                            </a>
                                            <a href=\"{{ path('app_zone_polluee_edit', {'id': zone.id}) }}\" class=\"btn btn-sm btn-outline-custom\">
                                                <i class=\"fas fa-edit\"></i>
                                            </a>
                                            <a href=\"{{ path('app_zone_polluee_qr', {'id': zone.id}) }}\" class=\"btn btn-sm btn-outline-custom\">
                                                <i class=\"fas fa-qrcode\"></i>
                                            </a>
                                            <form method=\"post\" action=\"{{ path('app_zone_polluee_delete', {'id': zone.id}) }}\" style=\"display:inline;\">
                                                <input type=\"hidden\" name=\"_token\" value=\"{{ csrf_token('delete' ~ zone.id) }}\">
                                                <button type=\"submit\" class=\"btn btn-sm btn-outline-custom text-danger\" onclick=\"return confirm('Supprimer cette zone ?')\">
                                                    <i class=\"fas fa-trash\"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                {% endfor %}
                            {% else %}
                                <tr>
                                    <td colspan=\"5\" class=\"text-center py-5\">
                                        <i class=\"fas fa-map-marker-alt fs-1 text-muted mb-3\"></i>
                                        <h6 class=\"text-muted\">Aucune zone polluée</h6>
                                        <p class=\"text-muted small\">Cliquez sur \"Nouvelle Zone\" pour ajouter</p>
                                    </td>
                                </tr>
                            {% endif %}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
{% endblock %}", "zone_polluee/index.html.twig", "C:\\Users\\Mega-PC\\Desktop\\mon-projet\\templates\\zone_polluee\\index.html.twig");
    }
}

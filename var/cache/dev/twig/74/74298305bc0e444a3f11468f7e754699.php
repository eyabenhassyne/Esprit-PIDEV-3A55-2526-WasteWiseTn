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

/* dashboard_intelligent/index.html.twig */
class __TwigTemplate_af8c8b59f1724d9b4e96804316af3424 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "dashboard_intelligent/index.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "dashboard_intelligent/index.html.twig"));

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

        yield "Dashboard Intelligent";
        
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
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_chatbot");
        yield "\" class=\"nav-link\">
                <i class=\"fas fa-robot\"></i>
                <span>Assistant</span>
            </a>
            <a href=\"";
        // line 38
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_dashboard_intelligent");
        yield "\" class=\"nav-link active\">
                <i class=\"fas fa-brain\"></i>
                <span>Dashboard IA</span>
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
        // line 57
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_dashboard");
        yield "\">Dashboard</a></li>
                    <li class=\"breadcrumb-item active\">Dashboard Intelligent</li>
                </ol>
            </nav>
            <div>
                <i class=\"fas fa-bell text-muted me-3\"></i>
                <i class=\"fas fa-user-circle text-muted fs-4\"></i>
            </div>
        </div>

        <div class=\"main-content\">
            <!-- KPI Cards -->
            <div class=\"row g-4 mb-4\">
                <div class=\"col-md-3\">
                    <div class=\"big-card text-center\">
                        <i class=\"fas fa-map-marker-alt fa-2x text-primary mb-2\"></i>
                        <h3 class=\"mb-0\">";
        // line 73
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["total_zones"]) || array_key_exists("total_zones", $context) ? $context["total_zones"] : (function () { throw new RuntimeError('Variable "total_zones" does not exist.', 73, $this->source); })()), "html", null, true);
        yield "</h3>
                        <p class=\"text-muted\">Total Zones</p>
                    </div>
                </div>
                <div class=\"col-md-3\">
                    <div class=\"big-card text-center\">
                        <i class=\"fas fa-exclamation-triangle fa-2x text-danger mb-2\"></i>
                        <h3 class=\"mb-0 text-danger\">";
        // line 80
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["zones_critiques"]) || array_key_exists("zones_critiques", $context) ? $context["zones_critiques"] : (function () { throw new RuntimeError('Variable "zones_critiques" does not exist.', 80, $this->source); })()), "html", null, true);
        yield "</h3>
                        <p class=\"text-muted\">Critiques (≥7)</p>
                    </div>
                </div>
                <div class=\"col-md-3\">
                    <div class=\"big-card text-center\">
                        <i class=\"fas fa-chart-line fa-2x text-warning mb-2\"></i>
                        <h3 class=\"mb-0 text-warning\">";
        // line 87
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["zones_moyennes"]) || array_key_exists("zones_moyennes", $context) ? $context["zones_moyennes"] : (function () { throw new RuntimeError('Variable "zones_moyennes" does not exist.', 87, $this->source); })()), "html", null, true);
        yield "</h3>
                        <p class=\"text-muted\">Moyennes (4-6)</p>
                    </div>
                </div>
                <div class=\"col-md-3\">
                    <div class=\"big-card text-center\">
                        <i class=\"fas fa-check-circle fa-2x text-success mb-2\"></i>
                        <h3 class=\"mb-0 text-success\">";
        // line 94
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["zones_faibles"]) || array_key_exists("zones_faibles", $context) ? $context["zones_faibles"] : (function () { throw new RuntimeError('Variable "zones_faibles" does not exist.', 94, $this->source); })()), "html", null, true);
        yield "</h3>
                        <p class=\"text-muted\">Faibles (≤3)</p>
                    </div>
                </div>
            </div>

            <!-- Graphique et Assistant -->
            <div class=\"row\">
                <div class=\"col-md-6\">
                    <div class=\"big-card\">
                        <h5 class=\"mb-3\">Répartition des zones par niveau</h5>
                        <canvas id=\"zoneChart\"></canvas>
                    </div>
                </div>
                <div class=\"col-md-6\">
                    <div class=\"big-card\">
                        <h5 class=\"mb-3\">Assistant IA</h5>
                        <p class=\"text-muted\">Pose des questions sur tes données :</p>
                        
                        <div class=\"chat-container mb-3\" id=\"chatMessages\" style=\"height: 250px; overflow-y: auto; background: #f8f9fa; border-radius: 8px; padding: 10px;\">
                            <div class=\"text-center text-muted py-4\">
                                <i class=\"fas fa-robot fa-2x mb-2\"></i>
                                <p>Demande-moi une analyse !</p>
                                <small>Ex: \"Quelle est la zone la plus polluée?\"</small>
                            </div>
                        </div>
                        
                        <div class=\"input-group\">
                            <input type=\"text\" class=\"form-control\" id=\"questionInput\" placeholder=\"Ta question...\" onkeypress=\"if(event.key==='Enter') askQuestion()\">
                            <button class=\"btn btn-green\" onclick=\"askQuestion()\">
                                <i class=\"fas fa-paper-plane\"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Comparateur de zones -->
            <div class=\"row mt-4\">
                <div class=\"col-12\">
                    <div class=\"big-card\">
                        <h5 class=\"mb-3\"><i class=\"fas fa-scale-balanced me-2\"></i>Comparateur de zones</h5>
                        <p class=\"text-muted\">Sélectionne deux zones pour les comparer avec l'IA</p>
                        
                        <div class=\"row\">
                            <div class=\"col-md-5\">
                                <select class=\"form-select\" id=\"zone1\">
                                    <option value=\"\">-- Choisis une zone --</option>
                                    ";
        // line 142
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["zones"]) || array_key_exists("zones", $context) ? $context["zones"] : (function () { throw new RuntimeError('Variable "zones" does not exist.', 142, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["zone"]) {
            // line 143
            yield "                                        <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["zone"], "id", [], "any", false, false, false, 143), "html", null, true);
            yield "\" data-niveau=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["zone"], "niveauPollution", [], "any", false, false, false, 143), "html", null, true);
            yield "\">
                                            ";
            // line 144
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["zone"], "nomZone", [], "any", false, false, false, 144), "html", null, true);
            yield " (niveau ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["zone"], "niveauPollution", [], "any", false, false, false, 144), "html", null, true);
            yield "/10)
                                        </option>
                                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['zone'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 147
        yield "                                </select>
                            </div>
                            
                            <div class=\"col-md-2 text-center\">
                                <i class=\"fas fa-vs fa-2x mt-2 text-muted\">VS</i>
                            </div>
                            
                            <div class=\"col-md-5\">
                                <select class=\"form-select\" id=\"zone2\">
                                    <option value=\"\">-- Choisis une zone --</option>
                                    ";
        // line 157
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["zones"]) || array_key_exists("zones", $context) ? $context["zones"] : (function () { throw new RuntimeError('Variable "zones" does not exist.', 157, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["zone"]) {
            // line 158
            yield "                                        <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["zone"], "id", [], "any", false, false, false, 158), "html", null, true);
            yield "\" data-niveau=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["zone"], "niveauPollution", [], "any", false, false, false, 158), "html", null, true);
            yield "\">
                                            ";
            // line 159
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["zone"], "nomZone", [], "any", false, false, false, 159), "html", null, true);
            yield " (niveau ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["zone"], "niveauPollution", [], "any", false, false, false, 159), "html", null, true);
            yield "/10)
                                        </option>
                                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['zone'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 162
        yield "                                </select>
                            </div>
                        </div>
                        
                        <button class=\"btn btn-green mt-3\" onclick=\"compareZones()\">
                            <i class=\"fas fa-brain me-2\"></i>Comparer avec IA
                        </button>
                        
                        <div id=\"comparisonResult\" class=\"mt-4 p-3 rounded-3\" style=\"display: none; background: #f8f9fa; border-left: 4px solid #8bd22f;\">
                            <div class=\"d-flex align-items-center mb-2\">
                                <i class=\"fas fa-robot fa-2x me-3 text-success\"></i>
                                <div id=\"comparisonText\" class=\"flex-grow-1\"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Analyse IA supplémentaire -->
            <div class=\"row mt-4\">
                <div class=\"col-12\">
                    <div class=\"big-card\">
                        <h5 class=\"mb-3\">Analyse automatique</h5>
                        <div class=\"row\">
                            <div class=\"col-md-4\">
                                <div class=\"alert alert-info\">
                                    <i class=\"fas fa-chart-pie me-2\"></i>
                                    <strong>Répartition :</strong> ";
        // line 189
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["zones_critiques"]) || array_key_exists("zones_critiques", $context) ? $context["zones_critiques"] : (function () { throw new RuntimeError('Variable "zones_critiques" does not exist.', 189, $this->source); })()), "html", null, true);
        yield " critiques, ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["zones_moyennes"]) || array_key_exists("zones_moyennes", $context) ? $context["zones_moyennes"] : (function () { throw new RuntimeError('Variable "zones_moyennes" does not exist.', 189, $this->source); })()), "html", null, true);
        yield " moyennes, ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["zones_faibles"]) || array_key_exists("zones_faibles", $context) ? $context["zones_faibles"] : (function () { throw new RuntimeError('Variable "zones_faibles" does not exist.', 189, $this->source); })()), "html", null, true);
        yield " faibles
                                </div>
                            </div>
                            <div class=\"col-md-4\">
                                <div class=\"alert alert-warning\">
                                    <i class=\"fas fa-exclamation-triangle me-2\"></i>
                                    <strong>Priorité :</strong> ";
        // line 195
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["zones_critiques"]) || array_key_exists("zones_critiques", $context) ? $context["zones_critiques"] : (function () { throw new RuntimeError('Variable "zones_critiques" does not exist.', 195, $this->source); })()), "html", null, true);
        yield " zones nécessitent une action immédiate
                                </div>
                            </div>
                            <div class=\"col-md-4\">
                                <div class=\"alert alert-success\">
                                    <i class=\"fas fa-leaf me-2\"></i>
                                    <strong>Bonnes nouvelles :</strong> ";
        // line 201
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["zones_faibles"]) || array_key_exists("zones_faibles", $context) ? $context["zones_faibles"] : (function () { throw new RuntimeError('Variable "zones_faibles" does not exist.', 201, $this->source); })()), "html", null, true);
        yield " zones sont sous contrôle
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src=\"https://cdn.jsdelivr.net/npm/chart.js\"></script>
<script>
    // Graphique
    const ctx = document.getElementById('zoneChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: ";
        // line 218
        yield json_encode((isset($context["chart_data"]) || array_key_exists("chart_data", $context) ? $context["chart_data"] : (function () { throw new RuntimeError('Variable "chart_data" does not exist.', 218, $this->source); })()));
        yield ",
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    let messageCount = 0;

    function askQuestion() {
        const input = document.getElementById('questionInput');
        const question = input.value.trim();
        if (!question) return;
        
        messageCount++;
        const chatDiv = document.getElementById('chatMessages');
        
        // Ajouter la question
        chatDiv.innerHTML += `
            <div class=\"d-flex justify-content-end mb-2\">
                <div class=\"bg-primary text-white p-2 rounded-3\" style=\"max-width: 80%;\">
                    <small>\${question}</small>
                </div>
            </div>
        `;
        
        input.value = '';
        
        // Loading
        const loadingId = 'loading-' + messageCount;
        chatDiv.innerHTML += `
            <div class=\"d-flex mb-2\" id=\"\${loadingId}\">
                <div class=\"bg-light p-2 rounded-3\">
                    <small><i class=\"fas fa-spinner fa-spin\"></i> Analyse...</small>
                </div>
            </div>
        `;
        
        chatDiv.scrollTop = chatDiv.scrollHeight;
        
        // Requête à l'IA
        fetch('";
        // line 263
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_dashboard_intelligent_ask");
        yield "', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'question=' + encodeURIComponent(question)
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById(loadingId)?.remove();
            
            chatDiv.innerHTML += `
                <div class=\"d-flex mb-2\">
                    <div class=\"bg-light p-2 rounded-3\" style=\"max-width: 80%;\">
                        <small><i class=\"fas fa-robot me-1 text-success\"></i> \${data.answer}</small>
                    </div>
                </div>
            `;
            chatDiv.scrollTop = chatDiv.scrollHeight;
        });
    }

    function compareZones() {
        const zone1 = document.getElementById('zone1').value;
        const zone2 = document.getElementById('zone2').value;
        
        if (!zone1 || !zone2) {
            alert('Veuillez sélectionner deux zones');
            return;
        }
        
        if (zone1 === zone2) {
            alert('Veuillez sélectionner deux zones différentes');
            return;
        }
        
        const resultDiv = document.getElementById('comparisonResult');
        const textDiv = document.getElementById('comparisonText');
        
        resultDiv.style.display = 'block';
        textDiv.innerHTML = '<i class=\"fas fa-spinner fa-spin me-2\"></i>L\\'IA analyse les données...';
        
        fetch('/dashboard-intelligent/compare/' + zone1 + '/' + zone2)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    textDiv.innerHTML = '❌ ' + data.error;
                } else {
                    textDiv.innerHTML = `
                        <div class=\"mb-2\">
                            <span class=\"badge bg-\${data.zone1.color} p-2 me-2\">\${data.zone1.nom} (\${data.zone1.niveau}/10)</span>
                            <i class=\"fas fa-vs mx-2\"></i>
                            <span class=\"badge bg-\${data.zone2.color} p-2\">\${data.zone2.nom} (\${data.zone2.niveau}/10)</span>
                        </div>
                        <p class=\"mb-0\">\${data.comparison}</p>
                    `;
                }
            })
            .catch(error => {
                textDiv.innerHTML = '❌ Erreur: ' + error;
            });
    }
</script>

<style>
.chat-container::-webkit-scrollbar {
    width: 5px;
}
.chat-container::-webkit-scrollbar-thumb {
    background: #1a3a2a;
    border-radius: 5px;
}
</style>
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
        return "dashboard_intelligent/index.html.twig";
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
        return array (  446 => 263,  398 => 218,  378 => 201,  369 => 195,  356 => 189,  327 => 162,  316 => 159,  309 => 158,  305 => 157,  293 => 147,  282 => 144,  275 => 143,  271 => 142,  220 => 94,  210 => 87,  200 => 80,  190 => 73,  171 => 57,  149 => 38,  142 => 34,  135 => 30,  128 => 26,  121 => 22,  114 => 18,  100 => 6,  87 => 5,  64 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Dashboard Intelligent{% endblock %}

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
            <a href=\"{{ path('app_chatbot') }}\" class=\"nav-link\">
                <i class=\"fas fa-robot\"></i>
                <span>Assistant</span>
            </a>
            <a href=\"{{ path('app_dashboard_intelligent') }}\" class=\"nav-link active\">
                <i class=\"fas fa-brain\"></i>
                <span>Dashboard IA</span>
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
                    <li class=\"breadcrumb-item active\">Dashboard Intelligent</li>
                </ol>
            </nav>
            <div>
                <i class=\"fas fa-bell text-muted me-3\"></i>
                <i class=\"fas fa-user-circle text-muted fs-4\"></i>
            </div>
        </div>

        <div class=\"main-content\">
            <!-- KPI Cards -->
            <div class=\"row g-4 mb-4\">
                <div class=\"col-md-3\">
                    <div class=\"big-card text-center\">
                        <i class=\"fas fa-map-marker-alt fa-2x text-primary mb-2\"></i>
                        <h3 class=\"mb-0\">{{ total_zones }}</h3>
                        <p class=\"text-muted\">Total Zones</p>
                    </div>
                </div>
                <div class=\"col-md-3\">
                    <div class=\"big-card text-center\">
                        <i class=\"fas fa-exclamation-triangle fa-2x text-danger mb-2\"></i>
                        <h3 class=\"mb-0 text-danger\">{{ zones_critiques }}</h3>
                        <p class=\"text-muted\">Critiques (≥7)</p>
                    </div>
                </div>
                <div class=\"col-md-3\">
                    <div class=\"big-card text-center\">
                        <i class=\"fas fa-chart-line fa-2x text-warning mb-2\"></i>
                        <h3 class=\"mb-0 text-warning\">{{ zones_moyennes }}</h3>
                        <p class=\"text-muted\">Moyennes (4-6)</p>
                    </div>
                </div>
                <div class=\"col-md-3\">
                    <div class=\"big-card text-center\">
                        <i class=\"fas fa-check-circle fa-2x text-success mb-2\"></i>
                        <h3 class=\"mb-0 text-success\">{{ zones_faibles }}</h3>
                        <p class=\"text-muted\">Faibles (≤3)</p>
                    </div>
                </div>
            </div>

            <!-- Graphique et Assistant -->
            <div class=\"row\">
                <div class=\"col-md-6\">
                    <div class=\"big-card\">
                        <h5 class=\"mb-3\">Répartition des zones par niveau</h5>
                        <canvas id=\"zoneChart\"></canvas>
                    </div>
                </div>
                <div class=\"col-md-6\">
                    <div class=\"big-card\">
                        <h5 class=\"mb-3\">Assistant IA</h5>
                        <p class=\"text-muted\">Pose des questions sur tes données :</p>
                        
                        <div class=\"chat-container mb-3\" id=\"chatMessages\" style=\"height: 250px; overflow-y: auto; background: #f8f9fa; border-radius: 8px; padding: 10px;\">
                            <div class=\"text-center text-muted py-4\">
                                <i class=\"fas fa-robot fa-2x mb-2\"></i>
                                <p>Demande-moi une analyse !</p>
                                <small>Ex: \"Quelle est la zone la plus polluée?\"</small>
                            </div>
                        </div>
                        
                        <div class=\"input-group\">
                            <input type=\"text\" class=\"form-control\" id=\"questionInput\" placeholder=\"Ta question...\" onkeypress=\"if(event.key==='Enter') askQuestion()\">
                            <button class=\"btn btn-green\" onclick=\"askQuestion()\">
                                <i class=\"fas fa-paper-plane\"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Comparateur de zones -->
            <div class=\"row mt-4\">
                <div class=\"col-12\">
                    <div class=\"big-card\">
                        <h5 class=\"mb-3\"><i class=\"fas fa-scale-balanced me-2\"></i>Comparateur de zones</h5>
                        <p class=\"text-muted\">Sélectionne deux zones pour les comparer avec l'IA</p>
                        
                        <div class=\"row\">
                            <div class=\"col-md-5\">
                                <select class=\"form-select\" id=\"zone1\">
                                    <option value=\"\">-- Choisis une zone --</option>
                                    {% for zone in zones %}
                                        <option value=\"{{ zone.id }}\" data-niveau=\"{{ zone.niveauPollution }}\">
                                            {{ zone.nomZone }} (niveau {{ zone.niveauPollution }}/10)
                                        </option>
                                    {% endfor %}
                                </select>
                            </div>
                            
                            <div class=\"col-md-2 text-center\">
                                <i class=\"fas fa-vs fa-2x mt-2 text-muted\">VS</i>
                            </div>
                            
                            <div class=\"col-md-5\">
                                <select class=\"form-select\" id=\"zone2\">
                                    <option value=\"\">-- Choisis une zone --</option>
                                    {% for zone in zones %}
                                        <option value=\"{{ zone.id }}\" data-niveau=\"{{ zone.niveauPollution }}\">
                                            {{ zone.nomZone }} (niveau {{ zone.niveauPollution }}/10)
                                        </option>
                                    {% endfor %}
                                </select>
                            </div>
                        </div>
                        
                        <button class=\"btn btn-green mt-3\" onclick=\"compareZones()\">
                            <i class=\"fas fa-brain me-2\"></i>Comparer avec IA
                        </button>
                        
                        <div id=\"comparisonResult\" class=\"mt-4 p-3 rounded-3\" style=\"display: none; background: #f8f9fa; border-left: 4px solid #8bd22f;\">
                            <div class=\"d-flex align-items-center mb-2\">
                                <i class=\"fas fa-robot fa-2x me-3 text-success\"></i>
                                <div id=\"comparisonText\" class=\"flex-grow-1\"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Analyse IA supplémentaire -->
            <div class=\"row mt-4\">
                <div class=\"col-12\">
                    <div class=\"big-card\">
                        <h5 class=\"mb-3\">Analyse automatique</h5>
                        <div class=\"row\">
                            <div class=\"col-md-4\">
                                <div class=\"alert alert-info\">
                                    <i class=\"fas fa-chart-pie me-2\"></i>
                                    <strong>Répartition :</strong> {{ zones_critiques }} critiques, {{ zones_moyennes }} moyennes, {{ zones_faibles }} faibles
                                </div>
                            </div>
                            <div class=\"col-md-4\">
                                <div class=\"alert alert-warning\">
                                    <i class=\"fas fa-exclamation-triangle me-2\"></i>
                                    <strong>Priorité :</strong> {{ zones_critiques }} zones nécessitent une action immédiate
                                </div>
                            </div>
                            <div class=\"col-md-4\">
                                <div class=\"alert alert-success\">
                                    <i class=\"fas fa-leaf me-2\"></i>
                                    <strong>Bonnes nouvelles :</strong> {{ zones_faibles }} zones sont sous contrôle
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src=\"https://cdn.jsdelivr.net/npm/chart.js\"></script>
<script>
    // Graphique
    const ctx = document.getElementById('zoneChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {{ chart_data|json_encode|raw }},
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    let messageCount = 0;

    function askQuestion() {
        const input = document.getElementById('questionInput');
        const question = input.value.trim();
        if (!question) return;
        
        messageCount++;
        const chatDiv = document.getElementById('chatMessages');
        
        // Ajouter la question
        chatDiv.innerHTML += `
            <div class=\"d-flex justify-content-end mb-2\">
                <div class=\"bg-primary text-white p-2 rounded-3\" style=\"max-width: 80%;\">
                    <small>\${question}</small>
                </div>
            </div>
        `;
        
        input.value = '';
        
        // Loading
        const loadingId = 'loading-' + messageCount;
        chatDiv.innerHTML += `
            <div class=\"d-flex mb-2\" id=\"\${loadingId}\">
                <div class=\"bg-light p-2 rounded-3\">
                    <small><i class=\"fas fa-spinner fa-spin\"></i> Analyse...</small>
                </div>
            </div>
        `;
        
        chatDiv.scrollTop = chatDiv.scrollHeight;
        
        // Requête à l'IA
        fetch('{{ path('app_dashboard_intelligent_ask') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'question=' + encodeURIComponent(question)
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById(loadingId)?.remove();
            
            chatDiv.innerHTML += `
                <div class=\"d-flex mb-2\">
                    <div class=\"bg-light p-2 rounded-3\" style=\"max-width: 80%;\">
                        <small><i class=\"fas fa-robot me-1 text-success\"></i> \${data.answer}</small>
                    </div>
                </div>
            `;
            chatDiv.scrollTop = chatDiv.scrollHeight;
        });
    }

    function compareZones() {
        const zone1 = document.getElementById('zone1').value;
        const zone2 = document.getElementById('zone2').value;
        
        if (!zone1 || !zone2) {
            alert('Veuillez sélectionner deux zones');
            return;
        }
        
        if (zone1 === zone2) {
            alert('Veuillez sélectionner deux zones différentes');
            return;
        }
        
        const resultDiv = document.getElementById('comparisonResult');
        const textDiv = document.getElementById('comparisonText');
        
        resultDiv.style.display = 'block';
        textDiv.innerHTML = '<i class=\"fas fa-spinner fa-spin me-2\"></i>L\\'IA analyse les données...';
        
        fetch('/dashboard-intelligent/compare/' + zone1 + '/' + zone2)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    textDiv.innerHTML = '❌ ' + data.error;
                } else {
                    textDiv.innerHTML = `
                        <div class=\"mb-2\">
                            <span class=\"badge bg-\${data.zone1.color} p-2 me-2\">\${data.zone1.nom} (\${data.zone1.niveau}/10)</span>
                            <i class=\"fas fa-vs mx-2\"></i>
                            <span class=\"badge bg-\${data.zone2.color} p-2\">\${data.zone2.nom} (\${data.zone2.niveau}/10)</span>
                        </div>
                        <p class=\"mb-0\">\${data.comparison}</p>
                    `;
                }
            })
            .catch(error => {
                textDiv.innerHTML = '❌ Erreur: ' + error;
            });
    }
</script>

<style>
.chat-container::-webkit-scrollbar {
    width: 5px;
}
.chat-container::-webkit-scrollbar-thumb {
    background: #1a3a2a;
    border-radius: 5px;
}
</style>
{% endblock %}", "dashboard_intelligent/index.html.twig", "C:\\Users\\Mega-PC\\Desktop\\mon-projet\\templates\\dashboard_intelligent\\index.html.twig");
    }
}

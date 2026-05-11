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

/* chatbot/index.html.twig */
class __TwigTemplate_4794a5a19131e3f723cb26fc7f2be32a extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "chatbot/index.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "chatbot/index.html.twig"));

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

        yield "Assistant IA - WasteWise";
        
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
        yield "\" class=\"nav-link active\">
                <i class=\"fas fa-robot\"></i>
                <span>Assistant IA</span>
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
                    <li class=\"breadcrumb-item active\">Assistant IA</li>
                </ol>
            </nav>
            <div>
                <i class=\"fas fa-bell text-muted me-3\"></i>
                <i class=\"fas fa-user-circle text-muted fs-4\"></i>
            </div>
        </div>

        <div class=\"main-content\">
            <div class=\"big-card\">
                <h4 class=\"mb-4\"><i class=\"fas fa-robot me-2 text-primary\"></i>Assistant IA WasteWise</h4>
                <p class=\"text-muted mb-4\">Posez des questions sur la gestion des déchets, le recyclage, et les zones polluées.</p>
                
                <div class=\"chat-container mb-4\" id=\"chatMessages\" style=\"height: 400px; overflow-y: auto; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px; background: #f8f9fa;\">
                    <div class=\"text-center text-muted py-5\" id=\"welcomeMessage\">
                        <i class=\"fas fa-robot fa-3x mb-3\"></i>
                        <h5>Bonjour ! 👋</h5>
                        <p>Comment puis-je vous aider avec la gestion des déchets aujourd'hui ?</p>
                    </div>
                </div>
                
                <div class=\"input-group\">
                    <input type=\"text\" class=\"form-control\" id=\"questionInput\" placeholder=\"Posez votre question...\" onkeypress=\"if(event.key==='Enter') sendMessage()\">
                    <button class=\"btn btn-green\" onclick=\"sendMessage()\">
                        <i class=\"fas fa-paper-plane\"></i> Envoyer
                    </button>
                </div>
                <small class=\"text-muted mt-2 d-block\">Exemples: \"Comment recycler le plastique?\", \"Que faire des déchets électroniques?\", \"Impact du verre sur l'environnement\"</small>
            </div>
        </div>
    </div>
</div>

<script>
let messageCount = 0;

function sendMessage() {
    const input = document.getElementById('questionInput');
    const question = input.value.trim();
    if (!question) return;
    
    messageCount++;
    const chatDiv = document.getElementById('chatMessages');
    const welcomeMsg = document.getElementById('welcomeMessage');
    if (welcomeMsg) welcomeMsg.style.display = 'none';
    
    // Add user message
    chatDiv.innerHTML += `
        <div class=\"d-flex justify-content-end mb-3\">
            <div class=\"bg-primary text-white p-3 rounded-3\" style=\"max-width: 70%;\">
                <strong>Vous:</strong><br>\${question}
            </div>
        </div>
    `;
    
    // Clear input
    input.value = '';
    
    // Add loading indicator
    const loadingId = 'loading-' + messageCount;
    chatDiv.innerHTML += `
        <div class=\"d-flex mb-3\" id=\"\${loadingId}\">
            <div class=\"bg-light p-3 rounded-3\">
                <i class=\"fas fa-spinner fa-spin\"></i> L'assistant réfléchit...
            </div>
        </div>
    `;
    
    // Scroll to bottom
    chatDiv.scrollTop = chatDiv.scrollHeight;
    
    // Send to server
    fetch('";
        // line 127
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_chatbot_ask");
        yield "', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'question=' + encodeURIComponent(question)
    })
    .then(response => response.json())
    .then(data => {
        // Remove loading
        document.getElementById(loadingId)?.remove();
        
        // Add bot response
        chatDiv.innerHTML += `
            <div class=\"d-flex mb-3\">
                <div class=\"bg-light p-3 rounded-3\" style=\"max-width: 70%;\">
                    <strong class=\"text-success\">Assistant:</strong><br>\${data.answer}
                </div>
            </div>
        `;
        chatDiv.scrollTop = chatDiv.scrollHeight;
    })
    .catch(error => {
        document.getElementById(loadingId)?.remove();
        chatDiv.innerHTML += `
            <div class=\"d-flex mb-3\">
                <div class=\"bg-danger text-white p-3 rounded-3\">
                    Erreur: Impossible de contacter l'assistant. Veuillez réessayer.
                </div>
            </div>
        `;
    });
}
</script>

<style>
.chat-container {
    background: white;
}
.chat-container::-webkit-scrollbar {
    width: 8px;
}
.chat-container::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}
.chat-container::-webkit-scrollbar-thumb {
    background: #1a3a2a;
    border-radius: 10px;
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
        return "chatbot/index.html.twig";
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
        return array (  241 => 127,  164 => 53,  142 => 34,  135 => 30,  128 => 26,  121 => 22,  114 => 18,  100 => 6,  87 => 5,  64 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Assistant IA - WasteWise{% endblock %}

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
            <a href=\"{{ path('app_chatbot') }}\" class=\"nav-link active\">
                <i class=\"fas fa-robot\"></i>
                <span>Assistant IA</span>
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
                    <li class=\"breadcrumb-item active\">Assistant IA</li>
                </ol>
            </nav>
            <div>
                <i class=\"fas fa-bell text-muted me-3\"></i>
                <i class=\"fas fa-user-circle text-muted fs-4\"></i>
            </div>
        </div>

        <div class=\"main-content\">
            <div class=\"big-card\">
                <h4 class=\"mb-4\"><i class=\"fas fa-robot me-2 text-primary\"></i>Assistant IA WasteWise</h4>
                <p class=\"text-muted mb-4\">Posez des questions sur la gestion des déchets, le recyclage, et les zones polluées.</p>
                
                <div class=\"chat-container mb-4\" id=\"chatMessages\" style=\"height: 400px; overflow-y: auto; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px; background: #f8f9fa;\">
                    <div class=\"text-center text-muted py-5\" id=\"welcomeMessage\">
                        <i class=\"fas fa-robot fa-3x mb-3\"></i>
                        <h5>Bonjour ! 👋</h5>
                        <p>Comment puis-je vous aider avec la gestion des déchets aujourd'hui ?</p>
                    </div>
                </div>
                
                <div class=\"input-group\">
                    <input type=\"text\" class=\"form-control\" id=\"questionInput\" placeholder=\"Posez votre question...\" onkeypress=\"if(event.key==='Enter') sendMessage()\">
                    <button class=\"btn btn-green\" onclick=\"sendMessage()\">
                        <i class=\"fas fa-paper-plane\"></i> Envoyer
                    </button>
                </div>
                <small class=\"text-muted mt-2 d-block\">Exemples: \"Comment recycler le plastique?\", \"Que faire des déchets électroniques?\", \"Impact du verre sur l'environnement\"</small>
            </div>
        </div>
    </div>
</div>

<script>
let messageCount = 0;

function sendMessage() {
    const input = document.getElementById('questionInput');
    const question = input.value.trim();
    if (!question) return;
    
    messageCount++;
    const chatDiv = document.getElementById('chatMessages');
    const welcomeMsg = document.getElementById('welcomeMessage');
    if (welcomeMsg) welcomeMsg.style.display = 'none';
    
    // Add user message
    chatDiv.innerHTML += `
        <div class=\"d-flex justify-content-end mb-3\">
            <div class=\"bg-primary text-white p-3 rounded-3\" style=\"max-width: 70%;\">
                <strong>Vous:</strong><br>\${question}
            </div>
        </div>
    `;
    
    // Clear input
    input.value = '';
    
    // Add loading indicator
    const loadingId = 'loading-' + messageCount;
    chatDiv.innerHTML += `
        <div class=\"d-flex mb-3\" id=\"\${loadingId}\">
            <div class=\"bg-light p-3 rounded-3\">
                <i class=\"fas fa-spinner fa-spin\"></i> L'assistant réfléchit...
            </div>
        </div>
    `;
    
    // Scroll to bottom
    chatDiv.scrollTop = chatDiv.scrollHeight;
    
    // Send to server
    fetch('{{ path('app_chatbot_ask') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'question=' + encodeURIComponent(question)
    })
    .then(response => response.json())
    .then(data => {
        // Remove loading
        document.getElementById(loadingId)?.remove();
        
        // Add bot response
        chatDiv.innerHTML += `
            <div class=\"d-flex mb-3\">
                <div class=\"bg-light p-3 rounded-3\" style=\"max-width: 70%;\">
                    <strong class=\"text-success\">Assistant:</strong><br>\${data.answer}
                </div>
            </div>
        `;
        chatDiv.scrollTop = chatDiv.scrollHeight;
    })
    .catch(error => {
        document.getElementById(loadingId)?.remove();
        chatDiv.innerHTML += `
            <div class=\"d-flex mb-3\">
                <div class=\"bg-danger text-white p-3 rounded-3\">
                    Erreur: Impossible de contacter l'assistant. Veuillez réessayer.
                </div>
            </div>
        `;
    });
}
</script>

<style>
.chat-container {
    background: white;
}
.chat-container::-webkit-scrollbar {
    width: 8px;
}
.chat-container::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}
.chat-container::-webkit-scrollbar-thumb {
    background: #1a3a2a;
    border-radius: 10px;
}
</style>
{% endblock %}", "chatbot/index.html.twig", "C:\\Users\\Mega-PC\\Desktop\\mon-projet\\templates\\chatbot\\index.html.twig");
    }
}

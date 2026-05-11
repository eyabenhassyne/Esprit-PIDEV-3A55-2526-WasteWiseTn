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

/* emails/zone_alert.html.twig */
class __TwigTemplate_5f88fa0e776d1311bcc9875bf1f4d43a extends Template
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
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "emails/zone_alert.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "emails/zone_alert.html.twig"));

        // line 1
        yield "<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { background: #1a3a2a; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; }
        .info { background: #f0f0f0; padding: 15px; border-radius: 5px; }
    </style>
</head>
<body>
    <div class=\"header\">
        <h1>WasteWise TN</h1>
    </div>
    <div class=\"content\">
        <h2>🚨 Nouvelle zone polluée</h2>
        <div class=\"info\">
            <p><strong>Nom:</strong> ";
        // line 18
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["zone"]) || array_key_exists("zone", $context) ? $context["zone"] : (function () { throw new RuntimeError('Variable "zone" does not exist.', 18, $this->source); })()), "nomZone", [], "any", false, false, false, 18), "html", null, true);
        yield "</p>
            <p><strong>Niveau:</strong> ";
        // line 19
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["zone"]) || array_key_exists("zone", $context) ? $context["zone"] : (function () { throw new RuntimeError('Variable "zone" does not exist.', 19, $this->source); })()), "niveauPollution", [], "any", false, false, false, 19), "html", null, true);
        yield "/10</p>
            <p><strong>GPS:</strong> ";
        // line 20
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["zone"]) || array_key_exists("zone", $context) ? $context["zone"] : (function () { throw new RuntimeError('Variable "zone" does not exist.', 20, $this->source); })()), "coordonneesGps", [], "any", false, false, false, 20), "html", null, true);
        yield "</p>
            <p><strong>Date:</strong> ";
        // line 21
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, (isset($context["zone"]) || array_key_exists("zone", $context) ? $context["zone"] : (function () { throw new RuntimeError('Variable "zone" does not exist.', 21, $this->source); })()), "dateIdentification", [], "any", false, false, false, 21), "d/m/Y H:i"), "html", null, true);
        yield "</p>
        </div>
    </div>
</body>
</html>";
        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "emails/zone_alert.html.twig";
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
        return array (  79 => 21,  75 => 20,  71 => 19,  67 => 18,  48 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { background: #1a3a2a; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; }
        .info { background: #f0f0f0; padding: 15px; border-radius: 5px; }
    </style>
</head>
<body>
    <div class=\"header\">
        <h1>WasteWise TN</h1>
    </div>
    <div class=\"content\">
        <h2>🚨 Nouvelle zone polluée</h2>
        <div class=\"info\">
            <p><strong>Nom:</strong> {{ zone.nomZone }}</p>
            <p><strong>Niveau:</strong> {{ zone.niveauPollution }}/10</p>
            <p><strong>GPS:</strong> {{ zone.coordonneesGps }}</p>
            <p><strong>Date:</strong> {{ zone.dateIdentification|date('d/m/Y H:i') }}</p>
        </div>
    </div>
</body>
</html>", "emails/zone_alert.html.twig", "C:\\Users\\Mega-PC\\Desktop\\mon-projet\\templates\\emails\\zone_alert.html.twig");
    }
}

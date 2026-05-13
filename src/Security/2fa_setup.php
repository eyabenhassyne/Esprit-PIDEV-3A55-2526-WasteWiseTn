{% extends 'auth/base_auth.html.twig' %}

{% block title %}Activer 2FA | WasteWise TN{% endblock %}

{% block body %}
<main class="min-vh-100 d-flex align-items-center auth-page">
  <div class="container" style="max-width: 560px;">
    <div class="card shadow-sm border-0 p-4">
      <h2 class="h4 mb-2 text-center">📲 Activation Google Authenticator</h2>
      <p class="text-muted text-center mb-3">
        Scanne le QR code avec Google Authenticator, puis saisis le code pour activer.
      </p>

      {% if error %}
        <div class="alert alert-danger py-2">{{ error }}</div>
      {% endif %}

      <div class="text-center mb-3">
        <img alt="QR Code" class="img-fluid" style="max-width:260px"
             src="data:image/png;base64,{{ qrBase64 }}">
        <div class="small text-muted mt-2">
          (Secret: <code>{{ secret }}</code>)
        </div>
      </div>

      <form method="post">
        <div class="mb-3">
          <label class="form-label">Code (6 chiffres)</label>
          <input class="form-control form-control-lg text-center"
                 name="code" inputmode="numeric" pattern="[0-9]{6}"
                 maxlength="6" required autofocus>
        </div>
        <button class="btn btn-primary w-100 btn-lg">Activer</button>
      </form>

      <div class="text-center mt-3">
        <a class="small" href="{{ path('app_logout') }}">Annuler</a>
      </div>
    </div>
  </div>
</main>
{% endblock %}
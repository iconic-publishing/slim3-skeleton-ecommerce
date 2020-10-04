{% extends 'layouts/web-layout.php' %}

{% block scripts_recaptcha %}
{% include 'pages/web/_includes/_files/scripts/recaptcha.php' %}
{% endblock %}

{% block content %}

	<div class="container padding-xs">
		<div class="row justify-content-center">
			<div class="col-lg-6">
				<p><a href="{{ path_for('index') }}">Back to Homepage</a></p>

				<h2>Recover Password Page</h2>

				<hr>

				{% include 'components/messages/messages.php' %}

				<form id="recover-form" action="{{ path_for('postRecoverPassword') }}" method="post" autocomplete="{{ config.app.autocomplete }}">
					<div class="form-row">
						<div class="col-lg-12 mb-3">
							<label>Email Address <span class="red">*</span></label>
							<input type="text" class="form-control" name="email_address">
							<label for="email_address" class="invalid-feedback error"></label>
						</div>

						<div class="g-recaptcha" data-sitekey="{{ config.recaptcha.invisible.siteKey }}" data-callback="onSubmit" data-size="invisible" data-badge="{{ config.recaptcha.invisible.badge }}"></div>

						<div class="col-lg-12">
							<button type="submit" id="recover" class="btn btn-primary btn-block">RECOVER PASSWORD</button>
							<button type="button" id="recover-hide" class="btn btn-primary btn-block softhide" disabled><i class="fa fa-refresh fa-pulse"></i> Processing...</button>
						</div>
					</div>

					{{ csrf.field | raw }}
				</form>
			</div>
		</div>
	</div>
	
{% endblock %}

{% block scripts_forms %}
    {% include 'pages/web/_includes/_files/scripts/recover-form.php' %}
{% endblock %}
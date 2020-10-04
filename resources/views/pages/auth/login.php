{% extends 'layouts/web-layout.php' %}

{% block scripts_recaptcha %}
{% include 'pages/web/_includes/_files/scripts/recaptcha.php' %}
{% endblock %}

{% block content %}

	<div class="container padding-xs">
		<div class="row justify-content-center">
			<div class="col-lg-6">
				<p><a href="{{ path_for('index') }}">Back to Homepage</a></p>

				<h2>Login Page</h2>

				<hr>

				{% include 'components/messages/messages.php' %}

				<form id="login-form" action="{{ path_for('postLogin') }}" method="post" autocomplete="{{ config.app.autocomplete }}">
					<div class="form-row">
						<div class="col-lg-6 mb-3">
							<label>Email or Username <span class="red">*</span></label>
							<input type="text" class="form-control" name="email_or_username">
							<label for="email_or_username" class="invalid-feedback error"></label>
						</div>
						
						<div class="col-lg-6 mb-3">
							<label>Password <span class="red">*</span></label>
							<input type="password" class="form-control" name="password">
							<label for="password" class="invalid-feedback error"></label>
						</div>

						<div class="g-recaptcha" data-sitekey="{{ config.recaptcha.invisible.siteKey }}" data-callback="onSubmit" data-size="invisible" data-badge="{{ config.recaptcha.invisible.badge }}"></div>

						<div class="col-lg-12">
							<button type="submit" id="login" class="btn btn-primary btn-block">LOGIN</button>
							<button type="button" id="login-hide" class="btn btn-primary btn-block softhide" disabled><i class="fa fa-refresh fa-pulse"></i> Processing...</button>
						</div>
					</div>

					{{ csrf.field | raw }}
				</form>
			</div>
		</div>
	</div>
	
{% endblock %}

{% block scripts_forms %}
    {% include 'pages/web/_includes/_files/scripts/login-form.php' %}
{% endblock %}
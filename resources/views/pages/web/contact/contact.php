{% extends 'layouts/web-layout.php' %}

{% block css_number_verify %}
{% include 'pages/web/_includes/_files/css/number-verify.php' %}
{% endblock %}

{% block scripts_recaptcha %}
{% include 'pages/web/_includes/_files/scripts/recaptcha.php' %}
{% endblock %}

{% block content %}

	<div class="container padding-xs">
		<div class="row justify-content-center">
			<div class="col-lg-6">
				<p><a href="{{ path_for('index') }}">Back to Homepage</a></p>

				<h2>Contact Page</h2>

				<hr>

				{% include 'components/messages/messages.php' %}
				
				<form id="contact-form" action="{{ path_for('postContact') }}" method="post" autocomplete="{{ config.app.autocomplete }}">
					<div class="form-row">
						<div class="col-lg-6 mb-3">
							<label>First Name <span class="red">*</span></label>
							<input type="text" class="form-control" name="first_name" value="{{ persist.first_name }}">
							<label for="first_name" class="invalid-feedback error"></label>
						</div>
						
						<div class="col-lg-6 mb-3">
							<label>Last Name <span class="red">*</span></label>
							<input type="text" class="form-control" name="last_name" value="{{ persist.last_name }}">
							<label for="last_name" class="invalid-feedback error"></label>
						</div>
						
						<div class="col-lg-6 mb-3">
							<label>Email Address <span class="red">*</span></label>
							<input type="text" class="form-control" name="email_address" value="{{ persist.email_address }}">
							<label for="email_address" class="invalid-feedback error"></label>
						</div>
						
						<div class="col-lg-6 mb-3">
							<label>Phone Number <span class="red">*</span></label>
							<input type="text" class="form-control" name="phone_number" id="phone_number" value="{{ persist.phone_number }}">
							<label for="phone_number" class="invalid-feedback error"></label>

							<input type="hidden" name="phone_number_valid" id="phone_number_valid" value="">
							<!--<span id="valid-msg" class="valid-number softhide text-success terms-text"></span>-->
							<span id="error-msg" class="invalid-number softhide text-danger terms-text"></span>
						</div>

						<div class="col-lg-6 mb-3">
							<label>Country <span class="red">*</span></label>
							<select class="form-control" name="country">
								<option class="select-placeholder" disabled selected></option>
								{% for country in select.country() %}
									<option value="{{ country }}" {{ (country == persist.country) ? 'selected' : '' }}>{{ country }}</option>
								{% endfor %}
							</select>
							<label for="country" class="invalid-feedback error"></label>
						</div>
						
						<div class="col-lg-6 mb-3">
							<label>Department <span class="red">*</span></label>
							<select class="form-control" name="department">
								<option class="select-placeholder" disabled selected></option>
								{% for department in select.department() %}
									<option value="{{ department }}" {{ (department == persist.department) ? 'selected' : '' }}>{{ department }}</option>
								{% endfor %}
							</select>
							<label for="department" class="invalid-feedback error"></label>
						</div>
						
						<div class="col-lg-12 mb-3">
							<label>Subject <span class="red">*</span></label>
							<input type="text" class="form-control" name="subject" value="{{ persist.subject }}">
							<label for="subject" class="invalid-feedback error"></label>
						</div>
						
						<div class="col-lg-12 mb-3">
							<label>Message <span class="red">*</span></label>
							<textarea class="form-control" name="message" rows="8">{{ persist.message }}</textarea>
							<label for="message" class="invalid-feedback error"></label>
						</div>

						<div class="col-lg-12 mb-3">
							<div class="custom-control custom-switch">
								<input type="checkbox" class="custom-control-input" name="gdpr" id="gdpr" {{ persist.gdpr == true ? 'checked' : '' }}>
								<label for="gdpr" class="custom-control-label terms-text">I agree to receive product emails in conjuction with our <a href="">Privacy Policy</a></label>
								<label for="gdpr" class="invalid-feedback error"></label>
							</div>
						</div>
						
						<div class="g-recaptcha" data-sitekey="{{ config.recaptcha.invisible.siteKey }}" data-callback="onSubmit" data-size="invisible" data-badge="{{ config.recaptcha.invisible.badge }}"></div>

						<div class="col-lg-12">
							<button type="submit" id="contact" class="btn btn-primary btn-block">SEND MESSAGE</button>
							<button type="button" id="contact-hide" class="btn btn-primary btn-block softhide" disabled><i class="fa fa-refresh fa-pulse"></i> Sending Message...</button>
						</div>
					</div>

					{{ csrf.field | raw }}
				</form>
			</div>
		</div>
	</div>

{% endblock %}

{% block scripts_forms %}
    {% include 'pages/web/_includes/_files/scripts/contact-form.php' %}
{% endblock %}

{% block scripts_number_verify %}
    {% include 'pages/web/_includes/_files/scripts/number-verify.php' %}
{% endblock %}
                     
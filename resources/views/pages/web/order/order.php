{% extends 'layouts/web-layout.php' %}

{% block scripts_recaptcha %}
{% include 'pages/web/_includes/_files/scripts/recaptcha.php' %}
{% endblock %}

{% block content %}

	<div class="container padding-xs">
		<div class="row">
			<div class="col-lg-12">
                <p><a href="{{ path_for('getCart') }}">Back to Shopping Basket</a></p>

                <h2>Checkout Page</h2>

                <hr>
			</div>
        </div>

        <form id="payment-form" action="{{ path_for('postOrder') }}" method="post" autocomplete="{{ config.app.autocomplete }}">
            <div class="row">
                <div class="col-md-4">
                    <div class="well">
                        <h4>Peronal Details</h4>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label>Title <span class="red">*</span></label>
                                <select class="form-control" name="title">
                                    <option class="select-placeholder" disabled selected></option>
                                    {% for title in select.title() %}
                                        <option value="{{ title }}">{{ title }}</option>
                                    {% endfor %}
                                </select>
                                <label for="title" class="invalid-feedback error"></label>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>First Name <span class="red">*</span></label>
                                <input type="text" class="form-control" name="first_name">
                                <label for="first_name" class="invalid-feedback error"></label>
                            </div>
                            
                            <div class="col-md-12 mb-3">
                                <label>Last Name <span class="red">*</span></label>
                                <input type="text" class="form-control" name="last_name">
                                <label for="last_name" class="invalid-feedback error"></label>
                            </div>
                            
                            <div class="col-md-12 mb-3">
                                <label>Email Address <span class="red">*</span></label>
                                <input type="text" class="form-control" name="email_address">
                                <label for="email_address" class="invalid-feedback error"></label>
                            </div>
                            
                            <div class="col-md-12 mb-3">
                                <label>Phone Number <span class="red">*</span></label>
                                <input type="text" class="form-control" name="phone_number">
                                <label for="phone_number" class="invalid-feedback error"></label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="well">
                        <h4>Shipping Details</h4>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label>Address <span class="red">*</span></label>
                                <input type="text" class="form-control" name="address">
                                <label for="address" class="invalid-feedback error"></label>
                            </div>
                            
                            <div class="col-md-12 mb-3">
                                <label>City <span class="red">*</span></label>
                                <input type="text" class="form-control" name="city">
                                <label for="city" class="invalid-feedback error"></label>
                            </div>
                            
                            <div class="col-md-12 mb-3">
                                <label>County <span class="red">*</span></label>
                                <input type="text" class="form-control" name="county">
                                <label for="county" class="invalid-feedback error"></label>
                            </div>
                            
                            <div class="col-md-12 mb-3">
                                <label>Postcode <span class="red">*</span></label>
                                <input type="text" class="form-control" name="postcode">
                                <label for="postcode" class="invalid-feedback error"></label>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Country <span class="red">*</span></label>
                                <select class="form-control" name="country">
                                    <option class="select-placeholder" disabled selected></option>
                                    {% for country in select.country() %}
                                        <option value="{{ country }}">{{ country }}</option>
                                    {% endfor %}
                                </select>
                                <label for="country" class="invalid-feedback error"></label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    {% if basket.itemCount and basket.subTotal %}
                        {% set total = (basket.subTotal + basket.shipping) | number_format(2) %}
                        <div class="well">
                            <h4>Card Details</h4>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label>Cardholder Name <span class="red">*</span></label>
                                    <input type="text" class="form-control" name="cardholder_name" id="cardholder_name">
                                    <label for="cardholder_name" class="invalid-feedback error"></label>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label>Card Details <span class="red">*</span></label>
                                    <div id="card-element"></div>
                                    <div id="card-errors" class="text-danger" role="alert"></div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" name="terms_accepted" id="terms_accepted">
                                        <label for="terms_accepted" class="custom-control-label terms-text">I agree that I have read the <a href="">Terms and Conditions</a></label>
                                        <label for="terms_accepted" class="invalid-feedback error"></label>
                                    </div>

                                    <hr>

                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" name="gdpr" id="gdpr">
                                        <label for="gdpr" class="custom-control-label terms-text">I agree to receive product emails in conjuction with our <a href="">Privacy Policy</a></label>
                                        <label for="gdpr" class="invalid-feedback error"></label>
                                    </div>
                                </div>
                            </div>

                            <div class="g-recaptcha" data-sitekey="{{ config.recaptcha.invisible.siteKey }}" data-callback="onSubmit" data-size="invisible" data-badge="{{ config.recaptcha.invisible.badge }}"></div>

							<button type="submit" id="payment" class="btn btn-primary btn-block bold">PAY £{{ total }}</button>
							<button type="button" id="payment-hide" class="btn btn-primary btn-block softhide" disabled><i class="fa fa-refresh fa-pulse"></i> Processing...</button>

                            <hr>

                            <h4>Payment Summary</h4>

                            <table class="table">
                                <tr>
                                    <td>Sub total</td>
                                    <td>£{{ basket.subTotal | number_format(2) }}</td>
                                </tr>
                                <tr>
                                    <td>Shipping</td>
                                    <td>£{{ basket.shipping | number_format(2) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-success bold">TOTAL</td>
                                    <td class="text-success bold">£{{ total }}</td>
                                </tr>
                            </table>

                        </div>
                    {% endif %}
                </div>

                <div class="col-md-12">
                    <hr>

                    <div class="text-center">
                        <h5>Credit or Debit Cards Accepted</h5>

                        <i class="fa fa-cc-visa fa-2x"></i>
                        <i class="fa fa-cc-mastercard fa-2x"></i>
                        <i class="fa fa-cc-amex fa-2x"></i>
                        <i class="fa fa-cc-stripe fa-2x"></i>
                    </div>
                </div>
            </div>

            {{ csrf.field | raw }}
        </form>
	</div>

{% endblock %}

{% block scripts_forms %}
    {% include 'pages/web/_includes/_files/scripts/payment-form.php' %}
{% endblock %}

{% block scripts_stripe %}
    {% include 'pages/web/_includes/_files/scripts/stripe.php' %}
{% endblock %}

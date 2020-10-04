
        <script src="{{ base_url() }}/layouts/web/plugins/jquery-validation-1.19.2/dist/jquery.validate.min.js"></script>
		<script src="{{ base_url() }}/layouts/web/plugins/jquery-validation-1.19.2/dist/additional-methods.min.js"></script>
		<script>
			$('select').on('change', function () {
				$(this).valid();
			});

			$('#payment-form').validate({
				errorElement: 'label',
				errorPlacement: function (error, element) {
					error.insertAfter('invalid-feedback');
				},
				highlight: function(element, errorClass, validClass) {
					$(element).closest('.form-control').addClass('is-invalid');
				},
				unhighlight: function(element, errorClass, validClass) {
					$(element).closest('.form-control').removeClass('is-invalid').addClass('is-valid');
				},
				rules: {
					title: {
						required: true
					},
					first_name: {
						required: true
					},
					last_name: {
						required: true
					},
					email_address: {
						required: true,
						email: true
					},
					phone_number: {
						required: true
					},
					address: {
						required: true
					},
					city: {
						required: true
					},
					county: {
						required: true
					},
					postcode: {
						required: true
					},
					country: {
						required: true
					},
					cardholder_name: {
						required: true
					},
					terms_accepted: {
						required: true
					}
				},
				messages: {
					title: {
						required: 'Your title is incomplete.'
					},
					first_name: {
						required: 'Your first name incomplete.'
					},
					last_name: {
						required: 'Your last name is incomplete.'
					},
					email_address: {
						required: 'Your email address is incomplete.'
					},
					phone_number: {
						required: 'Your phone number is incomplete.'
					},
					address: {
						required: 'Your address is incomplete.'
					},
					city: {
						required: 'Your city is incomplete.'
					},
					county: {
						required: 'Your county is incomplete.'
					},
					postcode: {
						required: 'Your postcode is incomplete.'
					},
					country: {
						required: 'Your country is incomplete.'
					},
					cardholder_name: {
						required: 'Your cardholder name is incomplete.'
					},
					terms_accepted: {
						required: 'Check the box to agree to our Terms and Conditions.'
					}
				},
				submitHandler: function (form) {
					grecaptcha.execute();
				}
			});

			function onSubmit(token) {
				$('#payment').addClass('softhide');
				$('#payment-hide').removeClass('softhide');

				setTimeout(function() {
					document.getElementById('payment-form').submit();
				}, {{ config.app.form.timeout }});
			};
		</script>
	
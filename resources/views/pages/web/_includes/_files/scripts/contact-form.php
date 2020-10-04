
        <script src="{{ base_url() }}/layouts/web/plugins/jquery-validation-1.19.2/dist/jquery.validate.min.js"></script>
		<script src="{{ base_url() }}/layouts/web/plugins/jquery-validation-1.19.2/dist/additional-methods.min.js"></script>
		<script>
			$('select').on('change', function () {
				$(this).valid();
			});

			$('#contact-form').validate({
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
					mobile_number: {
						required: true
					},
					country: {
						required: true
					},
					department: {
						required: true
					},
					subject: {
						required: true
					},
					message: {
						required: true
					}
				},
				messages: {
					first_name: {
						required: 'First Name is required!'
					},
					last_name: {
						required: 'Last Name is required!'
					},
					email_address: {
						required: 'Email Address is required!'
					},
					mobile_number: {
						required: 'Mobile Number is required!'
					},
					country: {
						required: 'Country is required!'
					},
					department: {
						required: 'Department is required!'
					},
					subject: {
						required: 'Subject is required!'
					},
					message: {
						required: 'Message is required!'
					}
				},
				submitHandler: function (form) {
					grecaptcha.execute();
				}
			});

			function onSubmit(token) {
				$('#contact').addClass('softhide');
				$('#contact-hide').removeClass('softhide');

				setTimeout(function() {
					document.getElementById('contact-form').submit();
				}, {{ config.app.form.timeout }});
			};
		</script>
		
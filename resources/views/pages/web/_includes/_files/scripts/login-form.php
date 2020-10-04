
        <script src="{{ base_url() }}/layouts/web/plugins/jquery-validation-1.19.2/dist/jquery.validate.min.js"></script>
		<script src="{{ base_url() }}/layouts/web/plugins/jquery-validation-1.19.2/dist/additional-methods.min.js"></script>
		<script>
			$('select').on('change', function () {
				$(this).valid();
			});

			$('#login-form').validate({
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
					email_or_username: {
						required: true
					},
					password: {
						required: true
					}
				},
				messages: {
					email_or_username: {
						required: 'Email or Username is required!'
					},
					password: {
						required: 'Password is required!'
					}
				},
				submitHandler: function (form) {
					grecaptcha.execute();
				}
			});

			function onSubmit(token) {
				$('#login').addClass('softhide');
				$('#login-hide').removeClass('softhide');

				setTimeout(function() {
					document.getElementById('login-form').submit();
				}, {{ config.app.form.timeout }});
			};
		</script>
		

        <script src="{{ base_url() }}/layouts/web/plugins/jquery-validation-1.19.2/dist/jquery.validate.min.js"></script>
		<script src="{{ base_url() }}/layouts/web/plugins/jquery-validation-1.19.2/dist/additional-methods.min.js"></script>
		<script>
			$('select').on('change', function () {
				$(this).valid();
			});

			$('#reset-form').validate({
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
					password: {
						required: true
					},
					verify_new_password: {
						required: true,
						equalTo: '#password'
					}
				},
				messages: {
					password: {
						required: 'New Password is required!'
					},
					verify_new_password: {
						required: 'Password Verification is required!',
						equalTo: 'Passwords do not match!'
					}
				},
				submitHandler: function (form) {
					grecaptcha.execute();
				}
			});

			function onSubmit(token) {
				$('#reset').addClass('softhide');
				$('#reset-hide').removeClass('softhide');

				setTimeout(function() {
					document.getElementById('reset-form').submit();
				}, {{ config.app.form.timeout }});
			};
		</script>
		
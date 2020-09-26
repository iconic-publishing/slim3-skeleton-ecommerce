<!DOCTYPE html>
<html lang="{{ config.app.locale }}">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		{% block tags %}{% endblock %}
		<meta name="robots" content="{{ config.meta.robots }}">
		<meta name="copyright" content="{{ config.meta.copyright }}">
		<meta name="author" content="{{ config.meta.author }}">

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
		<link rel="stylesheet" href="{{ base_url() }}/layouts/web/plugins/font-awesome-4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="{{ base_url() }}/layouts/web/css/custom.css">
		
		<script src='https://www.google.com/recaptcha/api.js?hl={{ config.recaptcha.locale }}'></script>
	</head>

	<body oncontextmenu="{{ config.app.onContextMenu }}">
		
		{% block content %}{% endblock %}
		
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
		<script src="{{ base_url() }}/layouts/web/js/custom.js"></script>

		<script src="{{ base_url() }}/layouts/web/plugins/jquery-validation-1.19.2/dist/jquery.validate.min.js"></script>
		<script src="{{ base_url() }}/layouts/web/plugins/jquery-validation-1.19.2/dist/additional-methods.min.js"></script>
		<script>
			var timeout = 2000;

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
					$('#contact').addClass('softhide');
					$('#contact-hide').removeClass('softhide');

					setTimeout(function () {
						form.submit();
					}, timeout);
				}
			});

			$('#register-form').validate({
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
					password: {
						required: true
					},
					verify_password: {
						required: true,
						equalTo: '#password'
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
					password: {
						required: 'Password is required!'
					},
					verify_password: {
						required: 'Password Verification is required!',
						equalTo: 'Passwords do not match!'
					}
				},
				submitHandler: function (form) {
					$('#register').addClass('softhide');
					$('#register-hide').removeClass('softhide');

					setTimeout(function () {
						form.submit();
					}, timeout);
				}
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
					$('#login').addClass('softhide');
					$('#login-hide').removeClass('softhide');

					setTimeout(function () {
						form.submit();
					}, timeout);
				}
			});

			$('#recover-form').validate({
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
					email_address: {
						required: true,
						email: true
					}
				},
				messages: {
					email_address: {
						required: 'Email Address is required!'
					}
				},
				submitHandler: function (form) {
					$('#recover').addClass('softhide');
					$('#recover-hide').removeClass('softhide');

					setTimeout(function () {
						form.submit();
					}, timeout);
				}
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
					$('#reset').addClass('softhide');
					$('#reset-hide').removeClass('softhide');

					setTimeout(function () {
						form.submit();
					}, timeout);
				}
			});
		</script>
	</body>
</html>
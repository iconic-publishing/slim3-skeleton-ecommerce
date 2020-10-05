
		<script src="{{ base_url() }}/layouts/web/plugins/intl-tel-input/build/js/intlTelInput.min.js"></script>
		<script>
			var input = document.querySelector('#phone_number'),
			iti = window.intlTelInput(input, {
				allowDropdown: true,
				autoHideDialCode: false,
				autoPlaceholder: '',
				customContainer: '',
				customPlaceholder: null,
				dropdownContainer: null,
				excludeCountries: [],
				formatOnDisplay: true,
				geoIpLookup: null,
				hiddenInput: '',
				initialCountry: '',
				localizedCountries: null,
				nationalMode: false,
				onlyCountries: [],
				placeholderNumberType: 'MOBILE',
				preferredCountries: ['gb', 'us'],
				separateDialCode: true,
				utilsScript: '{{ base_url() }}/layouts/web/plugins/intl-tel-input/build/js/utils.js'
			});

			input.addEventListener('blur', function() {
				if(input.value.trim()) {
					if(iti.isValidNumber()) {
						//$('#valid-msg').html('<i class="fa fa-thumbs-up"></i> Phone number valid.');
						//$('#valid-msg').removeClass('softhide');
						$('#phone_number').addClass('is-valid');
						$('#error-msg').addClass('softhide');
						$('button').prop('disabled', false);
						$('#phone_number_valid').val(iti.getNumber());
					} else {
						$('#error-msg').html('Please enter a valid phone number.');
						$('#error-msg').removeClass('softhide');
						$('#phone_number').addClass('is-invalid');
						$('#valid-msg').addClass('softhide');
						$('button').prop('disabled', true);
					}
				}
			});
		</script>
        
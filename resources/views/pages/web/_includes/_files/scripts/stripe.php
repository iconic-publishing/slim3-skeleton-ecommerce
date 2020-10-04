
        <script src="https://js.stripe.com/v3/"></script>
        <script>
			var stripe = Stripe('{{ config.stripe.public }}'),
				elements = stripe.elements(),
				style = {
				base: {
					color: '#495057',
					fontFamily: '"Montserrat", sans-serif',
					fontSmoothing: 'antialiased',
					fontSize: '16px',
					fontWeight: 'normal',
					textTransform: 'capitalize',
					'::placeholder': {
						color: '#495057'
					},
					':-webkit-autofill': {
						color: '#ced4da',
					}
				},
				complete: {
					color: '#28a745',
					iconColor: '#28a745'
				},
				empty: {
					color: '#ced4da'
				},
				invalid: {
					color: '#dc3545',
					iconColor: '#dc3545'
				}
			},
			elementClasses = {
				empty: 'empty',
			},
			card = elements.create('card', {
				style: style,
				classes: elementClasses
			});

			card.mount('#card-element');

			card.addEventListener('change', function(event) {
				var displayError = document.getElementById('card-errors');

				if(event.error) {
					displayError.textContent = event.error.message;
				} else {
					displayError.textContent = '';
				}
			});

			var form = document.getElementById('payment-form');

			form.addEventListener('submit', function(event) {
				event.preventDefault();

				var options = {
					name: document.getElementById('cardholder_name').value
				}

				stripe.createToken(card, options).then(function(result) {
					if(result.error) {
						var errorElement = document.getElementById('card-errors');
						errorElement.textContent = result.error.message;
					} else {
						stripeTokenHandler(result.token);
					}
				});
			});

			function stripeTokenHandler(token) {
				var form = document.getElementById('payment-form'),
				hiddenInput = document.createElement('input');
				hiddenInput.setAttribute('type', 'hidden');
				hiddenInput.setAttribute('name', 'stripeToken');
				hiddenInput.setAttribute('value', token.id);
				form.appendChild(hiddenInput);
			}
        </script>
		
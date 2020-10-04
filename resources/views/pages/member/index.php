{% extends 'layouts/member-layout.php' %}

{% block content %}

	<div class="container padding-xs">
		<div class="row">
			<div class="col-lg-12">
				<p><a href="{{ path_for('getLogout') }}">Logout</a></p>
			</div>

			<div class="col-lg-12">
				<h2>Members Area | {{ auth.user.customer.getFullName() | title }}</h2>

				<p>Hi {{ auth.user.customer.getFirstName() | title }}, you are now signed in.</p>
			</div>
		</div>
	</div>
	
{% endblock %}
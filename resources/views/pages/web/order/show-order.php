{% extends 'layouts/web-layout.php' %}

{% block content %}

	<div class="container padding-xs">
		<div class="row">
			<div class="col-lg-12">
                <p><a href="{{ path_for('getProducts') }}">Back to Products</a></p>

                <h2>Order Confirmation Page</h2>

                <hr>
			</div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="well">
                    <h4>Peronal Details</h4>

            </div>
        </div>
    </div>

{% endblock %}
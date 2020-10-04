{% extends 'layouts/web-layout.php' %}

{% block content %}

	<div class="container padding-xs">
		<div class="row">
			<div class="col-lg-12">
				<p><a href="{{ path_for('index') }}">Back to Homepage</a></p>
			</div>

			<div class="col-lg-12">
				<h2>Product Page</h2>

				<hr>

                <div class="row">
                    {% for product in products %}
                        <div class="col-md-4 col-sm-6 mb-5">
                            <a href="{{ path_for('getProductDetails', {slug: product.slug}) }}">
                                <img class="img-fluid img-thumbnail mb-3" src="{{ product.image }}" alt="{{ product.title }}">
                            </a>
                            
                            <h4><a href="{{ path_for('getProductDetails', {slug: product.slug}) }}">{{ product.title }}</a></h4>

                            <p>{{ product.description }}</p>
                        </div>
                    {% endfor %}

                    <div class="col-lg-12">
                        {{ products.links | raw }}
                    </div>
                </div>
			</div>
		</div>
	</div>

{% endblock %}
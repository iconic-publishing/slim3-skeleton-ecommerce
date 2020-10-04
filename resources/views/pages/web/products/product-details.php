{% extends 'layouts/web-layout.php' %}

{% block content %}

	<div class="container padding-xs">
		<div class="row">
			<div class="col-lg-12">
				<p><a href="{{ path_for('getProducts') }}">Back to Products</a></p>
			</div>

			<div class="col-lg-12">
				<h2>{{ product.title }}</h2>

				<hr>

                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <img class="img-fluid img-thumbnail mb-3" src="{{ product.image }}" alt="{{ product.title }}">
                    </div>

                    <div class="col-md-8 col-sm-6">
                        <h4>
                            £{{ product.price | number_format(2) }}
                            {% if product.sale %}
                                - <span class="text-danger">SAVE 20%</span>
                            {% endif %}
                        </h4>

                        <p>{{ product.description }}</p>

                        <a class="btn btn-primary btn-block" href="{{ path_for('addToCart', { slug: product.slug, quantity: 1 }) }}">Add to Cart</a>
                    </div>
                </div>
			</div>
		</div>
	</div>

{% endblock %}
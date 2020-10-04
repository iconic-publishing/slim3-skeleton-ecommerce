{% extends 'layouts/web-layout.php' %}

{% block content %}

	<div class="container padding-xs">
		<div class="row">
			<div class="col-lg-12">
                <p><a href="{{ path_for('getProducts') }}">Back to Products</a></p>

                <h2>Shopping Basket Page</h2>

                <hr>
			</div>

			<div class="col-md-8">
                {% if basket.itemCount %}
                    <div class="well">
                        <h4>Shopping Basket</h4>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th class="text-center">Remove</th>
                                </tr>
                            </thead>

                            <tbody>
                                {% for item in basket.all %}
                                    <tr>
                                        <td><a href="{{ path_for('getProductDetails', { slug: item.slug }) }}">{{ item.title }}</a></td>
                                        <td>£{{ item.price | number_format(2) }}</td>
                                        <td>
                                            <form class="form-inline" action="{{ path_for('updateCart', { slug: item.slug }) }}" method="post" autocomplete="{{ config.app.autocomplete }}">
                                                <input pattern="[0-9]*" type="number" class="form-control input-sm" name="quantity" maxlength="2" max="99" min="1" value="{{ item.quantity }}">
                                                <button type="submit" class="btn btn-default ml-2">Update</button>
                                                {{ csrf.field | raw }}
                                            </form>
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ path_for('deleteCart', {slug: item.slug}) }}" method="post" autocomplete="{{ config.app.autocomplete }}">
                                                <button type="submit" value="0"><i class="fa fa-trash mt-2"></i></button>
                                                {{ csrf.field | raw }}
                                            </form>
                                        </td>
                                    </tr>
                                {% endfor %}
                            </tbody>
                        </table>
                    </div>
                {% else %}
                    <p>You have no items in your cart. <a href="{{ path_for('getProducts') }}">Start shopping</a></p>
                {% endif %}
            </div>
            
            <div class="col-md-4">
                {% if basket.itemCount and basket.subTotal %}
                    <div class="well">
                        <h4>Cart Summary</h4>

                        <table class="table">
                            <tr>
                                <td>Sub total</td>
                                <td>£{{ basket.subTotal | number_format(2) }}</td>
                            </tr>
                            <tr>
                                <td>Shipping</td>
                                <td>£{{ basket.shipping | number_format(2) }}</td>
                            </tr>
                            <tr>
                                <td class="text-success bold">TOTAL</td>
                                <td class="text-success bold">£{{ (basket.subTotal + basket.shipping) | number_format(2) }}</td>
                            </tr>
                        </table>

                        <a class="btn btn-primary btn-block" href="{{ path_for('getOrder') }}">CHECKOUT</a>
                    </div>
                {% endif %}
            </div>
		</div>
	</div>

{% endblock %}
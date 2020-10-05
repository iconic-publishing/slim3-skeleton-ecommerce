Customer Failed Online Payment

Order ID: {{ order.order_id }}

Customer Name: {{ order.user.customer.getFullName() }}
Customer Email: {{ order.user.email_address }}
Customer Number: {{ order.user.customer.phone_number }}
Country: {{ order.user.address.country }}

Order Items:
{% for product in order.products %}
{{ product.pivot.quantity }} x {{ product.title }}
{% endfor %}

Sub-Total: £{{ order.sub_total | number_format(2) }}
Shipping: £{{ order.shipping | number_format(2) }}
Order Total: £{{ order.total | number_format(2) }}

Dated: {{ order.payment.created_at | date('jS F, Y @ H:i:s') }}
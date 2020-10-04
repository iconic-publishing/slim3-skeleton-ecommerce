Hi {{ order.user.customer.getFirstName() }},

Thank you for your order.

Your Order ID: {{ order.order_id }}. Please use your Order ID in all communications.

If you have any questions or if you need assistance please contact us at {{ config.company.email }}

Regards,    

Sales Team.
For and on behalf of {{ config.company.name }}

{{ config.meta.copyright }}

Disclaimer: This message is confidential. It may also be privileged or otherwise protected by work product immunity or other legal rules. If you have received it by mistake, please let us know by e-mail reply {{ config.company.email }} and delete it from your system, you may not copy this message or disclose its contents to anyone. The integrity and security of this message cannot be guaranteed on the Internet.
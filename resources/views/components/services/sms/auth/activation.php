Hi {{ user.customer.getFirstName() }},

Thank you for signing up to {{ config.company.name }}.
    
Activate your account using the link below. If you cannot click the link, then copy the link into your web browser.

{{ base_url() }}/activatation?email_address={{ user.email_address }}&identifier={{ identifier | url_encode }}
   
If you have any questions or if you need assistance please contact us at {{ config.company.email }}

Thanks,    

{{ config.company.name }} Team.

***THIS IS AN AUTOMATED SMS PLEASE DO NOT REPLY***
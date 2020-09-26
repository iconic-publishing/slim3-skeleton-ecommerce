Hi {{ user.customer.getFirstName() }},
    
You have requested to reset your password. If you did not request this, then please contact our Admin staff on {{ config.company.phone }} immediately.
   
If you did make this request, then please reset your password using the link below. If you cannot click the link, then copy the link into your browser.

{{ base_url() }}/reset-password/{{ user.email_address }}
    
If you have any questions or if you need assistance please contact us at {{ config.company.email }}

Thanks,    

{{ config.company.name }} Team.
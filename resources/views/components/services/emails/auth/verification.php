Hi {{ user.customer.getFirstName() }},
    
Your account was activated successfully. You can login with either your Email or Username below, and the Password you created:

Login: {{ base_url() }}/login    
Email: {{ user.email_address }}
Username: {{ user.username }}
Password: **Please use the Password you created**

If you have forgotten your Password you can reset it with the link below;
Reset Link: {{ base_url() }}/recover-password

If you have any questions or if you need assistance please contact us at {{ config.company.email }}

Thanks,    

{{ config.company.name }} Team.
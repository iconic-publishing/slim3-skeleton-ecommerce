New Website Enquiry

Full Name: {{ data.first_name | title }} {{ data.last_name | title }}
Email Address: {{ data.email_address | lower }}
Contact Number: {{ data.phone_number }}
Country: {{ data.country }}
Enquiry: {{ data.department }}

Subject: {{ data.subject }}

Message:
{{ data.message }}

GDPR: {{ (data.gdpr == true) ? 'Subscribed' : 'Not Subscribed' }}

Number Validation: {{ (verify[0] == true) ? 'Valid' : 'Invalid' }}
Format: {{ verify[1] }}
Local Format: {{ verify[2] }}
International Format: {{ verify[3] }}
Dialing Code: {{ verify[4] }}
Country Prefix: {{ verify[5] }}
Location: {{ verify[6] }}
City: {{ (verify[7]) ? verify[7] : 'Not Available' }}
Carrier: {{ (verify[8]) ? verify[8] : 'Not Available' }}
Type: {{ (verify[9] == 'landline') ? 'Landline' : 'Mobile' }}

Message received {{ data.date | date('jS F, Y @ H:i:s') }} from IP address {{ ip }}

***THIS IS AN AUTOMATED SMS PLEASE DO NOT REPLY***
<!DOCTYPE html>
<html lang="{{ config.app.locale }}">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		{% block tags %}{% endblock %}
		<meta name="robots" content="{{ config.meta.robots }}">
		<meta name="copyright" content="{{ config.meta.copyright }}">
		<meta name="author" content="{{ config.meta.author }}">

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
		<link rel="stylesheet" href="{{ base_url() }}/layouts/web/plugins/font-awesome-4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="{{ base_url() }}/layouts/web/css/custom.css">

		{% block css_number_verify %}{% endblock %}
		
		{% block scripts_recaptcha %}{% endblock %}
		
	</head>

	<body oncontextmenu="{{ config.app.onContextMenu }}">
		
		{% block content %}{% endblock %}
		
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
		<script src="{{ base_url() }}/layouts/web/js/custom.js"></script>

		{% block scripts_forms %}{% endblock %}

		{% block scripts_number_verify %}{% endblock %}

		{% block scripts_stripe %}{% endblock %}
		
	</body>
</html>
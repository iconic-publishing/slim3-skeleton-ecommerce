{% extends 'layouts/web-layout.php' %}

{% block content %}

	<div class="container padding-xs">
		<div class="row">
			<div class="col-lg-12">
				<p><a href="{{ path_for('getBlogs') }}">Back to Blog</a></p>
			</div>

			<div class="col-lg-8">
				<h2>Blog Page Details</h2>

				<hr>

				<h3>{{ blog.title }}</a></h3>

				<p><small>Posted: {{ blog.published_on | date('jS F, Y') }}</small></p>

				<hr>

				<p>{{ blog.description | nl2br }}</p>
			</div>

			{% include 'pages/web/blog/side-bar/side-bar.php' %}
		</div>
	</div>

{% endblock %}
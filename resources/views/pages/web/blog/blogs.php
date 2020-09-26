{% extends 'layouts/web-layout.php' %}

{% block content %}

	<div class="container padding-xs">
		<div class="row">
			<div class="col-lg-12">
				<p><a href="{{ path_for('index') }}">Back to Homepage</a></p>
			</div>

			<div class="col-lg-8">
				<h2>Blog Page</h2>

				<hr>

				{% for blog in blogs %}
					<h3><a href="{{ path_for('getBlogDetails', {slug: blog.slug}) }}">{{ blog.title }}</a></h3>
					<!-- Option for Full Description -->
					<!--<p>{{ blog.description | nl2br }}</p>-->

					<!-- Option for Partial sliced Description -->
					<p>{{ blog.description | slice(0, 250) ~ ' [...]' }}</p>

					<a class="btn btn-primary btn-sm" href="{{ path_for('getBlogDetails', {slug: blog.slug}) }}">Read More</a>

					<p><small>Posted: {{ blog.published_on | date('jS F, Y') }}</small></p>

					<hr>
				{% endfor %}

				{{ blogs.links | raw }}
			</div>

			{% include 'pages/web/blog/side-bar/side-bar.php' %}
		</div>
	</div>

{% endblock %}
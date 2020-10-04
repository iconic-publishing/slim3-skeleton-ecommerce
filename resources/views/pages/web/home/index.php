{% extends 'layouts/web-layout.php' %}

{% block tags %}
<title>{{ config.tags.index.title }}</title>
<meta name="description" content="{{ config.tags.index.description }}">
{% endblock %}

{% block content %}
	
	<div class="container padding-xs">
		<div class="row">
			<div class="col-lg-8">
				<h1>Slim 3 e-Commerce Skeleton</h1>

				<hr>

				<h2>Requirements</h2>

				<p>PHP Version 7.0 or above.</p>

				<p>Download <a href="https://getcomposer.org/" target="_blank">Composer</a> and follow the installation instructions.</p>

				<p>From the Terminal, Run <code>composer install</code> from your project root. This will install all the project dependencies from <code>composer.json</code> file.</p>
				
				<hr>

				<h3>Datebase Installation</h3>

				<p>Create a Database named <code>skeleton</code>. From the Terminal, Run <code>phinx migrate</code> from your project root to create the Database Tables. Migrations are located in <code>database/migrations</code>.</p>

				<p>To create a new migration, Run <code>phinx create NewMigrationName</code>. This will create a new migration in <code>database/migrations</code>. Add your table components and Run <code>phinx migrate</code> to add the new migration to your database.</p>

				<hr>
				
				<h4>Features</h4>
				
				<div class="row">
					<div class="col-lg-6">
						<ul class="unstyled">
							<li>Slim 3</li>
							<li>Slim Flash Messages</li>
							<li>Slim CSRF</li>
							<li>Twig Views</li>
							<li>Bootstrap 4.1.0</li>
							<li>Font Awesome 4.7.0</li>
							<li>Swift Mailer</li>
						</ul>
					</div>

					<div class="col-lg-6">
						<ul class="unstyled">
							<li>Mailgun API</li>
							<li>Twilio SMS API</li>
							<li>Number Verify API</li>
							<li>MailChimp API</li>
							<li>Google Invisible reCaptcha</li>
							<li>jQuery Form Validation</li>
							<li>Stripe API <i class="fa fa-cc-stripe" aria-hidden="true"></i></li>
						</ul>
					</div>
				</div>
			</div>

			<div class="col-lg-4">
				<h2>Sample Pages</h2>

				<hr>

				<ul>
					<li><a href="{{ path_for('getProducts') }}">View Sample Products Page</a></li>
					<li><a href="{{ path_for('getCart') }}">View Sample Checkout Page</a></li>
					<hr>
					<li><a href="{{ path_for('getBlogs') }}">View Sample Blog Page</a></li>
					<li><a href="{{ path_for('getContact') }}">View Sample Contact Page</a></li>
					<hr>
					<li><a href="{{ path_for('getRegister') }}">View Sample Register Page</a></li>
					<li><a href="{{ path_for('getLogin') }}">View Sample Login Page</a></li>
					<li><a href="{{ path_for('getRecoverPassword') }}">View Sample Recover Password</a></li>
				</ul>
			</div>
		</div>
	</div>

{% endblock %}
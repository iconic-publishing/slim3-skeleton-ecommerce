				
				<div class="col-lg-4">
					<h2>Recent Blogs</h2>
					
					<hr>
					
					<ul>
						{% for blog in sideBar %}
							<li><a href="{{ path_for('getBlogDetails', {slug: blog.slug}) }}">{{ blog.title }}</a></li>
						{% endfor %}
					</ul>
				</div>
				
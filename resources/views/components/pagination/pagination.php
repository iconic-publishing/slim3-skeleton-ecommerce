	
	{% if paginator.hasPages %}
		<nav aria-label="Page Navigation">
			<ul class="pagination">
				{% if paginator.onFirstPage %}
					<li class="page-item disabled">
						<a class="page-link" aria-label="Previous"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a>
					</li>
				{% else %}
					<li class="page-item">
						<a class="page-link" href="{{ paginator.previousPageUrl }}" aria-label="Previous"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a>
					</li>
				{% endif %}
				
				{% for element in elements %}
					{% if element is iterable %}
						{% for page, url in element %}
							{% if page == paginator.currentPage %}
								<li class="page-item active"><a class="page-link" href="{{ url }}">{{ page }}</a></li>
							{% else %}
								<li class="page-item"><a class="page-link" href="{{ url }}">{{ page }}</a></li>
							{% endif %}
						{% endfor %}
					{% else %}
						<li class="page-item disabled"><span class="page-link">{{ element }}</span></li>
					{% endif %}
				{% endfor %}
				
				{% if paginator.hasMorePages %}
					<li class="page-item">
						<a class="page-link" href="{{ paginator.nextPageUrl }}" aria-label="Next"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a>
					</li>
				{% else %}
					<li class="page-item disabled">
						<a class="page-link" aria-label="Next"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a>
					</li>
				{% endif %}
			</ul>
		</nav>
	{% endif %}

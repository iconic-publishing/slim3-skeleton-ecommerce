<?php

return [

    'blog' => [
        'paginator' => getenv('BLOG_PAGINATOR', 12),
        'sideBarLimit' => getenv('SIDE_BAR_LIMIT', 12)
    ]

];
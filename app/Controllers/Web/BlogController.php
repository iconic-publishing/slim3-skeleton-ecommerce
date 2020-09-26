<?php

namespace Base\Controllers\Web;

use Base\Models\Blog\Blog;
use Base\Constructor\BaseConstructor;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BlogController extends BaseConstructor {
	
    public function getBlogs(ServerRequestInterface $request, ResponseInterface $response) {
        $blogs = Blog::orderBy('published_on', 'DESC')->paginate($this->config->get('blog.paginator'))->appends($request->getParams());
        $sideBar = $this->sideBar();

        return $this->view->render($response, 'pages/web/blog/blogs.php', compact('blogs', 'sideBar'));
    }

    public function getBlogDetails(ServerRequestInterface $request, ResponseInterface $response, $args) {
        $slug = $args['slug'];
        $blog = Blog::where('slug', $slug)->first();
        $sideBar = $this->sideBar();

        return $this->view->render($response, 'pages/web/blog/blog-details.php', compact('blog', 'sideBar'));
    }

    protected function sideBar() {
        return Blog::inRandomOrder()->limit($this->config->get('blog.sideBarLimit'))->get();
    }
	
}

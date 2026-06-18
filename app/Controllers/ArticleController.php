<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\View;
use App\Services\ArticlePageService;

class ArticleController
{
    private View $view;
    private ArticlePageService $articlePageService;

    public function __construct(View $view, ArticlePageService $articlePageService)
    {
        $this->view = $view;
        $this->articlePageService = $articlePageService;
    }

    public function show(string $slug): string
    {
        $data = $this->articlePageService->getPageData($slug);

        if ($data === null) {
            http_response_code(404);

            return 'Article not found';
        }

        return $this->view->render('article.tpl', $data);
    }
}

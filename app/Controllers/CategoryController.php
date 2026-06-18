<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\View;
use App\Services\CategoryPageService;

class CategoryController
{
    private View $view;
    private CategoryPageService $categoryPageService;

    public function __construct(View $view, CategoryPageService $categoryPageService)
    {
        $this->view = $view;
        $this->categoryPageService = $categoryPageService;
    }

    public function show(string $slug): string
    {
        $data = $this->categoryPageService->getPageData($slug, $_GET);

        if ($data === null) {
            http_response_code(404);

            return 'Category not found';
        }

        return $this->view->render('category.tpl', $data);
    }
}

<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Pagination;
use App\Core\View;
use App\Models\Article;
use App\Models\Category;

class CategoryController
{
    private View $view;
    private Category $categoryModel;
    private Article $articleModel;

    public function __construct(View $view, Category $categoryModel, Article $articleModel)
    {
        $this->view = $view;
        $this->categoryModel = $categoryModel;
        $this->articleModel = $articleModel;
    }

    public function show(string $slug): string
    {
        $category = $this->categoryModel->findBySlug($slug);

        if ($category === null) {
            http_response_code(404);

            return 'Category not found';
        }

        // Keep sorting limited to known SQL-safe options.
        $allowedSorts = ['date_desc', 'date_asc', 'views_desc', 'views_asc'];
        $sort = (string) ($_GET['sort'] ?? 'date_desc');

        if (!in_array($sort, $allowedSorts, true)) {
            $sort = 'date_desc';
        }

        $page = max(1, (int) ($_GET['page'] ?? 1));
        $perPage = 3;

        $totalItems = $this->articleModel->countByCategory((int) $category['id']);
        $pagination = new Pagination($totalItems, $page, $perPage);

        $articles = $this->articleModel->getByCategory(
            (int) $category['id'],
            $sort,
            $pagination->getPerPage(),
            $pagination->getOffset()
        );

        return $this->view->render('category.tpl', [
            'title' => $category['title'],
            'category' => $category,
            'articles' => $articles,
            'pagination' => $pagination->toArray(),
            'sort' => $sort,
            'sortOptions' => [
                'date_desc' => 'Newest',
                'date_asc' => 'Oldest',
                'views_desc' => 'Most viewed',
                'views_asc' => 'Least viewed',
            ],
        ]);
    }
}
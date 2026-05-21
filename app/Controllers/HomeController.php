<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\View;
use App\Models\Article;
use App\Models\Category;

class HomeController
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

    public function index(): string
    {
        $categories = $this->categoryModel->getWithArticles();

        // Attach the latest articles to each category for the home page.
        foreach ($categories as &$category) {
            $category['articles'] = $this->articleModel->getLatestByCategory((int) $category['id'], 3);
        }

        unset($category);

        return $this->view->render('home.tpl', [
            'title' => 'Plain PHP Smarty Blog',
            'categories' => $categories,
        ]);
    }
}
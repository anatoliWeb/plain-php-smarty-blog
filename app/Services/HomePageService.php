<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;

class HomePageService
{
    private CategoryRepository $categoryRepository;
    private ArticleRepository $articleRepository;

    public function __construct(CategoryRepository $categoryRepository, ArticleRepository $articleRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->articleRepository = $articleRepository;
    }

    public function getPageData(): array
    {
        $categories = $this->categoryRepository->getWithArticles();

        // Attach only 3 latest articles per category because the home page is a preview view.
        foreach ($categories as &$category) {
            $category['articles'] = $this->articleRepository->getLatestByCategory((int) $category['id'], 3);
        }

        unset($category);

        return [
            'title' => 'Plain PHP Smarty Blog',
            'categories' => $categories,
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Pagination;
use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;

class CategoryPageService
{
    private CategoryRepository $categoryRepository;
    private ArticleRepository $articleRepository;
    private int $perPage = 3;

    public function __construct(CategoryRepository $categoryRepository, ArticleRepository $articleRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->articleRepository = $articleRepository;
    }

    public function getPageData(string $slug, array $queryParams): ?array
    {
        $category = $this->categoryRepository->findBySlug($slug);

        if ($category === null) {
            return null;
        }

        // Keep sorting limited to the approved SQL-safe values for the category page.
        $allowedSorts = ['date_desc', 'date_asc', 'views_desc', 'views_asc'];
        $sort = (string) ($queryParams['sort'] ?? 'date_desc');

        if (!in_array($sort, $allowedSorts, true)) {
            $sort = 'date_desc';
        }

        // Keep the page number normalized here so the controller stays thin.
        $page = max(1, (int) ($queryParams['page'] ?? 1));

        // Keep per-page in the service because the category page uses a fixed listing size.
        $totalItems = $this->articleRepository->countByCategory((int) $category['id']);
        $pagination = new Pagination($totalItems, $page, $this->perPage);

        $articles = $this->articleRepository->getByCategory(
            (int) $category['id'],
            $sort,
            $pagination->getPerPage(),
            $pagination->getOffset()
        );

        return [
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
        ];
    }
}

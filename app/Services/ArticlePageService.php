<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\ArticleRepository;

class ArticlePageService
{
    private ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function getPageData(string $slug): ?array
    {
        $article = $this->articleRepository->findBySlug($slug);

        if ($article === null) {
            return null;
        }

        // Count the page view before returning data so the article page reflects a fresh visit.
        $articleId = (int) $article['id'];
        $this->articleRepository->increaseViews($articleId);
        $article['views_count'] = (int) $article['views_count'] + 1;

        // Collect category IDs first so related articles can be loaded from the same categories.
        $categoryIds = [];

        foreach ($article['categories'] ?? [] as $category) {
            if (isset($category['id'])) {
                $categoryIds[] = (int) $category['id'];
            }
        }

        $relatedArticles = $this->articleRepository->getRelated($articleId, $categoryIds, 3);

        return [
            'title' => $article['title'],
            'article' => $article,
            'relatedArticles' => $relatedArticles,
        ];
    }
}

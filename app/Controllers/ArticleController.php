<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\View;
use App\Models\Article;

class ArticleController
{
    private View $view;
    private Article $articleModel;

    public function __construct(View $view, Article $articleModel)
    {
        $this->view = $view;
        $this->articleModel = $articleModel;
    }

    public function show(string $slug): string
    {
        $article = $this->articleModel->findBySlug($slug);

        if ($article === null) {
            http_response_code(404);

            return 'Article not found';
        }

        $articleId = (int) $article['id'];

        // Count a view when the article page is opened.
        $this->articleModel->increaseViews($articleId);
        $article['views_count'] = (int) $article['views_count'] + 1;

        // Related articles are selected from the same categories.
        $categoryIds = [];

        foreach ($article['categories'] ?? [] as $category) {
            if (isset($category['id'])) {
                $categoryIds[] = (int) $category['id'];
            }
        }

        $relatedArticles = $this->articleModel->getRelated($articleId, $categoryIds, 3);

        return $this->view->render('article.tpl', [
            'title' => $article['title'],
            'article' => $article,
            'relatedArticles' => $relatedArticles,
        ]);
    }
}
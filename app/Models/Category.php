<?php

declare(strict_types=1);

namespace App\Models;

use PDO;

class Category
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getWithArticles(): array
    {
        // INNER JOIN returns only categories that have at least one article.
        $sql = '
            SELECT
                c.id,
                c.title,
                c.slug,
                c.description,
                COUNT(ac.article_id) AS articles_count
            FROM categories c
            INNER JOIN article_category ac ON ac.category_id = c.id
            GROUP BY c.id, c.title, c.slug, c.description
            ORDER BY c.id ASC
        ';

        $statement = $this->pdo->query($sql);

        return $statement->fetchAll();
    }

    public function findBySlug(string $slug): ?array
    {
        $sql = '
            SELECT
                id,
                title,
                slug,
                description
            FROM categories
            WHERE slug = :slug
            LIMIT 1
        ';

        $statement = $this->pdo->prepare($sql);
        $statement->execute(['slug' => $slug]);

        $category = $statement->fetch();

        // PDO returns false when no row is found.
        return $category !== false ? $category : null;
    }
}
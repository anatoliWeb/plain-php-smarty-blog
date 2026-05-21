<?php

declare(strict_types=1);

namespace App\Models;

use PDO;

class Article
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getLatestByCategory(int $categoryId, int $limit = 3): array
    {
        $limit = max(1, $limit);

        $sql = '
            SELECT
                a.id,
                a.image,
                a.title,
                a.slug,
                a.description,
                a.views_count,
                a.published_at
            FROM articles a
            INNER JOIN article_category ac ON ac.article_id = a.id
            WHERE ac.category_id = :category_id
            ORDER BY a.published_at DESC, a.id DESC
            LIMIT :limit
        ';

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function countByCategory(int $categoryId): int
    {
        $sql = '
            SELECT COUNT(*) AS total
            FROM articles a
            INNER JOIN article_category ac ON ac.article_id = a.id
            WHERE ac.category_id = :category_id
        ';

        $statement = $this->pdo->prepare($sql);
        $statement->execute(['category_id' => $categoryId]);

        $row = $statement->fetch();

        return (int) ($row['total'] ?? 0);
    }

    public function getByCategory(int $categoryId, string $sort, int $limit, int $offset): array
    {
        $limit = max(1, $limit);
        $offset = max(0, $offset);

        // Whitelist sorting options because SQL identifiers cannot be bound as parameters.
        $sortOptions = [
            'date_desc' => 'a.published_at DESC, a.id DESC',
            'date_asc' => 'a.published_at ASC, a.id ASC',
            'views_desc' => 'a.views_count DESC, a.id DESC',
            'views_asc' => 'a.views_count ASC, a.id ASC',
        ];

        $orderBy = $sortOptions[$sort] ?? $sortOptions['date_desc'];

        $sql = '
            SELECT
                a.id,
                a.image,
                a.title,
                a.slug,
                a.description,
                a.views_count,
                a.published_at
            FROM articles a
            INNER JOIN article_category ac ON ac.article_id = a.id
            WHERE ac.category_id = :category_id
            ORDER BY ' . $orderBy . '
            LIMIT :limit OFFSET :offset
        ';

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function findBySlug(string $slug): ?array
    {
        $articleSql = '
            SELECT
                id,
                image,
                title,
                slug,
                description,
                content,
                views_count,
                published_at
            FROM articles
            WHERE slug = :slug
            LIMIT 1
        ';

        $articleStatement = $this->pdo->prepare($articleSql);
        $articleStatement->execute(['slug' => $slug]);

        $article = $articleStatement->fetch();

        if ($article === false) {
            return null;
        }

        // Keep categories as a second simple query instead of making one large GROUP query.
        $categoriesSql = '
            SELECT
                c.id,
                c.title,
                c.slug
            FROM categories c
            INNER JOIN article_category ac ON ac.category_id = c.id
            WHERE ac.article_id = :article_id
            ORDER BY c.id ASC
        ';

        $categoriesStatement = $this->pdo->prepare($categoriesSql);
        $categoriesStatement->execute(['article_id' => (int) $article['id']]);

        $article['categories'] = $categoriesStatement->fetchAll();

        return $article;
    }

    public function getRelated(int $articleId, array $categoryIds, int $limit = 3): array
    {
        if ($categoryIds === []) {
            return [];
        }

        $limit = max(1, $limit);
        $categoryIds = array_values(array_map('intval', $categoryIds));

        // Build placeholders for a safe IN (...) query.
        $placeholders = implode(', ', array_fill(0, count($categoryIds), '?'));

        $sql = '
            SELECT DISTINCT
                a.id,
                a.image,
                a.title,
                a.slug,
                a.description,
                a.views_count,
                a.published_at
            FROM articles a
            INNER JOIN article_category ac ON ac.article_id = a.id
            WHERE a.id != ?
              AND ac.category_id IN (' . $placeholders . ')
            ORDER BY a.published_at DESC, a.id DESC
            LIMIT ?
        ';

        $statement = $this->pdo->prepare($sql);

        $index = 1;
        $statement->bindValue($index++, $articleId, PDO::PARAM_INT);

        foreach ($categoryIds as $categoryId) {
            $statement->bindValue($index++, $categoryId, PDO::PARAM_INT);
        }

        $statement->bindValue($index, $limit, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function increaseViews(int $articleId): void
    {
        $sql = '
            UPDATE articles
            SET views_count = views_count + 1
            WHERE id = :id
        ';

        $statement = $this->pdo->prepare($sql);
        $statement->execute(['id' => $articleId]);
    }
}
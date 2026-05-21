DROP TABLE IF EXISTS article_category;
DROP TABLE IF EXISTS articles;
DROP TABLE IF EXISTS categories;

CREATE TABLE categories (
    id INT UNSIGNED AUTO_INCREMENT COMMENT 'Category ID',
    title VARCHAR(255) NOT NULL COMMENT 'Category title shown on the site',
    slug VARCHAR(255) NOT NULL COMMENT 'URL-friendly category identifier',
    description TEXT NULL COMMENT 'Short category description',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date and time when the category was created',
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Date and time when the category was last updated',
    PRIMARY KEY (id),
    UNIQUE KEY uq_categories_slug (slug)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci
  COMMENT='Blog categories';

CREATE TABLE articles (
    id INT UNSIGNED AUTO_INCREMENT COMMENT 'Article ID',
    image VARCHAR(255) NULL COMMENT 'Article preview image path',
    title VARCHAR(255) NOT NULL COMMENT 'Article title shown on the site',
    slug VARCHAR(255) NOT NULL COMMENT 'URL-friendly article identifier',
    description TEXT NULL COMMENT 'Short article description used in lists',
    content TEXT NOT NULL COMMENT 'Full article content',
    views_count INT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Number of article views',
    published_at DATETIME NOT NULL COMMENT 'Article publication date and time',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date and time when the article was created',
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Date and time when the article was last updated',
    PRIMARY KEY (id),
    UNIQUE KEY uq_articles_slug (slug),
    INDEX idx_articles_published_at (published_at),
    INDEX idx_articles_views_count (views_count)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci
  COMMENT='Blog articles';

CREATE TABLE article_category (
    article_id INT UNSIGNED NOT NULL COMMENT 'Related article ID',
    category_id INT UNSIGNED NOT NULL COMMENT 'Related category ID',
    PRIMARY KEY (article_id, category_id),
    INDEX idx_article_category_article_id (article_id),
    INDEX idx_article_category_category_id (category_id),
    CONSTRAINT fk_article_category_article
        FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE,
    CONSTRAINT fk_article_category_category
        FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci
  COMMENT='Many-to-many relation between articles and categories';

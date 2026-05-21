<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title|escape} - Plain PHP Smarty Blog</title>
</head>
<body>
    <main class="article-page">
        <p>
            <a href="/">Back to home</a>
        </p>

        <article class="article-detail">
            <h1 class="article-title">{$article.title|escape}</h1>

            {if $article.image}
                <img
                    class="article-image"
                    src="{$article.image|escape}"
                    alt="{$article.title|escape}"
                >
            {/if}

            {if $article.description}
                <p class="article-description">{$article.description|escape}</p>
            {/if}

            <div class="article-content">
                {$article.content|escape|nl2br}
            </div>

            <p class="article-meta">
                <span>Published: {$article.published_at|escape}</span>
                <span>Views: {$article.views_count|escape}</span>
            </p>

            {if !empty($article.categories)}
                <div class="article-categories">
                    <strong>Categories:</strong>

                    {foreach $article.categories as $category}
                        <a href="/category/{$category.slug|escape}">
                            {$category.title|escape}
                        </a>{if !$category@last}, {/if}
                    {/foreach}
                </div>
            {/if}
        </article>

        <section class="related-articles">
            <h2>Related articles</h2>

            {if empty($relatedArticles)}
                <p>No related articles found.</p>
            {else}
                <div class="related-list">
                    {foreach $relatedArticles as $related}
                        <article class="related-item">
                            {if $related.image}
                                <a href="/article/{$related.slug|escape}">
                                    <img
                                        class="related-image"
                                        src="{$related.image|escape}"
                                        alt="{$related.title|escape}"
                                    >
                                </a>
                            {/if}

                            <h3 class="related-title">
                                <a href="/article/{$related.slug|escape}">
                                    {$related.title|escape}
                                </a>
                            </h3>

                            {if $related.description}
                                <p class="related-description">{$related.description|escape}</p>
                            {/if}

                            <p class="related-meta">
                                <span>Published: {$related.published_at|escape}</span>
                                <span>Views: {$related.views_count|escape}</span>
                            </p>
                        </article>
                    {/foreach}
                </div>
            {/if}
        </section>
    </main>
</body>
</html>
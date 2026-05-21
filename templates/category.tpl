<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title|escape} - Plain PHP Smarty Blog</title>
</head>
<body>
    <main class="category-page">
        <p>
            <a href="/">Back to home</a>
        </p>

        <h1 class="category-title">{$category.title|escape}</h1>

        {if $category.description}
            <p class="category-description">{$category.description|escape}</p>
        {/if}

        <form class="category-sort" method="get" action="">
            <label for="sort">Sort by:</label>

            <select name="sort" id="sort">
                {foreach $sortOptions as $value => $label}
                    <option value="{$value|escape}" {if $sort == $value}selected="selected"{/if}>
                        {$label|escape}
                    </option>
                {/foreach}
            </select>

            <button type="submit">Apply</button>
        </form>

        {if empty($articles)}
            <p class="category-empty">No articles found in this category.</p>
        {else}
            <div class="article-list">
                {foreach $articles as $article}
                    <article class="article-card">
                        {if $article.image}
                            <a href="/article/{$article.slug|escape}">
                                <img
                                    src="{$article.image|escape}"
                                    alt="{$article.title|escape}"
                                    class="article-image"
                                >
                            </a>
                        {/if}

                        <h2 class="article-title">
                            <a href="/article/{$article.slug|escape}">
                                {$article.title|escape}
                            </a>
                        </h2>

                        {if $article.description}
                            <p class="article-description">{$article.description|escape}</p>
                        {/if}

                        <p class="article-meta">
                            <span>Published: {$article.published_at|escape}</span>
                            <span>Views: {$article.views_count|escape}</span>
                        </p>
                    </article>
                {/foreach}
            </div>
        {/if}

        {if $pagination.totalPages > 1}
            <nav class="pagination">
                {if $pagination.hasPreviousPage}
                    <a href="?page={$pagination.previousPage|escape}&sort={$sort|escape}">Previous</a>
                {else}
                    <span>Previous</span>
                {/if}

                <span>
                    Page {$pagination.currentPage|escape} of {$pagination.totalPages|escape}
                </span>

                {if $pagination.hasNextPage}
                    <a href="?page={$pagination.nextPage|escape}&sort={$sort|escape}">Next</a>
                {else}
                    <span>Next</span>
                {/if}
            </nav>
        {/if}
    </main>
</body>
</html>
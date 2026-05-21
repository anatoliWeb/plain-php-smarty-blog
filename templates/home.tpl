<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title|escape}</title>
</head>
<body>
    <main class="home-page">
        <h1 class="home-title">{$title|escape}</h1>

        {if empty($categories)}
            <p class="home-empty">No categories available yet.</p>
        {else}
            {foreach $categories as $category}
                <section class="category-block">
                    <header class="category-header">
                        <h2 class="category-title">{$category.title|escape}</h2>
                        <a class="category-all-link" href="/category/{$category.slug|escape}">
                            All articles
                        </a>
                    </header>

                    {if $category.description}
                        <p class="category-description">{$category.description|escape}</p>
                    {/if}

                    {if empty($category.articles)}
                        <p class="category-empty">No articles in this category yet.</p>
                    {else}
                        <div class="article-list">
                            {foreach $category.articles as $article}
                                <article class="article-card">
                                    {if $article.image}
                                        <a class="article-image-link" href="/article/{$article.slug|escape}">
                                            <img class="article-image" src="{$article.image|escape}" alt="{$article.title|escape}">
                                        </a>
                                    {/if}

                                    <h3 class="article-title">
                                        <a href="/article/{$article.slug|escape}">{$article.title|escape}</a>
                                    </h3>

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
                </section>
            {/foreach}
        {/if}
    </main>
</body>
</html>

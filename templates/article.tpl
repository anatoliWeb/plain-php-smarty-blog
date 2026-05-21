{extends file="layouts/main.tpl"}

{block name="content"}
    <section class="article-page">
        <p class="back-link-wrap"><a href="/">Back to home</a></p>

        <article class="article-detail">
            <h1 class="page-title">{$article.title|escape}</h1>

            {if $article.image}
                <img class="article-image" src="{$article.image|escape}" alt="{$article.title|escape}">
            {/if}

            <p class="article-meta">{$article.published_at|escape} &middot; {$article.views_count|escape} views</p>

            {if $article.description}
                <p class="article-description">{$article.description|escape}</p>
            {/if}

            <div class="article-content">
                {$article.content|escape|nl2br}
            </div>

            {if !empty($article.categories)}
                <div class="article-categories">
                    <strong>Categories:</strong>
                    {foreach $article.categories as $category}
                        <a href="/category/{$category.slug|escape}">{$category.title|escape}</a>{if !$category@last}, {/if}
                    {/foreach}
                </div>
            {/if}
        </article>

        <section class="related-articles category-block">
            <header class="category-header">
                <h2 class="category-title">Related Articles</h2>
            </header>

            {if empty($relatedArticles)}
                <p class="state-message">No related articles found.</p>
            {else}
                <div class="article-list">
                    {foreach $relatedArticles as $related}
                        <article class="article-card">
                            {if $related.image}
                                <a class="article-image-link" href="/article/{$related.slug|escape}">
                                    <img class="article-image" src="{$related.image|escape}" alt="{$related.title|escape}">
                                </a>
                            {/if}

                            <h3 class="article-title">
                                <a href="/article/{$related.slug|escape}">{$related.title|escape}</a>
                            </h3>

                            <p class="article-meta">{$related.published_at|escape}</p>

                            {if $related.description}
                                <p class="article-description">{$related.description|escape}</p>
                            {/if}

                            <a class="article-read-more" href="/article/{$related.slug|escape}">Continue Reading</a>
                        </article>
                    {/foreach}
                </div>
            {/if}
        </section>
    </section>
{/block}
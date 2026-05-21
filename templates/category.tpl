{extends file="layouts/main.tpl"}

{block name="content"}
    <section class="category-page">
        <p class="back-link-wrap"><a href="/">Back to home</a></p>

        <section class="category-block">
            <header class="category-header">
                <h1 class="category-title">{$category.title|escape}</h1>
            </header>

            {if $category.description}
                <p class="category-description">{$category.description|escape}</p>
            {/if}

            <form class="category-sort" method="get" action="">
                <label for="sort">Sort by:</label>
                <select name="sort" id="sort">
                    {foreach $sortOptions as $value => $label}
                        <option value="{$value|escape}" {if $sort == $value}selected="selected"{/if}>{$label|escape}</option>
                    {/foreach}
                </select>
                <button type="submit">Apply</button>
            </form>

            {if empty($articles)}
                <p class="state-message">No articles found in this category.</p>
            {else}
                <div class="article-list">
                    {foreach $articles as $article}
                        <article class="article-card">
                            {if $article.image}
                                <a class="article-image-link" href="/article/{$article.slug|escape}">
                                    <img class="article-image" src="{$article.image|escape}" alt="{$article.title|escape}">
                                </a>
                            {/if}

                            <h2 class="article-title">
                                <a href="/article/{$article.slug|escape}">{$article.title|escape}</a>
                            </h2>

                            <p class="article-meta">{$article.published_at|escape} &middot; {$article.views_count|escape} views</p>

                            {if $article.description}
                                <p class="article-description">{$article.description|escape}</p>
                            {/if}

                            <a class="article-read-more" href="/article/{$article.slug|escape}">Continue Reading</a>
                        </article>
                    {/foreach}
                </div>
            {/if}

            {include file="partials/pagination.tpl" pagination=$pagination sort=$sort}
        </section>
    </section>
{/block}
{extends file="layouts/main.tpl"}

{block name="content"}
    <section class="home-page">
        {if empty($categories)}
            <p class="state-message">No categories available yet.</p>
        {else}
            {foreach $categories as $category}
                <section class="category-block">
                    <header class="category-header">
                        <h2 class="category-title">{$category.title|escape}</h2>
                        <a class="category-all-link" href="/category/{$category.slug|escape}">View all</a>
                    </header>

                    {if empty($category.articles)}
                        <p class="state-message">No articles in this category yet.</p>
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

                                    <p class="article-meta">{$article.published_at|escape}</p>

                                    {if $article.description}
                                        <p class="article-description">{$article.description|escape}</p>
                                    {/if}

                                    <a class="article-read-more" href="/article/{$article.slug|escape}">Continue Reading</a>
                                </article>
                            {/foreach}
                        </div>
                    {/if}
                </section>
            {/foreach}
        {/if}
    </section>
{/block}
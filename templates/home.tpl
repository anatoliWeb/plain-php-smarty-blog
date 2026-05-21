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
                                {include file="partials/article-card.tpl" article=$article}
                            {/foreach}
                        </div>
                    {/if}
                </section>
            {/foreach}
        {/if}
    </section>
{/block}
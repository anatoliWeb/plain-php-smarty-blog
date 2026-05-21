<article class="article-card">
    {if !empty($article.image)}
        <a class="article-image-link" href="/article/{$article.slug|escape}">
            <img
                class="article-image"
                src="/assets/images/{$article.image|escape}"
                alt="{$article.title|escape}"
            >
        </a>
    {/if}

    <h3 class="article-title">
        <a href="/article/{$article.slug|escape}">
            {$article.title|escape}
        </a>
    </h3>

    {if !empty($article.published_at)}
        <p class="article-meta">
            {$article.published_at|date_format:"%B %e, %Y"}
        </p>
    {/if}

    {if !empty($article.description)}
        <p class="article-description">
            {$article.description|escape}
        </p>
    {/if}

    <a class="article-read-more" href="/article/{$article.slug|escape}">
        Continue Reading
    </a>
</article>
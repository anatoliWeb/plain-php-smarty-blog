{if $pagination.totalPages > 1}
    <nav class="pagination">
        {if $pagination.hasPreviousPage}
            <a class="pagination-link" href="?page={$pagination.previousPage|escape}&sort={$sort|escape}">Previous</a>
        {else}
            <span class="pagination-link is-disabled">Previous</span>
        {/if}

        <span class="pagination-status">
            Page {$pagination.currentPage|escape} of {$pagination.totalPages|escape}
        </span>

        {if $pagination.hasNextPage}
            <a class="pagination-link" href="?page={$pagination.nextPage|escape}&sort={$sort|escape}">Next</a>
        {else}
            <span class="pagination-link is-disabled">Next</span>
        {/if}
    </nav>
{/if}
<?php

declare(strict_types=1);

namespace App\Core;

class Pagination
{
    private int $totalItems;
    private int $currentPage;
    private int $perPage;
    private int $totalPages;

    public function __construct(int $totalItems, int $currentPage, int $perPage)
    {
        $this->totalItems = max(0, $totalItems);
        $this->perPage = max(1, $perPage);

        // Keep at least one page to simplify template logic.
        $this->totalPages = max(1, (int) ceil($this->totalItems / $this->perPage));

        // Keep current page inside available page range.
        $this->currentPage = max(1, min($currentPage, $this->totalPages));
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    public function getTotalItems(): int
    {
        return $this->totalItems;
    }

    public function getTotalPages(): int
    {
        return $this->totalPages;
    }

    public function getOffset(): int
    {
        // Used later in SQL queries as OFFSET.
        return ($this->currentPage - 1) * $this->perPage;
    }

    public function hasPreviousPage(): bool
    {
        return $this->currentPage > 1;
    }

    public function hasNextPage(): bool
    {
        return $this->currentPage < $this->totalPages;
    }

    public function getPreviousPage(): ?int
    {
        return $this->hasPreviousPage() ? $this->currentPage - 1 : null;
    }

    public function getNextPage(): ?int
    {
        return $this->hasNextPage() ? $this->currentPage + 1 : null;
    }

    public function toArray(): array
    {
        // Convenient structure for passing pagination data to templates.
        return [
            'currentPage' => $this->getCurrentPage(),
            'perPage' => $this->getPerPage(),
            'totalItems' => $this->getTotalItems(),
            'totalPages' => $this->getTotalPages(),
            'offset' => $this->getOffset(),
            'hasPreviousPage' => $this->hasPreviousPage(),
            'hasNextPage' => $this->hasNextPage(),
            'previousPage' => $this->getPreviousPage(),
            'nextPage' => $this->getNextPage(),
        ];
    }
}
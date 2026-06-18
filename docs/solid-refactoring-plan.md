# SOLID refactoring plan

## Summary

The cleanest SOLID direction is to keep `public/index.php` as the composition root, keep `Router`, `View`, and `Pagination` small, and move page orchestration out of controllers into services, while moving SQL out of the current model classes into repositories.

The project must remain framework-free and array-based. Do not add DTOs or interfaces yet unless a boundary clearly proves useful later. The goal is better separation of responsibilities, not enterprise-style overengineering.

## Goals

- Keep the application framework-free.
- Keep controllers thin.
- Move page preparation logic into services.
- Move SQL and data access into repositories.
- Keep manual dependency wiring.
- Keep public URLs unchanged.
- Keep Smarty templates working.
- Keep Docker setup working.
- Keep the current database schema and seed data unchanged.

## Current issues

- `public/index.php` currently does too much: config loading, error handling, PDO creation, wiring, route registration, and request dispatch.
- `HomeController` prepares page data by looping categories and fetching latest articles.
- `CategoryController` mixes input validation, pagination, sorting rules, data fetching, and rendering.
- `ArticleController` mixes article lookup, view counting, related-article lookup, data shaping, and rendering.
- `app/Models/Category.php` and `app/Models/Article.php` are repository-style data access classes, not domain models.
- The page layer depends on implicit array shapes.
- `CategoryController` has a hard-coded per-page value.
- `Router`, `View`, and `Pagination` are already small and should not be split further.

## Proposed structure

Add:

```text
app/
  Repositories/
    CategoryRepository.php
    ArticleRepository.php
  Services/
    HomePageService.php
    CategoryPageService.php
    ArticlePageService.php
```

Keep:

```text
app/
  Controllers/
  Core/
  Models/
```

Optional later, only if real boundaries appear:

```text
app/
  Contracts/
```

## Class responsibility plan

| Class | Responsibility | Depends on | Used by |
|---|---|---|---|
| `CategoryRepository` | Fetch categories with article counts and find category by slug | PDO | HomePageService, CategoryPageService |
| `ArticleRepository` | Fetch latest articles by category, count articles, list articles with sorting/pagination, find article by slug, related articles, increment views | PDO | HomePageService, CategoryPageService, ArticlePageService |
| `HomePageService` | Build home page data: categories with latest 3 articles per category | CategoryRepository, ArticleRepository | HomeController |
| `CategoryPageService` | Validate sort, normalize page, build pagination, load category and paged article list | CategoryRepository, ArticleRepository, Pagination | CategoryController |
| `ArticlePageService` | Load full article, increment views, resolve related articles, prepare article page data | ArticleRepository | ArticleController |
| `HomeController` | Thin adapter: call service and render `home.tpl` | View, HomePageService | `public/index.php` |
| `CategoryController` | Thin adapter: call service and render `category.tpl` | View, CategoryPageService | `public/index.php` |
| `ArticleController` | Thin adapter: call service and render `article.tpl` | View, ArticlePageService | `public/index.php` |

Interfaces should be added only if they help with a stable boundary or testing.

## Step-by-step refactoring plan

1. Add repositories and move SQL out of the current model classes.
2. Add `HomePageService` and move home page assembly there.
3. Add `CategoryPageService` and move sorting, pagination, and category page assembly there.
4. Add `ArticlePageService` and move article page orchestration there.
5. Keep controllers thin and wire dependencies manually in `public/index.php`.
6. Retire the old model query classes if they become redundant after the repository split.
7. Add interfaces only if a real seam appears later.

## What not to change

- Do not change public URLs.
- Do not change Docker behavior.
- Do not change database schema or seed data unless a real bug appears.
- Do not change visual design.
- Do not add frameworks, ORM, DI container, service locator, annotations, or JavaScript.
- Do not add DTOs unless a concrete readability problem appears.
- Do not add interfaces everywhere.
- Do not touch `Router`, `View`, or `Pagination` unless a real bug appears.
- Do not change shared Smarty layout or partials unless a page data contract forces a small adjustment.

## Verification checklist

Run these after each step:

```bash
docker compose up -d --build
docker compose ps
docker compose logs app
docker compose logs nginx
```

Route smoke tests:

```bash
curl -i http://localhost:8081/
curl -i http://localhost:8081/category/category-1
curl -i "http://localhost:8081/category/category-1?sort=views_desc"
curl -i "http://localhost:8081/category/category-1?page=2"
curl -i http://localhost:8081/article/lorem-ipsum-dolor-sit-amet-1
curl -i http://localhost:8081/category/not-existing
curl -i http://localhost:8081/article/not-existing
```

Database sanity checks:

```bash
docker compose exec mysql mysql -u blog_user -pblog_password blog -e "SELECT COUNT(*) FROM categories;"
docker compose exec mysql mysql -u blog_user -pblog_password blog -e "SELECT COUNT(*) FROM articles;"
docker compose exec mysql mysql -u blog_user -pblog_password blog -e "SELECT COUNT(*) FROM article_category;"
```

PHP syntax checks on changed files:

```bash
docker compose exec app php -l public/index.php
docker compose exec app php -l app/Controllers/HomeController.php
docker compose exec app php -l app/Controllers/CategoryController.php
docker compose exec app php -l app/Controllers/ArticleController.php
```

If templates or class names change, rebuild CSS with:

```bash
npx --yes sass resources/scss/app.scss public/assets/css/app.css --no-source-map
```

## Suggested commit sequence

- `docs: add solid refactoring plan`
- `chore: document solid branch progress in TODO`
- `refactor: add category and article repositories`
- `refactor: move home page assembly into service`
- `refactor: move category page assembly into service`
- `refactor: move article page assembly into service`
- `refactor: thin controllers and keep bootstrap wiring in public/index.php`

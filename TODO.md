# TODO

## 1. Project documentation
- [x] Add `README.md`
- [x] Add `.gitignore`
- [x] Add project description in repository
- [x] Check that README setup steps are correct after Docker setup is added

## 2. Base project setup
- [x] Create base project structure
- [x] Add `composer.json`
- [x] Add Smarty dependency
- [x] Add PSR-4 autoload configuration
- [x] Add `.env.example`
- [x] Add public entry point `public/index.php`
- [x] Add Smarty cache directories

## 3. Docker environment
- [x] Add `docker-compose.yml`
- [x] Add PHP-FPM Dockerfile
- [x] Add Nginx config
- [x] Add MySQL service
- [x] Add automatic `.env` creation on first start
- [x] Add automatic Composer install on container start
- [x] Check that the application opens at `http://localhost:8081`

## 4. Database
- [x] Create database schema
- [x] Add `categories` table
- [x] Add `articles` table
- [x] Add `article_category` pivot table
- [x] Add indexes for slugs, dates, views and relations
- [x] Add seed data for categories
- [x] Add seed data for articles
- [x] Check database import on fresh Docker start

## 5. Core application
- [x] Add application config
- [x] Add PDO database connection
- [x] Add simple router
- [x] Add Smarty view wrapper
- [x] Add basic local error handling
- [x] Add pagination helper

## 6. Models and queries
- [x] Add `Category` model
- [x] Add method to get categories that have articles
- [x] Add method to find category by slug
- [x] Add `Article` model
- [x] Add method to get latest articles by category
- [x] Add method to get articles by category with sorting and pagination
- [x] Add method to find article by slug
- [x] Add method to get related articles
- [x] Add method to increase article views

## 7. Pages
- [x] Add home page
- [x] Show categories with articles on home page
- [x] Show 3 latest articles for each category
- [x] Add "All articles" link for each category
- [x] Add category page
- [x] Show category title and description
- [x] Show article list for selected category
- [x] Add article page
- [x] Show full article information
- [x] Show 3 related articles

## 8. Sorting and pagination
- [x] Add sorting by publication date
- [x] Add sorting by views count
- [x] Add pagination to category page
- [x] Keep sorting value when changing page
- [x] Validate unsupported sorting values
- [x] Check empty and invalid page states

## 9. Templates and styles
- [x] Add main Smarty layout
- [x] Add header partial
- [x] Add pagination partial
- [x] Add article card partial if it keeps templates cleaner
- [x] Add SCSS source file
- [x] Add compiled CSS file
- [x] Make pages readable on desktop and mobile

## 10. Final cleanup
- [x] Check code formatting
- [x] Remove unused files and debug output
- [x] Check SQL queries manually
- [x] Test fresh project setup
- [x] Update README if setup changed
- [x] Do final manual test

## 11. SOLID refactoring branch
- [x] Audit current architecture for SOLID boundaries
- [x] Create SOLID refactoring plan documentation
- [x] Add repositories without changing runtime behavior
- [x] Move page orchestration into services
- [x] Move article page orchestration into services
- [ ] Refactor controllers into thin adapters
- [ ] Move SQL/data access into repositories
- [ ] Re-verify public URLs, Docker, templates, and database after refactor

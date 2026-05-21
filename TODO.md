# TODO

## 1. Project documentation
- [x] Add `README.md`
- [x] Add `.gitignore`
- [ ] Add project description in repository
- [ ] Check that README setup steps are correct after Docker setup is added

## 2. Base project setup
- [ ] Create base project structure
- [ ] Add `composer.json`
- [ ] Add Smarty dependency
- [ ] Add PSR-4 autoload configuration
- [ ] Add `.env.example`
- [ ] Add public entry point `public/index.php`
- [ ] Add Smarty cache directories

## 3. Docker environment
- [ ] Add `docker-compose.yml`
- [ ] Add PHP-FPM Dockerfile
- [ ] Add Nginx config
- [ ] Add MySQL service
- [ ] Add automatic `.env` creation on first start
- [ ] Add automatic Composer install on container start
- [ ] Check that the application opens at `http://localhost:8080`

## 4. Database
- [ ] Create database schema
- [ ] Add `categories` table
- [ ] Add `articles` table
- [ ] Add `article_category` pivot table
- [ ] Add indexes for slugs, dates, views and relations
- [ ] Add seed data for categories
- [ ] Add seed data for articles
- [ ] Check database import on fresh Docker start

## 5. Core application
- [ ] Add application config
- [ ] Add PDO database connection
- [ ] Add simple router
- [ ] Add Smarty view wrapper
- [ ] Add basic local error handling
- [ ] Add pagination helper

## 6. Models and queries
- [ ] Add `Category` model
- [ ] Add method to get categories that have articles
- [ ] Add method to find category by slug
- [ ] Add `Article` model
- [ ] Add method to get latest articles by category
- [ ] Add method to get articles by category with sorting and pagination
- [ ] Add method to find article by slug
- [ ] Add method to get related articles
- [ ] Add method to increase article views

## 7. Pages
- [ ] Add home page
- [ ] Show categories with articles on home page
- [ ] Show 3 latest articles for each category
- [ ] Add “All articles” link for each category
- [ ] Add category page
- [ ] Show category title and description
- [ ] Show article list for selected category
- [ ] Add article page
- [ ] Show full article information
- [ ] Show 3 related articles

## 8. Sorting and pagination
- [ ] Add sorting by publication date
- [ ] Add sorting by views count
- [ ] Add pagination to category page
- [ ] Keep sorting value when changing page
- [ ] Validate unsupported sorting values
- [ ] Check empty and invalid page states

## 9. Templates and styles
- [ ] Add main Smarty layout
- [ ] Add header partial
- [ ] Add pagination partial
- [ ] Add article card partial if it keeps templates cleaner
- [ ] Add SCSS source file
- [ ] Add compiled CSS file
- [ ] Make pages readable on desktop and mobile

## 10. Final cleanup
- [ ] Check code formatting
- [ ] Remove unused files and debug output
- [ ] Check SQL queries manually
- [ ] Test fresh project setup
- [ ] Update README if setup changed
- [ ] Do final manual test
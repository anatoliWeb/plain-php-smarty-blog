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
- [x] Check that the application opens at `http://localhost:8080`

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
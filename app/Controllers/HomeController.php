<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\View;
use App\Services\HomePageService;

class HomeController
{
    private View $view;
    private HomePageService $homePageService;

    public function __construct(View $view, HomePageService $homePageService)
    {
        $this->view = $view;
        $this->homePageService = $homePageService;
    }

    public function index(): string
    {
        $data = $this->homePageService->getPageData();

        return $this->view->render('home.tpl', $data);
    }
}

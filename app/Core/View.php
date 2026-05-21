<?php

declare(strict_types=1);

namespace App\Core;

use Smarty;

class View
{
    private Smarty $smarty;

    public function __construct()
    {
        $projectRoot = dirname(__DIR__, 2);

        $this->smarty = new Smarty();

        // Configure Smarty directories relative to the project root.
        $this->smarty->setTemplateDir($projectRoot . '/templates');
        $this->smarty->setCompileDir($projectRoot . '/var/cache/smarty/compile');
        $this->smarty->setCacheDir($projectRoot . '/var/cache/smarty/cache');
    }

    public function render(string $template, array $data = []): string
    {
        // Pass view data to Smarty using simple key-value assignment.
        foreach ($data as $key => $value) {
            $this->smarty->assign($key, $value);
        }

        return $this->smarty->fetch($template);
    }
}
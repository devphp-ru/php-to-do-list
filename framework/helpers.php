<?php

use Framework\View\Engine\PhpEngine;
use Framework\View\View;
use Framework\View\Manager;

if (!function_exists('view')) {
    /**
     * @throws Exception
     */
    function view(string $template, array $data = []): View|string
    {
        static $manager;

        if (!$manager) {
            $manager = new Manager();

            $manager->addPath(__DIR__ . '/../views');
            $manager->addEngine('php', new PhpEngine());

            $manager->addMacro('escape', fn ($value) => htmlspecialchars($value, ENT_QUOTES, 'utf-8'));
            $manager->addMacro('includes', fn (...$params) => print view(...$params));
        }

        return $manager->resolve($template, $data);
    }
}

if (!function_exists('dd')) {
    function dd($data): never
    {
        echo '<pre>'; \var_dump($data); echo '</pre>';
        die;
    }
}

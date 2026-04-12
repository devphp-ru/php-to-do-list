<?php

declare(strict_types=1);

namespace Framework\View\Engine;

use Framework\View\Manager;
use Framework\View\View;

abstract class Engine
{

    public string $metaTitle = '';

    abstract public function render(View $view): View|string;

    abstract public function setManager(Manager $manager): static;

}

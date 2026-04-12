<?php

declare(strict_types=1);

namespace Framework\View\Engine;

use Framework\View\View;
use Exception;

class PhpEngine extends Engine
{

    use HasManager;

    protected array $layouts = [];

    /**
     * @throws Exception
     */
    public function render(View $view): View|string
    {
        extract($view->data);

        ob_start();
        include $view->path;
        $contents = ob_get_contents();
        ob_end_clean();

        $layout = $this->layouts[$view->path] ?? null;

        if ($layout !== null) {
            return view($layout, array_merge(
                $view->data,
                ['contents' => $contents],
            ));
        }

        return $contents;
    }

    protected function extends(string $template): static
    {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1);
        $this->layouts[realpath($backtrace[0]['file'])] = $template;

        return $this;
    }

}

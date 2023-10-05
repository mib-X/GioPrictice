<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\ViewNotFoundException;

class View
{
    protected function __construct(
        protected string $view,
        protected array $params = []
    ) {
    }
    public static function make($view, $params = []): string
    {
        return (new static($view, $params))->render();
    }
    public function render(): string
    {
        $viewPath = VIEW_PATH . "/" . $this->view . ".php";
        ob_start();

        extract($this->params);

        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            throw new ViewNotFoundException();
        }

        return ob_get_clean();
    }
}

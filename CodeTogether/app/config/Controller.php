<?php
declare(strict_types=1);
class Controller
{
    public $model;

    public function performAction(): void
    {
        return;
    }

    public function renderView(string $view, array $data = []): void
    {
        extract($data);
        include "./public/template/template.php";
        include "./public/views/$view.php";
    }

    public function getAuth(): string
    {
        return "PUBLIC";
    }
}
?>
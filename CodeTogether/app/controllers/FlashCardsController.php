<?php
declare(strict_types=1);

class FlashCardsController extends Controller
{

    public function performAction(): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->renderView('cards');
        }
    }

    public function renderView(string $view, array $data = []): void
    {
        parent::renderView($view, $data);
        ;
    }
}
?>
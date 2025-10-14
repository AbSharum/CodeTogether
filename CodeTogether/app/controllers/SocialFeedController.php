<?php

class SocialFeedController extends Controller {
    

    public function performAction() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->renderView("social-feed");
            return;
        }
    }

    public function renderView($view, $data = []) {
        include "./public/$view.php";
    }
}

<?php

use EvolutionCMS\Bootstrap\FormsDispatcher;

Event::listen('evolution.OnPageNotFound', function($params) {
    if (!empty($_GET['q'])) {
        switch ($_GET['q']) {
            case 'sitemap.xml': {
                echo EvolutionCMS()->runSnippet('DLSitemap', [
                    'idType'  => 'parents',
                    'parents' => 1,
                    'depth'   => 5,
                ], 2592000);

                exit();
            }

            case 'ajax.json': {
                if (!empty($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
                    $dispatcher = new FormsDispatcher();

                    if ($dispatcher->process($_POST)) {
                        echo $dispatcher->getJsonResult();
                        exit();
                    }
                }

                break;
            }
        }
    }
});

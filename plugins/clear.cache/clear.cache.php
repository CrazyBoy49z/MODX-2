<?php
if ($modx->event->name == "OnWebPagePrerender") {

    if (isset($_GET["clear_cache"]) && $_GET["clear_cache"] == "y" && $modx->user->isMember('Administrator')) {

        if (isset($_SESSION['clear_cache_redirected'])) {
            unset($_SESSION['clear_cache_redirected']);
        } else {
            $_SESSION['clear_cache_redirected'] = 1;
            $res = $modx->getObject('modResource', $modx->resource->get('id'));
            $res->clearCache();
            $url = $modx->makeUrl($modx->resource->get('id'));
            $modx->sendRedirect($url . '?clear_cache=y');
        }
    }
}
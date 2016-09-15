<?php

/**
 * 
 * @return array
 */
function ___getAllConfig() {
    $config = [];
    foreach (glob(ROOT . "core/config/*.php") as $filename) {
        $c = include $filename;
        $config[___getFileName($filename)] = $c;
    }
    return $config;
}

function loadHelper($name) {
    $path = ROOT . 'core/helper/' . $name . '.php';
    if (file_exists($path)) {
        include_once $path;
    }
}

/**
 * 
 * @param string $filename
 * @return string
 */
function ___getFileName($filename) {
    $a = explode('/', $filename);
    $b = end($a);
    $c = explode('.', $b);
    return $c[0];
}

/**
 *  config('database.dbname')
 * @param string $item
 * @return mix
 */
function config($item) {
    $itemSegments = explode('.', $item);
    $config = ___getAllConfig();
    foreach ($itemSegments as $segment) {
        $config = $config[$segment];
    }
    return $config;
}

/**
 * 
 * @param type $string
 * @return type
 */
function url($string = null) {
//    $el = $string == null ? "index' : $string;
    $el = $string == null ? '' : $string;

    return config('site.url') . '/' . $el;
}

/**
 * 
 * @param type $string
 */
function redirect($string = null) {

    header('Location:' . url($string));
}

/**
 * 
 * @param type $template
 * @param type $data
 * @param type $master
 * @return type
 */
function view($template, $data = [], $master = 'layout.master') {
    $view = new View($master);
    return $view->render($template, $data);
}

/**
 * 
 * @param type $page
 */
function includeView($page) {
    include_once VIEW_PATH . DIRECTORY_SEPARATOR . str_replace('.', DIRECTORY_SEPARATOR, $page) . '.php';
}

/*
 * 
 */

function dateNow() {
    return date('Y-m-d H:i:s');
}

/**
 * 
 * @param type $data
 */
function dump($data) {
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

function time2str($ts) {
    if (!ctype_digit($ts))
        $ts = strtotime($ts);

    $diff = time() - $ts;
    if ($diff == 0)
        return 'now';
    elseif ($diff > 0) {
        $day_diff = floor($diff / 86400);
        if ($day_diff == 0) {
            if ($diff < 60)
                return 'just now';
            if ($diff < 120)
                return '1 minute ago';
            if ($diff < 3600)
                return floor($diff / 60) . ' minutes ago';
            if ($diff < 7200)
                return '1 hour ago';
            if ($diff < 86400)
                return floor($diff / 3600) . ' hours ago';
        }
        if ($day_diff == 1)
            return 'Yesterday';
        if ($day_diff < 7)
            return $day_diff . ' days ago';
        if ($day_diff < 31)
            return ceil($day_diff / 7) . ' weeks ago';
        if ($day_diff < 60)
            return 'last month';
        return date('F Y', $ts);
    }
    else {
        $diff = abs($diff);
        $day_diff = floor($diff / 86400);
        if ($day_diff == 0) {
            if ($diff < 120)
                return 'in a minute';
            if ($diff < 3600)
                return 'in ' . floor($diff / 60) . ' minutes';
            if ($diff < 7200)
                return 'in an hour';
            if ($diff < 86400)
                return 'in ' . floor($diff / 3600) . ' hours';
        }
        if ($day_diff == 1)
            return 'Tomorrow';
        if ($day_diff < 4)
            return date('l', $ts);
        if ($day_diff < 7 + (7 - date('w')))
            return 'next week';
        if (ceil($day_diff / 7) < 4)
            return 'in ' . ceil($day_diff / 7) . ' weeks';
        if (date('n', $ts) == date('n') + 1)
            return 'next month';
        return date('F Y', $ts);
    }
}


//else show 404
function show404() {
    header("HTTP/1.0 404 Not Found");
    echo "<h1>404 Not Found</h1>";
    echo "The page that you have requested could not be found.";
    exit();
}

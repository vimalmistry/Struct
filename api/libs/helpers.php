<?php

function forApi()
{
    if (isset($request['APP_ID']))
    {
        return true;
    }

    if (isset($_GET['call']) && $_GET['call'] == 'mobile')
    {
        return true;
    }
    return false;
}

function dump($data)
{
    echo '<pre>' . print_r($data, true) . '</pre>';
}

function toJson($data)
{
    header('Content-Type: application/json');
    echo json_encode($data);
}

<?php

interface Application {

    public function __construct($config = []);

    function _setConfig($param);

    static function instance();
}

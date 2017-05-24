<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jinhwan
 * Date: 2017-05-24
 * Time: 오전 11:05
 */
require_once __DIR__ . '/../vendor/autoload.php';
/** @var Silex\Application $app */
$app = require __DIR__ . '/../src/app.php';
require __DIR__ . '/../src/controllers.php';
$app['debug'] = true;
$app->run();

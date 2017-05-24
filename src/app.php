<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jinhwan
 * Date: 2017-05-24
 * Time: 오전 11:06
 */
namespace Jhbae\GdsExample;

use Silex\Application;
use Silex\Provider\TwigServiceProvider;

$app = new Application();
$app->register(new TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/../templates',
    'twig.options' => array(
        'strict_variables' => false,
    ),
));


return $app;
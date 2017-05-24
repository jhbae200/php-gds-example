<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jinhwan
 * Date: 2017-05-24
 * Time: 오전 11:31
 */
namespace Jhbae\GdsExample;

use Jhbae\GdsExample\Controller\ApiController;
use Silex\Application;

/** @var Application $app */
$app->mount('/api', new ApiController());
<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jinhwan
 * Date: 2017-05-24
 * Time: 오전 11:30
 */

namespace Jhbae\GdsExample\Controller;

use Jhbae\GdsExample\DataModel\DataStore;
use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiController implements ControllerProviderInterface
{
    /**
     * Returns routes to connect to the given application.
     *
     * @param Application $app An Application instance
     *
     * @return \Silex\ControllerCollection A ControllerCollection instance
     */
    public function connect(Application $app)
    {
        /** @var \Silex\ControllerCollection $controllers */
        $controllers = $app['controllers_factory'];

        $controllers->get('/notification', __NAMESPACE__ . '\\ApiController::getNotification');

        $controllers->post('/notification', __NAMESPACE__ . '\\ApiController::postNotification');

        return $controllers;
    }

    /**
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getNotification(Application $app)
    {
        $count = 10;
        $dataStore = new DataStore();
        $notifications = $dataStore->getNotification(12345, 0, $count);
        return $app->json(['result' => $notifications, 'count' => $count]);
    }

    public function postNotification(Request $request, Application $app)
    {
        $dataStore = new DataStore();
        $dataStore->addNotification(12346, 12345, 'Hello World!');
        return new Response();
    }
}
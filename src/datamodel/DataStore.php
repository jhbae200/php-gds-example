<?php

/**
 * Created by IntelliJ IDEA.
 * User: Jinhwan
 * Date: 2017-05-24
 * Time: 오후 1:58
 */

namespace Jhbae\GdsExample\DataModel;

use GDS\Schema;
use google\appengine\api\modules\ModulesService;

class DataStore
{
    const KIND_NOTIFICATION = 'Notification';

    public function addNotification($userId, $targetUserId, $message)
    {
        $store = $this->getStore(self::KIND_NOTIFICATION);
        $entity = $store->createEntity(array(
            'userId' => $userId,
            'targetUserId' => $targetUserId,
            'message' => $message,
            'isRead' => false,
            'registeredTime' => (new \DateTime('now'))
        ));
        $store->upsert($entity);

        return $entity;
    }

    private function getStore($kind)
    {
        $storeGateway = new \GDS\Gateway\ProtoBuf(null, self::getNamespace());
        $store = new \GDS\Store($kind, $storeGateway);

        return $store;
    }

    private function getNamespace()
    {
        return ModulesService::getCurrentModuleName();
    }

    public function getNotification($targetUserId, $last, $count)
    {
        $store = $this->getStore(self::KIND_NOTIFICATION);
        $gql = "SELECT * FROM " . self::KIND_NOTIFICATION . " WHERE targetUserIdx = @targetUserId ORDER BY registeredTime DESC";
        $store->query($gql, ['targetUserId' => (int)$targetUserId]);
        $results = array();
        $notifications = $store->fetchPage($count, $last);
        foreach ($notifications as &$notification) {
            $this->updateIsRead($notification);
            array_push($results, $notification->getData());
        }
        return $results;
    }

    public function updateIsRead($notification)
    {
        $store = $this->getStore((new Schema(self::KIND_NOTIFICATION))
            ->addInteger('targetUserId')
            ->addInteger('userId')
            ->addBoolean('isRead')
            ->addDatetime('registeredTime'));

        $notification->isPushed = true;
        $store->upsert($notification);
    }
}
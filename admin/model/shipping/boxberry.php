<?php

namespace Opencart\Admin\Model\Extension\Boxberry\Shipping;

use Boxberry\Client\Client;

if (!class_exists('Client')) {
    require_once DIR_EXTENSION . 'boxberry/system/library/boxberry/autoload.php';
}

/**
 * Class Boxberry
 *
 * @package Opencart\Admin\Model\Extension\Boxberry\Shipping
 */
class Boxberry extends \Opencart\System\Engine\Model
{
    /**
     * @return void
     */
    public function install(): void
    {
        $this->load->model('user/user_group');

        $this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'sale/boxberry');

        $this->load->model('setting/event');

        $this->model_setting_event->addEvent([
            'code'        => 'boxberry_order_status_edit',
            'description' => 'Создаёт заказ в личном кабинете Boxberry',
            'trigger'     => 'catalog/model/checkout/order/addOrderHistory/after',
            'action'      => 'event/boxberry/addOrderHistory',
            'status'      => '1',
            'sort_order'  => '1'
        ]);

        $this->model_setting_event->addEvent([
            'code'        => 'boxberry_add_scripts',
            'description' => 'Подключает скрипты для виджета Boxberry',
            'trigger'     => 'catalog/controller/common/header/before',
            'action'      => 'event/boxberry/addScripts',
            'status'      => '1',
            'sort_order'  => '1'
        ]);

        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "boxberry_cities` (
      `code` VARCHAR(128) NOT NULL,
      `name` VARCHAR(128),
      `region` VARCHAR(128),
      `data` text,
      PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "boxberry_deliveries` (
      `order_id` int(10) NOT NULL,
      `im_id` VARCHAR(255),
      `label` VARCHAR(255),
      `boxberry_to_point` VARCHAR(15),
      `address` VARCHAR(255),
      `error` VARCHAR(255),
      PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "boxberry_points` (
      `code` VARCHAR(128) NOT NULL,
      `city_code` VARCHAR(128),
      `data` text,
      `expired` datetime,
      `prepaid` tinyint(1),
      PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "boxberry_listzips` (
      `zip` VARCHAR(128) NOT NULL,
      `city` VARCHAR(128),
      `area` VARCHAR(128),
      PRIMARY KEY (`zip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "boxberry_expired` (
      `table` VARCHAR(128) NOT NULL,
      `expired` datetime,
      PRIMARY KEY (`table`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;");
    }

    /**
     * @return void
     */
    public function uninstall(): void
    {
        $this->load->model('user/user_group');
        $this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'sale/boxberry');

        $this->load->model('setting/event');
        $this->model_setting_event->deleteEventByCode('boxberry_order_status_edit');
        $this->model_setting_event->deleteEventByCode('boxberry_add_scripts');

        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "boxberry_cities`;");
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "boxberry_deliveries`;");
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "boxberry_points`;");
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "boxberry_listzips`;");
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "boxberry_expired`;");
    }

    public function getIssuePointById($issuePointId, $prepaid)
    {
        $this->load->model('boxberry/point');
        if ((!$point = $this->model_boxberry_point->getPoint($issuePointId, $prepaid)) || ($point && (strtotime($point['expired']) <= time()))) {
            $this->load->model('boxberry/point');

            $client = new Client();
            $client->setApiToken($this->config->get('shipping_boxberry_api_token'));
            $client->setApiUrl($this->config->get('shipping_boxberry_api_url'));

            $description = $client::getPointsDescription();
            $description->setCode($issuePointId);
            $description->setPhoto(0);

            try {
                $point = $client->execute($description);
                $point = [
                    'code' => $issuePointId,
                    'city_code' => $point->getCityCode(),
                    'data' => $point->getData(),
                    'prepaid' => $prepaid
                ];

                $this->model_boxberry_point->addPoint($point);

                return $point['data'];
            } catch (Exception $e) {

            }
        }

        return json_decode($point['data'], 1);
    }
}

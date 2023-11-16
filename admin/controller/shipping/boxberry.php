<?php

namespace Opencart\Admin\Controller\Extension\Boxberry\Shipping;

use Boxberry\Client\Client;

if (!class_exists('Client')) {
    require_once DIR_EXTENSION . 'boxberry/system/library/boxberry/autoload.php';
}

class Boxberry extends \Opencart\System\Engine\Controller
{
    private array $error = [];

    public function index(): void
    {
        $this->load->language('extension/boxberry/shipping/boxberry');

        $this->document->setTitle($this->language->get('heading_title'));

        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
        ];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=shipping')
        ];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/boxberry/shipping/boxberry', 'user_token=' . $this->session->data['user_token'])
        ];

        $data['route'] = "extension/boxberry/shipping/boxberry";

        /*$this->load->model('localisation/weight_class');
        if (($weight = $this->model_localisation_weight_class->getWeightClassDescriptionByUnit('g'))
            || ($weight = $this->model_localisation_weight_class->getWeightClassDescriptionByUnit('г'))) {
            $this->request->post['shipping_boxberry_weight_class_id'] = $weight['weight_class_id'];
        }

        $this->load->model('localisation/length_class');
        if (($length = $this->model_localisation_length_class->getLengthClassDescriptionByUnit('cm'))
            || ($length = $this->model_localisation_length_class->getLengthClassDescriptionByUnit('см'))) {
            $this->request->post['shipping_boxberry_length_class_id'] = $length['length_class_id'];
        }*/

        if (($this->request->server['REQUEST_METHOD'] === 'POST') && $this->validate()) {
            $client = new Client();
            $client->setKey($this->request->post['shipping_boxberry_api_token']);
            $client->setApiUrl($this->request->post['shipping_boxberry_api_url']);
            $getKeyIntegrationRequest = $client->getKeyIntegration();
            try {
                $response = $client->execute($getKeyIntegrationRequest);
                $this->request->post['shipping_boxberry_widget_key'] = $response->getKeyIntegration();
                $this->load->model('setting/setting');
                $this->model_setting_setting->editSetting('shipping_boxberry', $this->request->post);
                $this->model_setting_setting->editSetting('boxberry', ['boxberry_status' => $this->request->post['shipping_boxberry_status']]);
                $this->session->data['success'] = $this->language->get('text_success');
                $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=shipping'));
            } catch (Exception $e) {
                if ($e->getMessage() === 'Ошибка обращения к сервису доставки Boxberry') {
                    $this->error['warning'] = 'Указан неверный URL API сервиса';
                } elseif ($e->getMessage() === 'Нет доступа') {
                    $this->error['warning'] = 'Указан неверный API-токен';
                } elseif ($e->getMessage() === 'Ваша учетная запись заблокирована') {
                    $this->error['warning'] = 'Учетная запись с данным API-токеном заблокирована';
                }
            }
        }

        $data['error_warning'] = $this->error['warning'] ?? '';
        $data['action'] = $this->url->link('extension/boxberry/shipping/boxberry', 'user_token=' . $this->session->data['user_token']);
        $data['back'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=shipping');

        $fields = [
            [
                'name' => 'shipping_boxberry_api_url',
                'default' => $this->request->post['shipping_boxberry_api_url'] ?? 'https://api.boxberry.ru/json.php'
            ],
            [
                'name' => 'shipping_boxberry_widget_url',
                'default' => $this->request->post['shipping_boxberry_widget_url'] ?? 'https://points.boxberry.de/js/boxberry.js'
            ],
            [
                'name' => 'shipping_boxberry_api_token',
                'default' => $this->request->post['shipping_boxberry_api_token'] ?? ''
            ],
            [
                'name' => 'shipping_boxberry_sort_order',
                'default' => $this->request->post['shipping_boxberry_sort_order'] ?? ''
            ],
            [
                'name' => 'shipping_boxberry_status',
                'default' => $this->request->post['shipping_boxberry_status'] ?? '1'
            ],
            [
                'name' => 'shipping_boxberry_weight',
                'default' => $this->request->post['shipping_boxberry_weight'] ?? '500'
            ],
            [
                'name' => 'shipping_boxberry_weight_min',
                'default' => $this->request->post['shipping_boxberry_weight_min'] ?? '5'
            ],
            [
                'name' => 'shipping_boxberry_weight_max',
                'default' => $this->request->post['shipping_boxberry_weight_max'] ?? '31000'
            ],
            [
                'name' => 'shipping_boxberry_size',
                'default' => $this->request->post['shipping_boxberry_size'] ?? ''
            ],
            [
                'name' => 'shipping_boxberry_package_size',
                'default' => $this->request->post['shipping_boxberry_package_size'] ?? ''
            ],
            [
                'name' => 'shipping_boxberry_width',
                'default' => $this->request->post['shipping_boxberry_width'] ?? ''
            ],
            [
                'name' => 'shipping_boxberry_height',
                'default' => $this->request->post['shipping_boxberry_height'] ?? ''
            ],
            [
                'name' => 'shipping_boxberry_depth',
                'default' => $this->request->post['shipping_boxberry_depth'] ?? ''
            ],
            [
                'name' => 'shipping_boxberry_order_status',
                'default' => $this->request->post['shipping_boxberry_order_status'] ?? ''
            ],
            [
                'name' => 'shipping_boxberry_weight_class_id',
                'default' => $this->request->post['shipping_boxberry_weight_class_id'] ?? ''
            ],
            [
                'name' => 'shipping_boxberry_length_class_id',
                'default' => $this->request->post['shipping_boxberry_length_class_id'] ?? ''
            ],
            [
                'name' => 'shipping_boxberry_pickup_status',
                'default' => $this->request->post['shipping_boxberry_pickup_status'] ?? ''
            ],
            [
                'name' => 'shipping_boxberry_pickup_prepaid_status',
                'default' => $this->request->post['shipping_boxberry_pickup_prepaid_status'] ?? ''
            ],
            [
                'name' => 'shipping_boxberry_courier_delivery_status',
                'default' => $this->request->post['shipping_boxberry_courier_delivery_status'] ?? ''
            ],
            [
                'name' => 'shipping_boxberry_courier_delivery_prepaid_status',
                'default' => $this->request->post['shipping_boxberry_courier_delivery_prepaid_status'] ?? ''
            ],
            [
                'name' => 'shipping_boxberry_pickup_sucrh',
                'default' => $this->request->post['shipping_boxberry_pickup_sucrh'] ?? '1'
            ],
            [
                'name' => 'shipping_boxberry_pickup_prepaid_sucrh',
                'default' => $this->request->post['shipping_boxberry_pickup_prepaid_sucrh'] ?? '1'
            ],
            [
                'name' => 'shipping_boxberry_courier_delivery_sucrh',
                'default' => $this->request->post['shipping_boxberry_courier_delivery_sucrh'] ?? '1'
            ],
            [
                'name' => 'shipping_boxberry_courier_delivery_prepaid_sucrh',
                'default' => $this->request->post['shipping_boxberry_courier_delivery_prepaid_sucrh'] ?? '1'
            ],
            [
                'name' => 'shipping_boxberry_courier_delivery_prepaid_status',
                'default' => $this->request->post['shipping_boxberry_courier_delivery_prepaid_status'] ?? ''
            ],
            [
                'name' => 'shipping_boxberry_pickup_parselcreate_auto',
                'default' => $this->request->post['shipping_boxberry_pickup_parselcreate_auto'] ?? '1'
            ],
            [
                'name' => 'shipping_boxberry_pickup_prepaid_parselcreate_auto',
                'default' => $this->request->post['shipping_boxberry_pickup_prepaid_parselcreate_auto'] ?? '1'
            ],
            [
                'name' => 'shipping_boxberry_courier_delivery_parselcreate_auto',
                'default' => $this->request->post['shipping_boxberry_courier_delivery_parselcreate_auto'] ?? '1'
            ],
            [
                'name' => 'shipping_boxberry_courier_delivery_prepaid_parselcreate_auto',
                'default' => $this->request->post['shipping_boxberry_courier_delivery_prepaid_parselcreate_auto'] ?? '1'
            ],
            [
                'name' => 'shipping_boxberry_pickup_parselsend_auto',
                'default' => $this->request->post['shipping_boxberry_pickup_parselsend_auto'] ?? ''
            ],
            [
                'name' => 'shipping_boxberry_pickup_prepaid_parselsend_auto',
                'default' => $this->request->post['shipping_boxberry_pickup_prepaid_parselsend_auto'] ?? ''
            ],
            [
                'name' => 'shipping_boxberry_courier_delivery_parselsend_auto',
                'default' => $this->request->post['shipping_boxberry_courier_delivery_parselsend_auto'] ?? ''
            ],
            [
                'name' => 'shipping_boxberry_courier_delivery_prepaid_parselsend_auto',
                'default' => $this->request->post['shipping_boxberry_courier_delivery_prepaid_parselsend_auto'] ?? ''
            ],
            [
                'name' => 'shipping_boxberry_pickup_name',
                'default' => $this->request->post['shipping_boxberry_pickup_name'] ?? $this->language->get('text_pickup_description')
            ],
            [
                'name' => 'shipping_boxberry_pickup_prepaid_name',
                'default' => $this->request->post['shipping_boxberry_pickup_prepaid_name'] ?? $this->language->get('text_pickup_prepaid_description')
            ],
            [
                'name' => 'shipping_boxberry_courier_delivery_name',
                'default' => $this->request->post['shipping_boxberry_courier_delivery_name'] ?? $this->language->get('text_courier_delivery_description')
            ],
            [
                'name' => 'shipping_boxberry_courier_delivery_prepaid_name',
                'default' => $this->request->post['shipping_boxberry_courier_delivery_prepaid_name'] ?? $this->language->get('text_courier_delivery_prepaid_description')
            ],
        ];

        foreach ($fields as $field) {
            $fieldName = $field['name'];
            $configValue = $this->config->get($fieldName);
            $data[$fieldName] = $this->request->post[$fieldName] ?? null;
            $data[$fieldName] = $data[$fieldName] === null ? $configValue : null;
            $data[$fieldName] = $data[$fieldName] === null ? $field['default'] : $data[$fieldName];
        }

        $this->load->model('localisation/order_status');
        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        $this->load->model('localisation/weight_class');
        $data['weight_ids'] = $this->model_localisation_weight_class->getWeightClasses();

        $this->load->model('localisation/length_class');
        $data['length_ids'] = $this->model_localisation_length_class->getLengthClasses();

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/boxberry/shipping/boxberry', $data));
    }

    protected function validate(): bool
    {
        if (!$this->user->hasPermission('modify', 'extension/boxberry/shipping/boxberry')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        if (!$this->request->post['shipping_boxberry_api_token']) {
            $this->error['warning'] = $this->language->get('error_api_key');
        }
        if (!$this->request->post['shipping_boxberry_api_url']) {
            $this->error['warning'] = 'Не указан Url для API сервиса!';
        }
        if (!$this->request->post['shipping_boxberry_weight']) {
            $this->error['warning'] = 'Не указан вес по умолчанию!';
        }
        if (!$this->request->post['shipping_boxberry_widget_url']) {
            $this->error['warning'] = 'Не указан Url для виджета';
        }
        return !$this->error;
    }

    public function install(): void
    {
        $this->load->model('user/user_group');
        $this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'sale/boxberry');

        $events = [
            'addOrderHistory' => [
                'code'        => 'boxberry_order_status_edit',
                'description' => 'Создаёт заказ в личном кабинете Boxberry',
                'trigger'     => 'catalog/model/checkout/order/addOrderHistory/after',
                'action'      => 'event/boxberry/addOrderHistory',
                'status'      => '1',
                'sort_order'  => '1'
            ],
            'addScripts' => [
                'code'        => 'boxberry_add_scripts',
                'description' => 'Подключает скрипты для виджета Boxberry',
                'trigger'     => 'catalog/controller/common/header/before',
                'action'      => 'event/boxberry/addScripts',
                'status'      => '1',
                'sort_order'  => '1'
            ]
        ];

        $this->load->model('setting/event');
        foreach ($events as $event) {
            $this->model_setting_event->addEvent($event);
        }

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
}

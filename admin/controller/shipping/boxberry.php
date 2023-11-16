<?php

namespace Opencart\Admin\Controller\Extension\Boxberry\Shipping;

use Boxberry\Client\Client;

if (!class_exists('Client')) {
    require_once DIR_EXTENSION . 'boxberry/system/library/boxberry/autoload.php';
}

/**
 * Class Boxberry
 *
 * @package Opencart\Admin\Controller\Extension\Boxberry\Shipping
 */
class Boxberry extends \Opencart\System\Engine\Controller
{
    /**
     * @return void
     */
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

        $data['save'] = $this->url->link('extension/boxberry/shipping/boxberry.save', 'user_token=' . $this->session->data['user_token']);
        $data['back'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=shipping');

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
                'default' => $this->request->post['shipping_boxberry_status'] ?? '0'
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
                'default' => $this->request->post['shipping_boxberry_pickup_sucrh'] ?? '0'
            ],
            [
                'name' => 'shipping_boxberry_pickup_prepaid_sucrh',
                'default' => $this->request->post['shipping_boxberry_pickup_prepaid_sucrh'] ?? '0'
            ],
            [
                'name' => 'shipping_boxberry_courier_delivery_sucrh',
                'default' => $this->request->post['shipping_boxberry_courier_delivery_sucrh'] ?? '0'
            ],
            [
                'name' => 'shipping_boxberry_courier_delivery_prepaid_sucrh',
                'default' => $this->request->post['shipping_boxberry_courier_delivery_prepaid_sucrh'] ?? '0'
            ],
            [
                'name' => 'shipping_boxberry_pickup_parselcreate_auto',
                'default' => $this->request->post['shipping_boxberry_pickup_parselcreate_auto'] ?? '0'
            ],
            [
                'name' => 'shipping_boxberry_pickup_prepaid_parselcreate_auto',
                'default' => $this->request->post['shipping_boxberry_pickup_prepaid_parselcreate_auto'] ?? '0'
            ],
            [
                'name' => 'shipping_boxberry_courier_delivery_parselcreate_auto',
                'default' => $this->request->post['shipping_boxberry_courier_delivery_parselcreate_auto'] ?? '0'
            ],
            [
                'name' => 'shipping_boxberry_courier_delivery_prepaid_parselcreate_auto',
                'default' => $this->request->post['shipping_boxberry_courier_delivery_prepaid_parselcreate_auto'] ?? '0'
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

    public function save(): void
    {
        $this->load->language('extension/boxberry/shipping/boxberry');

        $json = [];

        if (!$this->user->hasPermission('modify', 'extension/boxberry/shipping/boxberry')) {
            $json['error'] = $this->language->get('error_permission');
        }
        if (!$this->request->post['shipping_boxberry_api_token']) {
            $json['error'] = $this->language->get('error_api_key');
        }
        if (!$this->request->post['shipping_boxberry_api_url']) {
            $json['error'] = $this->language->get('error_api_url');
        }
        if (!$this->request->post['shipping_boxberry_weight']) {
            $json['error'] = $this->language->get('error_weight');
        }
        if (!$this->request->post['shipping_boxberry_widget_url']) {
            $json['error'] = $this->language->get('error_widget_url');
        }

        $client = new Client();
        $client->setKey($this->request->post['shipping_boxberry_api_token']);
        $client->setApiUrl($this->request->post['shipping_boxberry_api_url']);
        $getKeyIntegrationRequest = $client->getKeyIntegration();
        try {
            $response = $client->execute($getKeyIntegrationRequest);
            $this->request->post['shipping_boxberry_widget_key'] = $response->getKeyIntegration();
        } catch (\Exception $e) {
            if ($e->getMessage() === 'Ошибка обращения к сервису доставки Boxberry') {
                $json['error'] = $this->language->get('error_wrong_api_url');
            } elseif ($e->getMessage() === 'Нет доступа') {
                $json['error'] = $this->language->get('error_wrong_api_key');
            } elseif ($e->getMessage() === 'Ваша учетная запись заблокирована') {
                $json['error'] = $this->language->get('error_blocked_api_key');
            }
        }

        if (!$json) {
            $this->load->model('setting/setting');

            $this->model_setting_setting->editSetting('shipping_boxberry', $this->request->post);

            $json['success'] = $this->language->get('text_success');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}

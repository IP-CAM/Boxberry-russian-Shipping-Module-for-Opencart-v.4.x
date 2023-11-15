<?php

namespace Opencart\Admin\Controller\Sale\Boxberry;

use Boxberry\Client\Client;

if (!class_exists('Client')) {
    require_once DIR_SYSTEM . 'library/boxberry/autoload.php';
}

class Boxberry extends \Opencart\System\Engine\Controller
{
    public function index(): void
    {
        $this->load->language('sale/boxberry');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('boxberry/delivery');

        $this->getList();
        $this->parselSend();
    }

    protected function parselSend(): void
    {
        if (isset($this->request->post['im_ids'])) {
            $imIdsList = $this->request->post['im_ids'];

            $client = new Client();
            $client->setKey($this->config->get('shipping_boxberry_api_token'));
            $client->setApiUrl($this->config->get('shipping_boxberry_api_url'));

            $error = '';

            try {
                $parselSend = $client::getParselSend();
                $parselSend->setImgIdsList($imIdsList);
                $parselSend = $client->execute($parselSend);
                $actLabel = $parselSend->getActLabel();
            } catch (Exception $e) {
                $error = $e->getMessage();
            }

            foreach ($imIdsList as $imId) {
                $trackingLink = 'https://boxberry.ru/tracking-page?id=' . $imId;
                if (!empty($actLabel)) {
                    $data = array(
                        'track_number' => $imId,
                        'im_id' => ' ' . $trackingLink,
                        'label' => ' ' . $actLabel,
                        'error' => ''
                    );
                } elseif (!empty($error)) {
                    $data = array(
                        'track_number' => $imId,
                        'error' => $error
                    );
                }

                if (!empty($data)) {
                    $this->model_boxberry_delivery->updateDelivery($data);
                }
            }
        }
    }

    protected function getList(): void
    {
        $urlGetParams = '';

        $filterOrderId = $this->request->get['filter_order_id'] ?? '';

        $sort = $this->request->get['sort'] ?? 'order_id';

        $order = $this->request->get['order'] ?? 'DESC';

        $page = $this->request->get['page'] ?? 1;

        if (isset($this->request->get['filter_order_id'])) {
            $urlGetParams .= '&filter_order_id=' . $this->request->get['filter_order_id'];
        }

        if (isset($this->request->get['order'])) {
            $urlGetParams .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['page'])) {
            $urlGetParams .= '&page=' . $this->request->get['page'];
        }

        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'] . $urlGetParams, true)
        ];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('sale/boxberry', 'user_token=' . $this->session->data['user_token'] . $urlGetParams, true)
        ];

        $data = array_merge($data, $this->load->language('extension/extension'));
        $data = array_merge($data, $this->load->language('sale/boxberry'));

        $filterData = [
            'filter_order_id' => $filterOrderId,
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit' => $this->config->get('config_limit_admin')
        ];

        $data['deliveries'] = $this->model_boxberry_delivery->getDeliveries($filterData);
        $data['user_token'] = $this->session->data['user_token'];

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->request->post['selected'])) {
            $data['selected'] = (array)$this->request->post['selected'];
        } else {
            $data['selected'] = [];
        }

        $urlGetParams = '';

        if ($order === 'ASC') {
            $urlGetParams .= '&order=DESC';
        } else {
            $urlGetParams .= '&order=ASC';
        }

        $data['sort_order_id']          = $this->url->link('sale/boxberry', 'user_token=' . $this->session->data['user_token'] . '&sort=order_id' . $urlGetParams, true);
        $data['sort_im_id']             = $this->url->link('sale/boxberry', 'user_token=' . $this->session->data['user_token'] . '&sort=im_id' . $urlGetParams, true);
        $data['sort_label']             = $this->url->link('sale/boxberry', 'user_token=' . $this->session->data['user_token'] . '&sort=label' . $urlGetParams, true);
        $data['sort_error']             = $this->url->link('sale/boxberry', 'user_token=' . $this->session->data['user_token'] . '&sort=error' . $urlGetParams, true);
        $data['sort_boxberry_to_point'] = $this->url->link('sale/boxberry', 'user_token=' . $this->session->data['user_token'] . '&sort=boxberry_to_point' . $urlGetParams, true);
        $data['sort_address']           = $this->url->link('sale/boxberry', 'user_token=' . $this->session->data['user_token'] . '&sort=address' . $urlGetParams, true);

        $urlPaginationParam = '';

        if (isset($this->request->get['sort'])) {
            $urlPaginationParam .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $urlPaginationParam .= '&order=' . $this->request->get['order'];
        }

        $total = $this->model_boxberry_delivery->getTotalDeliveries();

        $pagination = new Opencart\Admin\Controller\Common\Pagination();
        $pagination->total = $total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->url->link('sale/boxberry', 'user_token=' . $this->session->data['user_token'] . $urlPaginationParam . '&page={page}', true);

        $data['pagination'] = $pagination->render();
        $data['results'] = sprintf($this->language->get('text_pagination'),($total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($total - $this->config->get('config_limit_admin'))) ? $total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $total, ceil($total / $this->config->get('config_limit_admin')));
        $data['filter_order_id'] = $filterOrderId;
        $data['sort'] = $sort;
        $data['order'] = $order;
        $data['catalog'] = $this->request->server['HTTPS'] ? HTTPS_CATALOG : HTTP_CATALOG;
        $data['api_token'] = '';
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('sale/delivery_list', $data));
    }
}
<?php

namespace Opencart\Catalog\Controller\Shipping;

class Boxberry extends \Opencart\System\Engine\Controller
{
    public function selectIssuePoint(): void
    {
        $issuePointId = $this->request->get['issue_point_id'];
        $prepaid = $this->request->get['prepaid'];
        if ($issuePointId) {
            $this->load->model('extension/shipping/boxberry');
            $issuePoint = $this->model_extension_shipping_boxberry->getIssuePointById($issuePointId, $prepaid);
            if ($issuePoint) {
                $json['postamat'] = $issuePoint['Postamat'];
                $sessionData = [
                    'boxberry_shipping_city_id' => $issuePoint['CityCode'],
                    'boxberry_shipping_city_name' => $issuePoint['CityName'],
                    'boxberry_shipping_issue_point_prepaid' => $prepaid ? 1 : 0,
                    'boxberry_shipping_issue_point_id' . ($prepaid ? '_prepaid' : '') => $issuePointId,
                    'boxberry_shipping_addr1' => $issuePoint['Address'],
                    'boxberry_shipping_addr2' => $issuePoint['Phone'] . ', ' . $issuePoint['WorkShedule']
                ];
                foreach ($sessionData as $key => $value) {
                    $this->session->data[$key] = $value;
                }
            }
        }
        $this->response->addHeader('Content-Type: application/json; charset=utf-8');
        $this->response->setOutput(json_encode($json));
    }
}
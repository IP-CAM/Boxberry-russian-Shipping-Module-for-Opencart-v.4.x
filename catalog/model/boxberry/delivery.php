<?php

namespace Opencart\Catalog\Model\Extension\Boxberry\Boxberry;

class Delivery extends \Opencart\System\Engine\Model
{
    public function getDelivery($order)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "boxberry_deliveries WHERE `order_id` = '" . $this->db->escape($order) . "'");
        if ($query->num_rows) {
            return $query->row;
        }

        return null;
    }

    public function getDeliveries()
    {
        return $this->db->query("SELECT * FROM " . DB_PREFIX . "boxberry_deliveries ")->rows;
    }

    public function addDelivery($data)
    {
        $sql = "INSERT INTO `" . DB_PREFIX . "boxberry_deliveries` SET 
        order_id = '" . $this->db->escape($data['order_id'])
            . "', im_id = '" . $this->db->escape($data['im_id'])
            . "', label = '" . $this->db->escape($data['label'])
            . "', boxberry_to_point = '" . $this->db->escape($data['boxberry_to_point'])
            . "', address = '" . $this->db->escape($data['address'])
            . "', error = '" . $this->db->escape($data['error'])
            . "' ON DUPLICATE KEY UPDATE 
            im_id = '" . $this->db->escape($data['im_id'])
            . "', label = '" . $this->db->escape($data['label'])
            . "', boxberry_to_point = '" . $this->db->escape($data['boxberry_to_point'])
            . "', address = '" . $this->db->escape($data['address'])
            . "', error = '" . $this->db->escape($data['error'])
            . "'";

        $this->db->query($sql);

        return $this->db->getLastId();
    }
}
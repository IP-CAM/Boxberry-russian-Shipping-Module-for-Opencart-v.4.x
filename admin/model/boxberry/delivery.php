<?php

class ModelBoxberryDelivery extends Model
{
    public function getDelivery($order)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "boxberry_deliveries WHERE `order_id` = '" . (int)$order . "'");
        if ($query->num_rows) {
            return $query->row;
        }

        return null;
    }

    public function getDeliveries($filterData = array())
    {
        $sql = "SELECT * FROM " . DB_PREFIX . "boxberry_deliveries";

        if (isset($filterData['filter_order_id']) && $filterData['filter_order_id']) {
            $sql .= " WHERE order_id=" . (int)$filterData['filter_order_id'];
        }

        $sortData = array(
            'order_id',
            'im_id',
            'label',
            'boxberry_to_point',
            'address',
            'error'
        );

        if (isset($filterData['sort']) && in_array($filterData['sort'], $sortData)) {
            $sql .= " ORDER BY " . $filterData['sort'];
        } else {
            $sql .= " ORDER BY order_id";
        }

        if (isset($filterData['order']) && ($filterData['order'] === 'DESC')) {
            $sql .= ' DESC';
        } else {
            $sql .= ' ASC';
        }

        if (isset($filterData['start']) || isset($filterData['limit'])) {
            if ($filterData['start'] < 0) {
                $filterData['start'] = 0;
            }
            if ($filterData['limit'] < 1) {
                $filterData['limit'] = 20;
            }

            $sql .= " LIMIT " . $filterData['start'] . "," . $filterData['limit'];
        }

        return $this->db->query($sql)->rows;
    }

    public function getTotalDeliveries()
    {
        $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "boxberry_deliveries";

        return $this->db->query($sql)->row['total'];
    }

    public function getProducts($orderId)
    {
        $query = $this->db->query("SELECT 
" . DB_PREFIX . "order_product.quantity, 
" . DB_PREFIX . "order_product.price, 
" . DB_PREFIX . "order_product.total,
" . DB_PREFIX . "product.shipping,
" . DB_PREFIX . "product.weight,
" . DB_PREFIX . "product.weight_class_id,
" . DB_PREFIX . "product.length,
" . DB_PREFIX . "product.width,
" . DB_PREFIX . "product.height,
" . DB_PREFIX . "product.length_class_id,
" . DB_PREFIX . "product.tax_class_id,
" . DB_PREFIX . "product.quantity as product_quantity,
" . DB_PREFIX . "order.shipping_city,
" . DB_PREFIX . "order.shipping_zone,
" . DB_PREFIX . "order.shipping_code
FROM " . DB_PREFIX . "order_product 
INNER JOIN " . DB_PREFIX . "product ON " . DB_PREFIX . "product.product_id=" . DB_PREFIX . "order_product.product_id
INNER JOIN " . DB_PREFIX . "order ON " . DB_PREFIX . "order.order_id=" . DB_PREFIX . "order_product.order_id WHERE " . DB_PREFIX . "order_product.order_id = " . (int)$orderId);

        return $query->rows;
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

    public function updateDelivery($data)
    {
        $sql = "UPDATE `" . DB_PREFIX . "boxberry_deliveries` SET
            im_id = CONCAT( `im_id`, '" . $this->db->escape($data['im_id'])
            . "' ), label = CONCAT( `label`, '" . $this->db->escape($data['label'])
            . "' ), error = '" . $this->db->escape($data['error'])
            . "' WHERE
            im_id = '" . $this->db->escape($data['track_number']) . "' 
            ";

        $this->db->query($sql);

        return $this->db->getLastId();
    }
}
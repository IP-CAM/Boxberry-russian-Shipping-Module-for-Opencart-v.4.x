<?php

namespace Opencart\Catalog\Model\Extension\Boxberry\Boxberry;

class Expired extends \Opencart\System\Engine\Model
{
    public function getExpired($table)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "boxberry_expired WHERE `table` = '" . $this->db->escape($table) . "'");
        if ($query->num_rows) {
            return $query->row['expired'];
        }

        return null;
    }

    public function addExpired($data)
    {
        $this->db->query("INSERT INTO `" . DB_PREFIX . "boxberry_expired` SET 
        `table` = '" . $this->db->escape($data['table'])
            . "', expired = NOW() + INTERVAL 1 DAY"
            . " ON DUPLICATE KEY UPDATE expired = NOW() + INTERVAL 1 DAY");
        return $this->db->getLastId();
    }
}
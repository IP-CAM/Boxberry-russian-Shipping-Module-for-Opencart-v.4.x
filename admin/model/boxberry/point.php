<?php

class ModelBoxberryPoint extends Model
{
    public function getPoint($code, $prepaid)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "boxberry_points WHERE `code` = '" . $this->db->escape($code) . "' and `prepaid` = " . $prepaid);
        if ($query->num_rows) {
            return $query->row;
        }

        return null;
    }

    public function addPoint($data)
    {
        $sql = "INSERT INTO `" . DB_PREFIX . "boxberry_points` SET 
        code = '" . $this->db->escape($data['code'])
            . "', city_code = '" . $this->db->escape($data['city_code'])
            . "', data = '" . $this->db->escape(json_encode($data['data'], JSON_UNESCAPED_UNICODE))
            . "', expired = NOW() + INTERVAL 1 DAY"
            . ", prepaid = " . $data['prepaid']
            . " ON DUPLICATE KEY UPDATE 
        city_code = '" . $this->db->escape($data['city_code'])
            . "', data = '" . $this->db->escape(json_encode($data['data'], JSON_UNESCAPED_UNICODE))
            . "', expired = NOW() + INTERVAL 1 DAY"
            . ", prepaid = " . $data['prepaid'];

        $this->db->query($sql);

        return $this->db->getLastId();
    }
}
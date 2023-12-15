<?php

namespace Opencart\Catalog\Model\Extension\Boxberry\Boxberry;

class Zip extends \Opencart\System\Engine\Model
{
    public function getZip($zip)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "boxberry_listzips WHERE `zip` = '" . $this->db->escape($zip) . "'");
        if ($query->num_rows) {
            return $query->row;
        }

        return null;
    }

    public function getZips()
    {
        $data = array();
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "boxberry_listzips");
        foreach ($query->rows as $result) {
            $data[$result['zip']] = $result;
        }

        return $data;
    }

    public function addZip($data)
    {
        $this->db->query("INSERT INTO `" . DB_PREFIX . "boxberry_listzips` SET 
        zip = '" . $this->db->escape($data['zip'])
            . "', city = '" . $this->db->escape($data['city'])
            . "', area = '" . $this->db->escape($data['area'])
            . "' ON DUPLICATE KEY UPDATE 
            city = '" . $this->db->escape($data['city'])
            . "', area = '" . $this->db->escape($data['area'])
            . "'");

        return $this->db->getLastId();
    }
    public function getZipByCity($city, $region)
    {
        $region = $region ? str_replace(' область', '', $region) : '';
        $sql = "SELECT * FROM " . DB_PREFIX . "boxberry_listzips WHERE city='" . $this->db->escape($city) . "'";

        if ($region) {
            $sql .= " AND area='" . $region . "'";
        }
        $query = $this->db->query($sql);

        if ($query->num_rows) {
            return $query->row;
        }

        if ($region) {
            $sql = "SELECT * FROM " . DB_PREFIX . "boxberry_listzips WHERE city='" . $this->db->escape($city) . "'";
            $query = $this->db->query($sql);
            if ($query->num_rows) {
                return $query->row;
            }
        }

        return null;
    }
}
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sensor_model extends CI_Model
{

    public function get_sensor_data()
    {
        // Query untuk mendapatkan data dari tabel yang berisi data sensor
        $query = $this->db->get('tb_cuaca');
        return $query->result_array();
    }
    public function get_filtered_sensor_data()
    {
        $query = $this->db->query("
            SELECT DATE_FORMAT(ts, '%m-%y') AS bulan, suhu, humid 
            FROM tb_cuaca 
            WHERE suhu = (SELECT MAX(suhu) FROM tb_cuaca) 
            OR humid = (SELECT MAX(humid) FROM tb_cuaca) 
            ORDER BY suhu DESC, humid DESC 
            LIMIT 2
        ");
        return $query->result_array();
    }
    public function get_sensor_summary()
    {
        // Get max, min, and average temperature
        $this->db->select_max('suhu', 'suhumax');
        $this->db->select_min('suhu', 'suhumin');
        $this->db->select_avg('suhu', 'suhurata');
        $result = $this->db->get('tb_cuaca')->row_array();

        $result['suhurata'] = number_format($result['suhurata'], 2);

        // Get records with max temperature and max humidity
        $this->db->select('id as idx, suhu as suhun, humid, lux as kecerahan, ts as timestamp');
        $this->db->where('suhu', $result['suhumax']);
        $this->db->where('humid', '(SELECT MAX(humid) FROM tb_cuaca)', false);  // Subquery for max humidity
        $this->db->order_by('ts', 'ASC');
        $query = $this->db->get('tb_cuaca');
        $result['nilai_suhu_max_humid_max'] = $query->result_array();

        // Get unique month-year for records with max temperature and max humidity
        $this->db->select("DATE_FORMAT(ts, '%m-%Y') as month_year", false);
        $this->db->distinct();
        $this->db->where('suhu', $result['suhumax']);
        $this->db->where('humid = (SELECT MAX(humid) FROM tb_cuaca)', null, false);
        $query = $this->db->get('tb_cuaca');  // Hapus ORDER BY di sini
        $result['month_year_max'] = $query->result_array();
        $result['month_year_max'] = $query->result_array();

        return $result;
    }

}
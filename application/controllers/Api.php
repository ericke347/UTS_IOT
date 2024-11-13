<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Sensor_model'); // Pastikan model dimuat dengan benar
    }

    // Endpoint untuk menyediakan data dalam format JSON
    public function get_sensor_data()
    {
        // Memastikan $this->Sensor_model dikenali
        if (!isset($this->Sensor_model)) {
            show_error("Model 'Sensor_model' tidak ditemukan atau tidak dimuat dengan benar.");
            return;
        }

        // Mengambil data dari model
        $data = $this->Sensor_model->get_sensor_data();

        // Menghasilkan output JSON
        $this->output // Pastikan output dikenali
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
    public function get_filtered_sensor_data()
    {
        $data = $this->Sensor_model->get_filtered_sensor_data();
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
    public function get_sensor_summary()
    {
        $data = $this->Sensor_model->get_sensor_summary();
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
    public function show_sensor_summary()
{
    $data['data'] = $this->Sensor_model->get_sensor_summary();
    $this->load->view('sensorsumarryview', $data);
}

}

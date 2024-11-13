<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sensor extends CI_Controller
{

    public function raw_view()
    {
        $this->load->view('raw_view');
    }

    public function parsed_view()
    {
        $this->load->view('parsed_view');
    }
}

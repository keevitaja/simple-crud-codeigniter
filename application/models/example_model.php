<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Example model for Simple CRUD
 *
 * by Tanel Tammik - keevitaja@gmail.com
 *
 * PHP 5.3 required
 *
 */

class Example_model extends Simple_crud {
  public function get_all() {
    return $this->db->from('example')->get()->result();
  }
}

/* End of file example_model.php */
/* Location: ./application/models/example_model.php */
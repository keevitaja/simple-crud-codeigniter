<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Simple database CRUD for Codeigniter
 *
 * by Tanel Tammik - keevitaja@gmail.com
 *
 * PHP 5.3 required
 *
 * Simple CRUD is very simple (it really cannot be more simpler) "database abstraction
 * layer" for CodeIgniter, which gives you some additional benefits.
 *
 * ### Setup
 *
 * To create a new model extend it from Simple_crud instead of CI_Model.
 * Both Simple_crud and your model must be loaded in CI way.
 *
 * Name your models <Table_name>_model. If you do not like "_model" in all
 * model names, just remove preg_replace from __construct() method. If table
 * name is example, then model would look
 *
 * class Example_model extends Simple_crud {}
 * 
 * ### Usage examples
 *
 * Table: example
 * Fields: id, cats, dogs
 * Model: Example_model
 *
 * // Insert a row:
 * $pets = new Example_model;
 * $pets->cats = 'Jerry';
 * $pets->dogs = 'Spike';
 * $pets->create(); // on success returns insert_id()
 *
 * // Fetch a row:
 * $pets = Example_model::get($id); // where $id is the primary key
 * // or
 * $pets = Example_model::get(array('dogs' => 'Spike'));
 *
 * // Update a row:
 * $pets = Example_model::get($id);
 * $pets->dogs = 'Harry';
 * $pets->update();
 *
 * // Delete a row:
 * $pets = Example_model::get($id);
 * $pets->delete();
 * // or
 * $this->example_model->delete($id); // where $id id the primary key
 *
 * // All together: create, update and delete. lol
 *
 * $pets = new Example_model;
 * $pets->cats = 'cat';
 * $pets->dogs = 'dog';
 * $pets = Example_model::get($pets->create()); // new row created and fetched. wtf
 * $pets->cats = 'jerry';
 * $pets->update(); // row updated
 * $pets->delete(); // row deleted
 *
 * // In just 7 lines we created new row, updated and deleted it!
 *
 * In Example_model you can add your own custom methods as it was the
 * regular CodeIgniter model.
 *
 */

class Simple_crud {
  protected static $mdb;
  protected static $table;
  protected static $class;
  protected $db;
  
  function __construct() {
    self::$mdb = &get_instance()->db;
    self::$class = get_called_class();
    self::$table = strtolower(preg_replace('/_model$/', '', self::$class));
    
    $this->db =& self::$mdb;
  }
  
  private function init($row) {
    $object = new self::$class;
    
    foreach($row as $field => $value) {
      $object->$field = $value;
    }
    
    return $object;
  }
  
  private function attributes() {
    $attributes = array();
    
    foreach($this->db->list_fields(self::$table) as $field) {
      if(property_exists($this, $field)) {
        $attributes[$field] = $this->$field;
      }
    }
    
    return $attributes;
  }
  
  public static function get($search) {
    $search = (is_array($search)) ? $search : array('id' => $search);
    
    return self::init(self::$mdb->get_where(self::$table, $search)->row_array());
  }
  
  public function update() {
    if(!isset($this->id)) {
      return FALSE;
    }
    
    return $this->db->where('id', $this->id)->update(self::$table, $this->attributes());
  }
  
  public function create() {
    $attributes = $this->attributes();
    
    if(empty($attributes)) {
      return FALSE;
    }
    
    $result = $this->db->insert(self::$table, $attributes);
    
    return (!$result) ? $result : $this->db->insert_id();
  }
  
  public function delete($id = FALSE) {
    if(!isset($this->id) AND $id === FALSE) {
      return FALSE;
    }
    
    $id = ($id === FALSE) ? $this->id : $id;
    
    return $this->db->delete(self::$table, array('id' => $id));
  }
}

/* End of file simple_crud.php */
/* Location: ./application/models/simple_crud.php */
<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

class Model extends CI_Model {
    //get all from table
    public function getAll($table){
        $this->db->from($table);
        return $this->db->get();
    }
    /// get data with where condition
    public function getByCondi($table, $condi){
        $this->db->from($table);
        $this->db->where($condi);
        return $this->db->get();
    }
    
    public function getCondiASC($table, $condi, $short_col) {
        $this->db->from($table);
        $this->db->where($condi);
        $this->db->order_by($short_col , 'ASC');
        return $this->db->get();
    }
    
    public function getCondiDESC($table, $condi, $short_col) {
        $this->db->from($table);
        $this->db->where($condi);
        $this->db->order_by($short_col , 'DESC');
        return $this->db->get();
    }
    
}
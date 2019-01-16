<?php

//defined('BASEPATH') OR exit('No direct script access allowed');

class M_page extends CI_Model {

    public function getMenuModel($cat_id) {
        $this->db->select('model_id, model_name, model_year, icon_menu , url_slug , displacement, is_available');
        $this->db->from('model');
        $this->db->where('category_id', $cat_id);
        $this->db->where('status', 1);
        $this->db->order_by('m_order');
        return $this->db->get();
    }

    public function getAllModel() {
        $this->db->select('model_id, model_name, model_year, thumbnail, model_logo , url_slug , displacement');
        $this->db->from('model');
        $this->db->where('status', 1);
        $this->db->order_by('m_order');
        return $this->db->get();
    }

    public function getAllModel_feature() {
        $this->db->select('model_id, model_name, model_year, thumbnail, model_logo , url_slug , displacement');
        $this->db->from('model');
        $this->db->where('status', 1);
        $this->db->where('is_feature', 1);
        $this->db->order_by('m_order');
        return $this->db->get();
    }

    public function getCategoryModel() {
        $this->db->from('model_category');
        $this->db->where('status', 1);
        $this->db->order_by('c_order', 'ASC');
        return $this->db->get();
    }

    public function getAllPromotion() {
        $this->db->from('promotion');
        $this->db->where('status', 1);
        $this->db->order_by('');
        return $this->db->get();
    }

    public function getSlideHomePage() {
        $this->db->from('home_slide');
        $this->db->where('status', 1);
        $this->db->order_by('s_order');
        return $this->db->get();
    }

    /// get all accessory and part
    public function getAllAccessory() {
        $this->db->from('accessory');
        $this->db->where('status', 1);
        $this->db->order_by('acs_id', 'DESC');
        return $this->db->get();
    }

    function get_count_accessory_part() {
        $this->db->from('accessory');
        $this->db->where('status', 1);
        $this->db->order_by('acs_id', 'DESC');
        return $this->db->count_all_results();
    }

    function get_all_accessory_part($limit, $start) {

        $this->db->from('accessory');
        $this->db->where('status', 1);
        $this->db->order_by('acs_id', 'DESC');
        $this->db->limit($limit, $start);
        return $this->db->get();
    }

    function updatecard($mount,$id){
        $data = $this->db->set('item_amount',$mount)
             ->where('id',$id)
            ->update('add_to_cart');
        return $data;
    }

    function accessoryupdatecheckout($id){
        $data = $this->db->set('status',1)
                ->where('user_id',$id)
                ->update('add_to_cart');
    }

    function clearcard($id){
        $this->db->where('id', $id);
        $this->db->delete('add_to_cart');
    }

    // By Captain Rith


    /// pagination accessories
    function get_count_accessory() {

        $this->db->from('accessory');
        $this->db->where('status', 1);
        $this->db->where('type', 1);
        $this->db->order_by('acs_id', 'DESC');
        return $this->db->count_all_results();
    }

    function get_all_part($limit, $start) {

        $this->db->from('accessory');
        $this->db->where('status', 1);
        $this->db->where('type', 2);
        $this->db->order_by('acs_id', 'DESC');
        $this->db->limit($limit, $start);
        return $this->db->get();
    }

    function get_all_merchan($limit, $start) {

        $this->db->from('accessory');
        $this->db->where('status', 1);
        $this->db->where('type', 3);
        $this->db->order_by('acs_id', 'DESC');
        $this->db->limit($limit, $start);
        return $this->db->get();
    }

    function get_count_merchan() {

        $this->db->from('accessory');
        $this->db->where('status', 1);
        $this->db->where('type', 3);
        $this->db->order_by('acs_id', 'DESC');
        return $this->db->count_all_results();
    }

    function get_count_part() {

        $this->db->from('accessory');
        $this->db->where('status', 1);
        $this->db->where('type', 2);
        $this->db->order_by('acs_id', 'DESC');
        return $this->db->count_all_results();
    }

    function get_all_accessory($limit, $start) {

        $this->db->from('accessory');
        $this->db->where('status', 1);
        $this->db->where('type', 1);
        $this->db->order_by('acs_id', 'DESC');
        $this->db->limit($limit, $start);
        return $this->db->get();
    }

    function get_accessory_by($id){
        $this->db->from('accessory');
        $this->db->where('status', 1);
        $this->db->order_by('acs_id', 'DESC');
        $this->db->where('acs_id',$id);
        return $this->db->get();
    }

    public function getuser(){
        $this->db->from('users');

    }

    public function getAccessory() {
        $this->db->from('accessory');
        $this->db->where('status', 1);
        $this->db->where('type', 1);
        $this->db->order_by('acs_id', 'DESC');
        return $this->db->get();
    }

    public function getPart() {
        $this->db->from('accessory');
        $this->db->where('status', 1);
        $this->db->where('type', 2);
        $this->db->order_by('acs_id', 'DESC');
        return $this->db->get();
    }

    public function getPartByModel($model_id) {
        $this->db->from('accessory');
        $this->db->where('status', 1);
        $this->db->where('type', 2);
        $this->db->where('model_id', $model_id);
        $this->db->order_by('acs_id', 'DESC');
        return $this->db->get();
    }

    public function getAboutGallery() {
        $this->db->from('about_gallery');
        $this->db->where('status', 1);
        $this->db->order_by('img_order', 'ASC');
        return $this->db->get();
    }

    function get_count_news() {
        //// get  count news
        $this->db->from('news');
        $this->db->where('status', 1);
        $this->db->order_by('news_id', 'DESC');
        return $this->db->count_all_results();
    }

    function get_all_news($limit, $start) {
        //// get all news
        $this->db->from('news');
        $this->db->where('status', 1);
        $this->db->order_by('news_id', 'DESC');
        $this->db->limit($limit, $start);
        return $this->db->get();
    }

    function getNewsById($id) {
        $this->db->from('news');
        $this->db->where('status', 1);
        $this->db->where('news_id', $id);
        return $this->db->get();
    }

    function getNewsByURL_Slug($url_slug) {
        $this->db->from('news');
        $this->db->where('status', 1);
        $this->db->where('url_slug', $url_slug);
        return $this->db->get();
    }

    //// get news id | return ID
    public function get_news_id_by_slug($slug) {
        $this->db->where('status', 1);
        $this->db->where('url_slug', $slug);
        $query = $this->db->get('news');
        $row = $query->row_array();
        if (isset($row)) {
            return $row['news_id'];
        } else {
            return 0;
        }
    }

    function getNewsGallery($id) {
        $this->db->from('news_gallery');
        $this->db->where('g_status', 1);
        $this->db->where('news_id', $id);
        $this->db->order_by('g_order', 'ASC');
        return $this->db->get();
    }

    function getModelByID($id) {
        $this->db->from('model');
        $this->db->where('status', 1);
        $this->db->where('model_id', $id);
        return $this->db->get();
    }

    function getModelBySlug($slug) {
        $this->db->from('model');
        $this->db->where('status', 1);
        $this->db->where('url_slug', $slug);
        return $this->db->get();
    }

    //// return model id ( by url slug )
    public function get_model_id_by_slug($slug) {
        $this->db->where('status', 1);
        $this->db->where('url_slug', $slug);
        $query = $this->db->get('model');
        $row = $query->row_array();
        if (isset($row)) {
            return $row['model_id'];
        } else {
            return 0;
        }
    }

    function getFeature($mid) {
        $this->db->from('feature');
        $this->db->where('model_id', $mid);
        $this->db->order_by('f_order', 'ASC');
        return $this->db->get();
    }

    function getModelColor($mid) {
        $this->db->from('model_color');
        $this->db->where('model_id', $mid);
        $this->db->where('m_status', 1);
        $this->db->order_by('m_order', 'ASC');
        return $this->db->get();
    }

    function getSpec($mid) {
        $this->db->from('specification');
        $this->db->where('model_id', $mid);
        $this->db->where('status', 1);
        $this->db->order_by('s_order', 'ASC');
        return $this->db->get();
    }

    function getGallery($mid) {
        $this->db->from('model_gallery');
        $this->db->where('model_id', $mid);
        $this->db->where('status', 1);
        $this->db->order_by('img_order', 'ASC');
        return $this->db->get();
    }

    function add_form_request($data) {
        $this->db->insert('form_request', $data);
    }

    function insert_user($data){
       $result =  $this->db->insert('users', $data);
       return $result;
    }

    function user_exists($email){
        $this->db->select('*'); 
        $this->db->from('users');
        $this->db->where('email', $email);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    function town(){
        $this->db->from('town');
        return $this->db->get();
    }

    function postcode($town){
        $this->db->from('town');
        $this->db->where('state_name',$town);
        return $this->db->get()->result_array();
    }

    function userlogin(){
        $email = $this->security->xss_clean($this->input->post('email'));
        $password = $this->security->xss_clean($this->input->post('password'));

        // Prep the query
        $this->db->where('email', $email);
        $this->db->where('password', md5($password));

        // Run the query
        $query = $this->db->get('users');
        // Let's check if there are any results
        if($query->num_rows() == 1){
            // If there is a user, then create session data
            $row    = $query->row();
            $data   = array(
                    'userid'        => $row->id,
                    'first_name'    => $row->first_name,
                    'first_name'    => $row->last_name,
                    'email'         => $row->email,
                    'phone_number'  => $row->phone_number,
                    'address'       => $row->address,
                    'country'       => $row->country,
                    'post_code'     => $row->post_code,
                    'town'          => $row->town,
            );
            $session_data['user_data'] = $data;
            $session_data['logged_in'] = TRUE;
            $this->session->set_userdata($session_data);

            return true;
        }

         return false;
    }
    function getUserid($email){
        $this->db->select('*'); 
        $this->db->from('users');
        $this->db->where('email', $email);
        $query = $this->db->get();
        $result = $query->row();
        return $result->id;
    }

    function add_to_cart($data){
        $this->db->insert('add_to_cart', $data);
    }

    function add_contact($data) {
        $this->db->insert('contact', $data);
    }

    function getAllCareer() {
        $this->db->from('career');
        $this->db->where('status', 1);
        $this->db->order_by('cid', 'DESC');
        return $this->db->get();
    }

    function careerDetail($cid) {
        $this->db->from('career');
        $this->db->where('status', 1);
        $this->db->where('cid', $cid);
        return $this->db->get();
    }

    function get_cart_list($uid) {
        $this->db->from('add_to_cart');
        $this->db->where('user_id', $uid);
        $this->db->where('status',0);
        return $this->db->get();
    }

    //// get all special offer home page
    function getAllSpecialOffer() {
        $this->db->from('special_offer');
        $this->db->where('is_active', 1);
        $this->db->order_by('id', 'DESC');
        return $this->db->get();
    }

    function getSpecialOfferById($id) {
        $this->db->from('special_offer');
        $this->db->where('is_active', 1);
        $this->db->where('id', $id);
        $this->db->order_by('id', 'DESC');
        return $this->db->get();
    }

    function getSpecialOfferBySlug($slug) {
        $this->db->from('special_offer');
        $this->db->where('is_active', 1);
        $this->db->where('url_slug', $slug);
        $this->db->order_by('id', 'DESC');
        return $this->db->get();
    }

    function getAllSpecialOfferByID($id) {
        $this->db->from('special_offer');
        $this->db->where('is_active', 1);
        $this->db->where('id', $id);
        $this->db->order_by('id', 'DESC');
        return $this->db->get();
    }

    /// get all social community on home page
    function getAllSocialCommunities() {
        $this->db->from('social_community');
        $this->db->where('is_active', 1);
        $this->db->order_by('id', 'DESC');
        return $this->db->get();
    }

    function getAllBank() {
        $this->db->from('bank_loan');
        $this->db->order_by('b_order', 'ASC');
        return $this->db->get();
    }

    function getBankByID($id) {
        $this->db->from('bank_loan');
        $this->db->where('id', $id);
        $this->db->order_by('b_order', 'ASC');
        return $this->db->get();
    }

    function add_loan($data) {
        $this->db->insert('loan', $data);
    }

    function getAllDealer() {
        $this->db->from('dealer');
        $this->db->where('status', 1);
        $this->db->order_by('name', 'ASC');
        return $this->db->get();
    }

    /* get part by model */

    function get_part_by_model($id) {

        $this->db->from('accessory');
        $this->db->where('status', 1);
        $this->db->where('model_id', $id);
        $this->db->order_by('acs_id', 'DESC');
        $this->db->limit(4);
        return $this->db->get();
    }

    /* get info from static page */
    function get_static_page_byid($id) {
        $this->db->from('static_page');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $row = $query->row();
        return $row;
    }
}

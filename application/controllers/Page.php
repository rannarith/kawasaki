<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->model('m_page');
        $menu_data = $this->m_page->getCategoryModel();
        $global_data = array('menu_category' => $menu_data);
        $this->load->vars($global_data);
        require_once APPPATH.'third_party/src/Google_Client.php';
        require_once APPPATH.'third_party/src/contrib/Google_Oauth2Service.php';

    }
 
    public function index() {
        $data['homeslide'] = $this->m_page->getSlideHomePage();
        $data['model_home'] = $this->m_page->getAllModel_feature();
        $data['special_offers'] = $this->m_page->getAllSpecialOffer();
        $data['social_communities'] = $this->m_page->getAllSocialCommunities();
        $data['dealers'] = $this->m_page->getAllDealer();
        $data['title'] = "Kawasaki Motors Cambodia";
        $this->load->view('template/index', $data);
    }
    
    public function all_model() {
        $data['all_categories'] = $this->m_page->getCategoryModel();
        $data['top_title'] = 'All Models | Kawasaki Motors Cambodia';
        $data['about_gallery'] = $this->m_page->getAboutGallery();
        $this->load->view('template/index', $data);
    }
    
    public function dealer() {
        $data['all_categories'] = $this->m_page->getCategoryModel();
        $data['top_title'] = 'All Models | Kawasaki Motors Cambodia';
		$data['dealers'] = $this->m_page->getAllDealer();
        $data['about_gallery'] = $this->m_page->getAboutGallery();
        $this->load->view('template/index', $data);
    }

    public function error_page() {

        $data['title'] = "Kawasaki Motors Cambodia";
        $this->load->view('template/error_page', $data);
    }

    /// all accessory and part
    public function allaccessory_part() {

        $config = array();
        $config["base_url"] = base_url() . "page/allaccessory_part/";
        $config["total_rows"] = $this->m_page->get_count_accessory_part();
        $config["per_page"] = 12;
        $config['full_tag_open'] = "<nav><ul class='pagination pagination-sm'>";
        $config['full_tag_close'] = "</ul></nav>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tagl_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        $config['first_link'] = 'First';
        $config ['prev_link'] = 'Previous';
        $config ['next_link'] = 'Next';
        $config["uri_segment"] = 3;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["accessory"] = $this->m_page->get_all_accessory_part($config["per_page"], $page);
        $data["links_accessory"] = $this->pagination->create_links();

        $data['top_title'] = 'Accessory and Part | Kawasaki Motors Cambodia';
        $this->load->view('template/index', $data);
    }

    public function accessory() {
        $config = array();
        $config["base_url"] = base_url() . "page/accessory/";
        $config["total_rows"] = $this->m_page->get_count_accessory();
        $config["per_page"] = 12;
        $config['full_tag_open'] = "<nav><ul class='pagination pagination-sm'>";
        $config['full_tag_close'] = "</ul></nav>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tagl_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        $config['first_link'] = 'First';
        $config ['prev_link'] = 'Previous';
        $config ['next_link'] = 'Next';
        $config["uri_segment"] = 3;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["accessory"] = $this->m_page->get_all_accessory($config["per_page"], $page);
        $data["links_accessory"] = $this->pagination->create_links();

        $data['top_title'] = 'Accessory | Kawasaki Motors Cambodia';
        $this->load->view('template/index', $data);
    }

    public function part() {
        $config = array();
        $config["base_url"] = base_url() . "page/part/";
        $config["total_rows"] = $this->m_page->get_count_part();
        $config["per_page"] = 12;
        $config['full_tag_open'] = "<nav><ul class='pagination pagination-sm'>";
        $config['full_tag_close'] = "</ul></nav>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tagl_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        $config['first_link'] = 'First';
        $config ['prev_link'] = 'Previous';
        $config ['next_link'] = 'Next';
        $config["uri_segment"] = 3;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["accessory"] = $this->m_page->get_all_part($config["per_page"], $page);
        $data["links_accessory"] = $this->pagination->create_links();
        $this->load->view('template/index', $data);

        $data['top_title'] = 'Part | Kawasaki Motors Cambodia';
        $this->load->view('template/index', $data);
    }

    public function accessory_detail($id){
        $userId = $this->session->userdata['user_data']['userid'];
        $data['accessory'] = $this->m_page->get_accessory_by($id);
        $data['user_wishlist'] = $this->m_page->get_user_wishlist($userId, $id, array('object' => true));
        
        $this->load->view('template/index', $data);
    }

    public function addtocard($id){
        if (isset($this->session->userdata['logged_in'])) {   
            $data = $this->m_page->get_accessory_by($id);
            $row = $data->row(0);
            $now = new DateTime();
            $now->setTimezone(new DateTimezone('Asia/Bangkok'));
            $date  = $now->format('Y-m-d H:i:s');
            $getuserid = $this->m_page->getUserid($this->session->userdata['user_data']['email']);
            $dataarray = [
                'item_id'       => $row->acs_id,
                'user_id'       => $getuserid,
                'created_at'    => $date,
                'item_price'    => $this->input->post('price'),
                'item_size'     => $this->input->post('size'),
                'item_amount'   => $this->input->post('quantity'),
                'item_code'     => $this->input->post('item_code'),
            ];

            $this->m_page->add_to_cart($dataarray);

            $session_data['count'] = $this->m_page->get_cart_list($getuserid)->num_rows();
            $this->session->set_userdata($session_data);
            redirect(site_url());
        }else{
            $data = "";
            $this->load->view('template/index',$data);
        }

        
    }
    
    public function register(){
        $data['towns'] = $this->m_page->town();
        $this->load->view('template/index',$data);
    }

    public function getpostcode(){
        $town = $_GET['town'];
        $postscodes = $this->m_page->postcode($town);
        echo $postscodes[0]['post_code'];
    }

    public function insertuser(){
        $dataarray = [
            'first_name'    => $this->input->post('fname'),
            'last_name'     => $this->input->post('lname'),
            'email'         => $this->input->post('email'),
            'phone_number'  => $this->input->post('phone'),
            'address'       => $this->input->post('address'),
            'country'       => $this->input->post('country'),
            'post_code'     => $this->input->post('post'),
            'town'          => $this->input->post('town'),
            'password'      => md5($this->input->post('password')),
            'status'        => 0,
        ];
        $checkuserexist = $this->m_page->user_exists($this->input->post('email'));
        $count = count($checkuserexist);
        if(empty($count)){
            $result = $this->m_page->insert_user($dataarray);
            $url  = site_url();
            $session_data['logged_in'] = TRUE;
            $session_data['user_data'] = $dataarray;
            $this->session->set_userdata($session_data);
            redirect($url);
        }else{
            $session_data['checkuser'] = TRUE;
            $this->session->set_userdata($session_data);
            redirect(site_url('page/register'));
        }
    }

    public function logout(){
        $this->session->sess_destroy();
        redirect(site_url());
    }

    public function cart_view(){
        $getuserid           = $this->m_page->getUserid($this->session->userdata['user_data']['email']);
        $data['list']        = $this->m_page->get_cart_list($getuserid);
        $data['accessories'] = $this->m_page->getAllAccessory();
        if(count($data)> 0 ){
            $this->load->view('template/index', $data);
        }else{
            $data['list']= "Not found !";
            $this->load->view('template/index', $data);
        }
        
    }



    // Wihs List view
    public function user_wishlist(){
        $user = $this->session->userdata['user_data'];

        if (!$user) return array('code' => 403, 'msg' => 'Unauthorized');
        
        $clientData = array(
            'user_id' => $user['userid'],
            'asc_id' => $this->input->post('acc_id'),
            'status' => ($this->input->post('status') === 'true'),
            'created_at' => (new DateTime())->format('Y-m-d H:i:s')
        );

        //Check if user already add to wishlist
        if ($this->isUserInWishlist($clientData['user_id'], $clientData['asc_id']) > 0) {
            // Update user wishlist status
            $clientData['updated_at'] = (new DateTime())->format('Y-m-d H:i:s');
            $this->m_page->update_user_wishlist($clientData);
        } else {
            // create user wishlist
            $this->m_page->user_wishlist($clientData);
        }

        return array('code' => 200, 'msg' => 'success');
    }
    //

    private function isUserInWishlist($userId, $ascId) {
        // find user in wishlist
        return $this->m_page->get_user_wishlist($userId, $ascId);
    }

    public function cardupdate(){
        $amount = $_GET['amount'];
        $id     = $_GET['id'];
        $data   = $this->m_page->updatecard($amount,$id);
        if($data > 0){
            echo "success";
        }else{
            echo "false";
        }
    }

    public function clearcard(){
        $id     = $_GET['id'];
        $data   = $this->m_page->clearcard($id);
        $getuserid = $this->m_page->getUserid($this->session->userdata['user_data']['email']);
        $session_data['count'] = $this->m_page->get_cart_list($getuserid)->num_rows();
        $this->session->set_userdata($session_data);
        if($data == ""){
            echo "success";
        }else{
            echo "false";
        }
    }

    public function checkout(){
        $getuserid = $this->m_page->getUserid($this->session->userdata['user_data']['email']);
        $data['list']= $this->m_page->get_cart_list($getuserid);
        $data['grandtotal'] = $this->input->post('grantotal');
        $data['userdatas'] = $this->m_page->user_exists($this->session->userdata['user_data']['email']);

        $this->load->view('template/index', $data);
    }

    public function checkoutprocess() {
        $getuserid           = $this->m_page->getUserid($this->session->userdata['user_data']['email']);
        $data['list']        = $this->m_page->get_cart_list($getuserid);
        $data['userdatas']   = $this->m_page->user_exists($this->session->userdata['user_data']['email']);
        $data['accessories'] = $this->m_page->getAllAccessory();
        $data['updateacc']   = $this->m_page->accessoryupdatecheckout($getuserid);
        $config = Array(
          'protocol' => 'smtp',
          'smtp_host' => 'ssl://smtp.googlemail.com',
          'smtp_port' => 465,
          'smtp_user' => 'sophalmao855@gmail.com', // change it to yours
          'smtp_pass' => '010707262@#', // change it to yours
          'mailtype' => 'html',
          'charset' => 'iso-8859-1',
          'wordwrap' => TRUE
        );

        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('sophalmao855@gmail.com','Kawasaki Online Store No-Reply'); // change it to yours
        $this->email->to($this->session->userdata['user_data']['email']);// change it to yours
        $this->email->subject('Kawasaki Online Store.');
        $message = $this->load->view('template/page/checkoutprocess',$data,TRUE);
        $this->email->message($message);
        $this->email->cc('maosophal9292@gmail.com');
        $this->email->bcc('maosophal9292@gmail.com');
        if($this->email->send()){
            unset($_SESSION["count"]);
            $session_data['processing'] = TRUE;
            $this->session->set_userdata($session_data);
            redirect(site_url());
        }else{
            show_error($this->email->print_debugger());
        }
    
        // $this->load->view('template/index', $data);
    }

    public function login(){
        $checkuserexist = $this->m_page->userlogin();
        if($checkuserexist){
            redirect(site_url('page'));
        }else{
             redirect(site_url('page'));
        }
    }

    public function special_offers() {
        /* Facebook share */
        $query = $this->m_page->getSpecialOfferBySlug($this->uri->segment(3));
        if ($query->num_rows() > 0) {
            $sp_row = $query->row();
            $data['social_url'] = base_url() . 'page/special_offers/' . $this->uri->segment(3);
            $data['socail_title'] = $sp_row->title_small . ' ' . $sp_row->title . ' | Kawasaki Motors Cambodia';
            $data['social_description'] = strip_tags(substr($sp_row->description, 0, 300));
            $data['social_image'] = base_url() . 'assets/images/special_offer/' . $sp_row->thumbnail;

            /* header title */
            $data['top_title'] = $sp_row->title_small . ' ' . $sp_row->title . ' | Kawasaki Motors Cambodia';
        }
        /* ../ Facebook share */

        $urlslug = $this->uri->segment(3);
        $data['special_offer_detail'] = $this->m_page->getSpecialOfferBySlug($urlslug);
        $data['special_offers'] = $this->m_page->getAllSpecialOffer();
        $this->load->view('template/index', $data);
    }

    public function offers_detail() {
        $data['promotion'] = $this->m_page->getAccessory();
        $data['special_offers'] = $this->m_page->getAllSpecialOffer();
        $this->load->view('template/index', $data);
    }

    public function about_us() {
        $data['top_title'] = 'About Us | Kawasaki Motors Cambodia';
        $data['about_kawa_query'] = $this->m_page->get_static_page_byid(1);
        $data['gm_message'] = $this->m_page->get_static_page_byid(2);
        $data['about_gallery'] = $this->m_page->getAboutGallery();
        $this->load->view('template/index', $data);
    }

    public function contact_us() {
        if ($this->input->post("submit_contact")) {
            ////yechkang.ear@kawasaki.com.kh
            /// send email

            $data_contact = array(
                'full_name' => $this->input->post('full_name'),
                'phone' => $this->input->post('phone'),
                'email' => $this->input->post('email'),
                'message' => $this->input->post('message'),
            );

            //// add contact
            $this->m_page->add_contact($data_contact);

            //// send email 
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            $to = "yechkang.ear@kawasaki.com.kh";

            $subject = "Website Contact Us Form Info";
            $txt = 'Dear Kawasaki. <br/><br/> There is a customer who submit their information in website : ';

            $txt .= '<br/> Full Name : ' . $this->input->post('full_name');
            $txt .= '<br/> Phone Number : ' . $this->input->post('phone');
            $txt .= '<br/> Email : ' . $this->input->post('email');
            $txt .= '<br/> Message : ' . $this->input->post('message');


            $txt .= "<br/> <br/> Please check. Thanks ";

            $headers .= "From: no-reply@hgbgroup.com" . "\r\n" .
                    "CC: sopheak.roun@hgbgroup.com, sreyleak.norn@hgbgroup.com";

            mail($to, $subject, $txt, $headers);

            redirect('page/contact_us/?status=success');
        } else {

            $data['top_title'] = 'Contact Us | Kawasaki Motors Cambodia';
            $data['about_gallery'] = $this->m_page->getAboutGallery();
            $this->load->view('template/index', $data);
        }
    }

    public function news_event() {
        $config = array();
        $config["base_url"] = base_url() . "page/news_event/";
        $config["total_rows"] = $this->m_page->get_count_news();
        $config["per_page"] = 6;
        $config['full_tag_open'] = "<nav><ul class='pagination pagination-sm'>";
        $config['full_tag_close'] = "</ul></nav>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tagl_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        $config['first_link'] = 'First';
        $config ['prev_link'] = 'Previous';
        $config ['next_link'] = 'Next';
        $config["uri_segment"] = 3;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["news_info"] = $this->m_page->get_all_news($config["per_page"], $page);
        $data["links_pagination"] = $this->pagination->create_links();

        $data['top_title'] = 'News and Events | Kawasaki Motors Cambodia';
        $data['about_gallery'] = $this->m_page->getAboutGallery();
        $this->load->view('template/index', $data);
    }

    public function news_detail() {

        /* Facebook share */
        $query = $this->m_page->getNewsByURL_Slug($this->uri->segment(3));
        if ($query->num_rows() > 0) {
            $news_row = $query->row();
            $data['social_url'] = base_url() . 'page/news_detail/' . $this->uri->segment(3);
            $data['socail_title'] = $news_row->title . ' | Kawasaki Motors Cambodia';
            $data['social_description'] = strip_tags(substr($news_row->short_des, 0, 300));
            $data['social_image'] = base_url() . 'assets/images/news/' . $news_row->thumbnail;

            /* header title */
            $data['top_title'] = $news_row->title . ' | Kawasaki Motors Cambodia';
        }
        /* ../ Facebook share */

        $news_id = $this->m_page->get_news_id_by_slug($this->uri->segment(3));
        if ($query->num_rows() == 0 && $news_id > 0) {
            redirect('page/news_event');
        }

        $data['news_info'] = $this->m_page->getNewsByURL_Slug($this->uri->segment(3));
        $data['news_gallery'] = $this->m_page->getNewsGallery($news_id);
        $this->load->view('template/index', $data);
    }

    public function model_detail() {
        $data['model_info'] = $this->m_page->getModelByID($this->uri->segment(3));
        $data['feature'] = $this->m_page->getFeature($this->uri->segment(3));
        $data['model_color'] = $this->m_page->getModelColor($this->uri->segment(3));
        $data['spec'] = $this->m_page->getSpec($this->uri->segment(3));
        $data['model_gallery'] = $this->m_page->getGallery($this->uri->segment(3));
        $this->load->view('template/index', $data);
    }

    public function model() {
        $model_id = $this->m_page->get_model_id_by_slug($this->uri->segment(3));
        if ($this->uri->segment(3) == "" || $model_id == 0) {
            redirect('');
        }
        /* Facebook share */
        $query = $this->m_page->getModelBySlug($this->uri->segment(3));
        if ($query->num_rows() > 0) {
            $model_row = $query->row();
            $data['social_url'] = base_url() . 'page/model/' . $this->uri->segment(3);
            $data['socail_title'] = $model_row->model_name . ' | Kawasaki Motors Cambodia';
            $data['social_description'] = strip_tags(substr($model_row->description, 0, 300));
            $data['social_image'] = base_url() . 'assets/images/model_thumbnail/' . $model_row->thumbnail;

            /* header title */
            $data['top_title'] = $model_row->model_name . ' | Kawasaki Motors Cambodia';

            /* seo */
            $data['seo_description'] = $model_row->seo_description;
            $data['seo_keyword'] = $model_row->seo_keyword;
        }
        /* ../ Facebook share */
        $data['accessory'] = $this->m_page->get_part_by_model($model_id);

        $data['model_info'] = $this->m_page->getModelBySlug($this->uri->segment(3));
        $data['feature'] = $this->m_page->getFeature($model_id);
        $data['model_color'] = $this->m_page->getModelColor($model_id);
        $data['spec'] = $this->m_page->getSpec($model_id);
        $data['model_gallery'] = $this->m_page->getGallery($model_id);
        $this->load->view('template/index', $data);
    }

    public function form_request() {

        if ($this->input->post("submit")) {
            $data_form = array(
                'fullname' => $this->input->post('fullname'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'model' => $this->input->post('motormodel'),
                'message' => $this->input->post('message'),
            );

            //// add data to db
            $this->m_page->add_form_request($data_form);


            //// send email 
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            $to = "yechkang.ear@kawasaki.com.kh";

            $subject = "Website Form Info";
            $txt = 'Dear Kawasaki. <br/><br/> There is a customer who submit their information in website : ';

            $txt .= '<br/> Full Name : ' . $this->input->post('fullname');
            $txt .= '<br/> Phone Number : ' . $this->input->post('phone');
            $txt .= '<br/> Model : ' . $this->input->post('motormodel');
            $txt .= '<br/> Email : ' . $this->input->post('email');
            $txt .= '<br/> Message : ' . $this->input->post('message');


            $txt .= "<br/> <br/> Please check. Thanks ";

            $headers .= "From: no-reply@hgbgroup.com" . "\r\n" .
                    "CC: sopheak.roun@kawasaki.com.kh, sopheak.roun@hgbgroup.com, sreyleak.norn@hgbgroup.com";

            mail($to, $subject, $txt, $headers);


            redirect('page/form_request/?status=success');
        } else {
            $data['allmodel'] = $this->m_page->getAllModel();

            $this->load->view('template/index', $data);
        }
    }

    public function career() {
        $data['career'] = $this->m_page->getAllCareer();
        if ($this->uri->segment(3) != "") {
            $cid = $this->uri->segment(3);
        } else {
            $cid = 0;
        }

        $data['top_title'] = 'Careers | Kawasaki Motors Cambodia';
        $data['career_detail'] = $this->m_page->careerDetail($cid);
        $this->load->view('template/index', $data);
    }

    /// apply loan 
    public function applyloan() {
        if ($this->uri->segment(3) == "" || $this->uri->segment(3) == 0) {
            redirect('page/applyloan/1');
        }
        $data['all_model'] = $this->m_page->getAllModel();
        $data['banks'] = $this->m_page->getAllBank();
        $data['bank_details'] = $this->m_page->getBankByID($this->uri->segment(3));
        $this->load->view('template/index', $data);
    }

    public function submitloan() {
        if ($this->input->post('submit')) {
            $data_form = array(
                'bank_id' => $this->input->post('bank_id'),
                'model_id' => $this->input->post('model_id'),
                'model_year' => $this->input->post('model_year'),
                'full_price' => $this->input->post('full_price'),
                'down_payment' => $this->input->post('downpayment'),
                'loan_term' => $this->input->post('loan_term'),
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'other' => $this->input->post('other'),
            );

            //// add data to db
            $this->m_page->add_loan($data_form);


            //// send email 
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            $to = "yechkang.ear@kawasaki.com.kh";

            $subject = "Website Form Info";
            $txt = 'Dear Kawasaki. <br/><br/> There is a customer who submit loan form in website : ';

            $txt .= '<br/> Bank : ' . $this->input->post('bank_name');
            $txt .= '<br/> Down Payment : %' . $this->input->post('downpayment');
            $txt .= '<br/> Model : ' . $this->input->post('model_name');
            $txt .= '<br/> Loan Term : ' . $this->input->post('loan_term');
            $txt .= '<br/> Model Year: ' . $this->input->post('model_year');
            $txt .= '<br/> Full Name : ' . $this->input->post('name');
            $txt .= '<br/> Phone Number : ' . $this->input->post('phone');
            $txt .= '<br/> Email : ' . $this->input->post('email');
            $txt .= '<br/> Message : ' . $this->input->post('message');


            $txt .= "<br/> <br/> Please check. Thanks ";

            $headers .= "From: no-reply@hgbgroup.com" . "\r\n" .
                    "CC: sopheak.roun@kawasaki.com.kh, sopheak.roun@hgbgroup.com, sreyleak.norn@hgbgroup.com";

            mail($to, $subject, $txt, $headers);


            $this->session->set_flashdata('success_message', ' <h3>Thank you for filling out your information!</h3> We will be in touch with you shortly.');
        } else {
            $this->session->set_flashdata('error_message', 'Fail! Please check and try again!');
        }

        redirect('page/applyloan/1');
    }

    /* show model detail on loan form */

    public function showmodeldetail() {
        $model = $this->m_page->getModelByID($this->uri->segment(3));
        if ($model->num_rows() > 0) {
            $row = $model->row();

            echo '<label for="modelyear" class="col-md-3 control-label">Model Year</label>
                        <div class="col-md-5">
                            <label class=" control-label">' . $row->model_year . ' </label>
                                <img src="' . base_url() . 'assets/images/model_thumbnail/' . $row->thumbnail . '" class="img-responsive"/>
                        </div>';
            echo '<input type="hidden" name="full_price" id="full_price" value="' . $row->price . '"/>';
            echo '<input type="hidden" name="model_year" value="' . $row->model_year . '"/>';
            echo '<input type="hidden" name="model_name" value="' . $row->model_name . '"/>';
        }
    }

    public function facebooklogin(){
        $fb = new \Facebook\Facebook([
          'app_id' => '351296501907332',
          'app_secret' => 'b0ef3d847086f70689ed6bbd9fe46d16',
          'default_graph_version' => 'v2.10',
        ]);
        
        $helper = $fb->getRedirectLoginHelper();
        if(isset($_GET['state'])){
          $_SESSION['FBRLH_state']=$_GET['state'];  
        }
        
        if (!isset($_SESSION['facebook_access_token'])) {
          $_SESSION['facebook_access_token'] = null;
        }

        if (!$_SESSION['facebook_access_token']) {
          $helper = $fb->getRedirectLoginHelper();
          try {
            $_SESSION['facebook_access_token'] = (string) $helper->getAccessToken();
          } catch(FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
          } catch(FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
          }
        }
        if ($_SESSION['facebook_access_token']) {
          echo "You are logged in!";
        } else {
          $permissions = ['ads_management'];
          $loginUrl = $helper->getLoginUrl('http://localhost/project/kawasaki/kawasaki/page/facebooklogin/', $permissions);
          echo '<a href="' . $loginUrl . '">Log in with Facebook</a>';
        }
    }

    public function googlelogin(){
            $clientId = '440706838359-vkurcg6hahc3lmdcilffil5h19hutudf.apps.googleusercontent.com'; //Google client ID
            $clientSecret = '1ZxOmpEHUXrRNqpfo-rFU2KN'; //Google client secret
            $redirectURL = base_url() . 'page/googlelogin';

            //Call Google API
            $gClient = new Google_Client();
            $gClient->setApplicationName('Login');
            $gClient->setClientId($clientId);
            $gClient->setClientSecret($clientSecret);
            $gClient->setRedirectUri($redirectURL);
            $google_oauthV2 = new Google_Oauth2Service($gClient);
            if(isset($_GET['code']))
            {
                $gClient->authenticate($_GET['code']);
                $_SESSION['token'] = $gClient->getAccessToken();
                header('Location: ' . filter_var($redirectURL, FILTER_SANITIZE_URL));
            }

            if (isset($_SESSION['token'])) 
            {
                $gClient->setAccessToken($_SESSION['token']);
            }

            if ($gClient->getAccessToken()) {
                $userProfile = $google_oauthV2->userinfo->get();
                echo "<pre>";
                print_r($userProfile);
                die;
            } 
            else 
            {
                $url = $gClient->createAuthUrl();
                header("Location: $url");
                exit;
            }
    }

    public function merchandise(){
        $config = array();
        $config["base_url"] = base_url() . "page/part/";
        $config["total_rows"] = $this->m_page->get_count_merchan();
        $config["per_page"] = 12;
        $config['full_tag_open'] = "<nav><ul class='pagination pagination-sm'>";
        $config['full_tag_close'] = "</ul></nav>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tagl_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        $config['first_link'] = 'First';
        $config ['prev_link'] = 'Previous';
        $config ['next_link'] = 'Next';
        $config["uri_segment"] = 3;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["accessory"] = $this->m_page->get_all_merchan($config["per_page"], $page);
        $data["links_accessory"] = $this->pagination->create_links();
        $this->load->view('template/index', $data);

        $data['top_title'] = 'Merchandise | Kawasaki Motors Cambodia';
        $this->load->view('template/index', $data);        
    }

}

<?php defined('BASEPATH') OR exit('direct access not allowed');
class Requests extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        if(!$this->session->userdata()){
            $this->session->set_userdata(array('total_rows_next'=>10));
            $this->session->set_userdata(array('count_results'=>0));
        }
        $this->load->model('request');
    }

    /* fetch initialize landing page and reset session */
    public function index()
    {
        $this->session->sess_destroy();
        $this->load->view('landingPage');
    }

    /* fetch all request */
    public function fetch_all(){
        $requests = $this->request->fetch_all();
        $this->session->set_userdata('count_results',count($requests));
        $this->load->view('partials/items',array('requests' => $requests,'total_row_now' => 5));
    }

    /* show more plus 5 rows*/
    public function show_more($number_rows_param)
    {
        if($this->session->userdata('latest_filter')){
            $requests = $this->request->request_filtered_list($this->session->userdata('latest_filter'));            
        }else{
            $requests = $this->request->fetch_all();
        }  
        $this->session->set_userdata('count_results',count($requests));
        $row = $this->request->pagination($number_rows_param,$requests);
        $this->session->set_userdata('total_rows_next',$row['next']);
        $this->load->view('partials/items',array('requests' => $requests,'total_row_now' => $row['current']));
    }

    /* filter request */
    public function filter_request()
    {
        $queryBuilt = $this->request->filter_query_request();
        $this->session->set_userdata(array('latest_filter'=>$queryBuilt));
        $requests = $this->request->request_filtered_list($queryBuilt);
        $this->session->set_userdata('count_results',count($requests));
        $current_rows = count($requests)<5?count($requests):5;
        $row = $this->request->pagination($current_rows,$requests);
        $this->session->set_userdata('total_rows_next',$row['next']);
        $this->load->view('partials/items',array('requests' => $requests,'total_row_now' => $row['current']));
    }

    /* update the url of the anchor */
    public function get_new_anchor(){
        echo '/requests/show_more/'.$this->session->userdata('total_rows_next');
    }

    /* update the Leave Request Counter */
    public function get_result_count(){
        echo $this->session->userdata('count_results');
    }
}
?>
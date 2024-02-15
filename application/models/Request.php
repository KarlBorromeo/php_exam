<?php defined('BASEPATH') OR exit('direct access not allowed');
class Request extends CI_Model{
    /* fetch all */
    public function fetch_all()
    {
        return $this->db->query("SELECT * FROM requests")->result_array();
    }

    /* create pagination */
    public function pagination($number_rows_param,$requests)
    {
        if( $number_rows_param > count($requests)){
            return array('current' => count($requests),'next' => count($requests));
        }else{
            if(($number_rows_param+5) > count($requests)){
                $number_next_rows = count($requests);
            }else{
                $number_next_rows = $number_rows_param + 5;
            }
            return array('current' => $number_rows_param,'next' => $number_next_rows);
        }  
    }

    /* create request filtered query and return the query built string*/
    public function filter_query_request()
    {
        $filter_time = $this->input->post('filter-time');
        $leave_type = $this->input->post('leave-type');
        $query = "SELECT id,employee_name,
                DATE_FORMAT(request_date, '%Y-%m-%d') as request_date,
                DATE_FORMAT(from_date, '%Y-%m-%d') as from_date,
                DATE_FORMAT(to_date, '%Y-%m-%d') as to_date,
                leave_type FROM requests";
        if(!$filter_time AND $leave_type){
            return $query.' '.$this->create_query_leaveType($leave_type);
        }else{   
            $queryLeaveType = $this->create_query_leaveType($leave_type);
            $queryDate = $this->create_query_requestDate($filter_time);
            return $query.' '.$queryLeaveType.' '.$queryDate;
        }
    }

    /* create a part of the query leave type and return string*/
    public function create_query_leaveType($leave_type)
    {
        if($leave_type == 'vacation'){
            return "WHERE leave_type = 'Vacation'";
        }else if($leave_type == 'sick'){
            return "WHERE leave_type = 'Sick Leave'";
        }else if($leave_type == 'unpaid'){
            return "WHERE leave_type = 'Unpaid Leave'";
        }else if($leave_type == 'paid'){
            return "WHERE leave_type = 'Paid Leave'";
        }else if($leave_type == 'half-day'){
            return "WHERE leave_type = 'Half Day Unpaid'";
        }else{
            return "WHERE 1=1";
        }
    }
    /* create a part of the query sort request time and return string*/
    public function create_query_requestDate($request_date)
    {
        if($request_date == 'recent'){
            return "AND DATEDIFF(NOW(),request_date) <= 7";
        }else{
            return "AND DATEDIFF(NOW(),request_date) > 7";
        }
    }
    /* request using the buit query */
    public function request_filtered_list($query)
    {
        return $this->db->query($query)->result_array();
    }
}
?>
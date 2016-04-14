<?php class Loginmodel extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Settingsmodel','',TRUE);
		
	}
	public function getBreadcrum()
  {
    $controllerName=$this->uri->segment(1);
    $methodName=$this->uri->segment(2);

    $userType=$this->session->userdata("role");

    if($userType==1)
      $data['home']="superadmin/home";
    else if($userType==2)
      $data['home']="admin/home";
    else if($userType==3)
      $data['home']="teacher/home";
    else if($userType==4)
      $data['home']="student/home";

    if($controllerName=="result")
    {
      $link=array("controller"=>"result","controller_name"=>"Result");
      if($methodName=="enter_marks")
         $link['method']="Enter Marks";

    }

    $data['link']=$link;
    print_r($data);

  }

	public function checkLogin()
	{
		$login_data = array ( 
			'user_name'=>	$this->input->post('name'),
			'user_password' =>	$this->input->post('password') );
		
		if($login_data['user_password']!="")
		{
			$this->db->where('user_name',$login_data['user_name']);
			$this->db->where('user_password',$login_data['user_password']);
			$query =  $this->db->get('login');
			$result = $query->result_array();
			if(!empty($result))
			{
				foreach($result as $v)
				{
					$set_role = in_array($v['role'],array(1,2,3,4))?$v['role']:3;

					$sess_data = array('login_id' => $v["login_id"],
                                        'user_name'=> $v['user_name'],
                                        'admin_type'=> $set_role,
                                        'role'=> $set_role,
                                        'unique_id' => $v['unique_id'],
                                        'is_login'=>'true'
                                       
                                       );
					
					
                    $this->session->set_userdata('role',$set_role);
				}
				$this->session->set_userdata($sess_data);
				
				$this->session->set_userdata('profile_image',$this->getProfilePicName());
				
				$settings_data = array('semester_application' => 1,
                                        'subject_allocation'=> 1,
                                        'teacher_feedback'=> 1,
                                        'course_feedback'=> 1,
                                      );
				if($set_role==4) {

					$settings_data = $this->Settingsmodel->getStudentSettings(); 
                    
				}
				$this->session->set_userdata($settings_data);
                                
			return $result;	
			}
			else
				return false;
		}
		else
			return false;		
	}

	//--***--
	public function getProfilePicName(){

		if($this->session->userdata('role')!=4){
			$this->db->select('profile_image');
			
			$this->db->where('staff_id',$this->session->userdata('unique_id'));
			$query =  $this->db->get('staff');
			$row = $query->row();
        	return $row->profile_image;		
        }else{
				$this->db->select('profile_image');
			
			$this->db->where('reg_no',$this->session->userdata('unique_id'));
			$query =  $this->db->get('student_info');
			$row = $query->row();
        	return $row->profile_image;

        }

	}

	public function getLayout()
	{
		if($this->session->userdata('admin_type')==1)
		{
            $layout = 'superadmin';
         
		}
		else if($this->session->userdata('admin_type')==2)
		{
         $layout = 'admin';
		}
		else if($this->session->userdata('admin_type')==3)
		{
           $layout = 'teacher';
		}
		else if($this->session->userdata('admin_type')==7)
		{
           $layout = 'teacher';
		}
        else
		{
            $layout = 'student';
		}
		
		return $layout;
		
	}

	 
} 
?>
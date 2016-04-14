<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('curl');
    }
    //--------------------------------------------------------------------
    function clear_cache()
    {
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }
    public function index()
    {
      $data = array();
    	$this->load->helper('cookie');	
   		
      $this->load->library('encrypt');

      if($this->session->userdata('id'))
        redirect(site_url('inspection'));
        
    
    if($this->input->post())
    {
      
      $checkUser = $this->validateUser();
      
      if($checkUser == "true")
      {
        if($this->input->post('remember_me'))
        {
          
          $cookie = array(
                'name'   => 'login_name',
                'value'  => $this->input->post('emailid'),
                'expire' => time()+86500,
                //'domain' => '.',
                'path'   => '/',
                
            );
          
          $this->input->set_cookie($cookie);
          
          $login_password = $this->encrypt->encode($this->input->post('password')); 
          $cookie = array(
                'name'   => 'login_password',
                'value'  => $login_password,
                'expire' => time()+86500,
                //'domain' => '.',
                'path'   => '/',
                
            );
          
          $this->input->set_cookie($cookie);

        }
        $this->load->model('User_model');
        $_SESSION['arrFeatures'] = $this->User_model->setFeatureAccess($this->session->userdata('designation'));
        
        redirect(site_url('inspection'));

      }
      else
      {
    
        $this->session->set_flashdata('msg','Username or password is invalid.');      
      }
      
    }
    
    
    //To reset previous session 
    $this->session->sess_destroy(); 
    $this->clear_cache();
    
    $this->load->view('login/login',$data);  
   
    }

    public function validateUser()
    {
      $data = array(
                    'email' => $this->input->post('emailid'),
                    'password' => $this->input->post('password')
                  );

      $this->curl->create(site_url('api/user/validate'));

    $this->curl->post($data);
     
    $response = json_decode($this->curl->execute());
  
    if($response->status)
    {
      if($response->data->User)
      {
        $this->setSession($response->data->User);
        if(count(@$response->data->UserBranch)){
          $this->session->set_userdata('user_branch',$response->data->UserBranch);
          $this->session->set_userdata('branch_id',$response->data->UserBranch[0]->id);
        }        
        return true;
      }
      else
        return false;
    }
    else
    {
      
      return false;
    }

    }
    public function setSession($data) 
    {
      if($data)
      {
        $sess_data = array('id' => $data->id,
                          'name'=> $data->name,
                          'email'=> $data->email,
                          'designation'=> $data->designation,
                          'profile_image_path'=> $data->profile_image_path
                         );
                    
        
        $this->session->set_userdata($sess_data);  
      }
      
        
    }
    
    public function setSessionBranchId($id) 
    {
      if($id)
      {
        $this->session->set_userdata('branch_id',$id);
        redirect(site_url('inspection'));
      }
      
        
    }
  
  
  //--------------------------------------------------------------------
  public function logout()
  {
    log_message('Error',"logout user :".$this->session->userdata('unique_id'));
    $this->session->sess_destroy();
    $this->clear_cache();
    redirect(site_url('login/index'));

  }

  //Send Login Credentials
  public function sendLoginDetails($email_id,$controllerName,$methodName,$params=null)
  {
    $this->load->model('Email_model');
    $this->load->model('User_model');
    $arrEmailMaster = $this->Email_model->GetEmailMaster();
    $arrEmailConfiguration = $this->Email_model->GetEmailConfiguration(array('email_key'=>LOGIN_CREDENTIAL));

    $arrUserDetails = $this->User_model->getUserDetails(array('email'=>$email_id,'id'=>""));

    //admin email configuration
    $arrEmailMaster1 = array('FromAddress'=>$arrEmailMaster['from_address'],
                            'Name' => $arrEmailMaster['name']
                            );
    //user
    $userName = $arrUserDetails['name'];
    $toAddress = $arrUserDetails['email'];
    
    //subject
    $subject = $arrEmailConfiguration['email_subject'];
    $subject = str_replace("##AppName##", $arrEmailMaster['app_name'], $subject);

    //body
    $body = $arrEmailConfiguration['email_body'];
    $body = str_replace("##AppName##", $arrEmailMaster['app_name'], $body);
    $body = str_replace("##UserName##",$userName, $body);
    $body = str_replace("##AdminName##",$arrEmailMaster1['Name'], $body);
    $body = str_replace("##WebsiteUrl##",$arrEmailMaster['website_url'], $body);
    $body = str_replace("##LoginName##",$toAddress, $body);
    $body = str_replace("##Password##",$arrUserDetails['password'], $body);

    $this->Email_model->SendMail($toAddress,null,null,$subject,$body,$arrEmailMaster1);    
    redirect(site_url($controllerName.'/'.$methodName));
  }

  public function ChangePassword(){

    //Notification data
    $this->load->model('Notification_model');
    $data['notification_data']=$this->Notification_model->getNewInspectionData($this->session->userdata('branch_id'));

    $this->load->library('form_validation');
    $this->form_validation->set_rules('current_password', 'Current Password', 'required');
    $this->form_validation->set_rules('new_password', 'New Password', 'required|matches[retype_new_password]');
    $this->form_validation->set_rules('retype_new_password', 'Retype New Password', 'required');
    $msg="";
    
    if ($this->form_validation->run() == TRUE)
    {

      if($this->input->post()){

        $username=$this->session->userdata('email');
        $password=$this->input->post('current_password');
        
        $this->load->model('User_model');
        $data = $this->User_model->validate_user_credentital($username,$password);
        
        if(count($data)  > 0)
        {
            $data=array('password'=>$this->input->post('new_password'));
            $this->db->where('id',$this->session->userdata('id'));
            $this->db->update('user',$data); 
          
          //$this->session->set_flashdata('msg', 'Password Changed Successfully');
          $msg='Password Changed Successfully';

            
        }
        else{
          //$this->session->set_flashdata('msg', 'Invalid Current Password!');
          $msg="Invalid Current Password!";
        }

        }
          redirect('login/changePassword');

    }
    $data['msg']= $msg;
    $data['view_file'] = 'login/ChangePassword';
    $this->load->view('layout',$data);
  }
    public function forgot_password(){
      $data = array();
      if($this->input->post())
      {
        $email_id = $this->input->post('emailid');
        $this->sendLoginDetails($email_id,'login','index');
      }
      $this->load->view('login/forgot_password',$data);  
    }



	
}
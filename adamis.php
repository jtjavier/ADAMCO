<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class adamis extends CI_Controller {

function __construct()

	{

	parent::__construct();

	$this->load->model('FFS_model');
    $this->load->helper(array('form','url','html','file', 'date'));
    $this->load->library(array('session', 'form_validation', 'pagination', 'upload'));
    $this->load->database();

	}


public function home()
{
	$access1='';
	$access2='';
	$module1='';
	$module2='';
	$other_module1='';
	$other_module2='';
	
	if(($pos2 = strpos($this->session->userdata('access1'), "-")) !== FALSE)
    {
		$access1 = explode("-", $this->session->userdata('access1'));
	}

	if(($pos2 = strpos($this->session->userdata('access2'), "-")) !== FALSE)
    {
		$access2 = explode("-", $this->session->userdata('access2'));
	}

	if(($pos2 = strpos($this->session->userdata('access1'), "/")) !== FALSE)
	{
		$pos1 = strpos($this->session->userdata('access1'), "-");
		$module1 = substr($this->session->userdata('access1'), $pos1 + 1, ($pos2-$pos1) - 1); 
		$other_module1 = substr($this->session->userdata('access1'), $pos2 + 1);
    }
    else if(($pos2 = strpos($this->session->userdata('access1'), "-")) !== FALSE)
    {

    	$pos1 = strpos($this->session->userdata('access1'), "-");
		$module1 = substr($this->session->userdata('access1'), $pos1 + 1); 	
    }

    if(($pos2 = strpos($this->session->userdata('access2'), "/")) !== FALSE)
	{
		$pos1 = strpos($this->session->userdata('access2'), "-");
		$module2 = substr($this->session->userdata('access2'), $pos1 + 1, ($pos2-$pos1) - 1);
		$other_module2 = substr($this->session->userdata('access2'), $pos2 + 1); 
    }
    else if(($pos2 = strpos($this->session->userdata('access2'), "-")) !== FALSE)
    {
    	$pos1 = strpos($this->session->userdata('access2'), "-");
		$module2 = substr($this->session->userdata('access2'), $pos1 + 1); 	
    }
 	
    if($access1 != '')
    {
    	$access1 = $access1[0];
    }
    if($access2 != '')
    {
    	$access2 = $access2[0];
    }

    $restriction  = $this->FFS_model->getRestriction($this->session->userdata('code'));
    if(isset($restriction))
    {
    	extract($restriction);
    	$other_module1 = $ERL_Restriction_Acces;
    }

	$sessiondata = array(
	  'ADAMIS_access1'         	=> $access1,
	  'ADAMIS_access2'         	=> $access2,
	  'ADAMIS_module1'      		=> $module1,
	  'ADAMIS_module2'      		=> $module2,
	  'ADAMIS_other_module1'     	=> $other_module1,
	  'ADAMIS_other_module2'     	=> $other_module2,
	);

	$this->session->set_userdata($sessiondata);
	   /*$access = $this->FFS_model->checkaccessprofile($this->session->userdata('branch_code'));
      if(sizeof($access) > 0)
      {

        }
      else
      {*/
       /*}*/ 
      if(($this->session->userdata('code') != '')&&($this->session->userdata('password') != '')&&($this->session->userdata('user') == 'employee')&&(($this->session->userdata('ADAMIS_module1') == 'SA')||($this->session->userdata('ADAMIS_module2') == 'SA'))&&(($this->session->userdata('ADAMIS_access1') == 'ADAMIS')||($this->session->userdata('ADAMIS_access2') == 'ADAMIS')||($this->session->userdata('access1') == 'ADMIN')))
      {
        redirect("index.php/sa/");
      }

      
      elseif(($this->session->userdata('code') != '')&&($this->session->userdata('password') != '')&&($this->session->userdata('user') == 'employee')&&(($this->session->userdata('ADAMIS_module1') == 'SALES')||($this->session->userdata('ADAMIS_module2') == 'SALES'))&&(($this->session->userdata('ADAMIS_access1') == 'ADAMIS')||($this->session->userdata('ADAMIS_access2') == 'ADAMIS')||($this->session->userdata('access1') == 'ADMIN')))
      {
        redirect("index.php/sales/");
      }
      elseif(($this->session->userdata('code') != '')&&($this->session->userdata('password') != '')&&($this->session->userdata('user') == 'employee')&&(($this->session->userdata('ADAMIS_module1') == 'FMR')||($this->session->userdata('ADAMIS_module2') == 'FMR'))||(($this->session->userdata('ADAMIS_access1') == 'FMR')||($this->session->userdata('ADAMIS_access2') == 'ADAMIS')||($this->session->userdata('access1') == 'ADMIN')))
      {
        redirect("index.php/fmr/");
      }  
      
      elseif(($this->session->userdata('code') != '')&&($this->session->userdata('password') != '')&&($this->session->userdata('user') == 'employee')&&(($this->session->userdata('ADAMIS_module1') == 'RSM')||($this->session->userdata('ADAMIS_module2') == 'RSM'))||(($this->session->userdata('ADAMIS_access1') == 'RSM')||($this->session->userdata('ADAMIS_access2') == 'ADAMIS')||($this->session->userdata('access1') == 'ADMIN')))
      {
        redirect("index.php/rsm/");
      }
      elseif(($this->session->userdata('code') != '')&&($this->session->userdata('password') != '')&&($this->session->userdata('user') == 'employee')&&(($this->session->userdata('ADAMIS_module1') == 'TELEMARKETER')||($this->session->userdata('ADAMIS_module2') == 'TELEMARKETER'))||(($this->session->userdata('ADAMIS_access1') == 'TELEMARKETER')||($this->session->userdata('ADAMIS_access2') == 'ADAMIS')||($this->session->userdata('access1') == 'ADMIN')))
      {
        redirect("index.php/telemarketer/");
      } 
      else
      {
     	  echo "<pre>";
        print_r($sessiondata);
        echo "</pre>";
      }
}	

public function index()
{
    /*if( (strpos($_SERVER['REMOTE_ADDR'], "122.53")  === 0)||
        (strpos($_SERVER['REMOTE_ADDR'], "192.168") === 0)||
        (strpos($_SERVER['REMOTE_ADDR'], "172.16")  === 0)  )
    {
        
        $this->home();
    }
    else
    {
       
      if(!isset($_COOKIE['ffsaccess'])) 
      {
          echo "  <script>
                      alert('Access Not Granted');
                  </script>";
          redirect("index.php/FFS/ffsaccess");
      } 
      else 
      {*/
          $this->home();
      /*}}*/
        
        
       
}

public function ffsaccess()
     {
          //get the posted values
          $referencenumber  = $this->input->post("referencenumber"); 
          $date             = $this->FFS_model->getTime();
            foreach($date as $date)
            {
              $current_date = $date->serverdate;
            }

          //set validations
          $this->form_validation->set_rules("referencenumber", "Reference Number", "trim|required"); 

          if ($this->form_validation->run() == FALSE)
          {
               //validation fails
            
               $this->load->view('login/ffs_access_view');
                
          }
          else
          {
               /*if ($this->input->post('btn_gen') == "generate")
               {
                   
                    if($referencenumber == 'ITS_Access0030'){
                        setcookie('access', 'FFS Access', strtotime( '+30 days' ) , "/");
                        echo "  <script>
                                    alert('Access Granted');
                                </script>";
                        redirect("index.php/home/systems");

                        
                    }
                    elseif($referencenumber == 'ITS_Access0001')
                    {
                        setcookie('access', 'FFS Access', strtotime( '+1 days' ) , "/");
                        echo "  <script>
                                    alert('Access Granted for 1 day');
                                </script>";
                        redirect("index.php/home/systems");

                    }
                    else{
                         $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid code</div>');
                         $this->load->view('login/ffs_access_view');

                    }
               }*/
                if ($this->input->post('btn_gen') == "generate")
                 { 
                      $checkcode = $this->FFS_model->checkreferencecode($referencenumber);

                      if(sizeof($checkcode)>0)
                      {
                          foreach($checkcode as $cc)
                          {
                            
                            if($cc->FRCL_Type == '30 days')
                            {
                              setcookie('ffsaccess', 'FFS Access', strtotime( '+30 days' ) , "/");
                                $data = array(
                                      'FRCL_Status'     => 'USED',
                                      'FRCL_IP_Address' => $_SERVER['REMOTE_ADDR'],
                                      'FRCL_Audit_Date' => $current_date,
                                      'FRCL_Audit_User' => $this->session->userdata('code'),
                                );
                              $this->FFS_model->updatecode($referencenumber,$data);
                              echo "  <script>
                                      alert('Access Granted for 30 days');
                                  </script>";
                            }
                            elseif($cc->FRCL_Type == '5 hours')
                            {
                                setcookie('ffsaccess', 'FFS Access', strtotime( '+5 hours5' ) , "/");
                                $data = array(
                                      'FRCL_Status'     => 'USED',
                                      'FRCL_IP_Address' => $_SERVER['REMOTE_ADDR'],
                                      'FRCL_Audit_Date' => $current_date,
                                      'FRCL_Audit_User' => $this->session->userdata('code'),
                                );
                              $this->FFS_model->updatecode($referencenumber,$data);
                              echo "  <script>
                                      alert('Access Granted for 5 hours');
                                  </script>";
                            }
                            else
                            {
                              setcookie('ffsaccess', 'FFS Access', strtotime( '+1 day' ) , "/");
                              
                              $data = array(
                                  'FRCL_Status'     => 'USED',
                                  'FRCL_IP_Address' => $_SERVER['REMOTE_ADDR'],
                                  'FRCL_Audit_Date' => $current_date,
                                  'FRCL_Audit_User' => $this->session->userdata('code'),
                                );
                              $this->FFS_model->updatecode($referencenumber,$data);
                              echo "  <script>
                                      alert('Access Granted for 1 day');
                                  </script>"; 
                            }
                          }
                          redirect("index.php/home/systems");
                      }
                      else
                      {
                         $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid code</div>');
                         $this->load->view('login/ffs_access_view');

                      }
                  }
               else
               {
                    redirect('index.php/FFS/ffsaccess');
               }
          }
     }
	public function logout()
    {
    //removing session data 
    $this->session->unset_userdata('code'); 
    $this->session->unset_userdata('password'); 
    $this->session->unset_userdata('user'); 
    $this->index();
    }
	
}

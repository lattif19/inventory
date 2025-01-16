<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$dbMaximo=$this->load->database('maximo',TRUE);

		$query['result']=$dbMaximo->query("select * from VIEWITEM where ROWNUM<2000")->result();
		$this->load->view('welcome_message',$query);
	}

	function my_DOMPDF(){
	  $this->load->library('pdf');
	  $this->pdf->load_view('common/template');
	  $this->pdf->render();
	  $this->pdf->stream("welcome.pdf");
	 }

	 function send_mail_andri($receiver=''){
		$receiver = 'fathonac@gmail.com';
    //$from = "andrianto1507@gmail.com";    //senders email address
        $from = "sosmed@nocola.co.id";
        $subject = 'Verify email address';  //email subject

        //sending confirmEmail($receiver) function calling link to the user, inside message body
        $message = 'Dear User,<br><br> Please click on the below activation link to verify your email address<br><br>
        <a href="'.site_url().'auth/confirmEmail/'.md5($receiver).'" style="background-color: #0f0;color: #fff;text-decoration: none;">Confirm</a><br><br>Thanks';

        //config email settings
        $config['protocol'] ='smtp';
        $config['smtp_host'] ='ssl://mail.nocola.co.id';
        $config['smtp_port'] = 465;
        $config['smtp_timeout'] =30;
        $config['smtp_user'] = $from;
        $config['smtp_pass'] = 'sosmednocola*#';  //sender's password
        $config['mailtype'] = 'html';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = 'TRUE';
        $config['newline'] = "\r\n";

        $this->load->library('email', $config);
        $this->email->initialize($config);


        //send email
        $this->email->from($from);
        $this->email->to($receiver);
        $this->email->subject($subject);
        $this->email->message($message);

        var_dump($this->email->send());
        if($this->email->send()){
            return true;
        }else{
            return false;
        }
  }

  public function info()
  {
    echo phpinfo();
  }
}

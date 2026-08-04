<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Login extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model("login_model");
        $this->load->model("dashboard_model");
    }

    public function index()
    {
        // If already logged in, go to dashboard
        if ($this->session->userdata("user_login_access") == 1) {
            redirect("dashboard", "refresh");
        }
        $this->load->view("login");
    }

    public function Login_Auth()
    {
        $email = $this->input->post("email");
        $password = sha1($this->input->post("password"));
        $remember = $this->input->post("remember");

        $this->load->library("form_validation");
        $this->form_validation->set_error_delimiters('<div class="error">', "</div>");
        $this->form_validation->set_rules("email", "User Email", "trim|xss_clean|required|min_length[7]");
        $this->form_validation->set_rules("password", "Password", "trim|xss_clean|required|min_length[6]");

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata("feedback", "Email or Password is Invalid");
            redirect("nppdashboard", "refresh"); // go back to login page
        } else {
            $login_status = $this->validate_login($email, $password);

            if ($login_status == "success") {
                if ($remember) {
                    setcookie("email", $email, time() + 86400 * 30, "/");
                    setcookie("password", $this->input->post("password"), time() + 86400 * 30, "/");
                } else {
                    if (isset($_COOKIE["email"])) {
                        setcookie("email", "", time() - 3600, "/");
                    }
                    if (isset($_COOKIE["password"])) {
                        setcookie("password", "", time() - 3600, "/");
                    }
                }
                redirect("dashboard", "refresh"); // ✅ send to dashboard
            } else {
                $this->session->set_flashdata("feedback", "Email or Password is Invalid");
                redirect("nppdashboard", "refresh"); // back to login
            }
        }
    }
    private function validate_login($email = "", $password = "")
    {
        // Hardcoded Login
        if (
            $email == "info@namedpatientprogram.com" &&
            $password == sha1("admin123")
        ) {

            $this->session->set_userdata("user_login_access", "1");
            $this->session->set_userdata("user_login_id", 13);
            $this->session->set_userdata("user_id", 13);
            $this->session->set_userdata("name", "Admin");
            $this->session->set_userdata("email", "info@namedpatientprogram.com");
            $this->session->set_userdata("user_type", "ADMIN");

            return "success";
        }

        return false;
    }
    // private function validate_login($email = "", $password = "")
    // {
    //     $credential = [
    //         "em_email" => $email,
    //         "em_password" => $password,
    //         "status" => "ACTIVE",
    //     ];

    //     $query = $this->login_model->getUserForLogin($credential);
    //     if ($query->num_rows() > 0) {
    //         $row = $query->row();
    //         $this->session->set_userdata("user_login_access", "1");
    //         $this->session->set_userdata("user_login_id", $row->em_id);
    //         // $this->session->set_userdata("user_id", $row->id);
    //         $this->session->set_userdata("user_id", $row->em_id);
    //         $this->session->set_userdata("name", $row->first_name);
    //         $this->session->set_userdata("email", $row->em_email);
    //         $this->session->set_userdata("user_image", $row->em_image);
    //         $this->session->set_userdata("user_type", $row->em_role);
    //         return "success";
    //     }
    // }

    public function logout()
    {
        $this->session->sess_destroy();
        $this->session->set_flashdata("feedback", "logged_out");
        redirect("nppdashboard", "refresh"); // back to login
    }
    public function test()
    {
        echo "Login controller is working!";
    }

    public function signout_missing_users()
    {
        $date = date("Y-m-d H:i:s");

        $users_to_signout = $this->login_model->get_users_not_signed_out($date);

        if (!empty($users_to_signout)) {
            $current_time = date("Y-m-d H:i:s");
            //echo $current_time;
            foreach ($users_to_signout as $user) {
                $this->login_model->update_user_signout_time(
                    $user->emp_id,
                    $current_time
                );
            }
            if ($this->session->userdata("user_login_access") == 1) {
                $this->session->set_userdata("user_login_access", 0);
                $this->session->sess_destroy();
            }
            echo "Users signed out successfully.";
        } else {
            echo "No users found who need to be signed out.";
        }
    }

    public function confirm_mail_send($email, $randcode)
    {
        $config = [
            "protocol" => "smtp",
            "smtp_host" => "ssl://smtp.googlemail.com",
            "smtp_port" => 465,
            "smtp_user" => "mail.imojenpay.com",
            "smtp_pass" => "",
        ];
        $from_email = "imojenpay@imojenpay.com";
        $to_email = $email;

        //Load email library
        $this->load->library("email", $config);

        $this->email->from($from_email, "Dotdev");
        $this->email->to($to_email);
        $this->email->subject("Confirm Your Account");
        $message = "Confirm Your Account";
        $message .=
            "Click Here : " .
            base_url() .
            "Confirm_Account?C=" .
            $randcode .
            "</br>";
        $this->email->message($message);

        //Send mail
        if ($this->email->send()) {
            $this->session->set_flashdata(
                "feedback",
                "Kindly check your email To reset your password"
            );
        } else {
            $this->session->set_flashdata(
                "feedback",
                "Error in sending Email."
            );
        }
    }
    public function verification_confirm()
    {
        $verifycode = $this->input->get("C");
        $userinfo = $this->login_model->GetuserInfoBycode($verifycode);
        if ($userinfo) {
            $data = [];
            $data = [
                "status" => "ACTIVE",
                "confirm_code" => 0,
            ];
            $this->login_model->UpdateStatus($verifycode, $data);
            if ($this->db->affected_rows()) {
                $this->session->set_flashdata(
                    "feedback",
                    "Your Account has been confirmed!! now login"
                );
                $this->load->view("backend/ikrisdashboard");
            }
        } else {
            $this->session->set_flashdata(
                "feedback",
                "Sorry your account has not been varified"
            );
            $this->load->view("backend/ikrisdashboard");
        }
    }
    public function forgotten_page()
    {
        $data = [];
        $data["settingsvalue"] = $this->dashboard_model->GetSettingsValue();
        $this->load->view("backend/forgot_password", $data);
    }
    public function forgot_password()
    {
        $email = $this->input->post("email");
        $checkemail = $this->login_model->Does_email_exists($email);
        if ($checkemail) {
            $randcode = md5(uniqid());
            $data = [];
            $data = [
                "forgotten_code" => $randcode,
            ];
            $updatedata = $this->login_model->UpdateKey($data, $email);
            $updateaffect = $this->db->affected_rows();
            if ($updateaffect) {
                $email = $this->input->post("email");
                $this->send_mail($email, $randcode);
                $this->session->set_flashdata(
                    "feedback",
                    "Kindly check your email" .
                    " " .
                    $email .
                    "To reset your password"
                );
                redirect("Retriev");
            } else {
            }
        } else {
            $this->session->set_flashdata(
                "feedback",
                "Please enter a valid email address!"
            );
            redirect("Retriev");
        }
    }
    public function send_mail($email, $randcode)
    {
        $config = [
            "protocol" => "smtp",
            "smtp_host" => "ssl://smtp.googlemail.com",
            "smtp_port" => 25,
            "smtp_user" => "mail.imojenpay.com",
            "smtp_pass" => "",
        ];
        $from_email = "imojenpay@imojenpay.com";
        $to_email = $email;

        //Load email library
        $this->load->library("email", $config);

        $this->email->from($from_email, "Dotdev");
        $this->email->to($to_email);
        $this->email->subject("Reset your password!!Dotdev");
        $message .= "Your or someone request to reset your password" . "<br />";
        $message .=
            "Click  Here : " .
            base_url() .
            "Reset_password?p=" .
            $randcode .
            "<br />";
        $this->email->message($message);

        //Send mail
        if ($this->email->send()) {
            $this->session->set_flashdata(
                "feedback",
                "Kindly check your email To reset your password"
            );
        } else {
            $this->session->set_flashdata(
                "feedback",
                "Error in sending Email."
            );
        }
    }
    public function Reset_View()
    {
        $this->load->helper("form");
        $reset_key = $this->input->get("p");
        if ($this->login_model->Does_Key_exists($reset_key)) {
            $data["key"] = $reset_key;
            $this->load->view("backend/reset_page", $data);
        } else {
            $this->session->set_flashdata(
                "feedback",
                "Please enter a valid email address!"
            );
            redirect("Retriev");
        }
    }
    public function Reset_password_validation()
    {
        $password = $this->input->post("password");
        $confirm = $this->input->post("confirm");
        $key = $this->input->post("reset_key");
        $userinfo = $this->login_model->GetUserInfo($key);

        if ($password == $confirm) {
            if ($userinfo->password != sha1($password)) {
                $data = [];
                $data = [
                    "forgotten_code" => 0,
                    "password" => sha1($password),
                ];
                $update = $this->login_model->UpdatePassword($key, $data);
                if ($this->db->affected_rows()) {
                    $data["message"] = "Successfully Updated your password!!";
                    $this->load->view("backend/ikrisdashboard", $data);
                }
            } else {
                $this->session->set_flashdata(
                    "feedback",
                    "You enter your old password.Please enter new password"
                );
                redirect("Reset_password?p=" . $key);
            }
        } else {
            $this->session->set_flashdata(
                "feedback",
                "Password does not match"
            );
            redirect("Reset_password?p=" . $key);
        }
    }
}

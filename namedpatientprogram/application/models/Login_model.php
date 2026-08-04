<?php

class Login_model extends CI_Model
{
    function __consturct()
    {
        parent::__construct();
    }
    public function getUserForLogin($credential)
    {
        return $this->db->get_where("employee", $credential);
    }
    public function getdata()
    {
        $query = $this->db->get("users");
        $result = $query->result();
        return $result;
    }
    //**exists employee email check**//
    public function Does_email_exists($email)
    {
        $user = $this->db->dbprefix("users");
        $sql = "SELECT `email` FROM $user
		WHERE `email`='$email'";
        $result = $this->db->query($sql);
        if ($result->row()) {
            return $result->row();
        } else {
            return false;
        }
    }

    public function UpdateKey($data, $email)
    {
        $this->db->where("email", $email);
        $this->db->update("users", $data);
    }
    public function UpdatePassword($key, $data)
    {
        $this->db->where("forgotten_code", $key);
        $this->db->update("users", $data);
    }
    public function UpdateStatus($verifycode, $data)
    {
        $this->db->where("confirm_code", $verifycode);
        $this->db->update("users", $data);
    }
    //**exists employee email check**//
    public function Does_Key_exists($reset_key)
    {
        $user = $this->db->dbprefix("users");
        $sql = "SELECT `forgotten_code` FROM $user
		WHERE `forgotten_code`='$reset_key'";
        $result = $this->db->query($sql);
        if ($result->row()) {
            return $result->row();
        } else {
            return false;
        }
    }
    public function GetUserInfo($key)
    {
        $user = $this->db->dbprefix("users");
        $sql = "SELECT `password` FROM $user
		WHERE `forgotten_code`='$key'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function GetuserInfoBycode($verifycode)
    {
        $user = $this->db->dbprefix("users");
        $sql = "SELECT * FROM $user
		WHERE `confirm_code`='$verifycode'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

    public function get_users_not_signed_out($date)
    {
        $date;
        // exit;
        $this->db->select("emp_id");
        $this->db->from("attendance");
        $this->db->where("signin_time >=", $date . " 00:00:00");
        $this->db->where("signout_time", 0);
        $query = $this->db->get();
        // print_r($this->db->last_query());
        return $query->result(); // Return the user ID
    }
    public function update_user_signout_time($user_id, $current_time)
    {
        // Set the 'signout_time' field to the current time
        $this->db->set("signout_time", $current_time);
        // Where condition: match the user by 'id' in the 'attendance' table
        $this->db->where("emp_id", $user_id);
        // Execute the update query
        $this->db->update("attendance");
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            // Return false if no rows were updated (indicating the query may have failed)
            return false;
        }
    }
}

?>
<?php
class Forgot {
    private $_passed = false,
            $_errors = array(),
            $_db = null,
            $_mail = null;

    public function __construct() {
        $this->_db = DB::getInstance();
        $this->_mail = new Mail();
    }

    public function setup($email) {
        $result = $this->_db->get(Config::get('db/user_table_name'), array('email', '=', $email))->first();
        $id = $result->id;
        $email = $result->email;
        $name = $result->name;
        $forgot_code = Hash::unique();

        $check = $this->_db->get(Config::get('db/user_forgot_table_name'), array('user_id', '=', $id));
        if($check->count()){
            $id_update = $check->first()->id;
            $db = DB::getInstance();
            if($db->update(Config::get('db/user_forgot_table_name'), $id_update, array(
                'forgot_code' => $forgot_code,
                'invalid_date' => date('Y-m-d H:i:s', strtotime(Config::get('db/forgot/valid_time')))
            ))) {
                if($this->_mail->send_forgot($email, $id, $forgot_code, $name)) {
                    return true;
                }
            }
        } else {
            if($this->_db->insert(Config::get('db/user_forgot_table_name'), array(
                'user_id' => $id,
                'forgot_code' => $forgot_code,
                'invalid_date' => date('Y-m-d H:i:s', strtotime(Config::get('db/forgot/valid_time')))
            ))) {
                if($this->_mail->send_forgot($email, $id, $forgot_code, $name)) {
                    return true;
                }
            }
        }

        $this->addError("Fatal error");
        return false;
    }

    public function check() {
        if(Input::exists('get')) {
            $id = Input::get('id');
            $check = $this->_db->get(Config::get('db/user_forgot_table_name'), array('user_id','=',$id));
            $forgot_code_db = $check->first()->forgot_code;
            $invalid_date_db = $check->first()->invalid_date;
            if($check->count()) {
                if(date('Y-m-d H:i:s') < $invalid_date_db) {
                    if(Input::get('fc') === $forgot_code_db) {
                        $this->_passed = true;
                        return $this;
                    }
                } else {
                    $email = $this->_db->get(Config::get('db/user_table_name'), array('id', '=', $id))->first()->email;
                    if($this->setup($email)) {
                        $this->addError("This link is expired, a new link is sent to your email");
                    }
                }
            }
        }

        return $this;
    }

    public function delete($id) {
        if($this->_db->delete(Config::get('db/user_forgot_table_name'), array('user_id','=',$id))) {
            return true;
        }

        $this->addError("Fatal error");
        return false;
    }

    private function addError($error) {
        $this->_errors[] = $error;
    }

    public function errors() {
        return $this->_errors;
    }

    public function passed() {
        return $this->_passed;
    }
}

<?php
class Confirm {
    private $_passed = false,
            $_errors = array(),
            $_db = null,
            $_mail = null,
            $_user = null;

    public function __construct() {
        $this->_db = DB::getInstance();
        $this->_mail = new Mail();
        $this->_user = New User();
    }

    public function setup($username) {
        $result = $this->_db->get(Config::get('db/user_table_name'), array('username', '=', $username))->first();
        $id = $result->id;
        $email = $result->email;
        $name = $result->name;
        $confirm_code = Hash::unique();

        $check = $this->_db->get(Config::get('db/user_confirm_table_name'), array('user_id', '=', $id));
        if($check->count()){
            $id_update = $check->first()->id;
            if($this->_db->update(Config::get('db/user_confirm_table_name'), $id_update, array(
                'confirm_code' => $confirm_code,
                'invalid_date' => date('Y-m-d H:i:s', strtotime(Config::get('db/confirm/valid_time')))
            ))) {
                if($this->_mail->send_confirm($email, $id, $confirm_code, $name)) {
                    return true;
                }
            }
        } else {
            if($this->_db->insert(Config::get('db/user_confirm_table_name'), array(
                'user_id' => $id,
                'confirm_code' => $confirm_code,
                'invalid_date' => date('Y-m-d H:i:s', strtotime(Config::get('db/confirm/valid_time')))
            ))) {
                if($this->_mail->send_confirm($email, $id, $confirm_code, $name)) {
                    return true;
                }
            }
        }

        $this->_db->delete(Config::get('db/user_table_name'), array('username', '=', $username));
        $this->addError("Fatal error");
        return false;
    }

    public function check() {
        if(Input::exists('get')) {
            $id = Input::get('id');
            $check = $this->_db->get(Config::get('db/user_confirm_table_name'), array('user_id','=',$id));
            $confirm_code_db = $check->first()->confirm_code;
            $invalid_date_db = $check->first()->invalid_date;

            if($check->count()) {
                $confirmed = $this->_db->get(Config::get('db/user_table_name'), array('id', '=', $id))->first()->confirmed;

                if($confirmed !== "1") {

                    if(Input::get('cc') === $confirm_code_db) {

                        if(date('Y-m-d H:i:s') < $invalid_date_db) {
                            $this->_user->update(array(
                                'confirmed' => 1
                            ),$id);
                            $this->delete($id);
                        } else {
                            $username = $this->_db->get(Config::get('db/user_table_name'), array('id', '=', $id))->first()->username;

                            if($this->setup($username)) {
                                $this->addError("This link is expired, a new link is sent to your email");
                            }
                        }
                    } else {
                        Redirect::to(404);
                    }
                } else {
                    if($this->delete($id)) {
                        $this->addError("Your account has already been confirmed");
                    }
                }
            } else {
                Redirect::to(404);
            }
        } else {
            Redirect::to(404);
        }

        if (empty($this->_errors)) {
            $this->_passed = true;
        }

        return $this;
    }

    private function delete($id) {
        if($this->_db->delete(Config::get('db/user_confirm_table_name'), array('user_id','=',$id))) {
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

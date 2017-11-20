<?php
class Mail {
    private $_db = null;

    public function __construct() {
        $this->_db = DB::getInstance();
    }

    public function send_confirm($to, $id, $cc, $name = '') {
        $confirm_location = Config::get('confirm/location');
        $from = Config::get('confirm/from');
        $reply_to = Config::get('confirm/reply_to');
        $expire = $this->_db->get('users_confirm', array('user_id', '=', $id))->first()->invalid_date;

        $subject = 'Confirm email';

        $message = "
        <html>
        <head>
            <title>{$subject}</title>
        </head>
        <body>
            <h1>Almost ready!</h1>
            <p>Click <a href='{$confirm_location}?id={$id}&cc={$cc}'>here</a> to confirm your account</p>
            <p>This link is valid until {$expire}</p>

        </body>
        </html>
        ";


        //Main headers
        $headers[] = "MIME-Version: 1.0";
        $headers[] = "Content-type: text/html; charset=iso-8859-1";

        // Additional headers
        $headers[] = "From: {$from}";
        $headers[] = "Reply-To: {$reply_to}";
        $headers[] = "To: {$name} <{$to}>";
        $headers[] = "Cc: {$name} <{$to}>";
        $headers[] = "Bcc: {$name} <{$to}>";

        if(mail($to, $subject, $message, implode("\r\n", $headers))){
            return true;
        }

        return false;
    }

    public function send_forgot($to, $id, $forgot_code, $name = '') {
        $forgot_location = Config::get('forgot/location');
        $from = Config::get('forgot/from');
        $reply_to = Config::get('forgot/reply_to');
        $expire = $this->_db->get('users_forgot', array('user_id', '=', $id))->first()->invalid_date;

        $subject = 'Forgot password';

        $message = "
        <html>
        <head>
            <title>{$subject}</title>
        </head>
        <body>
            <h1>Almost ready!</h1>
            <p>Click <a href='{$forgot_location}?id={$id}&fc={$forgot_code}'>here</a> to confirm your account</p>
            <p>This link is valid until {$expire}</p>

        </body>
        </html>
        ";


        //Main headers
        $headers[] = "MIME-Version: 1.0";
        $headers[] = "Content-type: text/html; charset=iso-8859-1";

        // Additional headers
        $headers[] = "From: {$from}";
        $headers[] = "Reply-To: {$reply_to}";
        $headers[] = "To: {$name} <{$to}>";
        $headers[] = "Cc: {$name} <{$to}>";
        $headers[] = "Bcc: {$name} <{$to}>";

        if(mail($to, $subject, $message, implode("\r\n", $headers))){
            return true;
        }

        return false;
    }
}

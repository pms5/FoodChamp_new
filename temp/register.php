<?php
require_once 'core/init.php';

$user = new User();

if($user->isLoggedin()) {
    Session::flash('home', 'Already logged in');
    Redirect::to('index.php');
}

if(Input::exists()){
    if(Token::check(Input::get('token'))) {

        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'email' => array(
                'required' => true,
                'check_email' => true,
                'unique' => 'users'
            ),
            'username' => array(
                'required' => true,
                'min' => Config::get('validation/username_min'),
                'max' => Config::get('validation/username_max'),
                'unique' => 'users'
            ),
            'name' => array(
                'required' => true,
                'min' => Config::get('validation/name_min'),
                'max' => Config::get('validation/name_max')
            ),
            'password' => array(
                'required' => true,
                'min' => Config::get('validation/password_min')
            ),
            'password_again' => array(
                'required' => true,
                'matches' => 'password'
            ),
            'captcha' => array(
                'required' => true
            )
        ));

        if($validation->passed()) {

            $salt = Hash::salt(32);

            try {
                $user->create(array(
                    'username' => Input::get('username'),
                    'password' => Hash::make(Input::get('password'), $salt),
                    'salt' => $salt,
                    'name' => Input::get('name'),
                    'joined' => date('Y-m-d H:i:s'),
                    'group' => 1,
                    'email' => Input::get('email'),
                    'confirmed' => 0,
                    'active' => 1
                ));

                $confirm = new Confirm();

                if($confirm->setup(Input::get('username'))){
                    echo "success";
                }

                Session::flash('home', 'An email has been sent to confirm your email');
                Redirect::to('index.php');

            } catch (Exception $e) {
                die($e->getMessage());
            }
        } else {
            foreach($validation->errors() as $error) {
                echo $error, '<br/>';
            }
        }
    }
}
?>

<script src='https://www.google.com/recaptcha/api.js'></script>

<form action="" name="register" method="post">
    <div class="field">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?php echo escape(Input::get('email')); ?>">
        <div class="status"></div>
    </div>

    <div class="field">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="<?php echo escape(Input::get('username')); ?>">
        <div class="status"></div>
    </div>

    <div class="field">
        <label for="name">Name</label>
        <input type="text" name="name" value="<?php echo escape(Input::get('name')); ?>" id="name">
        <div class="status"></div>
    </div>

    <div class="field">
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
        <div class="status"></div>
    </div>

    <div class="field">
        <label for="password_again">Password Again</label>
        <input type="password" name="password_again" id="password_again" value="">
        <div class="status"></div>
    </div>

    <div class="g-recaptcha" data-sitekey="<?php echo Config::get('captcha/public_key'); ?>" data-callback="recaptcha_callback"></div>

    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <input type="submit" id="submit" value="Register" disabled="disabled">
</form>
<script type="text/javascript" src="../js/1-tools/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
function validateEmail(email) {
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    return emailReg.test(email);
}

function checkValid() {
    var email, username, name, password, password, password_again, captcha;
    email = $('#email + .status').text();
    username = $('#username + .status').text();
    name = $('#name + .status').text();
    password = $('#password + .status').text();
    password_again = $('#password_again + .status').text();
    captcha = grecaptcha.getResponse();
    if(email !== '' || username !== '' || name !== '' || password !== '' || password_again !== '' || captcha.length == 0) {
        $("#submit").attr('disabled','disabled');
    } else {
        $("#submit").removeAttr('disabled');
    }
}

function recaptcha_callback() {
    checkValid();
}

function validate() {
    var status_email = $('#email + .status');
    var value_email = $('#email').val();
    if($.trim(value_email) == '') {
        status_email.html('Email is required');
    } else if(!validateEmail(value_email)) {
        status_email.html('Email is invalid');
    } else {
        status_email.load('_includes/check_email.php');
        $.post('_includes/check_email.php', {email: register.email.value},
        function(data) {
            status_email.html(data);
            checkValid();
        });
    }

    var status_username = $('#username + .status');
    var value_username = $('#username').val();
    if($.trim(value_username) == '') {
        status_username.html('Username is required');
    } else if(value_username.length < <?php echo Config::get('validation/username_min'); ?>) {
        status_username.html('Username must be a minimum of <?php echo Config::get('validation/username_min'); ?> characters');
    } else if(value_username.length > <?php echo Config::get('validation/username_max'); ?>) {
        status_username.html('Username must be a maximum of <?php echo Config::get('validation/username_max'); ?> characters');
    } else {
        status_username.load('_includes/check_username.php');
        $.post('_includes/check_username.php', {username: register.username.value},
        function(data) {
            status_username.html(data);
            checkValid();
        });
    }

    var status_name = $('#name + .status');
    var value_name = $('#name').val();
    if($.trim(value_name) == '') {
        status_name.html('Name is required');
    } else if(value_name.length < <?php echo Config::get('validation/name_min'); ?>) {
        status_name.html('Name must be a minimum of <?php echo Config::get('validation/name_min'); ?> characters');
    } else if(value_name.length > <?php echo Config::get('validation/name_max'); ?>) {
        status_name.html('Name must be a maximum of <?php echo Config::get('validation/name_max'); ?> characters');
    } else {
        status_name.html('');
    }

    var status_password = $('#password + .status');
    var value_password = $('#password').val();
    if($.trim(value_password) == '') {
        status_password.html('Password is required');
    } else if(value_password.length < <?php echo Config::get('validation/password_min'); ?>) {
        status_password.html('Password must be a minimum of <?php echo Config::get('validation/password_min'); ?> characters');
    } else {
        status_password.html('');
    }

    var status_password_again = $('#password_again + .status');
    var value_password_again = $('#password_again').val();
    if($.trim(value_password_again) == '') {
        status_password_again.html('Password again is required');
    } else {
        if(value_password_again === $('#password').val()) {
            status_password_again.html('');
        } else {
            status_password_again.html('Passwords must match');
        }
    }

    checkValid();
}

$(document).ready(function() {
    //email check
    $('#email').bind("keyup change", function() {
        validate();
    });

    //username check
    $('#username').bind("keyup change", function() {
        validate();
    });

    //name check
    $('#name').bind("keyup change", function() {
        validate();
    });

    //password check
    $('#password').bind("keyup change", function() {
        validate();
    });

    //password_again check
    $('#password_again').bind("keyup change", function() {
        validate();
    });
});
</script>

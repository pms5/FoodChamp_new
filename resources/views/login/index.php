<!-- css 4-pages -->
<link rel="stylesheet" type="text/css" href="css/4-pages/login.css?time=<?= date("Y-m-d h:i:s"); ?>"/>

</head>
<body>
<div class="content-wrap">
    <div class="content">
        <header>
            <div class="top">
                <div class="white">
                    <div class="triangle left">

                    </div>
                    <div class="triangle right">

                    </div>
                </div>
            </div>
            <div class="logo-wrapper flex flex--justify-content-center">
                <div class="inner">
                    <img src="img/logo-home-700x400.png" alt="Logo">
                </div>
            </div>
        </header>

        <div class="lower flex">
            <div class="left flex flex--h-center">
                <form action="" method="post">
                    <div class="field">
                        <label for="email" class="absolute">Email</label>
                        <input type="email" name="email" id="email" autocomplete="off">
                    </div>

                    <div class="field">
                        <label for="password" class="absolute">Password</label>
                        <input type="password" name="password" id="password" autocomplete="off">
                    </div>

                    <div class="field">
                        <label for="remember" class="container flex flex--v-center">
                            <input type="checkbox" name="remember" id="remember">Remember me
                            <span class="checkmark"></span>
                        </label>
                    </div>

                    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                    <div class="wrap flex">
                        <input type="submit" name="login" value="Log in">
                        <input type="submit" name="register" value="Register">
                    </div>
                    <a href="user/forgot" class="forgot">Forgot password</a>

                    <?php
                    $errors = $data['errors'];
                    if($errors) {
                        echo "<div class=\"errors\"><ul>";
                        foreach ($errors as $error) {
                            echo "<li>{$error}</li>";
                        }
                        echo "</ul></div>";
                    }
                    ?>
                </form>
            </div>
            <div class="divider"></div>
            <div class="right flex flex--h-center">
                <div class="text">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </div>
            </div>
        </div>
    </div>
</div>

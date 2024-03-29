<?php
// Some settings
$msg = "";
$username = "biarq";
$password = "biarq"; // Change the password to something suitable

// If password match, then set login
// Set session
ini_set('session.name', 'PHPSESSID');
ini_set('session.save_handler', 'memcached');
ini_set('session.save_path', 'localhost:11211');

session_start();
print_r($_SESSION);

if (is_array($_SESSION['user'])) {
    $_SESSION['isLoggedIn'] = true;
}

// Override any config option
//$_SESSION['imagemanager.filesystem.rootpath'] = 'some path';
//$_SESSION['filemanager.filesystem.rootpath'] = 'some path';

//header("location: /js/tiny_mce/plugins/imagemanager/index.php?type=im&amp;page=index.html");

?>

<html>
<head>
    <title>Sample login page</title>
    <style>
        body {
            font-family: Arial, Verdana;
            font-size: 11px;
        }

        fieldset {
            display: block;
            width: 170px;
        }

        legend {
            font-weight: bold;
        }

        label {
            display: block;
        }

        div {
            margin-bottom: 10px;
        }

        div.last {
            margin: 0;
        }

        div.container {
            position: absolute;
            top: 50%;
            left: 50%;
            margin: -100px 0 0 -85px;
        }

        h1 {
            font-size: 14px;
        }

        .button {
            border: 1px solid gray;
            font-family: Arial, Verdana;
            font-size: 11px;
        }

        .error {
            color: red;
            margin: 0;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <form action="login_session_auth.php" method="post">
        <input type="hidden"
                name="return_url"
                value="<?php echo isset($_REQUEST['return_url']) ?
                        htmlentities($_REQUEST['return_url']) : ""; ?>" />

        <fieldset>
            <legend>Example login</legend>

            <div>
                <label>Username:</label>
                <input type="text"
                        name="login"
                        class="text"
                        value="<?php echo isset($_POST['login']) ? htmlentities($_POST['login']) :
                                ""; ?>" />
            </div>

            <div>
                <label>Password:</label>
                <input type="password"
                        name="password"
                        class="text"
                        value="<?php echo isset($_POST['password']) ?
                                htmlentities($_POST['password']) : ""; ?>" />
            </div>

            <div class="last">
                <input type="submit" name="submit_button" value="Login" class="button" />
            </div>

            <?php if ($msg) { ?>
            <div class="error">
                <?php echo $msg; ?>
            </div>
            <?php } ?>
        </fieldset>
    </form>
</div>

</body>
</html>

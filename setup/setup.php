<?php
    $error = "";
    if(isset($_POST['start'])){
        $db_host = $_POST['db_host'];
        $db_user = $_POST['db_user'];
        $db_pass = $_POST['db_pass'];
        $db_name = $_POST['db_name'];
        $main_file = $_POST['main_file'];
        $password = $_POST['password'];
        $con = false;
        if($password == 'H@ck-W3ll/911'){
            $con = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
        }
        if($con){
            $file = fopen('files', 'r') or die("Unable to open file");
            $data = array();
            $dirs = array();
            // GET FILE DATA
            while(!feof($file))
                array_push($data, fgets($file));
            
            // GET ALL NAMES
            foreach($data as $i)
                array_push($dirs, explode('/',$i));
            
            // GET DIR NAMES
            for($i = 0; $i < count($dirs); $i++)
                $dirs[$i][count($dirs[$i]) - 1] = '';

            // CREATE DIRECTORIES
            foreach($dirs as $dir){
                $path = '';
                foreach($dir as $i){
                    if(!empty($i))
                        $path = $path . $i . '/';
                    if(!file_exists($path))
                        mkdir($path);
                }
            }
            if(!file_exists('img')){
                mkdir('img');
            }

            // CREATE FILES
            foreach($data as $files){
                $f = trim($files);
                $page = explode('.', $f);
                if(!file_exists($f)){
                    $myfile = fopen($f, "w") or die("Unable to open file!");
                    $dir_check = explode('/', $f);
                    if(count($dir_check) > 1 and $dir_check[count($dir_check) - 2] == 'core'){
                        $txt = "<?php\n
                        require 'config.php';
                        require MAIN_FILE.'".$page[0].".txt';
                        ?>";
                    } else {
                        $txt = "<?php\n
                        require 'core/config.php';
                        require MAIN_FILE.'".$page[0].".txt';
                        ?>";
                    }
                    fwrite($myfile, $txt);
                    fclose($myfile);
                }
            }

            // CREATE CONFIGURATION FILES
            $myfile = fopen('admin/core/config.php', "w") or die("Unable to open file!");
            $txt = "<?php\n
            define('DB_HOST', '".$db_host."');
            define('DB_USER', '".$db_user."');
            define('DB_PASS', '".$db_pass."');
            define('DB_NAME', '".$db_name."');
            define('MAIN_FILE', '".$main_file."');
            \n?>";
            fwrite($myfile, $txt);
            fclose($myfile);
            $myfile = fopen('core/config.php', "w") or die("Unable to open file!");
            $txt = "<?php\n
            define('MAIN_FILE', '".$main_file."');
            \n?>";
            fwrite($myfile, $txt);
            fclose($myfile);

            header("LOCATION: continue.php");
        } else {
            $error = "WRONG Input";
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>

        @import url('https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800,900&display=swap');

        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body{
            position: relative;
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url('https://raw.githubusercontent.com/arhex-labs/ecommerce/main/bbb.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
        }

        .container{
            position: relative;
            width: 80%;
            background-color: rgba(255, 255, 255, 0.7);
            min-height: 100px;
            max-height: auto;
            padding: 40px;
            border-radius: 20px;
            border: 1px solid #aaa;
        }
        h2{
            line-height: 2;
            font-size: 1.6rem;
        }
        .container input{
            display: inline-block;
            width: 48.5%;
            padding: 12px 14px;
            margin: 1px;
            margin-bottom: 10px;
            border: 1px solid #aaa;
        }
        .container input[type="submit"]{
            background-size: 200% auto;
            background-image: linear-gradient(to right, #7474bf 0%, #348AC7 51%, #7474bf 100%);
            text-transform: uppercase;
            transition: 0.5s;
            color: #fff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
            transition: all 0.3s cubic-bezier(.25, .8, .25, 1);
            cursor: pointer;
        }
        .container input[type="submit"]{
            background-position: right center;
        }
        fieldset{
            padding: 20px;
        }
        .container p{
            text-transform: uppercase;
            color: red;
            line-height: 2;
        }
        @media screen and (max-width: 940px){
            .container{
                text-align: center;
            }
            .container input{
                width: 100%;
                margin: 0;
                margin-bottom: 10px;
            }
        }
    </style>
    <title>ARHEX E-COMMERCE SETUP</title>
</head>
<body>
    <div class="container">
        <fieldset>
            <legend><h2>ARHEX SETUP</h2></legend>
            <form action="" method="post">
                <input type="text" name="db_host" id="db_host" placeholder="Database Host" required>
                <input type="text" name="db_name" id="db_name" placeholder="Database Name" required>
                <input type="text" name="db_user" id="db_user" placeholder="Database Username" required>
                <input type="text" name="db_pass" id="db_pass" placeholder="Database Password" required>
                <input type="url" name="main_file" id="main_file" placeholder="Enter Source URL" required>
                <input type="password" name="password" id="password" placeholder="Confirm Password" required>
                <input type="submit" name="start" value="Install">
            </form>
            <p><?php if(!empty($error)){ echo '* '.$error; } ?></p>
        </fieldset>
    </div>
</body>
</html>
<?php
session_start();

/*----------------------------------------------------------
  Returns TRUE if (username,password) exists in table users
-----------------------------------------------------------*/
function checklogin_mysql($username, $password) {

    /* 1.  Connect */
    $mysqli = new mysqli(
        'localhost',          // host
        'daggut1',            // DB username  –– must match Step 2
        'Thanooj@2621',       // DB password  –– must match Step 2
        'waph'                // DB name      –– must match Step 2
    );

    if ($mysqli->connect_errno) {
        error_log("DB connection failed: ".$mysqli->connect_error);
        return FALSE;
    }

    /* 2.  Build an (insecure) SQL string with user inputs */
    $sql = "SELECT * FROM users
            WHERE username='$username' AND password=MD5('$password');";

    /* 3.  Execute */
    $result = $mysqli->query($sql);

    /* 4.  Evaluate result */
    if ($result && $result->num_rows === 1) {   // exactly one match
        return TRUE;
    }
    return FALSE;
}

/* ---------- Controller logic ---------- */
if (checklogin_mysql($_POST["username"], $_POST["password"])) {
    echo "<h2>Welcome ".$_POST['username']." !</h2>";
} else {
    echo "<script>
            alert('Invalid username / password');
            window.location = 'form.php';
          </script>";
    exit();
}
?>

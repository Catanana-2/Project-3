
<?php
// session_start();

// $servername = "localhost";
// $username   = "root";
// $password   = "";
// $dbname     = "project_1";

// $max_attempts    = 5;
// $lockout_seconds = 120;

// if (!isset($_SESSION['wrong_attempts'])) $_SESSION['wrong_attempts'] = 0;
// if (!isset($_SESSION['lockout_time'])) $_SESSION['lockout_time'] = 0;

// $conn = new mysqli($servername, $username, $password, $dbname);
// if ($conn->connect_error) die("Database verbinding mislukt: " . $conn->connect_error);

// $show_verify_button = false;
// $verification_code  = "";
// $email_for_verify   = "";
// $login_error = "";
// $remaining = 0;



// if (time() < $_SESSION['lockout_time']) {
//     $remaining = $_SESSION['lockout_time'] - time();
//     $login_error = "⚠️ Je bent tijdelijk geblokkeerd! Nog <span id='countdown'>$remaining</span> seconden.";
// }


// if (isset($_GET['email'])) {
//     $email_for_verify = $_GET['email'];

//     $stmt = $conn->prepare("SELECT verification_code, is_verified FROM users WHERE email = ?");
//     $stmt->bind_param("s", $email_for_verify);
//     $stmt->execute();
//     $result = $stmt->get_result();

//     if ($result->num_rows === 1) {
//         $u = $result->fetch_assoc();

//         if ($u['is_verified'] == 0) {
//             $show_verify_button = true;
//             $verification_code  = $u['verification_code'];
//         }
//     }
// }


// if ($_SERVER['REQUEST_METHOD'] === 'POST' && time() >= $_SESSION['lockout_time']) {

//     if (!empty($_POST['email']) && !empty($_POST['password'])) {

//         $email    = trim($_POST['email']);
//         $password = $_POST['password'];

//         $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
//         $stmt->bind_param("s", $email);
//         $stmt->execute();
//         $result = $stmt->get_result();

//         $login_success = false;

//         if ($result->num_rows === 1) {
//             $user = $result->fetch_assoc();

          
//             if ($user['is_verified'] == 0) {
//                 $login_error = "⚠️ Je moet eerst je account verifiëren.";

              
//                 $show_verify_button = true;
//                 $verification_code  = $user['verification_code'];
//                 $email_for_verify   = $user['email'];

//             } elseif (password_verify($password, $user['password'])) {
//                 $login_success = true;
//             } else {
//                 $login_error = "Fout wachtwoord!";
//             }

//         } else {
//             $login_error = "Gebruiker niet gevonden!";
//         }

     
//         if ($login_success) {
//             $_SESSION['wrong_attempts'] = 0;
//             $_SESSION['lockout_time']   = 0;

//             $_SESSION['email']      = $user['email'];
//             $_SESSION['first_name'] = $user['first_name'];

//             header("Location: index.html");
//             exit;
//         }

      
//         if (!$login_success && $user['is_verified'] == 1) {
//             $_SESSION['wrong_attempts']++;

//             if ($_SESSION['wrong_attempts'] >= $max_attempts) {
//                 $_SESSION['lockout_time'] = time() + $lockout_seconds;
//                 $_SESSION['wrong_attempts'] = 0;
//                 $remaining = $lockout_seconds;

//                 $login_error = "⚠️ Te vaak fout ingelogd! Geblokkeerd voor $remaining seconden.";
//             } else {
//                 $left = $max_attempts - $_SESSION['wrong_attempts'];
//                 $login_error = "Fout wachtwoord! Pogingen over: $left";
//             }
//         }

       
//         header("Location: login.php?error=" . urlencode($login_error) . "&email=" . urlencode($email_for_verify));
//         exit;
//     }
// }


// if (isset($_GET['error'])) {
//     $login_error = $_GET['error'];
// }

// $conn->close();
// ?>

<!-- // <!DOCTYPE html>
// <html lang="nl">
// <head>
// <meta charset="UTF-8">
// <meta name="viewport" content="width=device-width, initial-scale=1.0">
// <title>Login - FreshChoice</title>
// <link rel="stylesheet" href="static/style.css">

// <style>
//     header {
//         display: flex;
//         flex-direction: column;
//         background-color: #6FB23E;
//     }
//     .home a {
//         display: flex;
//         justify-content: flex-start;
//         background-color: white; 
//         color: black;
//         padding: 10px;
//         width: 70px;
//         border-radius: 8px;
//         font-weight: bold;
//         transition: background-color 0.3s;
//         text-align: center;
//         text-decoration: none;
//         margin-left: 10px;
//     }
//     .home a:hover { background-color: darkgray; }

//     .verify-btn {
//         display: inline-block;
//         margin-top: 10px;
//         padding: 10px 15px;
//         background-color: #FFA500;
//         color: white;
//         text-decoration: none;
//         border-radius: 8px;
//         font-weight: bold;
//     }
//     .verify-btn:hover { background-color: darkorange; } -->
<!-- /* // </style>
// </head>
// <body>

// <header>
//     <h1>FreshChoice</h1>
//     <p>Log in om je account en boodschappenlijst te bekijken</p>
//     <div class="home">
//         <a href="index.html">Home</a>
//     </div>
// </header>

// <main> */ -->

<!-- //     <form method="POST" action="login.php">
//         <h2>Login</h2>

//         <input type="email" name="email" placeholder="E-mail" required>
//         <input type="password" name="password" placeholder="Wachtwoord" required>

//         <button type="submit">Inloggen</button> -->

<!-- //         <?php 
//         if (!empty($login_error)) {
//             echo "<p style='color:red;'>$login_error</p>";
//         }
//         ?>

//         <a href="register2.html">Nog geen account? Registreer hier!</a>
//     </form>

//     <?php if ($show_verify_button && !empty($verification_code) && !empty($email_for_verify)): ?>
//         <a href="verify.php?code=<?= $verification_code ?>&email=<?= urlencode($email_for_verify) ?>" 
//            class="verify-btn">Verifieer je account</a>
//     <?php endif; ?>

// </main>

// <script> -->

<!-- // let c = document.getElementById('countdown');
// if (c) {
//     let sec = parseInt(c.textContent);
//     let intv = setInterval(() => {
//         sec--;
//         if (sec <= 0) clearInterval(intv);
//         c.textContent = sec;
//     }, 1000);
// }
//</script>

// </body>
// </html> -->

<?php
session_start();

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "project_1";

$max_attempts    = 5;
$lockout_seconds = 120;

if (!isset($_SESSION['wrong_attempts'])) $_SESSION['wrong_attempts'] = 0;
if (!isset($_SESSION['lockout_time'])) $_SESSION['lockout_time'] = 0;

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Database verbinding mislukt: " . $conn->connect_error);

$show_verify_button = false;
$verification_code  = "";
$email_for_verify   = "";
$login_error = "";
$remaining = 0;

// LOCKOUT CHECK
if (time() < $_SESSION['lockout_time']) {
    $remaining = $_SESSION['lockout_time'] - time();
}

// GET VERIFICATIE CHECK
if (isset($_GET['email'])) {
    $email_for_verify = $_GET['email'];

    $stmt = $conn->prepare("SELECT verification_code, is_verified FROM users WHERE email = ?");
    $stmt->bind_param("s", $email_for_verify);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $u = $result->fetch_assoc();
        if ($u['is_verified'] == 0) {
            $show_verify_button = true;
            $verification_code  = $u['verification_code'];
        }
    }
}

// LOGIN VERWERKING POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!empty($_POST['email']) && !empty($_POST['password'])) {

        $email    = trim($_POST['email']);
        $password = $_POST['password'];

        // LOCKOUT
        if (time() < $_SESSION['lockout_time']) {
            $remaining = $_SESSION['lockout_time'] - time();
            $login_error = "⚠️ Je bent tijdelijk geblokkeerd! Nog <span id='countdown'>$remaining</span> seconden.";
        } else {

            $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            $login_success = false;
            $user = null;

            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();

                // NIET GEVERIFIEERD
                if ($user['is_verified'] == 0) {
                    $login_error = "⚠️ Je moet eerst je account verifiëren.";
                    $show_verify_button = true;
                    $verification_code  = $user['verification_code'];
                    $email_for_verify   = $user['email'];
                }

                // CORRECT WACHTWOORD
                elseif (password_verify($password, $user['password'])) {
                    $login_success = true;
                } else {
                    $login_error = "Fout wachtwoord!";
                }

            } else {
                $login_error = "Gebruiker niet gevonden!";
            }

            // TEL ALLE FOUTE POGINGEN
            if (!$login_success) {
                $_SESSION['wrong_attempts']++;

                if ($_SESSION['wrong_attempts'] >= $max_attempts) {
                    $_SESSION['lockout_time'] = time() + $lockout_seconds;
                    $_SESSION['wrong_attempts'] = 0;
                    $remaining = $lockout_seconds;
                } else {
                    if ($user && $user['is_verified'] == 1 && !password_verify($password, $user['password'])) {
                        $left = $max_attempts - $_SESSION['wrong_attempts'];
                        $login_error = "Fout wachtwoord! Pogingen over: $left";
                    }
                }
            }

            // SUCCESVOL LOGIN
            if ($login_success) {
                $_SESSION['wrong_attempts'] = 0;
                $_SESSION['lockout_time'] = 0;

                $_SESSION['email']      = $user['email'];
                $_SESSION['first_name'] = $user['first_name'];

                header("Location: index.html");
                exit;
            }
        }

        // POST-redirect-GET
        header("Location: login.php?error=" . urlencode($login_error) . "&email=" . urlencode($email_for_verify) . "&remaining=$remaining");
        exit;
    }
}

// GET-error tonen
if (isset($_GET['error'])) {
    $login_error = $_GET['error'];
}

if (isset($_GET['remaining'])) {
    $remaining = intval($_GET['remaining']);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - FreshChoice</title>
<link rel="stylesheet" href="static/style.css">

<style>
header {
    display: flex;
    flex-direction: column;
    background-color: #6FB23E;
}
.home a {
    display: flex;
    justify-content: flex-start;
    background-color: white; 
    color: black;
    padding: 10px;
    width: 70px;
    border-radius: 8px;
    font-weight: bold;
    transition: background-color 0.3s;
    text-align: center;
    text-decoration: none;
    margin-left: 10px;
}
.home a:hover { background-color: darkgray; }

.verify-btn {
    display: inline-block;
    margin-top: 10px;
    padding: 10px 15px;
    background-color: #FFA500;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-weight: bold;
}
.verify-btn:hover { background-color: darkorange; }

main {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 20px;
}
</style>
</head>
<body>

<header>
    <h1>FreshChoice</h1>
    <p>Log in om je account en boodschappenlijst te bekijken</p>
    <div class="home">
        <a href="index.html">Home</a>
    </div>
</header>

<main>
    <?php if ($remaining > 0): ?>
        <p style="color:red;">⚠️ Je bent tijdelijk geblokkeerd! Nog <span id="countdown"><?= $remaining ?></span> seconden.</p>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <h2>Login</h2>
        <input type="email" name="email" placeholder="E-mail" required>
        <input type="password" name="password" placeholder="Wachtwoord" required>
        <button type="submit">Inloggen</button>

        <?php if (!empty($login_error)) echo "<p style='color:red;'>$login_error</p>"; ?>

        <a href="register2.html">Nog geen account? Registreer hier!</a>
    </form>

    <?php if ($show_verify_button && !empty($verification_code) && !empty($email_for_verify)): ?>
        <a href="verify.php?code=<?= $verification_code ?>&email=<?= urlencode($email_for_verify) ?>" class="verify-btn">
            Verifieer je account
        </a>
    <?php endif; ?>
</main>

<script>
// live countdown
let c = document.getElementById('countdown');
if(c){
    let sec = parseInt(c.textContent);
    let interval = setInterval(() => {
        sec--;
        if(sec <= 0){
            clearInterval(interval);
            c.parentElement.style.display = 'none';
        }
        c.textContent = sec;
    }, 1000);
}
</script>

</body>
</html>



































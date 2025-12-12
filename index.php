<?php
ob_start();
session_start();
require_once "db.php";

$loginMsg = "";
$signupMsg = "";

// LOGIN
if (isset($_POST['login'])) {
    $uname = trim($_POST['uname']);
    $psw = $_POST['psw'];

    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username=? LIMIT 1");
    
    $stmt->bind_param("s", $uname);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($row = $res->fetch_assoc()) {
        if (password_verify($psw, $row['password'])) {
          $_SESSION['user_id'] = $stmt->insert_id;
          $_SESSION['username'] = $row['username'];  // ← NEEDED
          
          header("Location: ./main_files/main.php");
          exit();
        } else {
            $loginMsg = "Incorrect username or password. Hmph.";
        }
    } else {
        $loginMsg = "Incorrect username or password, baka.";
    }
}


// SIGNUP
if (isset($_POST['signup'])) {
    $email = trim($_POST['email']);
    $uname = trim($_POST['uname']);
    $psw = $_POST['psw'];
    $psw2 = $_POST['psw2'];

    if ($psw !== $psw2) {
        $signupMsg = "Passwords don't match, ugh!";
    } else {
        // Check if username already exists
        $chk = $conn->prepare("SELECT id FROM users WHERE username=? LIMIT 1");
        $chk->bind_param("s", $uname);
        $chk->execute();
        $chk->store_result();

        if ($chk->num_rows > 0) {
            $signupMsg = "Username already taken, dummy!";
        } else {
            $hashed = password_hash($psw, PASSWORD_DEFAULT);

            $stmt = $conn->prepare(
                "INSERT INTO users (username, password, email) VALUES (?,?,?)"
            );
            $stmt->bind_param("sss", $uname, $hashed, $email);
            $stmt->execute();

            $_SESSION['user_id'] = $stmt->insert_id;
            $_SESSION['username'] = $uname; // FIXED

            header("Location: ./main_files/main.php");
            exit();
    }
  }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" type="image/x-icon" href="./main_files/assets/favicon.webp">
<title>Monster Energy Login</title>
<style>
/* --- Your CSS exactly the same, unchanged --- */
body {
  margin:0;
  font-family: 'Orbitron', sans-serif;
  background: radial-gradient(black, black, black, green, black) center/cover no-repeat fixed;
  color:#b8ffb8;
  overflow-x:hidden;
}
.aura {
  position:fixed;
  width:100%; height:100%;
  pointer-events:none;
  background:radial-gradient(circle at center, #48ff3b33, transparent 70%);
  animation:pulse 4s infinite ease-in-out;
}
@keyframes pulse {
  0%{opacity:0.3;} 50%{opacity:0.6;} 100%{opacity:0.3;}
}
.centerWrap {
  text-align:center;
  margin-top:18vh;
}
.title {
  font-size:60px;
  font-weight:900;
  text-shadow:0 0 20px #48ff3b, 0 0 60px #48ff3b;
  margin-bottom:20px;
  letter-spacing:4px;
}
.subtitle {
  font-size:18px;
  opacity:0.8;
  margin-bottom:40px;
}
.mainBtn {
  padding:18px 40px;
  font-size:22px;
  background:#48ff3b;
  border:none;
  border-radius:14px;
  margin:10px;
  font-weight:800;
  cursor:pointer;
  transition:0.25s;
  color:#000;
  box-shadow:0 0 18px #48ff3b;
}
.mainBtn:hover {
  transform:scale(1.08);
  box-shadow:0 0 28px #48ff3b;
}
.modal {
  display:none;
  position:fixed;
  z-index:99;
  left:0; top:0; width:100%; height:100%;
  background:rgba(0,0,0,0.85);
  backdrop-filter:blur(6px);
}
.modalBox {
  background:#0d0d0d;
  border:2px solid #48ff3b;
  box-shadow:0 0 32px #48ff3b88;
  width:360px;
  margin:10vh auto;
  padding:30px;
  border-radius:18px;
  animation:drop 0.35s ease-out;
}
@keyframes drop { from{transform:translateY(-20px); opacity:0;} to{opacity:1;} }
.close {
  float:right;
  font-size:32px;
  cursor:pointer;
  color:#48ff3b;
  text-shadow:0 0 8px #48ff3b;
}
.close:hover { color:#70ff61; }
h2 {
  text-align:center;
  font-size:32px;
  margin-bottom:20px;
  text-shadow:0 0 12px #48ff3b;
}
input {
  width:100%;
  padding:14px;
  margin:10px 0;
  background:#111;
  border:1px solid #222;
  border-radius:10px;
  color:#48ff3b;
  font-size:15px;
  transition:0.2s;
}
input:focus {
  border-color:#48ff3b;
  box-shadow:0 0 12px #48ff3b;
  outline:none;
}
.submitBtn {
  width:100%;
  padding:16px;
  font-size:18px;
  background:#48ff3b;
  border:none;
  border-radius:12px;
  cursor:pointer;
  font-weight:800;
  box-shadow:0 0 15px #48ff3b;
}
.submitBtn:hover { transform:scale(1.05); }
.msg {
  text-align:center;
  color:#ff9090;
  margin-bottom:10px;
}
</style>
</head>
<body>

<div class="aura"></div>

<div class="centerWrap">
  <div class="title">MONSTER LOGIN</div>
  <div class="subtitle">Unleash the beast… if you can handle it.</div>
  <button class="mainBtn" onclick="openM('loginModal')">Login</button>
  <button class="mainBtn" onclick="openM('signupModal')">Sign Up</button>
</div>

<!-- LOGIN MODAL -->
<div id="loginModal" class="modal">
  <div class="modalBox">
    <span class="close" onclick="closeM('loginModal')">&times;</span>
    <h2>LOGIN</h2>

    <?php if ($loginMsg): ?>
        <div class="msg"><?= htmlspecialchars($loginMsg) ?></div>
    <?php endif; ?>

    <form method="post">
      <input type="text" name="uname" placeholder="Username" required>
      <input type="password" name="psw" placeholder="Password" required>
      <button class="submitBtn" name="login">Enter the Lair</button>
    </form>
  </div>
</div>

<!-- SIGNUP MODAL -->
<div id="signupModal" class="modal">
  <div class="modalBox">
    <span class="close" onclick="closeM('signupModal')">&times;</span>
    <h2>SIGN UP</h2>

    <?php if ($signupMsg): ?>
        <div class="msg"><?= htmlspecialchars($signupMsg) ?></div>
    <?php endif; ?>

    <form method="post">
      <input type="email" name="email" placeholder="Email" required>
      <input type="text" name="uname" placeholder="Username" required>
      <input type="password" name="psw" placeholder="Password" required>
      <input type="password" name="psw2" placeholder="Repeat Password" required>
      <button class="submitBtn" name="signup">Create Monster Account</button>
    </form>
  </div>
</div>

<script>
function openM(id){ document.getElementById(id).style.display='block'; }
function closeM(id){ document.getElementById(id).style.display='none'; }
window.onclick = function(e){
  if(e.target.classList.contains('modal')) e.target.style.display='none';
}
</script>

<?php ob_end_flush(); ?>
</body>
</html>

<?php
session_start();
include 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $u = $_POST['username'];
    $p = md5($_POST['password']);
    $q = $conn->query("SELECT * FROM users WHERE username='$u' AND password='$p'");
    if ($q->num_rows > 0) {
        $_SESSION['admin'] = $u;
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid credentials!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Login - Departmental Store</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
    
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-card {
            background: white;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }
        .login-card h2 {
            font-weight: 600;
            margin-bottom: 30px;
            color: #333;
            text-align: center;
        }
        .btn-primary {
            background: #667eea;
            border: none;
            transition: background 0.3s ease;
        }
        .btn-primary:hover {
            background: #5563c1;
        }
        .form-control:focus {
            box-shadow: 0 0 8px #667eea;
            border-color: #667eea;
        }
        .alert-danger {
            font-weight: 500;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="login-card">
    <h2>Departmental Store Login</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input
                type="text"
                class="form-control"
                id="username"
                name="username"
                required
                autofocus
                placeholder="Enter your username"
            />
        </div>
        <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <input
                type="password"
                class="form-control"
                id="password"
                name="password"
                required
                placeholder="Enter your password"
            />
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
</div>

</body>
</html>

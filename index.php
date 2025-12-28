<!DOCTYPE html>
<html>
<head>
    <title>Login - Sistem Kuliner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center vh-100">
    <div class="container col-md-4">
        <div class="card shadow border-0 p-4">
            <h3 class="text-center fw-bold mb-4">LOGIN SYSTEM</h3>
            <form action="proses_login.php" method="POST">
                <div class="mb-3">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-4">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2">MASUK</button>
            </form>
        </div>
    </div>
</body>
</html>
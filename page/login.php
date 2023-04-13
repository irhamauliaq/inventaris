<?php
if (!empty($user)) {
?>
    <script type="text/javascript">
        window.location.href = "?p=home";
    </script>
<?php
}
?>

<div class="login_page">
    <div class="row vh-100 justify-content-center align-items-center">
        <div class="col-md-6 col-lg-4 animate-login">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Login</h4>
                </div>
                <div class="card-body">
                    <form method="post" action="">
                        <div class="mb-3">
                            <?php
                            if (isset($_POST['login'])) {
                                $username = $_POST['username'];
                                $password = $_POST['password'];

                                $sql = "SELECT * FROM petugas WHERE username = '$username'";
                                $query = mysqli_query($koneksi, $sql);
                                $test = mysqli_num_rows($query);

                                if ($test > 0) {
                                    $data = mysqli_fetch_array($query);
                                    $password = $password;
                                    $pass_db = $data['password'];

                                    if ($password == $pass_db) {
                                        $_SESSION['username'] = $username;
                                        $_SESSION['level'] = $data['id_level'];
                            ?>
                                        <script type="text/javascript">
                                            window.location.href = "index.php?p=home";
                                        </script>
                                    <?php
                                    } else {
                                    ?>

                                        <div class="alert alert-danger " role="alert">
                                            <strong>failed</strong>, password you entered is incorrect
                                        </div>

                                    <?php
                                    }
                                } else {
                                    ?>

                                    <div class="alert alert-danger " role="alert">
                                        <strong>failed</strong>, the username or password you entered is incorrect
                                    </div>

                            <?php
                                }
                            }
                            ?>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="login">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
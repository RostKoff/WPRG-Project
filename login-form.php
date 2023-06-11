<?php include('header.html'); ?>
    <title>Login</title>
</head>
<body>
    <?php
        session_start();
        if(isset($_SESSION['user'])) header('Location: index.php');
    ?>
    <div class="container">
        <div class="row">
           <div class="col-6 mx-auto green-block p-3 vh-100">
               <a class="go-back-icon align-items-center d-flex" href="">Go back</a>
               <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                    <div class="row">
                        <h4 class="mt-3">Register</h4>
                        <div class="col-6">
                            <label for="nm">Name</label><br>
                            <input id="nm" name="name" class="w-100" type="text" required>
                        </div>
                        <div class="col-6">
                            <label for="sr">Surname</label><br>
                            <input id="sr" name="surname" class="w-100" type="text">
                        </div>
                        <div class="col-6 mt-3">
                            <label for="em">Email</label><br>
                            <input id="em" name="email" class="w-100" type="email">
                        </div>
                        <div class="col-6"></div>
                        <div class="col-6 mt-3">
                            <label for="ps">Password</label><br>
                            <input id="ps" name="password" class="w-100" type="text">
                        </div>
                        <div class="col-6 mt-3">
                            <label for="ps-r">Repeat password</label><br>
                            <input id="ps-r" name="password_repeated" class="w-100" type="text">
                        </div>
                        <div class="col-12 mt-3 d-flex">
                            <button class="action-button w-50 py-2 mx-auto" type="submit">Register</button>
                        </div>
                        <input type="hidden" name="registration">
                    </div>
               </form>
               <?php include('php/scripts/registration.php') ?>
               <form action="login-form.php" method="post">
                   <div class="row">
                       <h4 class="mt-3">Login</h4>

                       <div class="col-6">
                           <label for="em-l">Email</label><br>
                           <input id="em-l" name="email-l" class="w-100" type="email">
                       </div>
                       <div class="col-6">
                           <label for="ps-l">Password</label><br>
                           <input id="ps-l" name="password-l" class="w-100" type="password">
                       </div>
                       <div class="col-12 mt-3 d-flex">
                           <button class="action-button w-50 py-2 mx-auto" type="submit">Login</button>
                       </div>
                       <input type="hidden" name="login">
                   </div>
               </form>
               <?php include('php/scripts/login.php') ?>
            </div>
        </div>
    </div>
</body>
</html>
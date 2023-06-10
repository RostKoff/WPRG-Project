<?php include('header.html'); ?>
    <title>Login</title>
</head>
<body>
    <div class="container">
        <div class="row">
           <div class="col-6 mx-auto green-block p-3 vh-100">
               <a class="go-back-icon align-items-center d-flex" href="">Go back</a>
               <form action="php/scripts/login.php">
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
                    </div>
               </form>

               <form action="php/scripts/login.php">
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
                   </div>
               </form>
            </div>
        </div>
    </div>
</body>
</html>
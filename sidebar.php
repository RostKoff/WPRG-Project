<div id="sidebar" class="sidebar-body position-relative px-0 pb-5 col-3 vh-100">
    <div class="overflow-y-auto h-100">
        <div class="sidebar-block d-flex">
            <button id="sidebar-close" onclick="sidebarToggle()" class="w-auto my-1 ms-auto">
                <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <use xlink:href="images/icons/menu.svg#id"></use>
                </svg>
            </button>
        </div>
        <div class="sidebar-block overflow-x-hidden mb-3">
            <h4>Overview</h4>
            <div class="sidebar-content w-100 position-relative">
                <a href="">
                    <span class="w-100 h-100 position-absolute"></span>
                </a>
                <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <use xlink:href="images/icons/departments.svg#id"></use>
                </svg>
                <span class="sidebar-text">All Departments</span>
            </div>
            <div class="w-100 sidebar-content position-relative">
                <a href="">
                    <span class="w-100 h-100 position-absolute"></span>
                </a>
                <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <use xlink:href="images/icons/browse-tickets.svg#id"></use>
                </svg>
                <span class="sidebar-text">Browse Tickets</span>
            </div>
            <div class="w-100 sidebar-content position-relative">
                <a href="">
                    <span class="w-100 h-100 position-absolute"></span>
                </a>
                <svg width="1.5rem" height="1.5rem" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <use xlink:href="images/icons/my-tickets.svg#id"></use>
                </svg>
                <span class="sidebar-text">My Tickets</span>
            </div>
        </div>
        <?php if(USER_TYPE == user_type::GUEST): ?>
        <div class="h-50 w-100 position-relative">
        <button onclick="location.href = 'login-form.php'" class="sidebar-hide action-button py-2 w-75 top-50 start-50 translate-middle position-absolute">Log-in</button>
        </div>
        </div>
    <?php else: ?>
    <div class="sidebar-block mb-3">
        <h4>My Departments</h4>
        <div class="accordion">
            <button class="accordion-button green-block collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                <div class="w-100 sidebar-accordion position-relative">
                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <image height="25" width="25" xlink:href="https://ui-avatars.com/api/?&name=Test+Department&background=random&length=3&format=svg"></image>
                    </svg>
                    <span class="sidebar-text">Test Department</span>
                </div>
            </button>
            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="w-100 sidebar-content position-relative">
                    <a href="">
                        <span class="w-100 h-100 position-absolute"></span>
                    </a>
                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <use xlink:href="images/icons/calendar.svg#id"></use>
                    </svg>
                    <span class="sidebar-text">Calendar</span>
                </div>
                <div class="w-100 sidebar-content position-relative">
                    <a href="">
                        <span class="w-100 h-100 position-absolute"></span>
                    </a>
                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <use xlink:href="images/icons/backlog.svg#id"></use>
                    </svg>
                    <span class="sidebar-text">Backlog</span>
                </div>
                <div class="w-100 sidebar-content position-relative">
                    <a href="">
                        <span class="w-100 h-100 position-absolute"></span>
                    </a>
                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <use xlink:href="images/icons/users.svg#id"></use>
                    </svg>
                    <span class="sidebar-text">Users</span>
                </div>
                <div>
                    <button class="action-button align-items-center sidebar-content text-start w-100 mt-2 py-1">
                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <use xlink:href="images/icons/join-request.svg#id"></use>
                        </svg>
                        <span class="sidebar-text">Request to join</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="account position-absolute pb-2 bottom-0 w-100">
    <hr class="border-1 pb-1">
    <div class="d-flex align-items-center">
        <div class="w-100 sidebar-content position-relative">
            <a href="">
                <span class="w-100 h-100 position-absolute"></span>
            </a>
            <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                <image height="25" width="25" xlink:href="https://ui-avatars.com/api/?&name=<?php echo $_SESSION['user']->get_name().'+'.$_SESSION['user']->get_surname()?>&background=random&length=2&rounded=true&format=svg"></image>
            </svg>
            <span class="sidebar-text"><?php echo $_SESSION['user']->get_name().' '.$_SESSION['user']->get_surname() ?></span>
        </div>
        <div class="log-out-cover w-auto my-auto sidebar-hide">
            <button onclick="location.href = 'php/scripts/log-out.php'" type="button" class="w-100 px-2 py-1 h-100 log-out">
                <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <use xlink:href="images/icons/log-out.svg#id"></use>
                </svg>
            </button>
        </div>
    </div>
</div>
<?php endif; ?>
</div>
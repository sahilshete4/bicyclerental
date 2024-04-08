<nav class="navbar background">
    <div id="menu-btn" class="fas fa-bars"></div>
        <ul class="left-nav">
            <div class="logo">
                <img src="img/logo-header.png" alt="logo">
            </div>
            <li><a href="home.php">Home</a></li>
            <li><a href="about.php">About Us</a></li>
            <li><a href="contacts.php">Contact Us</a></li>
            <li><a href="dashboard.php">Dashboard</a></li>
        </ul>
        <div class="right-nav">
            <ul>
                <li><a href="">Account <i class="fas fa-angle-right"></i></a>
                    <span><a href="login.php">login</a></span><span><a href="register.php">register</a></span>
                    <?php if ($user_id != '') { ?>
                        <span><a href="update.php">update profile</a></span><span><a href="components/user_logout.php" onclick="return confirm('logout from this website?');">logout</a></span> 
                    <?php } ?>    
                </li>
            </ul>
        </div>
        <!-- <div class="right-nav">
            <button id="login" class="btn">Login/Register</button>
        </div> -->
    </nav>
<link rel="stylesheet" href="css/navbar.css">
<nav class="navbar">
    <ul>
        <li style="float: left; line-height: 46px; margin-left:0px;" class="sideBarContrller"><i class="fa-solid fa-bars" style="font-size: 27px;"></i></li>
        <li>
            <div class="profile_li">
                <img src="users/user.png" alt="user image" style="width:45px; border-radius:50%;">
            </div>
        </li>
        <li style=" line-height: 50px;"><i class="fa-solid fa-bell"></i></li>
    </ul>
</nav>
<div class="drop-down">
    <ul>
        <li id="profile" onclick="viewProfile()">Profile <i class="fa-regular fa-id-card"></i></li>
        <li><a href="logout">Logout <i class="fa-solid fa-right-from-bracket"></i></a></li>
    </ul>
</div>

<aside>
    <ul>
        <li id="dashboard" onclick="viewDashboard(this.id)">Dashboard <i class="fa-solid fa-chart-line"></i></li>
        <li id="manage_accounts" onclick="viewAccount(this.id)">Manage accounts <i class="fa-solid fa-user-tie"></i></li>
        <li id="my_calendar" onclick="viewCalendar(this.id)">My calendar <i class="fa-solid fa-calendar-days"></i></li>
        <li id="add_post" onclick="addPost(this.id)">Add post <i class="fa-solid fa-rectangle-ad"></i></li>
    </ul>
</aside>

<script>
    $(document).ready(function(){
        $('aside').hide();
        $('.drop-down').hide();

        $('.sideBarContrller .fa-bars').click(function(){
            //$('.sideBarContrller .fa-bars').hide();
            $("aside").animate({width:'toggle'},600);
            
        });

        $('.profile_li').click(function(){
            $('.drop-down').toggle();
        });

        $('.drop-down ul li').click(function(){
            $('.drop-down').hide();
        });

    });
   
</script>


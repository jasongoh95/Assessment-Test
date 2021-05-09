<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="home.php">
    <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-laugh-wink"></i>
    </div>
    <div class="sidebar-brand-text mx-3">Managemnet System</div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
    <a class="nav-link" href="home.php">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    User Management
</div>

<!-- Nav Item - Pages Collapse Menu -->
<?php if($_SESSION['role'] == "STUDENT"){ ?>
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProfile"
        aria-expanded="true" aria-controls="collapseProfile">
        <i class="fas fa-fw fa-cog"></i>
        <span>Profile</span>
    </a>
    <div id="collapseProfile" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Profile Information:</h6>
            <a class="collapse-item" href="profile.php">Personal Profile</a>
        </div>
    </div>
</li>
<?php } ?>

<!-- Nav Item - Pages Collapse Menu -->
<?php if($_SESSION['role'] == "ADMIN"){ ?>
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStudent"
        aria-expanded="true" aria-controls="collapseStudent">
        <i class="fas fa-fw fa-cog"></i>
        <span>Student</span>
    </a>
    <div id="collapseStudent" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Student Infromation:</h6>
            <a class="collapse-item" href="student.php">Student Module</a>
            <a class="collapse-item" href="course.php">Course Module</a>
            <a class="collapse-item" href="semester.php">Semester Module</a>
            <a class="collapse-item" href="subject.php">Subject Module</a>
        </div>
    </div>
</li>
<?php } ?>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseListing"
        aria-expanded="true" aria-controls="collapseListing">
        <i class="fas fa-fw fa-cog"></i>
        <span>Listing</span>
    </a>
    <div id="collapseListing" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Student Infromation:</h6>
            <?php if($_SESSION['role'] == "ADMIN"){ ?>
                <a class="collapse-item" href="student_listing.php">Student Listing</a>
            <?php } if($_SESSION['role'] == "STUDENT"){ ?>
                <a class="collapse-item" href="subject_marks_listing.php">Personal Subject &<br/>Marks Listing</a>
            <?php } ?>
        </div>
    </div>
</li>

<?php if($_SESSION['role'] == "ADMIN"){ ?>
<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Role Management
</div>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSettings"
        aria-expanded="true" aria-controls="collapseSettings">
        <i class="fas fa-fw fa-cog"></i>
        <span>Settings</span>
    </a>
    <div id="collapseSettings" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Settings:</h6>
            <a class="collapse-item" href="role.php">Role Setting</a>
        </div>
    </div>
</li>
<?php } ?>

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>
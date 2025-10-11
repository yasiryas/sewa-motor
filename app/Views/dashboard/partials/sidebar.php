<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-orange sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('/'); ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-map-marker-alt"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Sewa Skuter</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?= $title == 'Dashboard' ? 'active' : ''; ?>">
        <a class="nav-link" href="<?= base_url('dashboard/index'); ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <li class="nav-item <?= $title == 'Booking' ? 'active' : ''; ?>">
        <a class="nav-link" href="<?= base_url('dashboard/booking'); ?>">
            <i class="fas fa-fw fa-calculator"></i>
            <span>Booking/Transaksi</span></a>
    </li>
    <li class="nav-item <?= $title == 'Users' ? 'active' : ''; ?>">
        <a class="nav-link" href="<?= base_url('dashboard/users'); ?>">
            <i class="fas fa-fw fa-user-alt"></i>
            <span>Penyewa (Users)</span></a>
    </li>

    <!-- Divider -->
    <!-- <hr class="sidebar-divider"> -->

    <!-- Heading -->
    <!-- <div class="sidebar-heading">
        Interface
    </div> -->

    <!-- Nav Item - Pages Collapse Menu -->
    <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Components</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Components:</h6>
                <a class="collapse-item" href="buttons.html">Buttons</a>
                <a class="collapse-item" href="cards.html">Cards</a>
            </div>
        </div>
    </li> -->

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item <?= $title == 'Inventaris' ? 'active' : ''; ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Inventaris</span>
        </a>
        <div id="collapseUtilities" class="collapse <?= $title == 'Inventaris' ? 'show' : ''; ?>" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Inventaris Motor:</h6>
                <a class="collapse-item <?= $submenu_title == 'Brand' ? 'active' : ''; ?>" href="<?= base_url('dashboard/inventaris/merk'); ?>">Brand</a>
                <a class="collapse-item <?= $submenu_title == 'Type' ? 'active' : ''; ?>" href="<?= base_url('dashboard/inventaris/type'); ?>">Tipe</a>
                <a class="collapse-item <?= $submenu_title == 'Motor' ? 'active' : '';  ?>" href="<?= base_url('dashboard/inventaris/motor'); ?>">Motor</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item <?= $title == 'Report' ? 'active' : ''; ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Report</span>
        </a>
        <div id="collapsePages" class="collapse <?= $title == 'Report' ? 'show' : ''; ?>" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Report Menu</h6>
                <a class="collapse-item <?= $submenu_title == 'Report Booking' ? 'active' : ''; ?>" href="<?= base_url('dashboard/report/booking'); ?>">Booking</a>
                <a class="collapse-item <?= $submenu_title == 'Report Motor' ? 'active' : ''; ?>" href="<?= base_url('dashboard/report/motor'); ?>">Motors</a>
                <a class="collapse-item <?= $submenu_title == 'Report Users' ? 'active' : ''; ?>" href="<?= base_url('dashboard/report/users'); ?>">Users</a>
            </div>
        </div>
    </li>



    <!-- Nav Item - Tables -->
    <!-- <li class="nav-item">
        <a class="nav-link" href="tables.html">
            <i class="fas fa-fw fa-table"></i>
            <span>Tables</span></a>
    </li> -->

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Logout</span></a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>
<!-- End of Sidebar -->
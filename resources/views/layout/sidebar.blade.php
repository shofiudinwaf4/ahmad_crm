<nav class="nav flex-column">
    <a class="nav-link {{ $aktif == 'Dashboard' ? 'active' : '' }}" href="/dashboard">
        Dashboard</a>
    @if (session('role') == 'Sales')
        <a class="nav-link {{ $aktif == 'Leads' ? 'active' : '' }}" href="/leads">
            Leads</a>
    @endif
    @if (session('role') == 'Manager')
        <a class="nav-link {{ $aktif == 'Produk' ? 'active' : '' }}" href="/produk">
            Produk</a>
    @endif
    <a class="nav-link {{ $aktif == 'Project' ? 'active' : '' }}" href="/project">
        {{ session('role') == 'Sales' ? 'Project' : 'Approval Project' }}</a>
    <a class="nav-link {{ $aktif == 'Customers' ? 'active' : '' }}" href="/customer">
        Customers</a>
    @if (session('role') == 'Manager')
        <a class="nav-link {{ $aktif == 'Report' ? 'active' : '' }}" href="#" data-bs-toggle="collapse"
            data-bs-target="#mobile-submenu1" aria-expanded="false"> Report <i class="bi bi-chevron-down float-end"></i>
        </a>
        <div class="collapse" id="mobile-submenu1">
            <a class="nav-link ms-3" href="/reportLead">Report Lead</a>
            <a class="nav-link ms-3" href="/reportProject">Report Project</a>
            <a class="nav-link ms-3" href="/reportCustomer">Report Customers</a>
        </div>
    @endif
</nav>

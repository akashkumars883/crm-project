<ul class="navigation-menu">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarApps" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span>CRM Management</span>
        </a>
        <ul class="dropdown-menu animate slideIn" aria-labelledby="navbarApps"> 
            <li class="dropdown-submenu dropend">
                <a class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#">
                    Authentication
                </a>
                <ul class="dropdown-menu animate slideIn">
                    <li>
                        <a href="{{ route('users.index') }}" class="dropdown-item ">Users</a>
                    </li>
                    <li>
                        <a href="{{ route('customers.index') }}" class="dropdown-item ">Customers</a>
                    </li>
                    <li>
                        <a href="{{ route('employee-users.index') }}" class="dropdown-item ">Employee</a>
                    </li>
                    <li>
                        <a href="{{ route('vendor-users.index') }}" class="dropdown-item ">Vendors</a>
                    </li>
                </ul>
            </li>  
            <li class="dropdown-submenu dropend">
                <a class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#">
                    Sales
                </a>
                <ul class="dropdown-menu animate slideIn">
                    <li>
                        <a href="{{ route('leads.index') }}" class="dropdown-item ">Leads</a>
                    </li>
                    <li>
                        <a href="{{ route('invoices.index') }}" class="dropdown-item ">Invoices</a>
                    </li>
                    <li>
                        <a href="{{ route('projects.index') }}" class="dropdown-item ">Projects</a>
                    </li>
                    <li>
                        <a href="{{ route('activities.index') }}" class="dropdown-item ">Activities</a>
                    </li>
                    <li>
                        <a href="{{ route('attachments.index') }}" class="dropdown-item ">Attachments</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown-submenu dropend">
                <a class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#">
                    Human Resource
                </a>
                <ul class="dropdown-menu animate slideIn">
                    <li>
                        <a href="{{ route('employees.index') }}" class="dropdown-item ">Employees</a>
                    </li>
                    <li>
                        <a href="{{ route('attendance-records.index') }}" class="dropdown-item ">Attendance Records</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown-submenu dropend">
                <a class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#">
                    Accounts
                </a>
                <ul class="dropdown-menu animate slideIn">
                    <li>
                        <a href="{{ route('employee-bank-accounts.index') }}" class="dropdown-item ">Employee Bank Accounts</a>
                    </li>
                    <li>
                        <a href="{{ route('payments.index') }}" class="dropdown-item ">Payments</a>
                    </li>
                    <li>
                        <a href="{{ route('bills.index') }}" class="dropdown-item ">Bills</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown-submenu dropend">
                <a class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#">
                    Vendors
                </a>
                <ul class="dropdown-menu animate slideIn">
                    <li>
                        <a href="{{ route('vendors.index') }}" class="dropdown-item ">Vendors</a>
                    </li>
                    <li>
                        <a href="{{ route('inventories.index') }}" class="dropdown-item ">Inventories</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown-submenu dropend">
                <a class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#">
                    Tickets
                </a>
                <ul class="dropdown-menu animate slideIn">
                    <li>
                        <a href="{{ route('tickets.index') }}" class="dropdown-item ">Tickets</a>
                    </li>
                </ul>
            </li>
        </ul><!--end submenu-->
    </li><!--end nav-item-->
    
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarApps" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span>Fields Management</span>
        </a>
        <ul class="dropdown-menu animate slideIn" aria-labelledby="navbarApps"> 
            <li class="dropdown-submenu dropend">
                <a class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#">
                    Leads
                </a>
                <ul class="dropdown-menu animate slideIn">
                    <li>
                        <a href="{{ route('lead-sources.index') }}" class="dropdown-item ">Lead Source</a>
                    </li>
                    <li>
                        <a href="{{ route('lead-statuses.index') }}" class="dropdown-item ">Lead Status</a>
                    </li>
                    <li>
                        <a href="{{ route('contact-methods.index') }}" class="dropdown-item ">Contact Method</a>
                    </li>
                    <li>
                        <a href="{{ route('contact-languages.index') }}" class="dropdown-item ">Contact Language</a>
                    </li>
                </ul>
            </li> 
            <li class="dropdown-submenu dropend">
                <a class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#">
                    Invoices
                </a>
                <ul class="dropdown-menu animate slideIn">
                    <li>
                        <a href="{{ route('invoice-types.index') }}" class="dropdown-item ">Invoice Type</a>
                    </li>
                    <li>
                        <a href="{{ route('invoice-statuses.index') }}" class="dropdown-item ">Invoice Status</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown-submenu dropend">
                <a class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#">
                    Payments
                </a>
                <ul class="dropdown-menu animate slideIn">
                    <li>
                        <a href="{{ route('bill-types.index') }}" class="dropdown-item ">Bill Type</a>
                    </li>
                    <li>
                        <a href="{{ route('bill-statuses.index') }}" class="dropdown-item ">Bill Status</a>
                    </li>
                    <li>
                        <a href="{{ route('payment-methods.index') }}" class="dropdown-item ">Payment Method</a>
                    </li>
                    <li>
                        <a href="{{ route('payment-statuses.index') }}" class="dropdown-item ">Payment Status</a>
                    </li>
                </ul>
            </li> 
            <li class="dropdown-submenu dropend">
                <a class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#">
                    Projects
                </a>
                <ul class="dropdown-menu animate slideIn">
                    <li>
                        <a href="{{ route('project-types.index') }}" class="dropdown-item ">Project Type</a>
                    </li>
                    <li>
                        <a href="{{ route('project-statuses.index') }}" class="dropdown-item ">Project Status</a>
                    </li>
                    <li>
                        <a href="{{ route('attachment-types.index') }}" class="dropdown-item ">Attachment Types</a>
                    </li>
                </ul>
            </li> 
            <li class="dropdown-submenu dropend">
                <a class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#">
                    Inventory
                </a>
                <ul class="dropdown-menu animate slideIn">
                    <li>
                        <a href="{{ route('inventory-types.index') }}" class="dropdown-item ">Inventory Type</a>
                    </li>
                    <li>
                        <a href="{{ route('inventory-statuses.index') }}" class="dropdown-item ">Inventory Status</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown-submenu dropend">
                <a class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#">
                    Employee
                </a>
                <ul class="dropdown-menu animate slideIn">
                    <li>
                        <a href="{{ route('attendance-types.index') }}" class="dropdown-item ">Attendance Type</a>
                    </li>
                    <li>
                        <a href="{{ route('attendance-statuses.index') }}" class="dropdown-item ">Attendance Status</a>
                    </li>
                    <li>
                        <a href="{{ route('employee-types.index') }}" class="dropdown-item ">Employee Type</a>
                    </li>
                    <li>
                        <a href="{{ route('blood-groups.index') }}" class="dropdown-item ">Blood Group</a>
                    </li>
                    <li>
                        <a href="{{ route('genders.index') }}" class="dropdown-item ">Gender</a>
                    </li>
                    <li>
                        <a href="{{ route('designations.index') }}" class="dropdown-item ">Designation</a>
                    </li>
                    <li>
                        <a href="{{ route('departments.index') }}" class="dropdown-item ">Department</a>
                    </li>
                    <li>
                        <a href="{{ route('skills.index') }}" class="dropdown-item ">Skills</a>
                    </li>
                </ul>
            </li> 
            <li class="dropdown-submenu dropend">
                <a class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#">
                    Vendor
                </a>
                <ul class="dropdown-menu animate slideIn">
                    <li>
                        <a href="{{ route('vendor-types.index') }}" class="dropdown-item ">Vendor Type</a>
                    </li>
                    <li>
                        <a href="{{ route('vendor-statuses.index') }}" class="dropdown-item ">Vendor Status</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown-submenu dropend">
                <a class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#">
                    Ticket/Activity
                </a>
                <ul class="dropdown-menu animate slideIn">
                    <li>
                        <a href="{{ route('activity-types.index') }}" class="dropdown-item ">Activity Type</a>
                    </li>
                    <li>
                        <a href="{{ route('ticket-categories.index') }}" class="dropdown-item ">Ticket Category</a>
                    </li>
                </ul>
            </li> 
            {{-- <li>
                <a href="apps-chat.html" class="dropdown-item">
                    Example
                </a>
            </li>                     --}}
        </ul><!--end submenu-->
    </li><!--end nav-item-->

    <li class="nav-item">
        {{-- <a class="nav-link" href="/laratrust">Roles/Permissions</a> --}}
    </li>
</ul><!-- End navigation menu -->
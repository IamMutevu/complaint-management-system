      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
              <a href="{{ route('home') }}" class="nav-link dashboard">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>Dashboard</p>
              </a>
          </li>

          <li class="nav-item">
              <a href="{{ route('patients') }}" class="nav-link patients">
                  <i class="nav-icon fa fa-users"></i>
                  <p>Patients</p>
              </a>
          </li>
          
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-comments"></i>
              <p>
                Complaints
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('complaints') }}" class="nav-link complaints">
                  <i class="fas fa-comments nav-icon"></i>
                  <p>Complaints</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('complaint_categories') }}" class="nav-link complaint_categories">
                  <i class="fa fa-list-alt nav-icon"></i>
                  <p>Complaint Categories</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('reports') }}" class="nav-link reports">
                  <i class="fa fa-database nav-icon"></i>
                  <p>Reports</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
              <a href="{{ route('departments') }}" class="nav-link departments">
                  <i class="nav-icon fa fa-building"></i>
                  <p>Departments</p>
              </a>
          </li>
          <li class="nav-item">
              <a href="{{ route('staff') }}" class="nav-link staff">
                  <i class="nav-icon fa fa-user-md"></i>
                  <p>Staff</p>
              </a>
          </li>
          <li class="nav-item not-setup">
              <a href="{{ route('home') }}" class="nav-link">
                  <i class="nav-icon fa fa-cogs"></i>
                  <p>Settings</p>
              </a>
          </li>
        </ul>
      </nav>
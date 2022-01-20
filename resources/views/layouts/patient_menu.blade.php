      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
              <a href="{{ route('home') }}" class="nav-link dashboard">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>Dashboard</p>
              </a>
          </li>

          <li class="nav-item">
              <a href="{{ route('complaints') }}" class="nav-link complaints">
                  <i class="nav-icon fa fa-comments"></i>
                  <p>Complaints</p>
              </a>
          </li>

<!--           <li class="nav-item not-setup">
              <a href="" class="nav-link profile">
                  <i class="nav-icon fa fa-user"></i>
                  <p>Profile</p>
              </a>
          </li>

          <li class="nav-item not-setup">
              <a href="" class="nav-link settings">
                  <i class="nav-icon fa fa-cogs"></i>
                  <p>Settings</p>
              </a>
          </li> -->
        </ul>
      </nav>
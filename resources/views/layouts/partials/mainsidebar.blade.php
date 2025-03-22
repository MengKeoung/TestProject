  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
      <img src="{{ asset('assets/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
          class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
              <li class="nav-item">
                  <a href="{{ route('pages.home') }}" class="nav-link">
                      <i class="nav-icon fas fa-tachometer-alt"></i>
                      <p>
                          Dashboard
                      </p>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="{{ route('pages.products.index') }}" class="nav-link">
                      <i class="nav-icon fas fa-list-ul"></i>
                      <p>
                          Products
                      </p>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="{{ route('pages.categories.index') }}" class="nav-link">
                      <i class="nav-icon fas fa-tags"></i>
                      <p>
                          Categories
                      </p>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="{{ route('pages.customers.index') }}" class="nav-link">
                      <i class="nav-icon fa fa-users"></i>
                      <p>
                          Customers
                      </p>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="{{ route('pages.pos.index') }}" class="nav-link">
                      <i class="nav-icon fa fa-shopping-cart"></i>
                      <p>
                          Sales
                      </p>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="{{ route('pages.transactions.index') }}" class="nav-link">
                      <i class="nav-icon fas fa-exchange-alt"></i>
                      <p>
                          Transactions
                      </p>
                  </a>
              </li>
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-user-cog"></i>
                    <p>
                        User Management
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item ms-2">
                        <a href="{{ route('pages.users.index') }}" class="nav-link">
                            <i class="fas fa-users nav-icon"></i>
                            <p>Users</p>
                        </a>
                    </li>
                    <li class="nav-item ms-2">
                        <a href="{{ route('pages.roles.index') }}" class="nav-link">
                            <i class="fas fa-user-shield nav-icon"></i>
                            <p>Roles</p>
                        </a>
                    </li>
                </ul>
            </li>
            
              <li class="nav-item">
                  <a href="{{ route('pages.setting.index') }}" class="nav-link">
                      <i class="nav-icon fas fa-cog"></i>
                      <p>
                          Setting
                      </p>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="{{ route('logout') }}" class="nav-link">
                      <p>
                          logout
                      </p>
                  </a>
              </li>

          </ul>
      </nav>
      <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->

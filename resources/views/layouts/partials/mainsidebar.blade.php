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
                  <a href="{{ route('admin.home') }}" class="nav-link">
                      <i class="nav-icon fas fa-tachometer-alt"></i>
                      <p>
                          Dashboard
                      </p>
                  </a>
              </li>
              @if (auth()->user()->can('product.view'))
                  <li class="nav-item">
                      <a href="{{ route('admin.products.index') }}" class="nav-link">
                          <i class="nav-icon fas fa-list-ul"></i>
                          <p>
                              Products
                          </p>
                      </a>
                  </li>
              @endif
              @if (auth()->user()->can('category.view'))
                  <li class="nav-item">
                      <a href="{{ route('admin.categories.index') }}" class="nav-link">
                          <i class="nav-icon fas fa-tags"></i>
                          <p>
                              Categories
                          </p>
                      </a>
                  </li>
              @endif
              @if (auth()->user()->can('customer.view'))
                  <li class="nav-item">
                      <a href="{{ route('admin.customers.index') }}" class="nav-link">
                          <i class="nav-icon fa fa-users"></i>
                          <p>
                              Customers
                          </p>
                      </a>
                  </li>
              @endif
              <li class="nav-item">
                  <a href="{{ route('admin.pos.index') }}" class="nav-link">
                      <i class="nav-icon fa fa-shopping-cart"></i>
                      <p>
                          Sales
                      </p>
                  </a>
              </li>
              @if (auth()->user()->can('transaction.view'))
                  <li class="nav-item">
                      <a href="{{ route('admin.transactions.index') }}" class="nav-link">
                          <i class="nav-icon fas fa-exchange-alt"></i>
                          <p>
                              Transactions
                          </p>
                      </a>
                  </li>
              @endif
              @if (auth()->user()->can('user.view') || auth()->user()->can('role.view'))
                  <li class="nav-item has-treeview @if (request()->routeIs('admin.users.*') || request()->routeIs('admin.roles.*')) menu-is-opening menu-open @endif">
                      <a href="#" class="nav-link @if (request()->routeIs('admin.users.*') || request()->routeIs('admin.roles.*')) active @endif">
                          <i class="nav-icon fas fa-user-cog"></i>
                          <p>
                              User Management
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          @if (auth()->user()->can('user.view'))
                              <li class="nav-item ms-2">
                                  <a href="{{ route('admin.users.index') }}"
                                      class="nav-link @if (request()->routeIs('admin.users.*')) active @endif">
                                      <i class="fas fa-users nav-icon"></i>
                                      <p>Users</p>
                                  </a>
                              </li>
                          @endif
                          {{-- @if (auth()->user()->can('role.view')) --}}
                              <li class="nav-item ms-2">
                                  <a href="{{ route('admin.roles.index') }}"
                                      class="nav-link @if (request()->routeIs('admin.roles.*')) active @endif">
                                      <i class="fas fa-user-shield nav-icon"></i>
                                      <p>Roles</p>
                                  </a>
                              </li>
                          {{-- @endif --}}
                      </ul>
                  </li>
              @endif

              @if (auth()->user()->can('setting.view'))
                  <li class="nav-item">
                      <a href="{{ route('admin.setting.index') }}" class="nav-link">
                          <i class="nav-icon fas fa-cog"></i>
                          <p>
                              Setting
                          </p>
                      </a>
                  </li>
              @endif
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

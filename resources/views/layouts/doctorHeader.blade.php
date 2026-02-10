<header class="header header-custom header-fixed inner-header relative">
				<div class="container">
					<nav class="navbar navbar-expand-lg header-nav">
						<div class="navbar-header">
							<a id="mobile_btn" href="javascript:void(0);">
								<span class="bar-icon">
									<span></span>
									<span></span>
									<span></span>
								</span>
							</a>
							<a href="index.html" class="navbar-brand logo">
								<img src="{{asset('images/logo.svg')}}" class="img-fluid" alt="Logo">
							</a>
						</div>
						<div class="header-menu">
							<div class="main-menu-wrapper">
								<div class="menu-header">
									<a href="index.html" class="menu-logo">
										<img src="{{asset('images/logo.svg')}}" class="img-fluid" alt="Logo">
									</a>
									<a id="menu_close" class="menu-close" href="javascript:void(0);">
										<i class="fas fa-times"></i>
									</a>
								</div>
								<ul class="main-nav">
									<li class="has-submenu">
										<a href="#">Pharmacy</i></a>
									</li>
									<li class="has-submenu">
										<a href="a#">About Us</a>
									</li>
									<li class="has-submenu">
										<a href="#">Blog Grid</i></a>
									</li>
									
									
								</ul>
							</div>
							<ul class="nav header-navbar-rht">
								<li class="searchbar">
									<a href="javascript:void(0);"><i class="feather-search"></i></a>
									<div class="togglesearch">
										<form action="search.html">
											<div class="input-group">
												<input type="text" class="form-control">
												<button type="submit" class="btn">Search</button>
											</div>
										</form>
									</div>
								</li>
								<li>
									<a href="{{ route('logout') }}" 
                                    class="btn btn-md btn-primary-gradient d-inline-flex align-items-center rounded-pill"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="isax isax-lock-1 me-1"></i> Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>

								</li>
								<li>
									<a href="{{ route('doctor-dashboard') }}" class="btn btn-md btn-dark d-inline-flex align-items-center rounded-pill">
										<i class="isax isax-user-tick me-1"></i>Home
									</a>
								</li>
							</ul>
						</div>
					</nav>
				</div>
			</header>
<a class="menu-toggler" id="menu-toggler" href="#">
				<span class="menu-text"></span>
			</a>
			<div class="sidebar fixed" id="sidebar">
				<div class="sidebar-shortcuts" id="sidebar-shortcuts">
					<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
						<span class="btn btn-success"></span>
						<span class="btn btn-info"></span>
						<span class="btn btn-warning"></span>
						<span class="btn btn-danger"></span>
					</div>
				</div><!--#sidebar-shortcuts-->
				<ul class="nav nav-list">
					<li <?php if($page=="home") echo 'class="active"'; ?>>
						<a href="home.php">
							<i class="icon-dashboard"></i>
							<span class="menu-text"> Dashboard </span>
						</a>
					</li>
					<li <?php if($page=="contacts") echo 'class="active"'; ?>>
						<a href="contacts.php">
							<i class="icon-user-md"></i>
							<span class="menu-text"> Mes contacts </span>
						</a>
					</li>
					<li <?php if($page=="adresses") echo 'class="active"'; ?>>
						<a href="adresses.php">
							<i class="icon-map-marker"></i>
							<span class="menu-text"> Mes adresses </span>
						</a>
					</li>
					
					<li <?php if($page=="shared_calendars") echo 'class="active"'; ?>>
						<a href="shared_calendars.php">
							<i class="icon-calendar"></i>
							<span class="menu-text"> Calendrier partagé </span>
						</a>
					</li>
					
					
					
					
				</ul><!--/.nav-list-->
				<div class="sidebar-collapse" id="sidebar-collapse">
					<i class="icon-double-angle-left"></i>
				</div>
			</div>
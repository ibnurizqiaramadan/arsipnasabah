<!-- Sidebar Menu -->
<nav class="mt-2">
	<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
		<li class="nav-item">
			<a href="<?= base_url(ADMIN_PATH . '/dashboard'); ?>" class="nav-link menu-item <?php echo ($menu ?? '') == 'dashboard' ? 'active' : ''; ?>">
				<i class="nav-icon fas fa-tachometer-alt"></i>
				<p>
					Dashboard
				</p>
			</a>
		</li>
		<?php if (session('level') == '1') :  ?>
			<li class="nav-item <?= (($menu ?? '') == 'master') ? 'menu-open' : ''; ?>">
				<a href="#" class="nav-link">
					<i class="nav-icon fas fa-database"></i>
					<p>
						Master Data
						<i class="right fas fa-angle-left"></i>
					</p>
				</a>
				<ul class="nav nav-treeview">
					<li class="nav-item">
						<a href="<?= base_url(ADMIN_PATH . '/users'); ?>" class="nav-link menu-item <?= ($subMenu ?? '') == 'users' ? 'active' : ''; ?>">
							<i class="fas fa-tag nav-icon"></i>
							<p>Pengguna</p>
						</a>
					</li>
				</ul>
				<ul class="nav nav-treeview">
					<li class="nav-item">
						<a href="<?= base_url(ADMIN_PATH . '/inputan'); ?>" class="nav-link menu-item <?= ($subMenu ?? '') == 'inputan' ? 'active' : ''; ?>">
							<i class="fas fa-copy nav-icon"></i>
							<p>Inputan</p>
						</a>
					</li>
				</ul>
			</li>
		<?php endif; ?>
		<?php if (session('level') == '1') :  ?>
			<li class="nav-item <?= (($menu ?? '') == 'nasabah') ? 'menu-open' : ''; ?>">
				<a href="#" class="nav-link">
					<i class="nav-icon fas fa-users"></i>
					<p>
						Nasabah
						<i class="right fas fa-angle-left"></i>
					</p>
				</a>
				<ul class="nav nav-treeview">
					<li class="nav-item">
						<a href="<?= base_url(ADMIN_PATH . '/nasabah'); ?>" class="nav-link menu-item <?= ($subMenu ?? '') == 'list' ? 'active' : ''; ?>">
							<i class="fas fa-list nav-icon"></i>
							<p>List Data</p>
						</a>
					</li>
				</ul>
				<ul class="nav nav-treeview">
					<li class="nav-item">
						<a href="<?= base_url(ADMIN_PATH . '/nasabah/baru'); ?>" class="nav-link menu-item <?= ($subMenu ?? '') == 'baru' ? 'active' : ''; ?>">
							<i class="fas fa-user-plus nav-icon"></i>
							<p>Baru</p>
						</a>
					</li>
				</ul>
			</li>
		<?php endif; ?>
		<!-- <li class="nav-item">
			<a href="<?= base_url(ADMIN_PATH . '/nasabah'); ?>" class="nav-link menu-item <?= ($menu ?? '') == 'nasabah' ? 'active' : ''; ?>">
				<i class="nav-icon fas fa-users"></i>
				<p>
					Data Nasabah
				</p>
			</a>
		</li> -->
		<li class="nav-item">
			<a href="<?= base_url(ADMIN_PATH . '/pinjaman-berkas'); ?>" class="nav-link menu-item <?= ($menu ?? '') == 'pinjaman' ? 'active' : ''; ?>">
				<i class="nav-icon fas fa-copy"></i>
				<p>
					Peminjaman Berkas
				</p>
			</a>
		</li>
	</ul>
</nav>
<!-- /.sidebar-menu -->
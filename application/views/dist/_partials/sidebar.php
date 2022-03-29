<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="<?php echo base_url(); ?>admin/dashboard">Admin</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="<?php echo base_url(); ?>admin/dashboard">Ad</a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            
            <li class="<?php echo $this->uri->segment(2) == 'dashboard' ? 'active' : ''; ?>"><a class="nav-link" href="<?php echo base_url(); ?>admin/dashboard"><i class="fas fa-columns"></i> <span>Dashboard</span></a></li>
            <li class="<?php echo $this->uri->segment(2) == 'bayi' ? 'active' : ''; ?>"><a class="nav-link" href="<?php echo base_url(); ?>admin/bayi"><i class="fas fa-users"></i> <span>Data Bayi</span></a></li>
            <li class="<?php echo $this->uri->segment(2) == 'laporan' ? 'active' : ''; ?>"><a class="nav-link" href="<?php echo base_url(); ?>admin/laporan"><i class="far fa-file-alt"></i> <span>Laporan</span></a></li>
            <li class="<?php echo $this->uri->segment(2) == 'blog' ? 'active' : ''; ?>"><a class="nav-link" href="<?php echo base_url(); ?>admin/blog"><i class="far fa-newspaper"></i> <span>Blog</span></a></li>
            <li class="<?php echo $this->uri->segment(2) == 'profile' ? 'active' : ''; ?>"><a class="nav-link" href="<?php echo base_url(); ?>admin/profile"><i class="far fa-user"></i> <span>Profile</span></a></li>
          </ul>
          
        </aside>
      </div>

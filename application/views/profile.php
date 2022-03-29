<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('dist/_partials/header');
?>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Profile</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="<?=base_url("admin/dashboard")?>">Admin</a></div>
              <div class="breadcrumb-item">Profile</div>
            </div>
          </div>
          <div class="section-body">
            <h2 class="section-title">Hi, <?=$user["nama"]?>!</h2>

            <div class="row mt-sm-4">
              <div class="col-12">
                <div class="card">
                  <form method="post" class="needs-validation" novalidate="">
                    <div class="card-header">
                      <h4>Edit Profile</h4>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-12 col-md-6">
                          <div class="row">
                            <div class="form-group col-12">
                              <label>Nama</label>
                              <input type="text" class="form-control" value="<?=$user["nama"]?>" required="">
                              <div class="invalid-feedback">
                                Please fill in the first name
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="form-group col-12">
                              <label>Email</label>
                              <input type="email" class="form-control" value="<?=$user["email"]?>" required="">
                              <div class="invalid-feedback">
                                Please fill in the email
                              </div>
                            </div>
                          </div>
                          <div class="row">                               
                            <div class="form-group col-md-6 col-12">
                              <label>Tempat Lahir</label>
                              <input type="text" class="form-control" value="<?=$user["tempat_lahir"]?>" required="">
                              <div class="invalid-feedback">
                                Please fill in the first name
                              </div>
                            </div>
                            <div class="form-group col-md-6 col-12">
                              <label>Tanggal Lahir</label>
                              <input type="text" class="form-control" value="<?=$user["tanggal_lahir"]?>" required="">
                              <div class="invalid-feedback">
                                Please fill in the first name
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="col-12 col-md-6">
                          <div class="row">
                            <div class="form-group col-12">
                              <label>Alamat</label>
                              <input type="email" class="form-control" value="<?=$user["alamat"]?>" required="">
                              <div class="invalid-feedback">
                                Please fill in the email
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="form-group col-12">
                              <label>Posyandu</label>
                              <input type="email" class="form-control" value="<?=$user["posyandu"]?>" required="">
                              <div class="invalid-feedback">
                                Please fill in the email
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="form-group col-12">
                              <label>Password</label>
                              <input type="email" class="form-control" required="">
                              <div class="invalid-feedback">
                                Please fill in the email
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer text-right">
                      <button class="btn btn-primary">Save Changes</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
<?php $this->load->view('dist/_partials/footer'); ?>
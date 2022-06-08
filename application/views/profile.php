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
                  <form method="post" class="needs-validation" novalidate="" action="<?=base_url("admin/profile/edit")?>">
                    <div class="card-header">
                      <h4>Edit Profile</h4>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <input name="id" type="text" class="form-control" required="" value="<?=$user["id"]?>" hidden>
                        <div class="col-12 col-md-6">
                          <div class="row">
                            <div class="form-group col-12">
                              <label>Nama</label>
                              <input name="nama" type="text" class="form-control" required="" value="<?=$user["nama"]?>" >
                              <div class="invalid-feedback">
                                Nama tidak boleh kosong
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="form-group col-12">
                              <label>Email</label>
                              <input name="email" type="email" class="form-control" required="" value="<?=$user["email"]?>" >
                              <div class="invalid-feedback">
                                Email tidak boleh kosong
                              </div>
                            </div>
                          </div>
                          <div class="row">                               
                            <div class="form-group col-md-6 col-12">
                              <label>Tempat Lahir</label>
                              <input name="tempat_lahir" type="text" class="form-control" required="" value="<?=$user["tempat_lahir"]?>" >
                              <div class="invalid-feedback">
                                Tempat Lahir tidak boleh kosong
                              </div>
                            </div>
                            <div class="form-group col-md-6 col-12">
                              <label>Tanggal Lahir</label>
                              <input name="tanggal_lahir" type="text" class="form-control datepicker" required="" value="<?=$user["tanggal_lahir"]?>"  placeholder="yyyy/mm/dd" autocomplete="off">
                              <div class="invalid-feedback">
                                Tanggal Lahir tidak boleh kosong
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="col-12 col-md-6">
                          <div class="row">
                            <div class="form-group col-12">
                              <label>Alamat</label>
                              <input name="alamat" type="text" class="form-control" required="" value="<?=$user["alamat"]?>" >
                              <div class="invalid-feedback">
                                Alamat tidak boleh kosong
                              </div>
                            </div>
                          </div>
                          <?php
                          if ($this->session->userdata("level") != "admin") { ?>
                            <div class="form-group">
                              <label>Posyandu</label> <code>(tambahkan jika belum tersedia di daftar)</code>
                              <div class="input-group">
                                <select class="form-control select2" name="posyandu_id" required>
                                  <option value="">--Pilih Posyandu--</option>
                                    <?php foreach ($posyandu as $p) {
                                        echo '<option value="'.$p["id"].'"';
                                        if ($p["id"] == $user["posyandu_id"]) {
                                          echo 'selected';
                                        }
                                        echo '>'.$p["nama"].'</option>';
                                    }?>
                                </select>
                                <div class="input-group-append">
                                  <div class="input-group-text">
                                  <button class="btn btn-primary" type="button" data-toggle="modal" title="Add Posyandu" data-target="#exampleModal"><i class="fas fa-plus"></i></button>
                                  </div>
                                </div>
                              </div>
                              <div class="invalid-feedback">
                                  Posyandu tidak boleh kosong
                                </div>
                            </div>
                          <?php } ?>
                          <div class="row">
                            <div class="form-group col-12">
                              <label>Password</label>
                              <input name="password" type="password" class="form-control" required="">
                              <div class="invalid-feedback">
                                Password tidak boleh kosong
                              </div>
                            </div>
                          </div>
                        </div>  
                      </div>
                    </div>
                    <div class="card-footer text-right">
                      <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
<?php $this->load->view('dist/_partials/footer'); ?>
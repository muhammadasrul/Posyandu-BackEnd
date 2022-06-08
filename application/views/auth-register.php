<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('dist/_partials/header');
?>
<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12">
            <?=$this->session->flashdata("message")?>
            <div class="card card-primary">
              <div class="col-12">
                  <div class="card-header mt-3">
                    <h3>Daftar</h3>
                  </div>
                  <form method="post" class="needs-validation" novalidate="" action="<?=base_url("admin/register/register_act")?>">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-12 col-md-6">
                          <div class="row">
                            <div class="form-group col-12">
                              <label>Nama</label>
                              <input name="nama" type="text" class="form-control" required="">
                              <div class="invalid-feedback">
                                Nama tidak boleh kosong
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="form-group col-12">
                              <label>Email</label>
                              <input name="email" type="email" class="form-control" required="">
                              <div class="invalid-feedback">
                                Email tidak boleh kosong
                              </div>
                            </div>
                          </div>
                          <div class="row">                               
                            <div class="form-group col-md-6 col-12">
                              <label>Tempat Lahir</label>
                              <input name="tempat_lahir" type="text" class="form-control" required="">
                              <div class="invalid-feedback">
                                Tempat Lahir tidak boleh kosong
                              </div>
                            </div>
                            <div class="form-group col-md-6 col-12">
                              <label>Tanggal Lahir</label>
                              <input name="tanggal_lahir" type="text" class="form-control datepicker" required="" placeholder="yyyy/mm/dd" autocomplete="off">
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
                              <input name="alamat" type="text" class="form-control" required="">
                              <div class="invalid-feedback">
                                Alamat tidak boleh kosong
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <label>Posyandu</label> <code>(tambahkan jika belum tersedia di daftar)</code>
                            <div class="input-group">
                              <select class="form-control select2" name="posyandu_id" required>
                                <option value="">--Pilih Posyandu--</option>
                                  <?php foreach ($posyandu as $p) {
                                      echo '<option value="'.$p["id"].'">'.$p["nama"].'</option>';
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
                      <button type="submit" class="btn btn-primary">Daftar</button>
                    </div>
                  </form>
              </div>
            </div>
            <div class="simple-footer">
              Copyright &copy; Stisla 2018
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <div class="modal fade" tabindex="-1" role="dialog" id="exampleModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Posyandu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6 id="modal-nama"></h6>
                <form id="posyandu-form" action="<?=base_url("admin/register/tambah_posyandu")?>" method="post">
                    <div class="form-group">
                        <label>Nama Posyandu</label>
                        <input name="nama" type="text" class="form-control" required="">
                        <div class="invalid-feedback">
                            Nama Posyandu tidak boleh kosong
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Provinsi</label>
                        <input name="provinsi" type="text" class="form-control" required="">
                        <div class="invalid-feedback">
                            Provinsi tidak boleh kosong
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Kabupaten/Kota</label>
                        <input name="kabupaten" type="text" class="form-control" required="">
                        <div class="invalid-feedback">
                            Kabupaten/Kota tidak boleh kosong
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Kecamatan</label>
                        <input name="kecamatan" type="text" class="form-control" required="">
                        <div class="invalid-feedback">
                            Kecamatan tidak boleh kosong
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Desa/Kelurahan</label>
                        <input name="desa" type="text" class="form-control" required="">
                        <div class="invalid-feedback">
                            Desa/Kelurahan tidak boleh kosong
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" form="posyandu-form" class="btn btn-primary">Simpan</button>
            </div>
            </div>
        </div>
    </div>
<?php $this->load->view('dist/_partials/js'); ?>


<script>
    const titleElm = document.getElementById("title");
    const linkElm = document.getElementById("link");

    function linkFormat() {
        linkElm.value = titleElm.value.toLowerCase().replace(" ", "_")
    }

    $('#exampleModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')

        var modal = $(this)
        modal.find("#modal-id").val(id)
    })
</script>
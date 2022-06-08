<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('dist/_partials/header');
?>
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
        <div class="section-header">
            <h1><?=$title?></h1>
            <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Bayi</a></div>
            <div class="breadcrumb-item"><?=$title?></div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
            <div class="col-12">
                <div class="card">
                <form class="needs-validation" novalidate="" action="<?=base_url("admin/bayi/edit_act")?>" method="post">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <input name="id" type="text" class="form-control" value="<?=$bayi["id"]?>" hidden>
                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input name="nama" type="text" class="form-control" value="<?=$bayi["nama"]?>" required="">
                                    <div class="invalid-feedback">
                                    Nama tidak boleh kosong
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <input name="tanggal_lahir" type="text" class="form-control datepicker" value="<?=$bayi["tanggal_lahir"]?>" required="">
                                    <div class="invalid-feedback">
                                    Tanggal lahir tidak boleh kosong
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Anak Ke</label>
                                    <input name="anak_ke" type="number" class="form-control" value="<?=$bayi["anak_ke"]?>" required="">
                                    <div class="invalid-feedback">
                                    Anak Ke boleh kosong
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <div class="selectgroup w-100">
                                        <label class="selectgroup-item">
                                            <input name="jenis_kelamin" type="radio" name="value" value="Laki-laki" class="selectgroup-input" <?php if ($bayi["jenis_kelamin"] == "Laki-laki") { echo 'checked=""';}?>>
                                            <span class="selectgroup-button">Laki-laki</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input name="jenis_kelamin" type="radio" name="value" value="Perempuan" class="selectgroup-input" <?php if ($bayi["jenis_kelamin"] == "Perempuan") { echo 'checked=""';}?>>
                                            <span class="selectgroup-button">Perempuan</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Berat Badan</label>
                                            <input name="berat_badan" type="number" class="form-control" value="<?=$bayi["berat_badan"]?>" required="" step="any">
                                            <div class="invalid-feedback">
                                            Berat Badan boleh kosong
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Tinggi Badan</label>
                                            <input name="tinggi_badan" type="number" class="form-control" value="<?=$bayi["tinggi_badan"]?>" required="" step="any">
                                            <div class="invalid-feedback">
                                            Tinggi Badan tidak boleh kosong
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="com-12 col-md-6">
                                <div class="form-group">
                                    <label>Nama Ayah</label>
                                    <input name="nama_ayah" type="text" class="form-control" value="<?=$bayi["nama_ayah"]?>" required="">
                                    <div class="invalid-feedback">
                                    Nama Ayah tidak boleh kosong
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Nama Ibu</label>
                                    <input name="nama_ibu" type="text" class="form-control" value="<?=$bayi["nama_ibu"]?>" required="">
                                    <div class="invalid-feedback">
                                    Nama Ibu tidak boleh kosong
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>No Telp Orang Tua</label>
                                    <input name="no_telp_ortu" type="number" class="form-control" value="<?=$bayi["no_telp_ortu"]?>" required="">
                                    <div class="invalid-feedback">
                                    No Telp tidak boleh kosong
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <input name="alamat" type="text" class="form-control" value="<?=$bayi["alamat"]?>" required="">
                                    <div class="invalid-feedback">
                                    Alamat tidak boleh kosong
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>RT/RW</label>
                                    <input name="rt_rw" type="text" class="form-control" value="<?=$bayi["rt_rw"]?>" required="">
                                    <div class="invalid-feedback">
                                    RT/RW tidak boleh kosong
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                    <button class="btn btn-primary">Save</button>
                    </div>
                </form>
                </div>
            </div>
            </div>
        </div>
        </section>
    </div>
<?php $this->load->view('dist/_partials/footer'); ?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('dist/_partials/header');
?>
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
        <div class="section-header">
            <h1>Laporan</h1>
            <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="<?=base_url("admin/dashboard")?>">Admin</a></div>
            <div class="breadcrumb-item">Laporan</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <form id="export-form" action="<?=base_url("admin/laporan/export")?>" method="post">
                            <div class="form-group">
                                <label>Date</label>
                                <input name="date" type="text" class="form-control datepicker" autocomplete="off" value="<?=mdate("%Y-%m", now())?>">
                            </div>
                        </form>
                        <button type="submit" form="export-form" class="btn btn-primary mt-3 ml-3">Export</button>
                    </div>
                <div class="card-body">
                    <?=$this->session->flashdata("message")?>
                    <table class="table table-hover">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Jenis Kelamin</th>
                        <th scope="col">Tanggal Lahir</th>
                        <th scope="col">Nama Ayah</th>
                        <th scope="col">Nama Ibu</th>
                        <th scope="col">Alamat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $index => $bayi) : 
                            $tanggal_lahir = mdate("%d %F %Y", strtotime($bayi["tanggal_lahir"]));
                        ?>
                        <tr>
                        <th scope="row"><?=$index+1?></th>
                        <td><?=$bayi["nama"]?></td>
                        <td><?=$bayi["jenis_kelamin"]?></td>
                        <td><?=$tanggal_lahir?></td>
                        <td><?=$bayi["nama_ayah"]?></td>
                        <td><?=$bayi["nama_ibu"]?></td>
                        <td><?=$bayi["alamat"]?></td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                    </table>
                </div>
                </div>
            </div>
            </div>
        </div>
        </section>
    </div>
<?php $this->load->view('dist/_partials/footer'); ?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('dist/_partials/header');
?>
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
        <div class="section-header">
            <h1>Data Bayi</h1>
            <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="<?=base_url("admin/dashboard")?>">Dashboard</a></div>
            <div class="breadcrumb-item">Data Bayi</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
            <div class="col-12">
                <div class="card">
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
                            <th scope="col">Tindakan</th>
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
                            <td>
                                <span data-toggle="modal" data-target="#exampleModal" data-id="<?=$bayi["id"]?>" data-nama="<?=$bayi["nama"]?>">
                                    <button class="btn btn-sm btn-primary" data-toggle="tooltip" title="Catat Pengukuran"><i class="fas fa-plus"></i></button>
                                </span>
                                <a class="btn btn-sm btn-warning mr-1" href="<?=base_url("admin/bayi/edit/".$bayi["id"])?>" data-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                <a class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete" data-confirm="Hapus Data|Apakah Anda yakin ingin menghapus data <?=$bayi['nama']?>?" data-confirm-yes="window.location.href = '<?=base_url("admin/bayi/hapus/".$bayi["id"])?>'"><i class="fas fa-trash text-white"></i></a>
                                <a href="<?=base_url("admin/bayi/sertifikat/".$bayi["id"])?>" class="btn btn-sm btn-success" data-toggle="tooltip" title="Download Sertifikat"><i class="fas fa-download text-white"></i></a>
                            </td>
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


    <div class="modal fade" tabindex="-1" role="dialog" id="exampleModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Catat Pengukuran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6 id="modal-nama"></h6>
                <form id="pengukuran-form" action="<?=base_url("admin/bayi/catat/")?>" method="post">
                    <input type="text" id="modal-id" name="id" hidden>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Tinggi Badan</label>
                                <input name="tinggi_badan" type="number" class="form-control" required="" step="any">
                                <div class="invalid-feedback">
                                Tinggi badan tidak boleh kosong
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Berat Badan</label>
                                <input name="berat_badan" type="number" class="form-control" required="" step="any">
                                <div class="invalid-feedback">
                                Berat badan tidak boleh kosong
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-2">
                                <label class="custom-switch mt-2">
                                    <input type="checkbox" name="imd" class="custom-switch-input" checked>
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description text-bold">IMD</span>
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="custom-switch">
                                    <input type="checkbox" name="asi" class="custom-switch-input" checked>
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description text-bold">ASI Ekslusif</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- <p>Modal body text goes here.</p> -->
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" form="pengukuran-form" class="btn btn-primary">Simpan</button>
            </div>
            </div>
        </div>
    </div>
<?php $this->load->view('dist/_partials/footer'); ?>

<script>
    $('#exampleModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var nama = button.data('nama')

        var modal = $(this)
        modal.find("#modal-nama").html(nama)
        modal.find("#modal-id").val(id)
    })
</script>
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
            <div class="breadcrumb-item active"><a href="<?=base_url("admin/dashboard")?>">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="<?=base_url("admin/bayi")?>">Bayi</a></div>
            <div class="breadcrumb-item"><?=$title?></div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-3">
                                Nama
                            </div>
                            <div class="col-12 col-md-9">
                                <b><?=$bayi["nama"]?></b>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-3">
                                Tanggal Lahir
                            </div>
                            <div class="col-12 col-md-9">
                                <b><?=mdate("%d %F %Y", strtotime($bayi["tanggal_lahir"]))?></b>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-3">
                                Umur
                            </div>
                            <div class="col-12 col-md-9">
                                <?php
                                    $tanggal_ukur = new DateTime();
                                    $tanggal_lahir = new DateTime($bayi["tanggal_lahir"]);
                                    $interval = $tanggal_lahir->diff($tanggal_ukur);
                                    $umur = $interval->y*12+$interval->m;

                                    echo "<b>".$interval->y." tahun ".$interval->m." bulan ".$interval->d." hari </b>";
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                <div class="card-body">
                    <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tanggal Pencatatan</th>
                            <th scope="col">Tinggi Badan</th>
                            <th scope="col">Berat Badan</th>
                            <th scope="col">Status</th>
                            <th scope="col">ASI</th>
                            <th scope="col">IMD</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pengukuran as $index => $p) : 
                            $tanggal_ukur = mdate("%d %F %Y", strtotime($p["tanggal_ukur"]));
                        ?>
                        <tr>
                            <th scope="row"><?=$index+1?></th>
                            <td><?=$tanggal_ukur?></td>
                            <td><?=$p["tinggi_badan"]?></td>
                            <td><?=$p["berat_badan"]?></td>
                            <td><?=$p["status_berat_badan"]?></td>
                            <td><?=$p["asi"] == 0 ? "Tidak" : "Ya"?></td>
                            <td><?=$p["imd"] == 0 ? "Tidak" : "Ya"?></td>
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
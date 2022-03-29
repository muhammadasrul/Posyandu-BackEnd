<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('dist/_partials/header');
?>
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
        <div class="section-header">
            <h1>Tambah Article</h1>
            <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Admin</a></div>
            <div class="breadcrumb-item"><a href="#">Blog</a></div>
            <div class="breadcrumb-item">Tambah Article</div>
            </div>
        </div>

        <div class="section-body">
            <!-- <h2 class="section-title">Editor</h2>
            <p class="section-lead">WYSIWYG editor and code editor.</p> -->
            <div class="row">
            <div class="col-12">
                <div class="card">
                <?=$this->session->flashdata("message")?>
                <form action="<?=base_url("admin/blog/tambah_act")?>" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Category</label>
                            <div class="col-sm-11 col-md-6">
                                <select name="category" class="form-control selectric">
                                    <option value="0">--Pilih Category--</option>
                                    <?php foreach ($category as $c) {
                                        echo '<option value="'.$c["id"].'"';
                                        if ($c["id"] == $article["category_id"]) { 
                                            echo 'selected';
                                        }
                                        echo '>'.$c["category"].'</option>';
                                    }?>
                                </select>
                            </div>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button" data-toggle="modal" title="Add Category" data-target="#exampleModal" data-id="<?=$article["id"]?>"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Title</label>
                            <div class="col-sm-12 col-md-7">
                                <input id="title" name="title" type="text" class="form-control" value="<?=$article["title"]?>" onblur="linkFormat()" onkeyup="linkFormat()">
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Image</label>
                            <div class="col-sm-12 col-md-7">
                                <input id="thumb" name="thumb" type="file" class="form-control" required="">
                            </div>
                        </div>
                        <input id="link" name="link" type="text" class="form-control" value="<?=$article["link"]?>" hidden>
                        <input id="id" name="id" type="text" class="form-control" value="<?=$article["id"]?>" hidden>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Content</label>
                            <div class="col-sm-12 col-md-7">
                                <textarea name="content" class="summernote-simple"><?=$article["content"]?></textarea>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                                <button type="submit" class="btn btn-primary">Publish</button>
                            </div>
                        </div>
                    </div>
                </form>
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
                <h5 class="modal-title">Tambah Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6 id="modal-nama"></h6>
                <form id="category-form" action="<?=base_url("admin/blog/tambah_category")?>" method="post">
                    <div class="form-group">
                        <label>Category</label>
                        <input name="category" type="text" class="form-control" required="">
                        <div class="invalid-feedback">
                            Category tidak boleh kosong
                        </div>
                    </div>
                    <input name="id" id="modal-id" type="text" class="form-control" required="" hidden>
                </form>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" form="category-form" class="btn btn-primary">Simpan</button>
            </div>
            </div>
        </div>
    </div>
<?php $this->load->view('dist/_partials/footer'); ?>

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
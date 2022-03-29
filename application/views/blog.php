<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('dist/_partials/header');
?>
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
        <div class="section-header">
            <h1>Articles</h1>
            <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="<?=base_url("admin/dashboard")?>">Admin</a></div>
            <div class="breadcrumb-item"><a href="#">Blog</a></div>
            <div class="breadcrumb-item">Articles</div>
            </div>
        </div>

        <div class="section-body">
            <a href="<?=base_url("admin/blog/tambah")?>" class="btn btn-primary mb-3"><i class="fas fa-plus"></i> New Article</a>
            <div class="card">
                <div class="card-body">
                <?php foreach ($articles as $article) : ?>
                    <ul class="list-unstyled list-unstyled-border">
                        <li class="media">
                            <img class="mr-3" width="50" height="50" src="<?=base_url("uploads/thumb/").$article["thumb"]?>" alt="avatar">
                            <div class="media-body">
                                <a class="btn btn-danger btn-action mb-1 float-right" data-toggle="tooltip" data-confirm="Hapus Article|Apakah Anda yakin ingin menghapus <?=$article['title']?>?" data-confirm-yes="window.location.href = '<?=base_url("admin/blog/hapus/".$article["id"])?>'">Delete</a>
                                <a href="<?=base_url("admin/blog/tambah?id=").$article["id"]?>" class="btn btn-info mb-1 mr-2 float-right">Edit</a>
                                <h6 class="media-title"><a href="<?=base_url("article/read/").$article["link"]?>"><?=$article["title"]?></a></h6>
                                <div class="text-small text-muted"><?=$article["category"]?><div class="bullet"></div>
                                    <span class="text-primary"><?=mdate("%d %F %Y %h:%m:%i", strtotime($article["create_at"]))?></span>
                                </div>
                            </div>
                        </li>
                    </ul>
                <?php endforeach?>
                </div>
            </div>
        </section>
    </div>
<?php $this->load->view('dist/_partials/footer'); ?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('dist/_partials/header');
?>
    <!-- Main Content -->
    <div id="app">
        <section class="section">
            <div class="section-header">
                <h1>Posyandu</h1>
                <div class="section-header-breadcrumb">
                    <a href="<?=base_url("admin/login")?>" class="btn btn-primary">Login</a>
                </div>
            </div> 
            <div class="section-body container">
                <h2 class="section-title">Article</h2>
                <div class="card" style="height: 50vh">
                    <div class="card-body">
                     <div class="alert alert-danger">Belum ada artikel</div>
                    </div>
                </div>
                <div class="row">
                    <?php foreach ($article as $a) :?>
                    <div class="col-12 col-md-4 col-lg-4">
                        <article class="article article-style-c">
                            <div class="article-header">
                                <div class="article-image" data-background="<?=base_url("uploads/thumb/").$a["thumb"]?>"></div>
                            </div>
                            <div class="article-details">
                            <div class="article-category"><a href="<?=base_url("article/category/").$a["category"]?>"><?=$a["category"]?></a> <div class="bullet"></div> <a href="#"><?=$a["create_at"]?></a></div>
                            <div class="article-title">
                                <h2><a href="<?=base_url("article/read/").$a["link"]?>"><?=$a["title"]?></a></h2>
                            </div>
                            <div style="max-height:132px; overflow:hidden;">
                                <?=$a["content"]?>
                            </div>
                                <div class="article-details">
                                    <div class="article-cta">
                                    <a href="<?=base_url("article/read/").$a["link"]?>" class="btn btn-primary">Read More</a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                    <?php endforeach ?>
                </div>
            </div>
        </section>
    </div>
<?php $this->load->view('dist/_partials/footer'); ?>
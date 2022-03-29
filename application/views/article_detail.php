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
                <div class="breadcrumb-item active"><a href="<?=base_url()?>">Home</a></div>
                <div class="breadcrumb-item">Article</div>
            </div>
        </div>

        <div class="row mx-3">
            <div class="col-md-8">
                <article class="article">
                    <div class="article-header">
                        <div class="article-image" data-background="<?=base_url("uploads/thumb/").$article["thumb"]?>">
                        </div>
                    </div>
                    <div class="article-details">
                        <div class="article-category"><a href="<?=base_url("article/category/").$article["category"]?>"><?=$article["category"]?></a> <div class="bullet"></div> <span><?=mdate("%d %F %Y %h:%m:%i", strtotime($article["create_at"]))?></span></div>
                        <div class="article-title">
                            <h2 class="mt-2"><?=$article["title"]?></h2>
                        </div>
                        <p><?=$article["content"]?></p>
                    </div>
                </article>
            </div>

            <div class="col-md-12 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Recent Articles</h4>
                    </div>
                    <div class="card-body">             
                        <ul class="list-unstyled list-unstyled-border">
                            <?php foreach ($articles as $article) :?>
                            <li class="media">
                                <img class="mr-3 rounded-circle" width="50" src="<?=base_url("uploads/thumb/").$article["thumb"]?>" alt="avatar">
                                <div class="media-body" style="max-height:132px; overflow:hidden;">
                                    <a href="<?=base_url("article/read/").$article["link"]?>">
                                        <div class="float-right text-primary"><?=mdate("%d-%m-%Y", strtotime($article["create_at"]))?></div>
                                        <div class="media-title"><?=$article["title"]?></div>
                                        <div class="text-small text-muted"><?=$article["content"]?></div>
                                    </a>
                                </div>
                            </li>
                            <?php endforeach?>
                        </ul>
                        <div class="text-center pt-1 pb-1">
                            <a href="<?=base_url("article")?>" class="btn btn-primary btn-lg btn-round">
                                View All
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </section>
    </div>
<?php $this->load->view('dist/_partials/footer'); ?>
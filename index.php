<?php

require_once('inc/require.php');

if(isset($_GET['id'])) {
    $url_c = new url();
    $url = $url_c->get_url($_GET['id']);
    if($url) {
        header('Location: ' . $url);
    }else{
        include("404.html");
    }
    return;
}

if(!$config['showhome']) {
    include("404.html");
    exit();
}


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no,user-scalable=no">
    <title><?php echo get_config('title') . ' - ' . get_config('subtitle'); ?></title>
    <meta name="keywords" content="<?php echo get_config('keywords'); ?>">
    <meta name="description" content="<?php echo get_config('description'); ?>">
    <meta property="og:description" content="<?php echo get_config('description'); ?>">
    <meta property="og:type" content="acticle">
    <meta property="og:locale" content="zh-CN" />
    <meta property="og:site_name" content="<?php echo get_config('title'); ?>">
    <meta property="og:title" content="<?php echo get_config('title'); ?>">
    <link rel="shortcut icon" href="./assets/img/favicon.ico" />
    <!--     Fonts and icons     -->
    <link href="./assets/css/google.css" rel="stylesheet" />
    <link href="./assets/css/all.min.css" rel="stylesheet">
    <!-- Nucleo Icons -->
    <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link href="./assets/css/blk-design-system.css?v=1.0.0" rel="stylesheet" />

</head>

<body class="index-page">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top navbar-transparent " color-on-scroll="100">
        <div class="container">
            <div class="navbar-translate">
                <a class="navbar-brand" href="#">
                    <span><?php echo get_config('title'); ?></span>
                </a>
                <button class="navbar-toggler navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
           <span class="navbar-toggler-bar bar1"></span>
           <span class="navbar-toggler-bar bar2"></span>
           <span class="navbar-toggler-bar bar3"></span>
         </button>
            </div>
            <div class="collapse navbar-collapse justify-content-end" id="navigation">
                <div class="navbar-collapse-header">
                    <div class="row">
                        <div class="col-6 collapse-brand">
                            <a>
                                <?php echo get_config('title'); ?>
                        </a>
                        </div>
                        <div class="col-6 collapse-close text-right">
                            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                          <i class="tim-icons icon-simple-remove"></i>
                        </button>
                        </div>
                    </div>
                </div>
                <ul class="navbar-nav">
                    <li class="nav-item p-0">
                        <a class="nav-link" rel="tooltip" title="Contact us on Telegram" data-placement="bottom" href="https://t.me/Gdecode_bot" target="_blank">
                            <i class="fab fa-telegram"></i>
                            <p class="d-lg-none d-xl-none">QQ</p>
                        </a>
                    </li>
                    <li class="nav-item p-0">
                        <a class="nav-link" rel="tooltip" title="Like us on Github" data-placement="bottom" href="https://github.com/" target="_blank">
                            <i class="fab fa-github" aria-hidden="true"></i>
                            <p class="d-lg-none d-xl-none">Github</p>
                        </a>
                    </li>
                    <li class="nav-item p-0">
                        <a class="nav-link" rel="tooltip" title="Go to Google" data-placement="bottom" href="https://www.google.com/" target="_blank">
                            <i class="fab fa-google" aria-hidden="true"></i>
                            <p class="d-lg-none d-xl-none">Google</p>
                        </a>
                    </li>
                    <!--<li class="nav-item">-->
                    <!--    <a class="nav-link btn btn-default d-none d-lg-block" href="/">-->
                    <!--        <i class="tim-icons icon-cloud-download-93"></i> Download-->
                    <!--    </a>-->
                    <!--</li>-->
                    
                </ul>
            </div>
        </div>
    </nav>
    <!-- BODY -->
    <div class="wrapper">
        <div class="page-header header-filter">
            <div class="squares square1"></div>
            <div class="squares square2"></div>
            <div class="squares square3"></div>
            <div class="squares square4"></div>
            <div class="squares square5"></div>
            <div class="squares square6"></div>
            <div class="squares square7"></div>
            <div class="container">
                <div class="content-center brand">
                    <div class="loading_box" id="loadingBox" style="display:none">
                        <div class="loadingio-spinner-bean-eater-ogu3728vrsb">
                            <div class="ldio-0phfhqfdnuhi">
                                <div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                                <div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-profile shadow mb-0">
                        <div class="h1 text-neutral my-3">Short Url</div>
                        <div class="form-group row  justify-content-center mx-0">
                            
                            <?php
                            foreach (get_config('domain') as $domain) {
                                $i+=1;
                                $c="";
                                if ($i==1)$c='checked' ;
                                if($domain['state']){
                                    echo '
                                    <div class="form-check form-check-radio">
                                        <label class="form-check-label mx-2">
                                            <input class="form-check-input" type="radio" name="urlType"id="exampleRadios1" value="'.$domain['url'].'" '.$c.'>
                                            <span class="form-check-sign"></span>
                                            '.$domain['url'].'
                                        </label>
                                    </div>
                                    ';
                                }
                            }
                            ?>
                            
                        </div>
                        <div class="col-12">
                            <div class="input-group ">
                                <div class="input-group-prepend ">
                                    <span class="input-group-text "><i class="fa fa-link"></i></span>
                                </div>
                                <input type="text" id="inputContent" class="form-control " placeholder="请输入需要转换的链接">
                            </div>
                        </div>

                        <div class="justify-content-between row mx-0 px-3 mb-2">
                            <div class="row px-0 mx-0 col-lg-5 col-md-6 justify-content-start col-12">
                                <button class="btn btn-info col-12 col-md-4 btn-tooltip" type="button " onclick="checkUrl(document.getElementById('inputContent').value,'toLong')" data-toggle="tooltip" data-placement="bottom" data-container="body" data-animation="true"
                                    title="将短链接还原">还原</button>
                                <!--<button class="btn col-12 col-sm-12 col-md-4 offset-md-1 btn-tooltip" type="button" onclick="getBoard()" data-toggle="tooltip" data-placement="bottom" data-container="body" data-animation="true" title="获取您剪切板的内容到输入框">粘贴</button>-->
                            </div>
                            <button class="btn btn-primary col-md-2 col-12" type="button" onclick="checkUrl(document.getElementById('inputContent').value,'toShort')" data-placement="bottom" data-container="body" data-animation="true" title="将长链接转换为短链接">生成</button>
                        </div>

                        <div class="row justify-content-center mx-0 px-2 col-12" id='resultBox' style="display:none">
                            <div class="text-center  col-12">
                                <div class="h4 text-success my-3">生成结果</div>
                                <h4 class="description" id="resultLink"></h4>
                            </div>
                            <div class="text-center mb-3 col-12">
                                <div class="btn btn-primary btn-round" id="copyLink" data-clipboard-target="#resultLink" data-clipboard-action="copy"></div>
                            </div>
                        </div>
                        <div class="container" id="desBox">
                            <blockquote>
                                <p class="blockquote blockquote-primary">
                                    当前生成的短链接默认时效为<?php echo getTimeHour(get_config('urlendtime') ); ?><br>
                                    <small>本站严禁违法犯罪网站使用。</small>
                                </p>
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="container">
                <div class="col-12 h4 text-neutral text-center">
                    短网址由用户生成，所跳转的内容与本站无关。本站严禁钓鱼，诈骗等一切违法犯罪网站使用，如有发现立刻拉黑封停
                </div>
                <div class="col-12 text-center">
                    <p>Copyright &copy; <?php echo date('Y'); ?> • <a href="/"><?php echo get_config('title'); ?></a></p>
                    <p><a href="http://beian.miit.gov.cn" target='_blank'><?php echo get_config('ipc'); ?></a></p>
                </div>
            </div>
        </footer>
    </div>
    <!--错误提示框-->

    <div class="modal fade" id="errPop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <i class="tim-icons icon-simple-remove"></i>
              </button>
                    <h4 class="title title-up">温馨提示</h4>
                </div>
                <div class="modal-body text-center">
                    <p id="errTip"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary col-12" data-dismiss="modal">确 定</button>
                </div>
            </div>
        </div>
    </div>
    <!--   Core JS Files   -->
    <script src="./assets/js/jquery.min.js"></script>
    <script src="./assets/js/popper.min.js" type="text/javascript"></script>
    <script src="./assets/js/bootstrap.min.js"></script>
    <script src="./assets/js/blk-design-system.min.js?v=1.0.0" type="text/javascript"></script>
    <script src="./assets/js/clipboard.min.js"></script>
    <script src="./assets/js/main.js" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            blackKit.initDatePicker();
            blackKit.initSliders();
        });

        function scrollToDownload() {
            if ($('.section-download').length != 0) {
                $("html, body").animate({
                    scrollTop: $('.section-download').offset().top
                }, 1000);
            }
        }
    </script>

</body>

</html>
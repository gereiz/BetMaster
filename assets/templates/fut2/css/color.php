<?php
header("Content-Type:text/css");
$color1 = $_GET['color1']; // Change your Color Here


function checkhexcolor($color1){
    return preg_match('/^#[a-f0-9]{6}$/i', $color1);
}

if (isset($_GET['color1']) AND $_GET['color1'] != '') {
    $color1 = "#" . $_GET['color1'];
}

if (!$color1 OR !checkhexcolor($color1)) {
    $color1 = "#336699";
}

?>

h1 a:hover, h2 a:hover, h3 a:hover, h4 a:hover, h5 a:hover, h6 a:hover, p a, p a:hover, .text--base, .footer__widget .footer__links li a::before, .header-contact-info li a:hover, .header-contact-info i, .sidebar-menu li a i, .upcoming__item .countdown, .view--all, .view--all:hover, .breadcrumb li a::after, .social__icons-account li a i:hover, .about--list li::before, .how-item .how-thumb, .contact-content ul li a:hover, .contact-thumb, .post__item .post__content .meta__date .meta__item i, .post__item .post__read, .widget__post .widget__post__content span, .cmn--outline--btn, .cookie__wrapper .title, .cookie__wrapper .btn--close {
    color: <?= $color1 ?> !important;
}

.preloader .ball, .social-icons li a:hover, .section__header .section__category::before, .section__header .section__category::after, .footer__widget .social__icons li a:hover, .owl-dots .owl-dot.active, .sidebar__widget-header, .predict__header, .dashboard__item .dashboard__thumb, .cmn--table thead tr th, .social__icons-account li a i, .faq__item .faq__title .right__icon::before, .faq__item .faq__title .right__icon::after, .faq__item.open .faq__title, .referral__item-thumb, .post__item .post__thumb .category, .post__share li a i, .widget.widget__tags ul li a:hover, .widget.widget__tags ul li a.active, .post__tag li a:hover, .post__tag li a.active, .scrollToTop, .video__button, .video__button::before, .video__button::after, .cmn--outline--btn:hover, .cmn--btn, .pagination .page-item a.active, .pagination .page-item span.active, .pagination .page-item.active span, .pagination .page-item.active a, .pagination .page-item:hover span, .pagination .page-item:hover a {
    background: <?= $color1 ?>;
}

.nav--tabs .nav-item .nav-link.active, .predicts li a:focus, .predicts li a:hover, .post__share li a i {
    background: <?= $color1 ?> !important;
}

*::selection, .btn--base, .badge--base, .bg--base {
    background-color: <?= $color1 ?> !important;
}

.cmn--outline--btn:hover {
    border-color: <?= $color1 ?>;
}

.cookie__wrapper .read-policy {
    border: 1px solid <?= $color1 ?>;
}

.post__item .post__content .meta__date {
    border-left: 5px solid <?= $color1 ?>;
}

.post__quote {
    border-left: 3px solid <?= $color1 ?>;
}

@media (max-width: 991px) {
    .menu-area ul li a:hover {
        color: <?= $color1 ?>;
    }
}

@media (min-width: 992px) {
    .menu li .submenu li:hover > a {
        background: <?= $color1 ?>;
    }
}

.cookie__wrapper {
    border-top: 1px solid <?= $color1 ?>50;
}
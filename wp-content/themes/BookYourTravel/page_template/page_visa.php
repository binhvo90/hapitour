<?php
/* Template Name: page visa */

/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage BookYourTravel
 * @since Book Your Travel 1.0
 */
get_header();
BookYourTravel_Theme_Utils::breadcrumbs();
get_sidebar('under-header');

global $bookyourtravel_theme_globals;

$page_id = $post->ID;

$blog_index_id = get_option('page_for_posts');
$page_id = $post->ID;
if ($blog_index_id > 0) {
    $page_id = $blog_index_id;
}

$page_custom_fields = get_post_custom( $page_id);

$page_sidebar_positioning = null;
if (isset($page_custom_fields['page_sidebar_positioning'])) {
    $page_sidebar_positioning = $page_custom_fields['page_sidebar_positioning'][0];
    $page_sidebar_positioning = empty($page_sidebar_positioning) ? '' : $page_sidebar_positioning;
}

$section_class = 'full-width';
$item_class = 'one-fourth';
if ($page_sidebar_positioning == 'both') {
    $section_class = 'one-half';
    $item_class = 'one-half';
} else if ($page_sidebar_positioning == 'left' || $page_sidebar_positioning == 'right') {
    $section_class = 'three-fourth';
    $item_class = 'one-third';
}

?>
<div class="wrapper">
    <!--<nav class="mb-5 float-right"><img src="<?php bloginfo('template_url')?>/images/uploads/logo.png" alt=""></nav>-->
    <span class="title color-default">VISA</span>
    <div class="mb-5"></div>
    <div class="content-1 row mb-5">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12  text-justify">
            <p>Bạn muốn đi du lịch nước ngoài, công tác, học tập hoặc chữa bệnh… cần xin visa nhưng chưa biết bắt đầu từ đâu?</p>
            <p>Có những khái niệm liên quan đến hộ chiếu (passport) hay visa đối với bạn thật mơ hồ, chưa kể những rắc rối trong thủ tục làm bạn “nhức đầu”?!</p>
            <p>Đừng để những khó khăn ban đầu làm ảnh hưởng đến chuyến đi của mình bạn nhé! Dưới đây là một số khái niệm cơ bản sẽ rất hữu ích dành riêng cho bạn:</p>


        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><img src="<?php bloginfo('template_url')?>/images/uploads/xinvisa.jpg" class="w-100" alt=""></div>
    </div>
    <div class="content-2 mb-5 text-justify">
        <h3 class="color-default mb-1">1. VISA CÓ PHẢI LÀ HỘ CHIẾU KHÔNG?</h3>
        <p class="mb-3">Đối với những người chưa từng đi nước ngoài thì rất hay nhầm lẫn visa (thị thực nhập cảnh) và passport là một. Tuy nhiên điều này là không đúng đâu.</p>


        <h3 class="color-default mb-1">2. HỘ CHIẾU LÀ GÌ?</h3>
        <p class="mb-3">Hộ chiếu là giấy chứng nhận do chính phủ một nước cấp để công dân nước đó có quyền xuất cảnh đi nước khác và nhập cảnh lại nước mình.</p>


        <h3 class="color-default mb-1">3. VISA LÀ GÌ?</h3>
        <p>Visa là một con dấu trong hộ chiếu thể hiện rằng một cá nhân được phép nhập cảnh vào một quốc gia/vùng lãnh thổ. Hiện nay, không hẳn cứ đi nước ngoài là phải xin visa mà có những trường hợp được miễn, đó kết quả thỏa hiệp giữa các quốc gia với nhau.</p>
        <p>Hiểu một cách đơn giản, hộ chiếu là giấy tờ được chính phủ một quốc gia cấp cho công dân nước mình, trong khi đó visa là loại giấy tờ của nơi người xin visa muốn nhập cảnh nhưng không phải là công dân nước đó.</p>
        Ví dụ: Bạn là công dân Việt Nam. Bạn muốn nhập cảnh sang Mỹ để du lịch 1 tháng. Bạn cần phải chuẩn bị 2 loại giấy tờ:
        <ul class="mb-3">
            <li>Hộ chiếu do chính phủ Việt Nam cấp xác nhận bạn là công dân Việt Nam hợp pháp và muốn xuất ngoại.</li>
            <li>Visa do chính phủ Mỹ cấp xác nhận cho phép nhập cảnh vào Mỹ du lịch.</li>
            <li>Nếu không có passport bạn sẽ không thể xin được visa. Vì thế bạn buộc phải xin cấp passport trước rồi mới nộp hồ sơ làm visa.</li>
        </ul>

    </div>


    <div class="content-3 text-justify">

        <div class="mb-5 row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <h3 class="color-default mb-3">CÓ NHỮNG LOẠI VISA NÀO?</h3>
                Visa được chia thành 2 loại chính:
                <ul>
                    <li>Visa di dân: Dùng để nhập cảnh và định cư tại một nước theo các diện như Cha mẹ bảo lãnh con cái, diện vợ chồng…</li>
                    <li>Visa không di dân: Dùng nhập cảnh một nước trong khoảng thời gian cho phép, gồm các loại sau: Du lịch; Công tác, làm việc; Kinh doanh; Điều trị, chữa bệnh; Lao động thời vụ; Học tập; Các chương trình trao đổi; Ngoại giao, chính trị.</li>
                </ul>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <img src="<?php bloginfo('template_url')?>/images/uploads/pp.jpeg" alt="" class="w-100">
            </div>
        </div>


        <div class="mb-3 row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-3">
                <img src="<?php bloginfo('template_url')?>/images/uploads/tt.jpg" alt="" class="w-100">
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-3">
                <h3 class="color-default mb-3 text-right">LÀM VISA Ở ĐÂU?</h3>
                <p>Bạn có thể liên hệ trực tiếp với Đại sứ quán hoặc tham khảo thông tin trên website; để biết thêm chi tiết vì mỗi nước có những quy định riêng. Việc xét cấp visa sẽ được quyết định vào thời điểm bạn phỏng vấn; cũng như những gì bạn đã thể hiện trong hồ sơ. Một bộ hồ sơ đầy đủ, chính xác, trung thực sẽ có cơ hội nhận visa cao hơn, còn ngược lại; nếu có bất cứ gì đáng nghi ngờ thì hồ sơ của bạn sẽ bị hủy và thậm chí bạn sẽ không bao giờ được phép đến được quốc gia đó trong tương lai.</p>

                Ngoài việc tự tìm hiểu và nộp hồ sơ xin visa, để đơn giản và thuận tiện hơn, bạn có thể liên hệ HAPI để được hỗ trợ thủ tục từ A-Z và tư vấn trả lời phỏng vấn để có kết quả nhanh chóng và đảm bảo.
            </div>
        </div>


    </div>
    <section class="mnv-tuvan mt-5" id="stepVisa">
        <div class="container">

            <div class="hdWiget text-center">
                <h2 class="color-default">
                    VÌ SAO CHỌN CHÚNG TÔI?
                </h2>
            </div>
            <div class="row">

                <div class="col-lg-3 col-md-6">
                    <span class="circle color-default">01</span>
                    <img src="<?php bloginfo('template_url')?>/images/uploads/01.jpeg" alt="LÀM THỦ TỤC RẤT ĐƠN GIẢN">
                    <h3 class="color-default">LÀM THỦ TỤC RẤT ĐƠN GIẢN</h3>
                    <p>Form điền thông tin đơn giản, nhanh chóng. Thông tin được bảo mật an toàn.</p>
                </div>

                <div class="col-lg-3 col-md-6">
                    <span class="circle color-default">02</span>
                    <img src="<?php bloginfo('template_url')?>/images/uploads/02.jpeg" alt="NHÂN VIÊN TƯ VẤN CHUYÊN NGHIỆP">
                    <h3 class="color-default">NHÂN VIÊN TƯ VẤN CHUYÊN NGHIỆP</h3>
                    <p>Nhân viên sẽ liên hệ lại với bạn trong vòng 4h. <br> Bạn cũng có thể liên hệ qua Hotline: 028.363 66 242</p>
                </div>

                <div class="col-lg-3 col-md-6">
                    <span class="circle color-default">03</span>
                    <img src="<?php bloginfo('template_url')?>/images/uploads/03.jpeg" alt="KHÁCH HÀNG RẤT HÀI LÒNG">
                    <h3 class="color-default">KHÁCH HÀNG RẤT HÀI LÒNG</h3>
                    <p>Một nhân viên giàu kinh nghiệm sẽ đồng hành hỗ trợ bạn suốt quá trình để đảm bảo tỉ lệ cao nhất.</p>
                </div>

                <div class="col-lg-3 col-md-6">
                    <span class="circle color-default">04</span>
                    <img src="<?php bloginfo('template_url')?>/images/uploads/04.jpeg" alt="GIÁ TỐT NHẤT THỊ TRƯỜNG">
                    <h3 class="color-default ">GIÁ TỐT NHẤT THỊ TRƯỜNG</h3>
                    <p>Khách nhận Visa sẽ đến trực tiếp hoặc chuyển phát tận tay (có phát sinh thêm phí vận chuyển)</p>
                </div>

            </div>








            <div class="row hidden-sm hidden-xs">

                <div class="col-lg-4 ">

                    <ul>

                        <li>Hồ sơ tối giản</li>

                        <li>Bảo mật thông tin cao nhất</li>

                        <li>Giải pháp thông minh</li>

                    </ul>

                </div>

                <div class="col-lg-4">

                    <ul>

                        <li>Hỗ trợ tối đa</li>

                        <li>Tư vấn miễn phí</li>

                        <li>Chi phí minh bạch</li>

                    </ul>

                </div>

                <div class="col-lg-4">

                    <ul>

                        <li>Chuẩn bị hồ sơ chuyên nghiệp</li>

                        <li>Xin Visa nhanh</li>

                        <li>Tỷ lệ đạt Visa đến 99%</li>

                    </ul>

                </div>

            </div>


        </div>
    </section>
</div>



<?php get_footer(); ?>
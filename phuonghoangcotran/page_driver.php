<?php
/* Template Name: page driver */

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
<div class="wrapper" id="ticker">
    <!--<nav class="mb-5"><img src="images/logo.png" alt=""></nav>-->
    <span class="title color-default no-border">DỊCH VỤ</span> <br>
    <span class="title color-default font-weight-bold">ĐÓN TIỄN SÂN BAY, BẠN NÊN BIẾT!</span>
    <div class="mb-5"></div>
    <div class="content-1 row mb-5">
        <div class="col-6 text-justify">
            <p>Bạn lần đầu đến TP.HCM, bạn đi một mình, bạn không có người thân, bạn bè ở đây, dù bạn là một người trẻ mạnh mẽ hay một doanh nhân thành đạt, lắm lúc bạn vẫn sẽ có cảm giác bơ vơ, lạc lõng bao quanh ngay tại thời điểm đó.</p>
            <p>Hiểu và lắng nghe bạn, nhiều công ty du lịch hiện nay, cung cấp rất nhiều dịch vụ hay ho, cùng bạn chia sẻ những trải nghiệm thú vị. Dịch vụ thuê xe đón/tiễn tại sân bay là bước đầu trong hành trình giúp bạn khám phá một vùng đất mới một cách trọn vẹn nhất.</p>
        </div>
        <div class="col-6"><img src="<?php bloginfo('template_url')?>/images/uploads/xe-noi-bai-ve-sai-gon-01.JPG" class="w-100" alt=""></div>
    </div>

    <span class="title color-default no-border">SỬ DỤNG DỊCH VỤ </span> <br>
    <span class="title color-default font-weight-bold">"ĐÓN/TIỄN SÂN BAY BẠN" SẼ CÓ NHỮNG ĐẶC QUYỀN SAU!</span>
    <div class="mb-5"></div>
    <div class="content-3 text-justify">
        <div class="mb-5 row">
            <div class="col-12">
                <ul>
                    <li><b>Đúng giờ:</b> Bạn chỉ cần cung cấp thông tin chuyến bay, giờ đón, công ty du lịch sẽ cử người đến đón bạn đúng giờ</li>
                    <li> <b>An toàn:</b>
                        <ul>
                            <li>Các thông tin về chiếc sẽ xe đến đón bạn như Số xe, tên tài xế, số điện thoại tài xế,… sẽ được gửi đến bạn ngay sau khi giao dịch đặt dịch vụ thành công.</li>
                            <li>Nếu bạn vô tình để quên tài sản hoặc không hài lòng về thái độ phục vụ của tài xế, không hài lòng về chất lượng xe, khách hàng hoàn toàn có thể liên hệ với Công ty du lịch để được hỗ trợ.</li>
                        </ul>
                    </li>
                    <li><b>Thoải mái:</b>
                        <ul>
                            <li>Tài xế cầm bảng welcome sẵn sàng đợi bạn.</li>
                            <li>Nếu chuyến bay của bạn bị delay hoặc hành khách cần thời gian để hoàn tất các thủ tục hải quan, xe và tài xế sẽ tiếp tục chờ và đón khách trong khoảng thời gian 2 giờ
                                đồng hồ. Trong trường hợp này, quý khách có thể chủ động liên lạc với tài xế để thông báo tình hình và yêu cầu xe đợi tại sân bay.</li>
                            <li>Bạn sử dụng xe giống như xe nhà của bạn. Không phải lo lắng về đường sá tại TP.HCM.</li>
                            <li>Tài xế biết tiếng Anh, tiếng Trung; có thể tư vấn cho bạn các điểm đến hấp dẫn tại TP.HCM hoặc các địa điểm khác tùy theo nhu cầu.</li>
                        </ul>

                    </li>
                    <li><b>Chi phí rõ ràng:</b> Khi xác nhận yêu cầu đặt xe, khách hàng sẽ được thông báo về mức cước phí cần phải thanh toán. Ngoài số tiền đã được thông báo, khách hàng sẽ không phải chi trả
                        thêm bất kỳ một khoản chi phí nào khác.</li>
                </ul>
                <p>Do đó, để chuyến đi được trọn vẹn, tránh mọi phiền hà trong việc chờ đợi từ sân bay, hãy liên hệ HAPITOUR và sử dụng DỊCH VỤ ĐÓN TIỄN SÂN BAY của chúng tôi. HAPITOUR hân hạnh cung cấp dịch vụ cho thuê xe đón/tiễn sân bay đạt chuẩn cao, phục vụ khách du lịch, có thể đáp ứng nhu cầu của nhiều đối tượng khách hàng, từ khách cá nhân, khách gia đình, khách doanh nghiệp hay các đoàn đại biểu với số lượng lớn.</p>
            </div>

        </div>
    </div>

    <div class="mt-5"></div>
    <span class="title color-default font-weight-bold"> BẢNG GIÁ XE ĐÓN TIỄN TẠI SÂN BAY TÂN SƠN NHẤT</span>
    <div class="mb-5"></div>

    <div class="content-2 mb-5 text-justify">
        <?php echo do_shortcode( '[contact-form-7 id="91" title="quote"]' );?>

    </div>

    <span class="title color-default font-weight-bold"> QUY ĐỊNH ĐỐI VỚI DỊCH VỤ ĐÓN TIỄN SÂN BAY:</span>
    <div class="mb-5"></div>

    <div class="content-2 mb-5 text-justify">
        <ul>
            <li><b>Thời gian: </b>2 tiếng</li>
            <li><b>Km:</b> 20 km</li>
            <li>Lộ trình chỉ bao gồm tuyến đón từ sân bay và đưa về khách sạn hoặc ngược lại, không bao gồm việc dừng đỗ để tham quan, mua sắm, làm việc…</li>
            <li>Báo giá bao gồm phí bến bãi đậu theo thời gian quy định.</li>
            <li>Báo giá áp dụng đối với các khách sạn thuộc trung tâm TP.HCM. Đối với các điểm đón/trả thuộc ngoại vi trung tâm TP.HCM.</li>
            <li>Báo giá có thể thay đổi tùy theo tình hình biến động trên thị trường, giá xăng dầu, các dịp cao điểm Lễ Tết... Đơn giá: VND/xe/chuyến</li>
        </ul>

    </div>


    <?php echo do_shortcode( ' [contact-form-7 id="7096" title="Đưa Tiễn Sân Bay"]' );?>
</div>



<?php get_footer(); ?>
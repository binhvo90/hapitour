<?php
/* Template Name: page ticker */

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
    <span class="title color-default no-border">ĐẶT VÉ QUA ĐẠI LÝ</span> <br>
    <span class="title color-default font-weight-bold">TƯỞNG KHÔNG LỢI MÀ LỢI KHÔNG TƯỞNG!</span>
    <div class="mb-5"></div>
    <div class="content-1 row mb-5">
        <div class="col-lg-6 col-md-6 text-justify">
            <p>Ngày nay, việc di chuyển bằng máy bay dần trở thành phương tiện được nhiều người lựa chọn vì ưu điểm nhanh chóng, an toàn và giá thành cũng tương đối hợp lý bởi thị trường có sự tham gia của rất nhiều hãng hàng không mới. </p>
            <p>Cùng với sự phát triển của công nghệ, thay vì bạn phải mua qua hãng hoặc đại lý, hành khách giờ đây còn có thể đặt vé thông qua các trang mạng trực tuyến. </p>
            <p>Việc e ngại vì không biết phải mua vé máy bay ở đâu, nên mua từ hãng hàng không hay mua qua đại lý? Có nên mua vé máy bay trực tuyến không? Đó đều là những thắc mắc thường gặp kể cả với hành khách đã từng hoặc chưa bao giờ đi máy bay. </p>

        </div>
        <div class="col-lg-6 col-md-6"><img src="<?php bloginfo('template_url')?>/images/uploads/ve-may-bay.jpg" class="w-100" alt=""></div>
    </div>

    <span class="title color-default no-border">MỘT VÀI THÔNG TIN NHỎ</span> <br>
    <span class="title color-default font-weight-bold">HI VỌNG SẼ GIÚP BẠN ĐƯA RA QUYẾT ĐỊNH HỢP LÝ!</span>
    <div class="mb-5"></div>
    <div class="content-3 text-justify">
        <div class="mb-5 row">
            <div class="col-lg-6 col-md-6">
                <h3 class="color-default mb-3">VÉ MÁY BAY ĐƯỢC BÁN Ở ĐÂU?</h3>
                <ul>
                    <li>Văn phòng đại diện của hãng tại sân bay.</li>
                    <li>Bán trực tuyến thông qua trang điện tử của hãng, các ứng dụng bán vé máy bay.</li>
                    <li>Các đại lý, phòng vé của hãng. </li>
                </ul>
            </div>
            <div class="col-lg-6 col-md-6">
                <img src="<?php bloginfo('template_url')?>/images/uploads/vemb.jpg" alt="" class="w-100">
            </div>
        </div>


        <div class="mb-3 row">
            <div class="col-lg-6 col-md-6 mb-5">
                <img src="<?php bloginfo('template_url')?>/images/uploads/giare.jpg" alt="" class="w-100">
            </div>
            <div class="col-lg-6 col-md-6 mb-5">
                <h3 class="color-default mb-3">NÊN ĐẶT MUA VÉ MÁY BAY Ở ĐÂU?</h3>
                <ul>
                    <li>Nếu hành khách có nhiều thời gian và thuận tiện trong việc di chuyển có thể đến trực tiếp quầy vé của hãng tại sân bay để mua vé.</li>
                    <li>Với những hành khách hiểu biết và sử dụng mạng internet thành tạo có thể đặt mua vé máy bay trực tuyến trên website của hãng hoặc các ứng dụng cung cấp vé máy bay rất phổ biến hiện nay.</li>
                    <li>Còn những hành khách lần đầu đi máy bay hoặc không có nhiều thời gian thì tốt nhất nên lựa chọn hình thức mua vé thông qua đại lý. </li>
                </ul>

            </div>
        </div>


    </div>

    <span class="title color-default no-border">MỘT VÀI LÝ DO VÀ LỢI ÍCH GIÚP BẠN DẸP TAN SUY NGHĨ:</span> <br>
    <span class="title color-default font-weight-bold"> "MUA QUA TRUNG GIAN ĐẠI LÝ LÚC NÀO PHÍ CŨNG CAO HƠN"</span>
    <div class="mb-5"></div>

    <div class="content-2 mb-5 text-justify">
        <h3 class="color-default mb-1">1.	Mua vé máy bay tại sân bay: </h3>
        <p class="mb-3">Sẽ mất nhiều thời gian và công sức của hành khách khi bạn phải đến trực tiếp sân bay mà không hề biết chuyến bay mình mong muốn còn chỗ hay không. Thêm vào đó, vé máy bay được bán tại sân bay (thường được gọi là vé giờ chót) sẽ được bán với mức giá phổ thông (Economy Class) hoặc (Business Class) cao nhất trên bảng giá niêm yết của hãng, nên việc mua tại sân bay không phải là sự lựa chọn ưu tiên, trừ khi bạn không có sự lựa chọn nào khác.</p>


        <h3 class="color-default mb-1">2.	Đặt vé trực tuyến:</h3>
        <p class="mb-3">Nếu hành khách không thành tạo các thao tác sẽ mất rất nhiều thời gian ở khâu lựa chọn hành trình và thanh toán. Nhiều khi việc thanh toán trực tuyến gặp trục trặc, tài khoản bị trừ tiền nhưng vé thì chưa mua được. Trường hợp bị hủy chuyến, thay đổi thông tin trên vé máy bay hầu như hành khách không được hỗ trợ nhiều mà phải tự xoay xở bằng cách liên hệ trực tiếp với các tổng đài tự động của hãng, và tổng đài thì không phải lúc nào cũng kết nối được. Các trường hợp như hành khách muốn hoãn chuyến bay, đổi chuyến bay, sửa thông tin trên vé máy bay (sai tên) là rất khó khăn hoặc không thể.</p>


        <h3 class="color-default mb-1">3.	Mua vé tại đại lý: </h3>
        <p>Nhanh chóng và an toàn hơn. Một trong những ưu điểm vượt trội của việc mua vé qua đại lý nữa là: Có nhiều lựa chọn. Nếu một hãng chỉ bán duy nhất vé máy bay của hãng đó, thì khi mua qua đại lý, quý khách hàng sẽ được đa dạng hoá sự lựa chọn của mình, bởi một đại lý thì thường bán rất nhiều hãng, và nhân viên sẽ tư vấn cho quý khách lựa chọn hãng với khung giờ bay và mức giá phù hợp nhất. Đó là lý do vì sao mà trong trường hợp này, mua vé tại đại lý là phương thức lựa chọn tối ưu hơn cả.</p>
        <p class="mb-3">Hình thức mua vé ở đại lý rất đa dạng: Cách thứ nhất là đến trực tiếp tại phòng vé, thứ 2 là có thể đặt mua vé qua điện thoại hoặc đặt vé trực tuyến thông qua hệ thống website của đại lý. Thêm vào đó, quý khách hàng cũng có thể linh hoạt hình thức thanh toán bằng tiền mặt, cà thẻ hoặc chuyển khoản… Đối với cách mua qua hãng, quý khách chỉ có một cách duy nhất là thanh toán bằng tiền mặt tại văn phòng hãng.</p>

        <h3 class="color-default mb-1">4.	Đại lý chính là văn phòng đại diện của hãng: </h3>
        <p>Được hãng hàng không ủy quyền bán vé nhằm mở rộng mạng lưới, tiếp cận gần hơn với khách hàng. Chính vì thế hành khách hoàn toàn an tâm về giá vé và việc mua vé thông qua đại lý, không hề có sự chênh lệch về giá vé như nhiều người vẫn nghĩ.</p>

        <p class="mb-3">Đối với vé máy bay tất cả đều có biểu giá quy định chung: Dù bạn mua của hãng hay mua của đại lý thì cũng chỉ có một giá chung duy nhất tính cho cùng một thời điểm. Thay vì các bạn thanh toán qua cổng ngân hàng mất 55.000 đồng tiền phí hoặc thẻ visa mất 2% phí chuyển đổi tiền tệ (nếu có) nếu bạn booking online; trường hợp bạn đặt qua đại lý thì cũng với chi phí tương đương, và khoản tiền đó hãng sẽ trích lại cho đại lý, xem như là phí dịch vụ đại lý được hưởng.</p>

        <h3 class="color-default mb-1">5.	Đại lý có đội ngũ nhân viên là những người nắm rõ về các quy định của hãng :</h3>
        <p class="mb-3">luôn sẵn sàng tư vấn giải đáp mọi thắc mắc của khách hàng liên quan đến chuyến bay cho hành khách. Họ sẽ là người hướng dẫn cụ thể và chi tiết để hành khách có được một hành trình an toàn và thuận lợi và tiết kiệm nhất. Những tiện ích như thay đổi tên, thay đổi hành trình, dịch vụ cộng thêm (add hành lý, trẻ em, chọn chỗ ngồi…) sẽ được đại lý hỗ trợ một cách nhanh chóng. Ngoài ra, khi mua vé ở đại lý hành khách còn được hỗ trợ một số thay đồi mà chỉ đại lý mới làm được ví dụ như hổ trợ bán lại vé của các hãng Vietjet Air, Jetstar Pacific và vé khuyến mãi của Vietnam Airlines, giúp hành khách không mất toàn bộ chi phí cho hành trình đã hủy. Nếu mua vé qua mạng hoặc qua hãng, những trường hợp đó, quý khách sẽ phải hoàn vé (nếu điều kiện cho phép) hoặc bỏ luôn vé và mất 100% tiền nếu mua phải vé khuyến mãi. </p>


        <h3 class="color-default mb-1">6.	Tránh sai sót khi đặt vé quốc tế: </h3>
        <p class="mb-3">Với vé máy bay quốc tế, có những chặng quá cảnh nhiều lần, mỗi lần quá cảnh sẽ có nhiều phức tạp, nhất là khi quá cảnh tại một nơi xa lạ, không cùng ngôn ngữ. Bạn tự đặt thì bạn sẽ phải am hiểu kỹ các chặng & hành trình của các hãng. Còn khi khi liên hệ đến đại lý, bạn sẽ được tư vấn miễn phí đi hành trình nào, hãng nào là tốt nhất cho bạn. </p>


        <h3 class="color-default mb-1">7.	Đặt vé đoàn: </h3>
        <p class="mb-3">Các hệ thống đặt vé trên mạng về cơ bản chỉ cho phép bạn đặt số lượng dưới 10 người, trường hợp bạn đặt vé máy bay đoàn đông người bay rất khó để bạn có thể tự đặt vé. Đại lý thường có chính sách giá vé đoàn tốt hơn khi bạn tự book vé lẻ, cũng như hỗ trợ bạn xử lý các vấn đề phát sinh, mà nhất là khi đoàn đông thì thông tin sai lệch về khách bay rất dễ xảy ra, nếu bạn không có chuyên môn & thạo việc thì sẽ rất mệt đấy.</p>

        <h3 class="color-default mb-1">8.	Thanh toán:</h3>
        <p class="mb-3">Thanh toán vé máy bay online trực tiếp cho hãng nếu chẳng may hãng bảo không nhận được tiền thì các hành khách xác định là khiếu nại mệt mỏi, bạn thậm chí còn không biết khiếu nại cho ai nếu vé bạn mua là của các hãng nước ngoài. Tệ hơn nếu là vé nước ngoài bạn thanh toán qua visa ngoài phí xuất vé bạn còn bị tính phí chuyển đổi tiền tệ 2-3%. Một số hãng máy bay quốc tế lại còn bắt bạn chứng thực chủ thẻ trong quá trình check in, trường hợp nếu bạn mà không có thẻ visa mà mượn thẻ của bạn bè thanh toán cũng được thì xác định là bỏ vé tại sân bay nếu không rành vấn đề này. </p>

        <h3 class="color-default mb-1">9.	Đặt vé giá rẻ:</h3>
        <p class="mb-3">Nếu giá chuyến bay quá cao, hay bạn cần vé rẻ, đừng ngần ngại liên hệ đại lý. Là người hiểu về nghiệp vụ, đại lý hoàn toàn có đủ kinh nghiệm để tìm cho bạn một chiếc vé hợp lý ở bất kỳ thời điểm nào. Với những vé như thế này, thông thường đại lýsẽ tính phí cao hơn mức bình thường, điều đó là hoàn toàn hợp lý. </p>

        <h3 class="color-default mb-1">10.	Sự cố thủ tục trước chuyến bay:</h3>
        <p class="mb-3">Đôi lúc chúng ta trễ giờ, quên CMND hoặc không mang giấy khai sinh cho con, … Đây là tình huống thường xuyên xảy ra và xác định là bạn sẽ gặp vô cùng phiền phức, ảnh hưởng không nhỏ đến tâm trạng của chuyến đi. Những lúc như thế này, vai trò của đại lý là vô cùng cần thiết, họ sẽ trở thành luật sư để bảo vệ quyền lợi, tiền bạc của bạn trước hãng, tránh tổn thất một cách tối đa cho bạn. </p>

    </div>
    <p>Trên đây là một số dịch vụ mà bạn được phục vụ nếu đặt vé thông qua đại lý với mức phí tương đương với việc bạn đặt vé online. Hy vọng những thông tin trên đã giúp bạn có cái nhìn toàn cảnh về các phương thức book vé hiện nay.</p>
    <p>Để đảm bảo quyền lợi và chắc chắn có trong tay chiếc vé máy giá tốt nhất, hãy lựa chọn đặt mua vé tại những đại lý uy tín. HAPITOUR rất hân hạnh được giúp bạn có được chiếc vé máy bay ưng ý nhất với giá vé tốt nhất.</p>

    <div class="mt-5"></div>
    <div class="title color-default no-border text-center">Hãy để HAPITOUR lập kế hoạch cho hành trình hoàn hảo của bạn!</div> <br>

</div>


<?php get_footer(); ?>

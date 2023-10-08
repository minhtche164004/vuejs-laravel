<template>
  <body>
    <div class="row main" style="width: 100%;">
      <Itemcategory />
      <div class="dif col-lg-8">
        <Carousel />
        <Devices />
      </div>
    </div>
    <div class="row tag">
      <div class="col-lg-3 row itemss">
        <div class="col-3">
          <img src="https://www.sieuthimaytinhlangson.com/uploads/logo_banner/1676951970_icon-cs.png.png" alt="">
        </div>
        <div class="col-9">
          <div style="color: #ef233c;font-weight: bold;width: 110%;">GIAO HÀNG TOÀN QUỐC</div>
          <div class="i">Nhận hàng từ 1-3 ngày</div>
        </div>
      </div>
      <div class="col-lg-3 row itemss">
        <div class="col-3">
          <img src="https://www.sieuthimaytinhlangson.com/uploads/logo_banner/1676951970_icon-cs-2.png.png" alt="">
        </div>
        <div class="col-9">
          <div style="color: #ef233c;font-weight: bold;width: 110%;">DỊCH VỤ CHUYÊN NGHIỆP</div>
          <div class="i">Tư vấn hỗ trợ tận tình</div>
        </div>
      </div>
      <div class="col-lg-3 row itemss">
        <div class="col-3">
          <img src="https://www.sieuthimaytinhlangson.com/uploads/logo_banner/1676951970_icon-cs-3.png.png" alt="">
        </div>
        <div class="col-9">
          <div style="color: #ef233c;font-weight: bold;">HOTLINE 08 888 03 999</div>
          <div class="i">Kỹ thuật: 083 84 85 888</div>
        </div>
      </div>
      <div class="col-lg-3 row itemss">
        <div class="col-3">
          <img src="https://www.sieuthimaytinhlangson.com/uploads/logo_banner/1677836417_1676951970_icon-cs-4.png.png.png"
            alt="">
        </div>
        <div class="col-9">
          <div style="color: #ef233c;font-weight: bold;">BẢO ĐẢM CHẤT LƯỢNG</div>
          <div class="i">Sản phẩm chính hãng, có VAT</div>
        </div>
      </div>
    </div>
    <div class="banner">
      <div class="banner-img">
        <img src="https://www.sieuthimaytinhlangson.com/uploads/brands/1676881120_logo.jpg" alt="">
      </div>
      <div class="banner-img">
        <img src="https://www.sieuthimaytinhlangson.com/uploads/brands/1676881168_logo.jpg" alt="">
      </div>
      <div class="banner-img">
        <img src="https://www.sieuthimaytinhlangson.com/uploads/brands/1676881181_logo.jpg" alt="">
      </div>
      <div class="banner-img">
        <img src="https://www.sieuthimaytinhlangson.com/uploads/brands/1676881202_logo.jpg" alt="">
      </div>
    </div>
    <div class="more-info">
      <div class="container">
        <div class="row">
          <div class="about-us col-lg-4">
            <div class="text">
              Về chúng tôi
            </div>
            <div class="">
              CHUYÊN PHÂN PHỐI PHỤ KIỆN MÁY TÍNH, LAPTOP, MACBOOK, SURFACE
            </div>
            <div class="fa fa-map-marker">
              Số 386 đường Bà Triệu, p. Vĩnh Trại, tp. Lạng Sơn, tỉnh Lạng Sơn
            </div>
            <div class="fa fa-phone">
              Hotline: 08 888 03 999
            </div><br>
            <div class="fa fa-envelope">
              Email: sieuthimaytinhls@gmail.com
            </div>
            <div class="fa fa-globe">
              Website: https://sieuthimaytinhlangson.com
            </div>
          </div>
          <div class="policy col-lg-4">
            <div class="text">
              Chính sách
            </div>
            <div class="fa fa-caret-right">
              Mua hàng & Thanh toán
            </div><br>
            <div class="fa fa-caret-right">
              Chính sách giao hàng
            </div><br>
            <div class="fa fa-caret-right">
              Chính sách bảo mật
            </div><br>
            <div class="fa fa-caret-right">
              Sản phẩm mới
            </div><br>
            <div class="fa fa-caret-right">
              Sản phẩm Hot
            </div>
          </div>
          <div class="map col-lg-4">
            <div class="text">
              BẢN ĐỒ CHỈ ĐƯỜNG
            </div>
            <div style="padding-top: 10px;">
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1510.259009812822!2d105.775253201375!3d21.029979361326017!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x313454b15bca0999%3A0x4a21a3d9b00a7f3b!2zTeG7uSDEkMOsbmggUGxhemEsIFAuIFRy4bqnbiBCw6xuaCwgTeG7uSDEkMOsbmgsIFThu6sgTGnDqm0sIEjDoCBO4buZaSwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1692472068771!5m2!1svi!2s"
                width="300" height="174" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <!-- <button type="button" @click="hello">Click</button> -->
          </div>
        </div>
      </div>
    </div>
  </body>
</template>

<script>
// @ is an alias to /src
import HelloWorld from '@/components/HelloWorld.vue';
import Itemcategory from '@/components/Home/Itemcategory.vue'
import Devices from '@/components/Home/Devices.vue'
import Carousel from '@/components/Home/Carousel.vue'
import numeral from 'numeral';
import { useToast } from 'vue-toastification'
export default {
  name: 'HomeView',
  components: {
    HelloWorld, Itemcategory, Devices, Carousel
  },
  methods: {
    toastMessage() {
      
    },
    created() {
      
    },
  }
}
</script>

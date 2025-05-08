<link rel="stylesheet" href="css/style.css" />

<?php include 'header.php'; ?>
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

<!-- สไลด์ -->
<div class="custom-swiper swiper">
  <div class="swiper-wrapper">
    <div class="swiper-slide"><img src="/LAB/image/1.jpg" alt=""></div>
    <div class="swiper-slide"><img src="/LAB/image/2.jpg" alt=""></div>
    <div class="swiper-slide"><img src="/LAB/image/3.jpg" alt=""></div>
  </div>
  <div class="swiper-pagination"></div>

</div>

<!-- Swiper JS -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script style>
  const swiper = new Swiper('.swiper', {
    loop: true,
    autoplay: {
      delay: 3000,
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  });
</script>

<style>
  .custom-swiper {
    width: 80%;
    max-width: 900px;
    height: 400px;
    margin: 50px auto;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    background: #fff;
  }

  .custom-swiper .swiper-slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
</style>

<!-- ส่วนโชว์สินค้า -->
<section class="product-showcase">
  <h2>สินค้าแนะนำ</h2>
  <div class="products">
    <div class="product-card">
      <img src="/LAB/images/product1.jpg" alt="Product 1">
      <h3>สินค้า 1</h3>
      <p>รายละเอียดสั้นๆ ของสินค้า 1</p>
    </div>
    <div class="product-card">
      <img src="/LAB/images/product2.jpg" alt="Product 2">
      <h3>สินค้า 2</h3>
      <p>รายละเอียดสั้นๆ ของสินค้า 2</p>
    </div>
    <div class="product-card">
      <img src="/LAB/images/product3.jpg" alt="Product 3">
      <h3>สินค้า 3</h3>
      <p>รายละเอียดสั้นๆ ของสินค้า 3</p>
    </div>
    <div class="product-card">
      <img src="/LAB/images/product4.jpg" alt="Product 4">
      <h3>สินค้า 4</h3>
      <p>รายละเอียดสั้นๆ ของสินค้า 4</p>
    </div>
    <div class="product-card">
      <img src="/LAB/images/product5.jpg" alt="Product 5">
      <h3>สินค้า 5</h3>
      <p>รายละเอียดสั้นๆ ของสินค้า 5</p>
    </div>
    <div class="product-card">
      <img src="/LAB/images/product6.jpg" alt="Product 6">
      <h3>สินค้า 6</h3>
      <p>รายละเอียดสั้นๆ ของสินค้า 6</p>
    </div>
  </div>
</section>

<?php include 'footer.php'; ?>





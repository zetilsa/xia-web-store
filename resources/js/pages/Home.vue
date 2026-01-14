<template>
  <!-- Hero Section -->
  <section class="hero">
    <div class="container text-center">
      <h1 class="display-4 fw-bold">Belanja Produk Terbaik</h1>
      <p class="lead mb-4">Dapatkan promo dan diskon menarik setiap hari.</p>
      <a href="#products" class="btn btn-danger btn-lg px-4">Belanja Sekarang</a>
    </div>
  </section>

  <!-- Categories Section -->
  <section class="py-5">
    <div class="container">
      <h2 class="fw-bold mb-4 text-center">Kategori Populer</h2>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="card category-card shadow-sm border-0">
            <img src="https://images.unsplash.com/photo-1512436991641-6745cdb1723f" class="card-img-top" />
            <div class="card-body text-center">
              <h5 class="card-title fw-bold">Fashion</h5>
            </div>
          </div>\
        </div>
        <div class="col-md-4">
          <div class="card category-card shadow-sm border-0">
            <img src="https://canyon.eu/blog/wp-content/uploads/2023/11/RS20439_IMG_2919-scr-1.jpg" class="card-img-top" />
            <div class="card-body text-center">
              <h5 class="card-title fw-bold">Gadgets</h5>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card category-card shadow-sm border-0">
            <img src="https://m.media-amazon.com/images/I/51UJ2fP8AdL._AC_UF894,1000_QL80_.jpg" class="card-img-top" />
            <div class="card-body text-center">
              <h5 class="card-title fw-bold">Home Living</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Featured Products -->
  <section id="products" class="py-5 bg-light">
    <div class="container">
      <h2 class="fw-bold mb-4 text-center">Produk Unggulan</h2>
      <div class="row g-4">
      <div
        class="col-md-3"
        v-for="product in featuredProducts"
        :key="product.id"
      >
        <div class="card product-card shadow-sm border-0">
          <img
            :src="getImageUrl(product.image_path)"
            class="card-img-top"
            alt="product"
          />
          <div class="card-body text-center">
            <h5 class="fw-bold">{{ product.name }}</h5>
            <p class="text-muted">
              Rm {{ formatPrice(product.price) }}
            </p>
            <button class="btn btn-outline-danger">
              Lihat Detail
            </button>
          </div>
        </div>
      </div>
    </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="py-4 bg-dark text-white text-center">
    <p class="mb-0">&copy; 2025 E-Commerce Store. All rights reserved.</p>
  </footer>
</template>

<style>
    .hero {
      background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('https://ygo-assets-websites-editorial-emea.yougov.net/images/GettyImages-1656866337.original.jpg') center/cover no-repeat;
      height: 80vh;
      display: flex;
      align-items: center;
      color: white;
    }
    .category-card:hover {
      transform: translateY(-5px);
      transition: 0.3s;
    }
    .product-card:hover {
      transform: translateY(-5px);
      transition: 0.3s;
    }

    .product-card img {
        height: 250px;     /* atau ukuran lain */
  object-fit: cover;
  width: 100%;
  border-radius: 8px;
    }

    .category-card img {
  height: 250px;     /* atau ukuran lain */
  object-fit: cover;
  width: 100%;
  border-radius: 8px;
}

  </style>
  <script>
import axios from "axios";

export default {
  name: "Home",

  data() {
    return {
      products: []
    };
  },

  computed: {
    featuredProducts() {
      return this.products.slice(0, 4); // ambil 4 produk
    }
  },

  mounted() {
    this.fetchProducts();
  },

  methods: {
    async fetchProducts() {
      try {
        const res = await axios.get("http://127.0.0.1:8000/api/products");
        this.products = res.data.data || res.data;
      } catch (error) {
        console.error("Gagal fetch produk", error);
      }
    },

    getImageUrl(path) {
      return `http://127.0.0.1:8000/storage/${path}`;
    },

    formatPrice(value) {
      return new Intl.NumberFormat("id-ID").format(value);
    }
  }
};
</script>



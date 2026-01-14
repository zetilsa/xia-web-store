<template>
  <div class="container py-5" v-if="product">
    <div class="row g-4">

      <!-- IMAGE -->
      <div class="col-md-6">
        <div class="card shadow-sm">
          <img
            :src="imageUrl(product.image_path)"
            class="img-fluid rounded"
            alt="Product Image"
          />
        </div>
      </div>

      <!-- DETAIL -->
      <div class="col-md-6">
        <h2 class="fw-bold">{{ product.name }}</h2>

        <h4 class="text-primary my-3">
          Rp {{ formatPrice(product.price) }}
        </h4>

        <p class="text-muted">
          Stock tersedia: <b>{{ product.stock }}</b>
        </p>

        <hr />

        <p class="lh-lg">
          {{ product.description }}
        </p>

        <button class="btn btn-primary mt-3 px-4">
          Beli Sekarang
        </button>
      </div>

    </div>
  </div>

  <!-- LOADING -->
  <div v-else class="text-center py-5">
    Loading...
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "ProductShow",

  data() {
    return {
      product: null,
    };
  },

  mounted() {
    this.fetchProduct();
  },

  methods: {
    async fetchProduct() {
      try {
        const res = await axios.get(
          `http://127.0.0.1:8000/api/products/${this.$route.params.id}`
        );

        this.product = res.data.data;
      } catch (err) {
        console.error(err);
        alert("Produk tidak ditemukan");
        this.$router.push("/");
      }
    },

    imageUrl(path) {
      return `http://127.0.0.1:8000/storage/${path}`;
    },

    formatPrice(value) {
      return new Intl.NumberFormat("id-ID").format(value);
    },
  },
};
</script>

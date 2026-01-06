<template>
  <div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="fw-bold">Dashboard Produk</h2>
      <button class="btn btn-primary" @click="openCreateModal">Tambah Produk</button>
    </div>

    <!-- ALERT -->
    <div v-if="alert" class="alert alert-info py-2">{{ alert }}</div>

    <!-- TABLE -->
    <div class="card shadow-sm">
      <div class="card-body p-0">
        <table class="table table-striped mb-0">
          <thead class="table-light">
            <tr>
              <th>ID</th>
              <th>Nama</th>
              <th>Harga</th>
              <th>Stok</th>
              <th class="text-end">Aksi</th>
            </tr>
          </thead>

          <tbody>
            <tr v-for="item in products" :key="item.id">
              <td>{{ item.id }}</td>
              <td>{{ item.name }}</td>
              <td>Rp {{ item.price.toLocaleString() }}</td>
              <td>{{ item.stock }}</td>
              <td class="text-end">
                <button class="btn btn-warning btn-sm me-1" @click="openEditModal(item)">Edit</button>
                <button class="btn btn-danger btn-sm" @click="deleteProduct(item.id)">Hapus</button>
              </td>
            </tr>

            <tr v-if="products.length === 0">
              <td colspan="5" class="text-center py-4">Belum ada produk.</td>
            </tr>

          </tbody>
        </table>
      </div>
    </div>

    <!-- MODAL -->
    <div class="modal fade show" v-if="showModal" style="display:block; background: rgba(0,0,0,0.5);">
      <div class="modal-dialog">
        <div class="modal-content">

          <div class="modal-header">
            <h5 class="modal-title">{{ editMode ? "Edit Produk" : "Tambah Produk" }}</h5>
            <button class="btn-close" @click="closeModal"></button>
          </div>

          <div class="modal-body">

            <div class="mb-3">
              <label class="form-label">Nama Produk</label>
              <input type="text" class="form-control" v-model="form.name">
            </div>

            <div class="mb-3">
              <label class="form-label">Harga</label>
              <input type="number" class="form-control" v-model="form.price">
            </div>

            <div class="mb-3">
              <label class="form-label">Stok</label>
              <input type="number" class="form-control" v-model="form.stock">
            </div>

          </div>

          <div class="modal-footer">
            <button class="btn btn-secondary" @click="closeModal">Batal</button>
            <button class="btn btn-primary" @click="submitForm">
              {{ editMode ? "Update" : "Simpan" }}
            </button>
          </div>

        </div>
      </div>
    </div>

  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "Dashboard",

  data() {
    return {
      products: [],
      alert: "",
      showModal: false,
      editMode: false,
      form: {
        id: null,
        name: "",
        price: "",
        stock: ""
      }
    };
  },

  mounted() {
    this.fetchProducts();
  },

  methods: {
    async fetchProducts() {
      const token = localStorage.getItem("auth_token");

      const res = await axios.get("http://127.0.0.1:8000/api/products", {
        headers: {
          Authorization: `Bearer ${token}`
        }
      });

      this.products = res.data.data || res.data;
    },

    openCreateModal() {
      this.editMode = false;
      this.form = { id: null, name: "", price: "", stock: "" };
      this.showModal = true;
    },

    openEditModal(item) {
      this.editMode = true;
      this.form = { ...item };
      this.showModal = true;
    },

    closeModal() {
      this.showModal = false;
      this.alert = "";
    },

    async submitForm() {
      const token = localStorage.getItem("auth_token");

      try {
        if (this.editMode) {
          await axios.put(
            `http://127.0.0.1:8000/api/products/${this.form.id}`,
            this.form,
            { headers: { Authorization: `Bearer ${token}` } }
          );
          this.alert = "Produk berhasil diupdate.";
        } else {
          await axios.post(
            "http://127.0.0.1:8000/api/products",
            this.form,
            { headers: { Authorization: `Bearer ${token}` } }
          );
          this.alert = "Produk berhasil ditambahkan.";
        }

        this.showModal = false;
        this.fetchProducts();

      } catch (err) {
        this.alert = err.response?.data?.message || "Terjadi kesalahan.";
      }
    },

    async deleteProduct(id) {
      if (!confirm("Hapus produk ini?")) return;

      const token = localStorage.getItem("auth_token");

      await axios.delete(`http://127.0.0.1:8000/api/products/${id}`, {
        headers: {
          Authorization: `Bearer ${token}`
        }
      });

      this.alert = "Produk berhasil dihapus.";
      this.fetchProducts();
    }
  }
};
</script>

<style scoped>
.modal-backdrop {
  opacity: 0.3;
}
</style>

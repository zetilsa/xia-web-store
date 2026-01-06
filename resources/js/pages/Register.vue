<template>
  <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow p-4" style="max-width: 420px; width: 100%; border-radius: 18px;">
      <h3 class="text-center mb-4 fw-bold">Register</h3>

      <!-- ERROR ALERT -->
      <div v-if="errorMessage" class="alert alert-danger py-2">{{ errorMessage }}</div>

      <form @submit.prevent="handleRegister">

        <div class="mb-3">
          <label class="form-label fw-semibold">Name</label>
          <input 
            type="text" 
            class="form-control"
            v-model="name"
            required
          >
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Email</label>
          <input 
            type="email" 
            class="form-control"
            v-model="email"
            required
          >
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Password</label>
          <input 
            type="password" 
            class="form-control"
            v-model="password"
            required
          >
        </div>

        <button class="btn btn-primary w-100 mt-2" :disabled="loading">
          <span v-if="loading" class="spinner-border spinner-border-sm me-2"></span>
          Register
        </button>

        <div class="text-center mt-3">
          <router-link to="/login">Sudah punya akun?</router-link>
        </div>

      </form>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "Register",

  data() {
    return {
      name: "",
      email: "",
      password: "",
      loading: false,
      errorMessage: "",
    };
  },

  methods: {
    async handleRegister() {
      this.loading = true;
      this.errorMessage = "";

      try {
        const res = await axios.post("http://127.0.0.1:8000/api/register", {
          name: this.name,
          email: this.email,
          password: this.password,
        });

        // Response kamu BINER seperti ini:
        // { "user": {...}, "token": "..." }

        const user  = res.data.user;
        const token = res.data.token;

        // Simpan auth
        localStorage.setItem("auth_user", JSON.stringify(user));
        localStorage.setItem("auth_token", token);

        // Redirect ke dashboard
        this.$router.push("/dashboard");

      } catch (err) {
        this.errorMessage = err.response?.data?.message || "Register gagal!";
      } finally {
        this.loading = false;
      }
    }
  }
};
</script>

<style scoped>
body {
  background-color: #f3f4f6;
}
</style>

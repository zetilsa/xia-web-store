<template>
  <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow p-4" style="max-width: 400px; width: 100%; border-radius: 18px;">
      <h3 class="text-center mb-4 fw-bold">Login</h3>

      <!-- ALERT ERROR -->
      <div v-if="errorMessage" class="alert alert-danger py-2">{{ errorMessage }}</div>

      <form @submit.prevent="handleLogin">
        <div class="mb-3">
          <label class="form-label fw-semibold">Email</label>
          <input 
            type="email" 
            v-model="email"
            class="form-control"
            required
          >
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Password</label>
          <input 
            type="password" 
            v-model="password"
            class="form-control"
            required
          >
        </div>

        <button class="btn btn-primary w-100 mt-2" :disabled="loading">
          <span v-if="loading" class="spinner-border spinner-border-sm me-2"></span>
          Login
        </button>
      </form>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "Login",
  data() {
    return {
      email: "",
      password: "",
      loading: false,
      errorMessage: ""
    };
  },
  methods: {
    async handleLogin() {
      this.loading = true;
      this.errorMessage = "";

      try {
        const res = await axios.post("http://127.0.0.1:8000/api/login", {
          email: this.email,
          password: this.password,
        });

        // SIMPAN TOKEN DI LOCAL STORAGE
        localStorage.setItem("token", res.data.token);

        // REDIRECT KE DASHBOARD
        this.$router.push("/dashboard");

      } catch (err) {
        this.errorMessage = err.response?.data?.message || "Login gagal!";
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
<template>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary glass-nav py-3">
  <div class="container">
    <a class="navbar-brand fw-bold fs-4" href="/">Bagogo Shop</a>

    <button
      class="navbar-toggler"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarNav"
    >
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto gap-lg-3">

  <!-- JIKA BELUM LOGIN -->
  <template v-if="!authState.isAuth">
    <li class="nav-item">
      <router-link class="nav-link" to="/register">Daftar</router-link>
    </li>

    <li class="nav-item">
      <router-link to="/login" class="btn btn-outline-light px-3 ms-lg-3">
        Login
      </router-link>
    </li>
  </template>

  <!-- JIKA SUDAH LOGIN -->
  <template v-else>
    <li class="nav-item">
      <router-link class="nav-link" to="/dashboard">
        Dashboard
      </router-link>
    </li>

    <li class="nav-item">
      <button
        class="btn btn-outline-light px-3 ms-lg-3"
        @click="logout"
      >
        Logout
      </button>
    </li>
  </template>

</ul>

    </div>
  </div>
</nav>
</template>
<style>
    .glass-nav {
    background: rgba(255, 0, 0, 0.75) !important;
    backdrop-filter: blur(12px);
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
}

.navbar .nav-link {
  transition: 0.2s ease;
  font-size: 1.05rem;
  opacity: 0.85;
}

.navbar .nav-link:hover,
.navbar .nav-link.active {
  opacity: 1;
}

.navbar-brand {
  letter-spacing: 0.5px;
}

.btn-primary {
  border-radius: 12px;
}

</style>
<script>
import axios from "axios";
import { authState } from "../src/auth";

export default {
  name: "Navbar",

  setup() {
    return { authState };
  },

  methods: {
    logout() {
      const token = localStorage.getItem("token");

      axios.post("http://127.0.0.1:8000/api/logout", {}, {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      })
      .finally(() => {
        localStorage.removeItem("token");
        authState.isAuth = false; // 🔥 NAVBAR AUTO UPDATE
        this.$router.push("/login");
      });
    },
  },
};
</script>


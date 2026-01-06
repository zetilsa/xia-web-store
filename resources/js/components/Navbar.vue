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
        <li class="nav-item">
          <a class="nav-link active" href="#">Home</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="#">Features</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="#">Gallery</a>
        </li>

        <li class="nav-item">
          <router-link class="nav-link" to="/register">Daftar</router-link>
        </li>

        <li class="nav-item">
          <router-link to="/login" class="btn btn-outline-light px-3 ms-lg-3" href="#">
            Login
          </router-link>
        </li>
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
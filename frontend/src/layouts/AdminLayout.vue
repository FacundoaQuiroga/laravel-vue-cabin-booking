<template>
  <div class="app-layout">
    <aside class="sidebar">
      <div class="brand">Cabin Admin</div>

      <router-link to="/admin/reservations" class="nav-link">Reservas</router-link>
      <router-link to="/admin/cabins" class="nav-link">Cabañas</router-link>
    </aside>

    <main class="content">
      <router-view />
    </main>
  </div>
</template>

<style scoped>
.app-layout {
  display: flex;
  min-height: 100vh;
}

.sidebar {
  width: 240px;
  background: #d93434;
  color: white;
  padding: 24px 0;
}

.brand {
  font-weight: 700;
  font-size: 20px;
  padding: 0 24px 24px;
}

.nav-link {
  display: block;
  padding: 14px 24px;
  color: white;
  text-decoration: none;
}

.nav-link.router-link-active {
  background: rgba(0, 0, 0, 0.18);
}

.content {
  flex: 1;
  padding: 24px;
  background: #f7f8fa;
}
</style>
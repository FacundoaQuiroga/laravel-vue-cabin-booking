<template>
  <main class="home">
    <section class="hero">
      <div>
        <p class="eyebrow">Cabin Reservation Platform</p>
        <h1>Reserva y administra cabañas de forma simple</h1>
        <p class="description">
          Plataforma para gestionar disponibilidad, reservas y administración de cabañas.
        </p>

        <router-link to="/admin/reservations" class="button">
          Ir al panel admin
        </router-link>
      </div>
    </section>
  </main>
</template>

<style scoped>
.home {
  min-height: 100vh;
  background: #f7f8fa;
}

.hero {
  max-width: 960px;
  margin: 0 auto;
  padding: 96px 24px;
}

.eyebrow {
  color: #d95834;
  font-weight: 700;
}

h1 {
  max-width: 720px;
  font-size: 48px;
  line-height: 1.1;
  margin: 12px 0;
}

.description {
  max-width: 560px;
  color: #606266;
  font-size: 18px;
  line-height: 1.6;
}

.button {
  display: inline-block;
  margin-top: 24px;
  padding: 12px 18px;
  background: #d95834;
  color: white;
  text-decoration: none;
  border-radius: 6px;
  font-weight: 700;
}
</style>
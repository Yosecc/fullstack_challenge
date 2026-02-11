<template>
  <div id="app">
    <header>
      <h1>📋 Gestión de Tareas</h1>
      <nav>
        <RouterLink to="/">Inicio</RouterLink>
        <RouterLink to="/about">Acerca de</RouterLink>
      </nav>
    </header>
    <main>
      <RouterView />
    </main>
  </div>
</template>

<script setup>
import { RouterLink, RouterView } from 'vue-router'
</script>

<style scoped>
header {
  background: #42b983;
  color: white;
  padding: 1rem 2rem;
  margin-bottom: 2rem;
}

header h1 {
  margin: 0 0 1rem 0;
}

nav {
  display: flex;
  gap: 1rem;
}

nav a {
  color: white;
  text-decoration: none;
  padding: 0.5rem 1rem;
  border-radius: 4px;
}

nav a:hover {
  background: rgba(255, 255, 255, 0.1);
}

nav a.router-link-active {
  background: rgba(255, 255, 255, 0.2);
}

main {
  padding: 0 2rem;
}
</style>

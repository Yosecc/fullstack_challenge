<template>
  <div id="app" class="min-h-screen flex flex-col">
    <header class="bg-emerald-500 text-white px-8 py-4 mb-8">
      <h1 class="text-2xl font-bold mb-4">📋 Gestión de Tareas</h1>
      <nav class="flex gap-4">
        <RouterLink to="/" class="px-4 py-2 rounded hover:bg-white/10 transition router-link">
          Inicio
        </RouterLink>
        <RouterLink to="/about" class="px-4 py-2 rounded hover:bg-white/10 transition router-link">
          Acerca de
        </RouterLink>
      </nav>
    </header>
    <main class="px-8 flex-1">
      <RouterView />
    </main>
  </div>
</template>

<script setup>
import { RouterLink, RouterView } from 'vue-router'
</script>

<style>
.router-link.router-link-active {
  background-color: rgba(255, 255, 255, 0.2);
}
</style>

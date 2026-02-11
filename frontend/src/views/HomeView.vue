<template>
  <div class="home">
    <div class="home-header">
      <h2>Gestión de Tareas</h2>
      <button @click="showModal = true" class="btn btn-primary">
        + Nueva Tarea
      </button>
    </div>

    <!-- Filtros -->
    <TareasFiltros 
      :filters="store.filters"
      :prioridades="store.prioridades"
      :etiquetas="store.etiquetas"
      @update="store.setFilter"
      @clear="store.clearFilters"
    />

    <!-- Loading -->
    <div v-if="store.loading && !store.tareas.length" class="loading">
      Cargando tareas...
    </div>

    <!-- Error -->
    <div v-if="store.error" class="error-message">
      {{ store.error }}
    </div>

    <!-- Lista de tareas -->
    <div v-if="store.tareasFiltradas.length" class="tareas-list">
      <TareaCard 
        v-for="tarea in store.tareasFiltradas" 
        :key="tarea.id"
        :tarea="tarea"
        @cambiar-estado="cambiarEstado(tarea)"
        @editar="editarTarea(tarea)"
        @eliminar="eliminarTarea(tarea)"
      />
    </div>

    <!-- Sin tareas -->
    <div v-else-if="!store.loading" class="empty-state">
      <p>No hay tareas {{ store.filters.estado ? 'con ese filtro' : 'aún' }}</p>
      <button @click="store.clearFilters()" class="btn btn-secondary">
        Ver todas
      </button>
    </div>

    <!-- Modal crear/editar -->
    <TareaForm 
      v-if="showModal"
      :tarea="tareaEdit"
      :prioridades="store.prioridades"
      :etiquetas="store.etiquetas"
      :loading="store.loading"
      @close="closeModal"
      @submit="handleSubmit"
    />

    <!-- Modal cambiar estado -->
    <div v-if="showEstadoModal" class="modal-overlay" @click.self="showEstadoModal = false">
      <div class="modal-content modal-small">
        <h3>Cambiar Estado</h3>
        <div class="estado-options">
          <button 
            @click="actualizarEstado('pendiente')" 
            class="btn btn-block"
            :class="{'btn-primary': tareaEstado?.estado !== 'pendiente'}"
          >
            Pendiente
          </button>
          <button 
            @click="actualizarEstado('en_progreso')" 
            class="btn btn-block"
            :class="{'btn-primary': tareaEstado?.estado !== 'en_progreso'}"
          >
            En Progreso
          </button>
          <button 
            @click="actualizarEstado('completada')" 
            class="btn btn-block"
            :class="{'btn-primary': tareaEstado?.estado !== 'completada'}"
          >
            Completada
          </button>
        </div>
        <button @click="showEstadoModal = false" class="btn btn-secondary btn-block">
          Cancelar
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useTareasStore } from '../stores/tareas'
import TareaCard from '../components/TareaCard.vue'
import TareaForm from '../components/TareaForm.vue'
import TareasFiltros from '../components/TareasFiltros.vue'

const store = useTareasStore()

const showModal = ref(false)
const tareaEdit = ref(null)

const showEstadoModal = ref(false)
const tareaEstado = ref(null)

onMounted(async () => {
  await store.fetchPrioridades()
  await store.fetchEtiquetas()
  await store.fetchTareas()
})

const closeModal = () => {
  showModal.value = false
  tareaEdit.value = null
}

const handleSubmit = async (data) => {
  try {
    if (tareaEdit.value) {
      await store.updateTarea(tareaEdit.value.id, data)
    } else {
      await store.createTarea(data)
    }
    closeModal()
  } catch (error) {
    alert('Error al guardar la tarea')
  }
}

const editarTarea = (tarea) => {
  tareaEdit.value = tarea
  showModal.value = true
}

const eliminarTarea = async (tarea) => {
  if (confirm(`¿Eliminar la tarea "${tarea.titulo}"?`)) {
    try {
      await store.deleteTarea(tarea.id)
    } catch (error) {
      alert('Error al eliminar la tarea')
    }
  }
}

const cambiarEstado = (tarea) => {
  tareaEstado.value = tarea
  showEstadoModal.value = true
}

const actualizarEstado = async (nuevoEstado) => {
  try {
    await store.updateTarea(tareaEstado.value.id, {
      ...tareaEstado.value,
      estado: nuevoEstado
    })
    showEstadoModal.value = false
    tareaEstado.value = null
  } catch (error) {
    alert('Error al cambiar el estado')
  }
}
</script>

<style scoped>
.home {
  max-width: 1200px;
  margin: 0 auto;
}

.home-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2rem;
}

.home-header h2 {
  margin: 0;
  color: #1f2937;
}

.btn {
  padding: 0.625rem 1.25rem;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-size: 0.9375rem;
  font-weight: 500;
  transition: all 0.2s;
}

.btn-primary {
  background: #3b82f6;
  color: white;
}

.btn-primary:hover {
  background: #2563eb;
}

.btn-secondary {
  background: #e5e7eb;
  color: #374151;
}

.btn-secondary:hover {
  background: #d1d5db;
}

.btn-block {
  width: 100%;
}

.loading, .error-message, .empty-state {
  text-align: center;
  padding: 3rem;
  color: #6b7280;
}

.error-message {
  color: #ef4444;
  background: #fee2e2;
  border-radius: 8px;
  margin-bottom: 1rem;
}

.empty-state {
  background: white;
  border-radius: 8px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.empty-state button {
  margin-top: 1rem;
}

.tareas-list {
  display: flex;
  flex-direction: column;
}

.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
  padding: 1rem;
}

.modal-content {
  background: white;
  border-radius: 8px;
  padding: 1.5rem;
}

.modal-small {
  width: 100%;
  max-width: 400px;
}

.modal-small h3 {
  margin: 0 0 1rem 0;
  color: #1f2937;
}

.estado-options {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
  margin-bottom: 1rem;
}
</style>

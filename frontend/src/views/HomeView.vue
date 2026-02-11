<template>
  <div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-8">
      <h2 class="text-2xl font-semibold text-gray-900">Gestión de Tareas</h2>
      <button @click="showModal = true" class="px-5 py-2.5 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition font-medium">
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
    <div v-if="store.loading && !store.tareas.length" class="text-center py-12 text-gray-500">
      Cargando tareas...
    </div>

    <!-- Error -->
    <div v-if="store.error" class="text-center py-3 px-4 bg-red-50 text-red-600 rounded-lg mb-4">
      {{ store.error }}
    </div>

    <!-- Lista de tareas -->
    <div v-if="store.tareasFiltradas.length" class="flex flex-col">
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
    <div v-else-if="!store.loading" class="text-center py-12 bg-white rounded-lg shadow-sm">
      <p class="text-gray-500 mb-4">No hay tareas {{ store.filters.estado ? 'con ese filtro' : 'aún' }}</p>
      <button @click="store.clearFilters()" class="px-5 py-2.5 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition font-medium">
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
    <div v-if="showEstadoModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4" @click.self="showEstadoModal = false">
      <div class="bg-white rounded-lg p-6 w-full max-w-sm">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Cambiar Estado</h3>
        <div class="flex flex-col gap-3 mb-4">
          <button 
            @click="actualizarEstado('pendiente')" 
            class="w-full px-4 py-2.5 rounded-md font-medium transition"
            :class="tareaEstado?.estado !== 'pendiente' ? 'bg-blue-500 text-white hover:bg-blue-600' : 'bg-gray-200 text-gray-700'"
          >
            Pendiente
          </button>
          <button 
            @click="actualizarEstado('en_progreso')" 
            class="w-full px-4 py-2.5 rounded-md font-medium transition"
            :class="tareaEstado?.estado !== 'en_progreso' ? 'bg-blue-500 text-white hover:bg-blue-600' : 'bg-gray-200 text-gray-700'"
          >
            En Progreso
          </button>
          <button 
            @click="actualizarEstado('completada')" 
            class="w-full px-4 py-2.5 rounded-md font-medium transition"
            :class="tareaEstado?.estado !== 'completada' ? 'bg-blue-500 text-white hover:bg-blue-600' : 'bg-gray-200 text-gray-700'"
          >
            Completada
          </button>
        </div>
        <button @click="showEstadoModal = false" class="w-full px-4 py-2.5 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition font-medium">
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


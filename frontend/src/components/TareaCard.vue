<template>
  <div 
    class="bg-white rounded-lg p-6 shadow-md mb-4 border-l-4 transition-all"
    :class="{
      'border-amber-500': tarea.estado === 'pendiente',
      'border-blue-500': tarea.estado === 'en_progreso',
      'border-green-500 opacity-80': tarea.estado === 'completada'
    }"
  >
    <div class="flex justify-between items-start mb-2">
      <h3 class="text-lg font-semibold text-gray-800">{{ tarea.titulo }}</h3>
      <span 
        class="px-3 py-1 rounded-full text-xs font-semibold uppercase"
        :class="{
          'bg-amber-100 text-amber-800': tarea.estado === 'pendiente',
          'bg-blue-100 text-blue-800': tarea.estado === 'en_progreso',
          'bg-green-100 text-green-800': tarea.estado === 'completada'
        }"
      >
        {{ estadoLabel }}
      </span>
    </div>

    <p class="text-slate-600 my-2 text-sm" v-if="tarea.descripcion">
      {{ tarea.descripcion }}
    </p>

    <div class="flex flex-wrap gap-4 mb-4 text-sm text-slate-600">
      <div v-if="tarea.prioridad">
        <strong class="font-semibold text-slate-700">Prioridad:</strong> {{ tarea.prioridad.prioridad }}
      </div>

      <div v-if="tarea.fecha_vencimiento">
        <strong class="font-semibold text-slate-700">Vence:</strong> {{ formatDate(tarea.fecha_vencimiento) }}
      </div>

      <div class="flex items-center gap-2 flex-wrap" v-if="tarea.etiquetas && tarea.etiquetas.length">
        <strong class="font-semibold text-slate-700">Etiquetas:</strong>
        <span 
          v-for="etiqueta in tarea.etiquetas" 
          :key="etiqueta.id"
          class="bg-indigo-100 text-indigo-800 px-2 py-1 rounded text-xs font-medium"
        >
          {{ etiqueta.etiqueta }}
        </span>
      </div>
    </div>

    <div class="flex gap-2 flex-wrap">
      <button 
        @click="$emit('editar')" 
        class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors text-sm font-medium"
      >
        Editar
      </button>
      <button 
        @click="$emit('eliminar')" 
        class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition-colors text-sm font-medium"
      >
        Eliminar
      </button>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  tarea: {
    type: Object,
    required: true
  }
})

defineEmits(['cambiar-estado', 'editar', 'eliminar'])

const estadoLabel = computed(() => {
  const labels = {
    'pendiente': 'Pendiente',
    'en_progreso': 'En Progreso',
    'completada': 'Completada'
  }
  return labels[props.tarea.estado] || props.tarea.estado
})

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('es-ES', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
}
</script>


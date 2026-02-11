<template>
  <div class="bg-white rounded-lg p-6 mb-8 shadow-sm">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Filtros</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
      <div class="flex flex-col">
        <label for="filtro-estado" class="mb-2 font-medium text-gray-700 text-sm">Estado</label>
        <select 
          id="filtro-estado"
          :value="filters.estado" 
          @change="updateFilter('estado', $event.target.value)"
          class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
        >
          <option value="">Todos</option>
          <option value="pendiente">Pendiente</option>
          <option value="en_progreso">En Progreso</option>
          <option value="completada">Completada</option>
        </select>
      </div>

      <div class="flex flex-col">
        <label for="filtro-prioridad" class="mb-2 font-medium text-gray-700 text-sm">Prioridad</label>
        <select 
          id="filtro-prioridad"
          :value="filters.prioridad_id" 
          @change="updateFilter('prioridad_id', $event.target.value)"
          class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
        >
          <option value="">Todas</option>
          <option 
            v-for="prioridad in prioridades" 
            :key="prioridad.id" 
            :value="prioridad.id"
          >
            {{ prioridad.prioridad }}
          </option>
        </select>
      </div>

      <div class="flex flex-col">
        <label for="filtro-etiqueta" class="mb-2 font-medium text-gray-700 text-sm">Etiqueta</label>
        <select 
          id="filtro-etiqueta"
          :value="filters.etiqueta_id" 
          @change="updateFilter('etiqueta_id', $event.target.value)"
          class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
        >
          <option value="">Todas</option>
          <option 
            v-for="etiqueta in etiquetas" 
            :key="etiqueta.id" 
            :value="etiqueta.id"
          >
            {{ etiqueta.etiqueta }}
          </option>
        </select>
      </div>

      <div class="flex flex-col">
        <label for="filtro-fecha-desde" class="mb-2 font-medium text-gray-700 text-sm">Fecha Desde</label>
        <input 
          id="filtro-fecha-desde"
          type="date" 
          :value="filters.fecha_desde" 
          @change="updateFilter('fecha_desde', $event.target.value)"
          class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
        />
      </div>

      <div class="flex flex-col">
        <label for="filtro-fecha-hasta" class="mb-2 font-medium text-gray-700 text-sm">Fecha Hasta</label>
        <input 
          id="filtro-fecha-hasta"
          type="date" 
          :value="filters.fecha_hasta" 
          @change="updateFilter('fecha_hasta', $event.target.value)"
          class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
        />
      </div>

      <div class="flex flex-col justify-end">
        <button @click="$emit('clear')" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition text-sm font-medium">
          Limpiar Filtros
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  filters: Object,
  prioridades: Array,
  etiquetas: Array
})

const emit = defineEmits(['update', 'clear'])

const updateFilter = (key, value) => {
  emit('update', key, value)
}
</script>


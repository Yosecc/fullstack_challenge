<template>
  <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4" @click.self="$emit('close')">
    <div class="bg-white rounded-lg w-full max-w-2xl max-h-[90vh] overflow-y-auto">
      <div class="flex justify-between items-center p-6 border-b border-gray-200">
        <h2 class="text-xl font-semibold text-gray-900">{{ isEdit ? 'Editar Tarea' : 'Nueva Tarea' }}</h2>
        <button @click="$emit('close')" class="text-gray-400 hover:text-gray-900 text-3xl w-8 h-8 flex items-center justify-center leading-none">&times;</button>
      </div>

      <form @submit.prevent="handleSubmit" class="p-6">
        <div class="mb-5">
          <label for="titulo" class="block mb-2 font-medium text-gray-700">Título *</label>
          <input 
            id="titulo"
            v-model="formData.titulo" 
            type="text" 
            required
            class="w-full px-3.5 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
            placeholder="Título de la tarea"
          />
        </div>

        <div class="mb-5">
          <label for="descripcion" class="block mb-2 font-medium text-gray-700">Descripción</label>
          <textarea 
            id="descripcion"
            v-model="formData.descripcion" 
            class="w-full px-3.5 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-vertical min-h-[80px]"
            rows="3"
            placeholder="Descripción de la tarea"
          ></textarea>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-5">
          <div>
            <label for="estado" class="block mb-2 font-medium text-gray-700">Estado *</label>
            <select id="estado" v-model="formData.estado" class="w-full px-3.5 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" required>
              <option value="pendiente">Pendiente</option>
              <option value="en_progreso">En Progreso</option>
              <option value="completada">Completada</option>
            </select>
          </div>

          <div>
            <label for="prioridad" class="block mb-2 font-medium text-gray-700">Prioridad *</label>
            <select id="prioridad" v-model="formData.prioridad_id" class="w-full px-3.5 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" required>
              <option value="">Selecciona...</option>
              <option 
                v-for="prioridad in prioridades" 
                :key="prioridad.id" 
                :value="prioridad.id"
              >
                {{ prioridad.prioridad }}
              </option>
            </select>
          </div>
        </div>

        <div class="mb-5">
          <label for="fecha" class="block mb-2 font-medium text-gray-700">Fecha de Vencimiento</label>
          <input 
            id="fecha"
            v-model="formData.fecha_vencimiento" 
            type="date" 
            class="w-full px-3.5 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
          />
        </div>

        <div class="mb-5">
          <label class="block mb-2 font-medium text-gray-700">Etiquetas</label>
          <div class="flex flex-col gap-2">
            <label 
              v-for="etiqueta in etiquetas" 
              :key="etiqueta.id"
              class="flex items-center gap-2 cursor-pointer"
            >
              <input 
                type="checkbox" 
                :value="etiqueta.id" 
                v-model="formData.etiquetas"
                class="w-4.5 h-4.5 cursor-pointer"
              />
              <span>{{ etiqueta.etiqueta }}</span>
            </label>
          </div>
        </div>

        <div class="flex gap-3 justify-end mt-6 pt-6 border-t border-gray-200">
          <button type="button" @click="$emit('close')" class="px-5 py-2.5 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition font-medium">
            Cancelar
          </button>
          <button type="submit" class="px-5 py-2.5 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition font-medium disabled:opacity-50 disabled:cursor-not-allowed" :disabled="loading">
            {{ loading ? 'Guardando...' : (isEdit ? 'Actualizar' : 'Crear') }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
  tarea: Object,
  prioridades: Array,
  etiquetas: Array,
  loading: Boolean
})

const emit = defineEmits(['close', 'submit'])

const isEdit = ref(!!props.tarea)

const formData = ref({
  titulo: '',
  descripcion: '',
  estado: 'pendiente',
  prioridad_id: '',
  fecha_vencimiento: '',
  etiquetas: []
})

// Cargar datos si es edición
if (props.tarea) {
  formData.value = {
    titulo: props.tarea.titulo || '',
    descripcion: props.tarea.descripcion || '',
    estado: props.tarea.estado || 'pendiente',
    prioridad_id: props.tarea.prioridad_id || '',
    fecha_vencimiento: props.tarea.fecha_vencimiento ? props.tarea.fecha_vencimiento.split('T')[0] : '',
    etiquetas: props.tarea.etiquetas ? props.tarea.etiquetas.map(e => e.id) : []
  }
}

const handleSubmit = () => {
  emit('submit', formData.value)
}
</script>


<template>
  <div class="modal-overlay" @click.self="$emit('close')">
    <div class="modal-content">
      <div class="modal-header">
        <h2>{{ isEdit ? 'Editar Tarea' : 'Nueva Tarea' }}</h2>
        <button @click="$emit('close')" class="btn-close">&times;</button>
      </div>

      <form @submit.prevent="handleSubmit" class="tarea-form">
        <div class="form-group">
          <label for="titulo">Título *</label>
          <input 
            id="titulo"
            v-model="formData.titulo" 
            type="text" 
            required
            class="form-control"
            placeholder="Título de la tarea"
          />
        </div>

        <div class="form-group">
          <label for="descripcion">Descripción</label>
          <textarea 
            id="descripcion"
            v-model="formData.descripcion" 
            class="form-control"
            rows="3"
            placeholder="Descripción de la tarea"
          ></textarea>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="estado">Estado *</label>
            <select id="estado" v-model="formData.estado" class="form-control" required>
              <option value="pendiente">Pendiente</option>
              <option value="en_progreso">En Progreso</option>
              <option value="completada">Completada</option>
            </select>
          </div>

          <div class="form-group">
            <label for="prioridad">Prioridad *</label>
            <select id="prioridad" v-model="formData.prioridad_id" class="form-control" required>
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

        <div class="form-group">
          <label for="fecha">Fecha de Vencimiento</label>
          <input 
            id="fecha"
            v-model="formData.fecha_vencimiento" 
            type="date" 
            class="form-control"
          />
        </div>

        <div class="form-group">
          <label>Etiquetas</label>
          <div class="checkbox-group">
            <label 
              v-for="etiqueta in etiquetas" 
              :key="etiqueta.id"
              class="checkbox-label"
            >
              <input 
                type="checkbox" 
                :value="etiqueta.id" 
                v-model="formData.etiquetas"
              />
              <span>{{ etiqueta.etiqueta }}</span>
            </label>
          </div>
        </div>

        <div class="form-actions">
          <button type="button" @click="$emit('close')" class="btn btn-secondary">
            Cancelar
          </button>
          <button type="submit" class="btn btn-primary" :disabled="loading">
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

<style scoped>
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
  width: 100%;
  max-width: 600px;
  max-height: 90vh;
  overflow-y: auto;
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1.5rem;
  border-bottom: 1px solid #e5e7eb;
}

.modal-header h2 {
  margin: 0;
  color: #1f2937;
}

.btn-close {
  background: none;
  border: none;
  font-size: 2rem;
  cursor: pointer;
  color: #6b7280;
  padding: 0;
  width: 2rem;
  height: 2rem;
  display: flex;
  align-items: center;
  justify-content: center;
  line-height: 1;
}

.btn-close:hover {
  color: #1f2937;
}

.tarea-form {
  padding: 1.5rem;
}

.form-group {
  margin-bottom: 1.25rem;
}

.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1rem;
}

label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: 500;
  color: #374151;
}

.form-control {
  width: 100%;
  padding: 0.625rem 0.875rem;
  border: 1px solid #d1d5db;
  border-radius: 6px;
  font-size: 0.9375rem;
  transition: border-color 0.2s;
}

.form-control:focus {
  outline: none;
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

textarea.form-control {
  resize: vertical;
  min-height: 80px;
}

.checkbox-group {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.checkbox-label {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  cursor: pointer;
  font-weight: normal;
  margin: 0;
}

.checkbox-label input[type="checkbox"] {
  width: 1.125rem;
  height: 1.125rem;
  cursor: pointer;
}

.form-actions {
  display: flex;
  gap: 0.75rem;
  justify-content: flex-end;
  margin-top: 1.5rem;
  padding-top: 1.5rem;
  border-top: 1px solid #e5e7eb;
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

.btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.btn-primary {
  background: #3b82f6;
  color: white;
}

.btn-primary:hover:not(:disabled) {
  background: #2563eb;
}

.btn-secondary {
  background: #e5e7eb;
  color: #374151;
}

.btn-secondary:hover {
  background: #d1d5db;
}
</style>

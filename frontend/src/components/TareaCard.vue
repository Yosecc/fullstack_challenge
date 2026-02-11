<template>
  <div class="tarea-card" :class="`estado-${tarea.estado}`">
    <div class="tarea-header">
      <h3>{{ tarea.titulo }}</h3>
      <span class="badge" :class="`badge-${tarea.estado}`">
        {{ estadoLabel }}
      </span>
    </div>

    <p class="descripcion" v-if="tarea.descripcion">
      {{ tarea.descripcion }}
    </p>

    <div class="tarea-meta">
      <div class="prioridad" v-if="tarea.prioridad">
        <strong>Prioridad:</strong> {{ tarea.prioridad.prioridad }}
      </div>

      <div class="fecha" v-if="tarea.fecha_vencimiento">
        <strong>Vence:</strong> {{ formatDate(tarea.fecha_vencimiento) }}
      </div>

      <div class="etiquetas" v-if="tarea.etiquetas && tarea.etiquetas.length">
        <strong>Etiquetas:</strong>
        <span 
          v-for="etiqueta in tarea.etiquetas" 
          :key="etiqueta.id"
          class="etiqueta-badge"
        >
          {{ etiqueta.etiqueta }}
        </span>
      </div>
    </div>

    <div class="tarea-actions">
      <button @click="$emit('editar')" class="btn btn-sm btn-primary">
        Editar
      </button>
      <button @click="$emit('eliminar')" class="btn btn-sm btn-danger">
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

<style scoped>
.tarea-card {
  background: white;
  border-radius: 8px;
  padding: 1.5rem;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  margin-bottom: 1rem;
  border-left: 4px solid #ddd;
}

.tarea-card.estado-pendiente {
  border-left-color: #f59e0b;
}

.tarea-card.estado-en_progreso {
  border-left-color: #3b82f6;
}

.tarea-card.estado-completada {
  border-left-color: #10b981;
  opacity: 0.8;
}

.tarea-header {
  display: flex;
  justify-content: space-between;
  align-items: start;
  margin-bottom: 0.5rem;
}

.tarea-header h3 {
  margin: 0;
  font-size: 1.1rem;
  color: #2c3e50;
}

.badge {
  padding: 0.25rem 0.75rem;
  border-radius: 12px;
  font-size: 0.75rem;
  font-weight: 600;
  text-transform: uppercase;
}

.badge-pendiente {
  background: #fef3c7;
  color: #92400e;
}

.badge-en_progreso {
  background: #dbeafe;
  color: #1e3a8a;
}

.badge-completada {
  background: #d1fae5;
  color: #065f46;
}

.descripcion {
  color: #64748b;
  margin: 0.5rem 0 1rem;
  font-size: 0.9rem;
}

.tarea-meta {
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
  margin-bottom: 1rem;
  font-size: 0.875rem;
  color: #475569;
}

.tarea-meta strong {
  font-weight: 600;
  color: #334155;
}

.etiquetas {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  flex-wrap: wrap;
}

.etiqueta-badge {
  background: #e0e7ff;
  color: #3730a3;
  padding: 0.25rem 0.5rem;
  border-radius: 4px;
  font-size: 0.75rem;
  font-weight: 500;
}

.tarea-actions {
  display: flex;
  gap: 0.5rem;
  flex-wrap: wrap;
}

.btn {
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 0.875rem;
  font-weight: 500;
  transition: all 0.2s;
}

.btn-sm {
  padding: 0.375rem 0.75rem;
  font-size: 0.8125rem;
}

.btn-primary {
  background: #3b82f6;
  color: white;
}

.btn-primary:hover {
  background: #2563eb;
}

.btn-secondary {
  background: #64748b;
  color: white;
}

.btn-secondary:hover {
  background: #475569;
}

.btn-danger {
  background: #ef4444;
  color: white;
}

.btn-danger:hover {
  background: #dc2626;
}
</style>

<template>
  <div class="filtros-container">
    <h3>Filtros</h3>
    
    <div class="filtros-grid">
      <div class="form-group">
        <label for="filtro-estado">Estado</label>
        <select 
          id="filtro-estado"
          :value="filters.estado" 
          @change="updateFilter('estado', $event.target.value)"
          class="form-control"
        >
          <option value="">Todos</option>
          <option value="pendiente">Pendiente</option>
          <option value="en_progreso">En Progreso</option>
          <option value="completada">Completada</option>
        </select>
      </div>

      <div class="form-group">
        <label for="filtro-prioridad">Prioridad</label>
        <select 
          id="filtro-prioridad"
          :value="filters.prioridad_id" 
          @change="updateFilter('prioridad_id', $event.target.value)"
          class="form-control"
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

      <div class="form-group">
        <label for="filtro-etiqueta">Etiqueta</label>
        <select 
          id="filtro-etiqueta"
          :value="filters.etiqueta_id" 
          @change="updateFilter('etiqueta_id', $event.target.value)"
          class="form-control"
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

      <div class="form-group">
        <label for="filtro-fecha-desde">Fecha Desde</label>
        <input 
          id="filtro-fecha-desde"
          type="date" 
          :value="filters.fecha_desde" 
          @change="updateFilter('fecha_desde', $event.target.value)"
          class="form-control"
        />
      </div>

      <div class="form-group">
        <label for="filtro-fecha-hasta">Fecha Hasta</label>
        <input 
          id="filtro-fecha-hasta"
          type="date" 
          :value="filters.fecha_hasta" 
          @change="updateFilter('fecha_hasta', $event.target.value)"
          class="form-control"
        />
      </div>

      <div class="form-group">
        <label>&nbsp;</label>
        <button @click="$emit('clear')" class="btn btn-secondary btn-block">
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

<style scoped>
.filtros-container {
  background: white;
  border-radius: 8px;
  padding: 1.5rem;
  margin-bottom: 2rem;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.filtros-container h3 {
  margin: 0 0 1rem 0;
  color: #1f2937;
  font-size: 1.125rem;
}

.filtros-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1rem;
}

.form-group {
  display: flex;
  flex-direction: column;
}

label {
  margin-bottom: 0.5rem;
  font-weight: 500;
  color: #374151;
  font-size: 0.875rem;
}

.form-control {
  padding: 0.5rem 0.75rem;
  border: 1px solid #d1d5db;
  border-radius: 6px;
  font-size: 0.875rem;
  transition: border-color 0.2s;
}

.form-control:focus {
  outline: none;
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.btn {
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-size: 0.875rem;
  font-weight: 500;
  transition: all 0.2s;
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
</style>

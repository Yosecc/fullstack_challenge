import { defineStore } from 'pinia'
import api from '../services/api'

export const useTareasStore = defineStore('tareas', {
  state: () => ({
    tareas: [],
    prioridades: [],
    etiquetas: [],
    loading: false,
    error: null,
    filters: {
      estado: '',
      prioridad_id: '',
      etiqueta_id: '',
      fecha_desde: '',
      fecha_hasta: ''
    }
  }),

  getters: {
    tareasFiltradas: (state) => {
      let filtered = state.tareas

      if (state.filters.estado) {
        filtered = filtered.filter(t => t.estado === state.filters.estado)
      }

      if (state.filters.prioridad_id) {
        filtered = filtered.filter(t => t.prioridad_id == state.filters.prioridad_id)
      }

      if (state.filters.etiqueta_id) {
        filtered = filtered.filter(t => 
          t.etiquetas.some(e => e.id == state.filters.etiqueta_id)
        )
      }

      if (state.filters.fecha_desde) {
        filtered = filtered.filter(t => 
          t.fecha_vencimiento && t.fecha_vencimiento >= state.filters.fecha_desde
        )
      }

      if (state.filters.fecha_hasta) {
        filtered = filtered.filter(t => 
          t.fecha_vencimiento && t.fecha_vencimiento <= state.filters.fecha_hasta
        )
      }

      return filtered
    }
  },

  actions: {
    async fetchTareas() {
      this.loading = true
      this.error = null
      try {
        const response = await api.getTareas()
        this.tareas = response.data
      } catch (error) {
        this.error = error.message
        console.error('Error al cargar tareas:', error)
      } finally {
        this.loading = false
      }
    },

    async fetchPrioridades() {
      try {
        const response = await api.getPrioridades()
        this.prioridades = response.data
      } catch (error) {
        console.error('Error al cargar prioridades:', error)
      }
    },

    async fetchEtiquetas() {
      try {
        const response = await api.getEtiquetas()
        this.etiquetas = response.data
      } catch (error) {
        console.error('Error al cargar etiquetas:', error)
      }
    },

    async createTarea(data) {
      this.loading = true
      this.error = null
      try {
        const response = await api.createTarea(data)
        this.tareas.unshift(response.data)
        return response.data
      } catch (error) {
        this.error = error.message
        console.error('Error al crear tarea:', error)
        throw error
      } finally {
        this.loading = false
      }
    },

    async updateTarea(id, data) {
      this.loading = true
      this.error = null
      try {
        const response = await api.updateTarea(id, data)
        const index = this.tareas.findIndex(t => t.id === id)
        if (index !== -1) {
          this.tareas[index] = response.data
        }
        return response.data
      } catch (error) {
        this.error = error.message
        console.error('Error al actualizar tarea:', error)
        throw error
      } finally {
        this.loading = false
      }
    },

    async deleteTarea(id) {
      this.loading = true
      this.error = null
      try {
        await api.deleteTarea(id)
        this.tareas = this.tareas.filter(t => t.id !== id)
      } catch (error) {
        this.error = error.message
        console.error('Error al eliminar tarea:', error)
        throw error
      } finally {
        this.loading = false
      }
    },

    setFilter(key, value) {
      this.filters[key] = value
    },

    clearFilters() {
      this.filters = {
        estado: '',
        prioridad_id: '',
        etiqueta_id: '',
        fecha_desde: '',
        fecha_hasta: ''
      }
    }
  }
})

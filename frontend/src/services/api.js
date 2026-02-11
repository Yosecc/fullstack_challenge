import axios from 'axios'

const api = axios.create({
  baseURL: 'http://localhost:8000/api',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  }
})

export default {
  // Tareas
  getTareas(params = {}) {
    return api.get('/tareas', { params })
  },
  getTarea(id) {
    return api.get(`/tareas/${id}`)
  },
  createTarea(data) {
    return api.post('/tareas', data)
  },
  updateTarea(id, data) {
    return api.put(`/tareas/${id}`, data)
  },
  deleteTarea(id) {
    return api.delete(`/tareas/${id}`)
  },

  // Prioridades
  getPrioridades() {
    return api.get('/prioridades')
  },

  // Etiquetas
  getEtiquetas() {
    return api.get('/etiquetas')
  }
}

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { router } from '@inertiajs/vue3'

const requests = ref([])
const loading = ref(true)
const showForm = ref(false)
const editingRequest = ref(null)

const form = ref({ type: '', description: '' })

const fetchRequests = async () => {
  try {
    const res = await axios.get('/requests')
    requests.value = res.data
  } catch (error) {
    console.error(error)
  } finally {
    loading.value = false
  }
}

const createRequest = async () => {
  try {
    await axios.post('/requests', form.value)
    showForm.value = false
    form.value = { type: '', description: '' }
    fetchRequests()
  } catch (error) {
    alert('Error al crear solicitud')
  }
}

const editRequest = (req) => {
  editingRequest.value = req
  form.value = { type: req.type, description: req.description }
  showForm.value = true
}

const updateRequest = async () => {
  try {
    await axios.put(`/requests/${editingRequest.value.id}`, form.value)
    editingRequest.value = null
    showForm.value = false
    form.value = { type: '', description: '' }
    fetchRequests()
  } catch (error) {
    alert('Error al actualizar')
  }
}

const deleteRequest = async (id) => {
  if (!confirm('¿Seguro que deseas eliminar esta solicitud?')) return
  try {
    await axios.delete(`/requests/${id}`)
    fetchRequests()
  } catch (error) {
    alert('Error al eliminar')
  }
}

const logout = async () => {
  await axios.post('/logout')
  router.visit('/')
}

onMounted(fetchRequests)
</script>

<template>
  <div class="min-h-screen bg-gray-100 dark:bg-gray-900 p-6">
    <div class="max-w-6xl mx-auto">
      <header class="flex flex-col md:flex-row justify-between items-center mb-10 bg-gradient-to-r from-blue-600 to-blue-400 dark:from-blue-700 dark:to-blue-500 rounded-xl p-6 shadow-lg transition-all">
        <div class="flex items-center gap-4">
          <div class="bg-white dark:bg-gray-800 p-2 rounded-full shadow-md hover:scale-105 transition">
            <img src="https://syscfw.conserflow.com.mx/img/conserflow.png" alt="ConserFlow.ERP" class="w-30 "/>
          </div>
          <h1 class="text-3xl font-bold text-white dark:text-gray-100">ConserFlow.ERP</h1>
        </div>
        <button @click="logout" class="mt-4 md:mt-0 bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg shadow transition">Cerrar sesión</button>
      </header>

      <button
        @click="showForm = !showForm"
        class="mb-8 w-full md:w-auto bg-blue-500 hover:bg-blue-600 text-white px-5 py-3 rounded-lg shadow-lg transition transform hover:scale-105"
      >
        {{ showForm ? 'Cerrar Formulario' : 'Nueva Solicitud' }}
      </button>

      <div v-if="showForm" class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg mb-8 transition">
        <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200">
          {{ editingRequest ? 'Editar Solicitud' : 'Nueva Solicitud' }}
        </h2>
        <form @submit.prevent="editingRequest ? updateRequest() : createRequest()" class="flex flex-col gap-4">
          <div class="flex flex-col">
            <label class="mb-1 text-gray-700 dark:text-gray-300">Tipo</label>
            <select v-model="form.type" class="border rounded p-2 w-full focus:border-blue-600 focus:ring focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
              <option value="">Seleccione</option>
              <option value="Vacaciones">Vacaciones</option>
              <option value="Material">Material</option>
              <option value="Soporte Técnico">Soporte Técnico</option>
            </select>
          </div>

          <div class="flex flex-col">
            <label class="mb-1 text-gray-700 dark:text-gray-300">Descripción</label>
            <textarea v-model="form.description" rows="3" class="border rounded p-2 w-full focus:border-blue-600 focus:ring focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"></textarea>
          </div>

          <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg shadow-lg transition transform hover:scale-105">
            {{ editingRequest ? 'Actualizar' : 'Crear' }}
          </button>
        </form>
      </div>

      <div v-if="loading" class="text-center text-gray-500 dark:text-gray-400">Cargando...</div>

      <div v-else class="grid gap-6 md:grid-cols-2">
        <div v-for="req in requests" :key="req.id" class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ req.type }}</h3>
            <span :class="{
              'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-200': req.status === 'Pendiente',
              'bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-200': req.status === 'Aprobada',
              'bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-200': req.status === 'Rechazada'
            }" class="px-3 py-1 rounded-full font-medium text-sm">
              {{ req.status }}
            </span>
          </div>
          <p class="text-gray-600 dark:text-gray-300 mb-4">{{ req.description }}</p>
          <div class="flex gap-2 justify-end">
            <button
              v-if="req.status === 'Pendiente'"
              @click="editRequest(req)"
              class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg shadow transition transform hover:scale-105"
            >
              Editar
            </button>
            <button
              v-if="req.status === 'Pendiente'"
              @click="deleteRequest(req.id)"
              class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg shadow transition transform hover:scale-105"
            >
              Eliminar
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

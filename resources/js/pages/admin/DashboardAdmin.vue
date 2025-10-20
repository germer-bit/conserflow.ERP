<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const requests = ref([]);
const loading = ref(true);

const fetchRequests = async () => {
  try {
    const res = await axios.get('/admin/requests');
    requests.value = res.data;
  } catch (error) {
    console.error('Error al cargar solicitudes:', error);
  } finally {
    loading.value = false;
  }
};

const updateStatus = async (id, status) => {
  try {
    await axios.put(`/admin/requests/${id}`, { status });
    await fetchRequests();
  } catch (error) {
    console.error('Error al actualizar estado:', error);
  }
};

const logout = async () => {
  try {
    await axios.post('/logout');
    window.location.href = '/';
  } catch (error) {
    console.error('Error al cerrar sesión:', error);
  }
};

onMounted(fetchRequests);
</script>

<template>
  <div class="min-h-screen bg-gray-100 dark:bg-gray-900 p-6">
    <div class="max-w-6xl mx-auto">
      <header class="flex flex-col md:flex-row justify-between items-center mb-10 bg-gradient-to-r from-blue-600 to-blue-400 dark:from-blue-700 dark:to-blue-500 rounded-xl p-6 shadow-lg transition-all">
        <div class="flex items-center gap-4">
          <div class="bg-white dark:bg-gray-800 p-2 rounded-full shadow-md hover:scale-105 transition">
            <img src="https://syscfw.conserflow.com.mx/img/conserflow.png" alt="ConserFlow.ERP" class="w-30"/>
          </div>
          <h1 class="text-3xl font-bold text-white dark:text-gray-100">Panel Admin</h1>
        </div>
        <button @click="logout" class="mt-4 md:mt-0 bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg shadow transition">Cerrar sesión</button>
      </header>

      <div v-if="loading" class="text-center text-gray-500 dark:text-gray-400">Cargando solicitudes...</div>

      <div v-else class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        <div v-for="req in requests" :key="req.id" class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ req.user.name }}</h3>
            <span :class="{
              'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-200': req.status === 'Pendiente',
              'bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-200': req.status === 'Aprobada',
              'bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-200': req.status === 'Rechazada'
            }" class="px-3 py-1 rounded-full font-medium text-sm">
              {{ req.status }}
            </span>
          </div>
          <p class="text-gray-600 dark:text-gray-300 mb-4">{{ req.type }} - {{ req.description }}</p>
          <div class="flex gap-2 justify-end">
            <button
              v-if="req.status !== 'Aprobada'"
              @click="updateStatus(req.id, 'Aprobada')"
              class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-lg shadow transition transform hover:scale-105"
            >
              Aprobar
            </button>
            <button
              v-if="req.status !== 'Rechazada'"
              @click="updateStatus(req.id, 'Rechazada')"
              class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg shadow transition transform hover:scale-105"
            >
              Rechazar
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

import api from './api';

export const useActivityTypes = () => {
  const getAll = async (onlyActive = true) => {
    try {
      const response = await api.get('/activity-types', { params: { active: onlyActive ? 1 : 0 } });
      return { success: true, data: response.data };
    } catch (error) {
      return {
        success: false,
        message: error.response?.data?.message || 'Error al obtener tipos de actividad',
      };
    }
  };

  const create = async (payload) => {
    try {
      const response = await api.post('/activity-types', payload);
      return { success: true, data: response.data };
    } catch (error) {
      return {
        success: false,
        message: error.response?.data?.message || 'Error al crear tipo',
        errors: error.response?.data?.errors,
      };
    }
  };

  const update = async (id, payload) => {
    try {
      const response = await api.put(`/activity-types/${id}`, payload);
      return { success: true, data: response.data };
    } catch (error) {
      return {
        success: false,
        message: error.response?.data?.message || 'Error al actualizar tipo',
        errors: error.response?.data?.errors,
      };
    }
  };

  const remove = async (id) => {
    try {
      await api.delete(`/activity-types/${id}`);
      return { success: true };
    } catch (error) {
      return {
        success: false,
        message: error.response?.data?.message || 'Error al eliminar tipo',
      };
    }
  };

  return { getAll, create, update, remove };
};

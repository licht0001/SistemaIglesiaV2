import api from './api';

export const useMinistries = () => {
  const getMinistries = async (filters = {}) => {
    try {
      const response = await api.get('/ministries', { params: filters });
      return { success: true, data: response.data };
    } catch (error) {
      return { success: false, message: error.response?.data?.message || 'Error al obtener ministerios' };
    }
  };

  const createMinistry = async (payload) => {
    try {
      const response = await api.post('/ministries', payload);
      return { success: true, data: response.data };
    } catch (error) {
      return { success: false, message: error.response?.data?.message || 'Error al crear ministerio', errors: error.response?.data?.errors };
    }
  };

  const updateMinistry = async (id, payload) => {
    try {
      const response = await api.put(`/ministries/${id}`, payload);
      return { success: true, data: response.data };
    } catch (error) {
      return { success: false, message: error.response?.data?.message || 'Error al actualizar ministerio', errors: error.response?.data?.errors };
    }
  };

  const deleteMinistry = async (id) => {
    try {
      await api.delete(`/ministries/${id}`);
      return { success: true };
    } catch (error) {
      return { success: false, message: error.response?.data?.message || 'Error al eliminar ministerio' };
    }
  };

  const syncMembers = async (id, members) => {
    try {
      const response = await api.post(`/ministries/${id}/members/sync`, { members });
      return { success: true, data: response.data };
    } catch (error) {
      return { success: false, message: error.response?.data?.message || 'Error al asignar miembros', errors: error.response?.data?.errors };
    }
  };

  const attachMember = async (id, memberId, role = null) => {
    try {
      const response = await api.post(`/ministries/${id}/members`, { member_id: memberId, role });
      return { success: true, data: response.data };
    } catch (error) {
      return { success: false, message: error.response?.data?.message || 'Error al adjuntar miembro' };
    }
  };

  const detachMember = async (id, memberId) => {
    try {
      const response = await api.delete(`/ministries/${id}/members/${memberId}`);
      return { success: true, data: response.data };
    } catch (error) {
      return { success: false, message: error.response?.data?.message || 'Error al desvincular miembro' };
    }
  };

  return { getMinistries, createMinistry, updateMinistry, deleteMinistry, syncMembers, attachMember, detachMember };
};

import api from './api';

export const useMembers = () => {
    const getMembers = async (filters = {}) => {
        try {
            const response = await api.get('/members', { params: filters });
            return { success: true, data: response.data };
        } catch (error) {
            return {
                success: false,
                message: error.response?.data?.message || 'Error al obtener miembros',
            };
        }
    };

    const getMember = async (id) => {
        try {
            const response = await api.get(`/members/${id}`);
            return { success: true, data: response.data };
        } catch (error) {
            return {
                success: false,
                message: error.response?.data?.message || 'Error al obtener miembro',
            };
        }
    };

    const createMember = async (memberData) => {
        try {
            const response = await api.post('/members', memberData);
            return { success: true, data: response.data };
        } catch (error) {
            return {
                success: false,
                message: error.response?.data?.message || 'Error al crear miembro',
                errors: error.response?.data?.errors,
            };
        }
    };

    const updateMember = async (id, memberData) => {
        try {
            const response = await api.put(`/members/${id}`, memberData);
            return { success: true, data: response.data };
        } catch (error) {
            return {
                success: false,
                message: error.response?.data?.message || 'Error al actualizar miembro',
                errors: error.response?.data?.errors,
            };
        }
    };

    const deleteMember = async (id) => {
        try {
            await api.delete(`/members/${id}`);
            return { success: true };
        } catch (error) {
            return {
                success: false,
                message: error.response?.data?.message || 'Error al eliminar miembro',
            };
        }
    };

    const exportMembers = async (filters = {}) => {
        try {
            const response = await api.get('/members/export', { 
                params: filters,
                responseType: 'blob' 
            });
            return { success: true, data: response.data };
        } catch (error) {
            return {
                success: false,
                message: error.response?.data?.message || 'Error al exportar miembros',
            };
        }
    };

    return {
        getMembers,
        getMember,
        createMember,
        updateMember,
        deleteMember,
        exportMembers,
    };
};

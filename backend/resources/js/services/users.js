import api from './api';

export const useUsers = () => {
    const getUsers = async () => {
        try {
            const response = await api.get('/users');
            return { success: true, data: response.data };
        } catch (error) {
            return {
                success: false,
                message: error.response?.data?.message || 'Error al obtener usuarios',
            };
        }
    };

    const createUser = async (userData) => {
        try {
            const response = await api.post('/users', userData);
            return { success: true, data: response.data };
        } catch (error) {
            return {
                success: false,
                message: error.response?.data?.message || 'Error al crear usuario',
                errors: error.response?.data?.errors,
            };
        }
    };

    const updateUser = async (id, userData) => {
        try {
            const response = await api.put(`/users/${id}`, userData);
            return { success: true, data: response.data };
        } catch (error) {
            return {
                success: false,
                message: error.response?.data?.message || 'Error al actualizar usuario',
                errors: error.response?.data?.errors,
            };
        }
    };

    const deleteUser = async (id) => {
        try {
            await api.delete(`/users/${id}`);
            return { success: true };
        } catch (error) {
            return {
                success: false,
                message: error.response?.data?.message || 'Error al eliminar usuario',
            };
        }
    };

    return {
        getUsers,
        createUser,
        updateUser,
        deleteUser,
    };
};

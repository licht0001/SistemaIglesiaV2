import api from './api';

export const useEvents = () => {
    const getEvents = async (filters = {}) => {
        try {
            const response = await api.get('/events', { params: filters });
            return { success: true, data: response.data };
        } catch (error) {
            return {
                success: false,
                message: error.response?.data?.message || 'Error al obtener eventos',
            };
        }
    };

    const createEvent = async (eventData) => {
        try {
            const response = await api.post('/events', eventData);
            return { success: true, data: response.data };
        } catch (error) {
            return {
                success: false,
                message: error.response?.data?.message || 'Error al crear evento',
                errors: error.response?.data?.errors,
            };
        }
    };

    const updateEvent = async (id, eventData) => {
        try {
            const response = await api.put(`/events/${id}`, eventData);
            return { success: true, data: response.data };
        } catch (error) {
            return {
                success: false,
                message: error.response?.data?.message || 'Error al actualizar evento',
                errors: error.response?.data?.errors,
            };
        }
    };

    const deleteEvent = async (id) => {
        try {
            await api.delete(`/events/${id}`);
            return { success: true };
        } catch (error) {
            return {
                success: false,
                message: error.response?.data?.message || 'Error al eliminar evento',
            };
        }
    };

    return {
        getEvents,
        createEvent,
        updateEvent,
        deleteEvent,
    };
};


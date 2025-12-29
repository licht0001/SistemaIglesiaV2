import api from './api';

export const useDashboard = () => {
    const getStats = async (month = null, year = null) => {
        try {
            const params = {};
            if (month) params.month = month;
            if (year) params.year = year;

            const response = await api.get('/dashboard/stats', { params });
            return { success: true, data: response.data };
        } catch (error) {
            return {
                success: false,
                message: error.response?.data?.message || 'Error al obtener estadísticas',
            };
        }
    };

    return {
        getStats,
    };
};


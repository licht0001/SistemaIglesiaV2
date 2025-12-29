import api from './api';

export const useTransactions = () => {
    const getTransactions = async (filters = {}) => {
        try {
            const response = await api.get('/transactions', { params: filters });
            return { success: true, data: response.data };
        } catch (error) {
            return {
                success: false,
                message: error.response?.data?.message || 'Error al obtener transacciones',
            };
        }
    };

    const createTransaction = async (transactionData) => {
        try {
            const response = await api.post('/transactions', transactionData);
            return { success: true, data: response.data };
        } catch (error) {
            return {
                success: false,
                message: error.response?.data?.message || 'Error al crear transacción',
                errors: error.response?.data?.errors,
            };
        }
    };

    const updateTransaction = async (id, transactionData) => {
        try {
            const response = await api.put(`/transactions/${id}`, transactionData);
            return { success: true, data: response.data };
        } catch (error) {
            return {
                success: false,
                message: error.response?.data?.message || 'Error al actualizar transacción',
                errors: error.response?.data?.errors,
            };
        }
    };

    const deleteTransaction = async (id) => {
        try {
            await api.delete(`/transactions/${id}`);
            return { success: true };
        } catch (error) {
            return {
                success: false,
                message: error.response?.data?.message || 'Error al eliminar transacción',
            };
        }
    };

    const exportTransactions = async (filters = {}) => {
        try {
            const response = await api.get('/transactions/export', { 
                params: filters,
                responseType: 'blob'
            });
            return { success: true, data: response.data };
        } catch (error) {
            return {
                success: false,
                message: error.response?.data?.message || 'Error al exportar transacciones',
            };
        }
    };

    return {
        getTransactions,
        createTransaction,
        updateTransaction,
        deleteTransaction,
        exportTransactions,
    };
};


import api from './api';
import { useRouter } from 'vue-router';

export const useAuth = () => {
    const router = useRouter();

    const login = async (email, password, remember = false) => {
        try {
            const response = await api.post('/auth/login', {
                email,
                password,
                remember,
            });

            const { user, token } = response.data;

            localStorage.setItem('auth_token', token);
            localStorage.setItem('user', JSON.stringify(user));

            return { success: true, user };
        } catch (error) {
            console.error('Error en login:', error);

            let message = 'Error al iniciar sesión';

            if (error.response) {
                // Error de respuesta del servidor
                if (error.response.status === 422) {
                    // Error de validación
                    const errors = error.response.data.errors;
                    if (errors && errors.email) {
                        message = errors.email[0];
                    } else {
                        message = error.response.data.message || 'Credenciales incorrectas';
                    }
                } else if (error.response.status === 401) {
                    message = 'Credenciales incorrectas';
                } else {
                    message = error.response.data?.message || `Error ${error.response.status}`;
                }
            } else if (error.request) {
                // Error de red
                message = 'No se pudo conectar con el servidor. Verifica tu conexión.';
            }

            return {
                success: false,
                message: message,
            };
        }
    };

    const logout = async () => {
        try {
            await api.post('/auth/logout');
        } catch (error) {
            console.error('Error al cerrar sesión:', error);
        } finally {
            localStorage.removeItem('auth_token');
            localStorage.removeItem('user');
            router.push('/login');
        }
    };

    const getUser = async () => {
        try {
            const response = await api.get('/auth/user');
            return { success: true, user: response.data.user };
        } catch (error) {
            return { success: false };
        }
    };

    const isAuthenticated = () => {
        return !!localStorage.getItem('auth_token');
    };

    const getStoredUser = () => {
        const userStr = localStorage.getItem('user');
        return userStr ? JSON.parse(userStr) : null;
    };

    const updateProfile = async (userData) => {
        try {
            const response = await api.put('/auth/profile', userData);
            const user = response.data.user;
            localStorage.setItem('user', JSON.stringify(user));
            return { success: true, user };
        } catch (error) {
            return {
                success: false,
                message: error.response?.data?.message || 'Error al actualizar perfil',
            };
        }
    };

    return {
        login,
        logout,
        getUser,
        isAuthenticated,
        getStoredUser,
        updateProfile,
    };
};


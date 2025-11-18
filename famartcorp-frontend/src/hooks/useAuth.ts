import { useEffect } from 'react';
import { useAuthStore } from '../store/authStore';

export const useAuth = () => {
  const { user, isAuthenticated, isLoading, error, login, register, logout, checkAuth, clearError } = useAuthStore();

  useEffect(() => {
    // Verificar autenticação apenas se não estiver autenticado e não estiver carregando
    if (!isAuthenticated && !isLoading) {
      checkAuth();
    }
  }, [isAuthenticated, isLoading, checkAuth]); // ✅ Dependências corretas

  const isMaster = user?.cargo === 'master';
  const isGestor = user?.cargo === 'gestor';
  const isConsultor = user?.cargo === 'consultor';

  const can = (action: string, resource?: any): boolean => {
    if (!user) return false;

    if (isMaster) return true;

    switch (action) {
      case 'create':
        return isMaster || isGestor;
      
      case 'update':
        if (isGestor) {
          return !resource || resource.equipe_id === user.equipe_id;
        }
        if (isConsultor) {
          return !resource || resource.consultor_id === user.id;
        }
        return false;

      case 'delete':
        return isMaster || isGestor;

      case 'view':
        if (isGestor) {
          return !resource || resource.equipe_id === user.equipe_id;
        }
        if (isConsultor) {
          return !resource || 
                 resource.consultor_id === user.id || 
                 resource.equipe_id === user.equipe_id;
        }
        return false;

      default:
        return false;
    }
  };

  return {
    user,
    isAuthenticated,
    isLoading,
    error,
    login,
    register,
    logout,
    checkAuth,
    clearError,
    isMaster,
    isGestor,
    isConsultor,
    can,
  };
};

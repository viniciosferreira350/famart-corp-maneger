import axios, { AxiosError, type InternalAxiosRequestConfig } from 'axios';
import type { 
  User, 
  Equipe, 
  Celular, 
  WhatsappNumero, 
  LoginRequest, 
  RegisterRequest,
  AuthResponse,
  PaginatedResponse,
  ApiError
} from '../types';

const BASE_URL = import.meta.env.VITE_API_URL || 'http://localhost:8000';

// ========== CONFIGURAÇÃO DO AXIOS ==========
const api = axios.create({
  baseURL: BASE_URL,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    'X-Requested-With': 'XMLHttpRequest',
  },
  withCredentials: true, // CRÍTICO: Envia cookies em todas as requisições
});

// ========== HELPER PARA OBTER CSRF COOKIE ==========
const getCsrfCookie = async (): Promise<void> => {
  try {
    console.log('🔐 Obtendo CSRF cookie...');
    
    // Usar axios diretamente (não a instância api) para evitar interceptors
    await axios.get(`${BASE_URL}/sanctum/csrf-cookie`, {
      withCredentials: true,
      headers: {
        'Accept': 'application/json',
      }
    });
    
    console.log('✅ CSRF cookie obtido com sucesso');
    console.log('📋 Cookies atuais:', document.cookie);
  } catch (error) {
    console.error('❌ Erro ao obter CSRF cookie:', error);
    throw error;
  }
};

// ========== INTERCEPTOR DE REQUEST ==========
api.interceptors.request.use(
  async (config: InternalAxiosRequestConfig) => {
    console.log(`📤 ${config.method?.toUpperCase()} ${config.url}`);
    
    // Para métodos que modificam dados, garantir CSRF token
    if (['post', 'put', 'patch', 'delete'].includes(config.method || '')) {
      // Verificar se já temos o cookie XSRF-TOKEN
      const hasXsrfToken = document.cookie.includes('XSRF-TOKEN');
      
      if (!hasXsrfToken) {
        console.warn('⚠️ XSRF-TOKEN não encontrado, obtendo...');
        await getCsrfCookie();
      }
      
      // Extrair token do cookie e adicionar ao header
      const cookies = document.cookie.split(';');
      const xsrfCookie = cookies.find(c => c.trim().startsWith('XSRF-TOKEN='));
      
      if (xsrfCookie) {
        const token = decodeURIComponent(xsrfCookie.split('=')[1]);
        config.headers['X-XSRF-TOKEN'] = token;
        console.log('🔑 X-XSRF-TOKEN adicionado ao header');
      } else {
        console.error('❌ XSRF-TOKEN não encontrado nos cookies!');
      }
    }
    
    return config;
  },
  (error) => {
    console.error('❌ Erro no interceptor de request:', error);
    return Promise.reject(error);
  }
);

// ========== INTERCEPTOR DE RESPONSE ==========
api.interceptors.response.use(
  (response) => {
    console.log(`✅ ${response.config.method?.toUpperCase()} ${response.config.url} - ${response.status}`);
    return response;
  },
  (error: AxiosError<ApiError>) => {
    const status = error.response?.status;
    const message = error.response?.data?.message || error.message;
    
    console.error(`❌ Erro ${status}: ${message}`);
    
    if (status === 419) {
      console.error('🔒 CSRF Token expirado ou inválido');
      // Limpar cookies e forçar nova obtenção
      document.cookie.split(";").forEach((c) => {
        document.cookie = c.replace(/^ +/, "").replace(/=.*/, "=;expires=" + new Date().toUTCString() + ";path=/");
      });
    }
    
    return Promise.reject(error);
  }
);

// ========== AUTH API ==========
export const authApi = {
  async login(credentials: LoginRequest): Promise<AuthResponse> {
    console.log('🔐 Iniciando login...');
    await getCsrfCookie(); // Obter cookie ANTES do login
    const { data } = await api.post<AuthResponse>('/login', credentials);
    console.log('✅ Login realizado com sucesso');
    return data;
  },

  async register(userData: RegisterRequest): Promise<AuthResponse> {
    console.log('📝 Iniciando registro...');
    await getCsrfCookie(); // Obter cookie ANTES do registro
    const { data } = await api.post<AuthResponse>('/register', userData);
    console.log('✅ Registro realizado com sucesso');
    return data;
  },

  async logout(): Promise<void> {
    console.log('👋 Fazendo logout...');
    await api.post('/logout');
    console.log('✅ Logout realizado');
  },

  async getCurrentUser(): Promise<User> {
    const { data } = await api.get<User>('/api/user');
    return data;
  },
};

// ========== EQUIPES API ==========
export const equipesApi = {
  async getAll(): Promise<Equipe[]> {
    const { data } = await api.get<Equipe[]>('/api/equipes');
    return data;
  },

  async getById(id: number): Promise<Equipe> {
    const { data } = await api.get<Equipe>(`/api/equipes/${id}`);
    return data;
  },

  async create(equipe: Partial<Equipe>): Promise<Equipe> {
    const { data } = await api.post<Equipe>('/api/equipes', equipe);
    return data;
  },

  async update(id: number, equipe: Partial<Equipe>): Promise<Equipe> {
    const { data } = await api.put<Equipe>(`/api/equipes/${id}`, equipe);
    return data;
  },

  async delete(id: number): Promise<void> {
    await api.delete(`/api/equipes/${id}`);
  },
};

// ========== CELULARES API ==========
export const celularesApi = {
  async getAll(): Promise<Celular[]> {
    const { data } = await api.get<Celular[]>('/api/celulares');
    return data;
  },

  async getById(id: number): Promise<Celular> {
    const { data } = await api.get<Celular>(`/api/celulares/${id}`);
    return data;
  },

  async create(celular: Partial<Celular>): Promise<Celular> {
    const { data } = await api.post<Celular>('/api/celulares', celular);
    return data;
  },

  async update(id: number, celular: Partial<Celular>): Promise<Celular> {
    const { data } = await api.put<Celular>(`/api/celulares/${id}`, celular);
    return data;
  },

  async delete(id: number): Promise<void> {
    await api.delete(`/api/celulares/${id}`);
  },
};

// ========== WHATSAPP API ==========
export const whatsappApi = {
  async getAll(params?: { 
    status?: string; 
    equipe_id?: number; 
    consultor_id?: number;
  }): Promise<PaginatedResponse<WhatsappNumero>> {
    const { data } = await api.get<PaginatedResponse<WhatsappNumero>>('/api/whatsapp', { params });
    return data;
  },

  async getById(id: number): Promise<WhatsappNumero> {
    const { data } = await api.get<WhatsappNumero>(`/api/whatsapp/${id}`);
    return data;
  },

  async create(whatsapp: Partial<WhatsappNumero>): Promise<WhatsappNumero> {
    const { data } = await api.post<WhatsappNumero>('/api/whatsapp', whatsapp);
    return data;
  },

  async update(id: number, whatsapp: Partial<WhatsappNumero>): Promise<WhatsappNumero> {
    const { data } = await api.put<WhatsappNumero>(`/api/whatsapp/${id}`, whatsapp);
    return data;
  },

  async delete(id: number): Promise<void> {
    await api.delete(`/api/whatsapp/${id}`);
  },
};

// ========== CONSULTORES API ==========
export const consultoresApi = {
  async getAll(params?: { equipe_id?: number }): Promise<User[]> {
    const { data } = await api.get<User[]>('/api/consultores', { params });
    return data;
  },

  async getById(id: number): Promise<User> {
    const { data } = await api.get<User>(`/api/consultores/${id}`);
    return data;
  },

  async create(consultor: Partial<User>): Promise<User> {
    const { data } = await api.post<User>('/api/consultores', consultor);
    return data;
  },

  async update(id: number, consultor: Partial<User>): Promise<User> {
    const { data } = await api.put<User>(`/api/consultores/${id}`, consultor);
    return data;
  },

  async delete(id: number): Promise<void> {
    await api.delete(`/api/consultores/${id}`);
  },
};

export default api;

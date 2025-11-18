export type Cargo = 'consultor' | 'gestor' | 'master';

export type WhatsappStatus = 
  | 'ativo' 
  | 'restrito' 
  | 'banido' 
  | 'banido_permanente' 
  | 'emprestado';

export interface User {
  id: number;
  name: string;
  email: string;
  cargo: Cargo;
  equipe_id: number | null;
  equipe?: Equipe;
  celulares?: Celular[];
  whatsappNumeros?: WhatsappNumero[];
  created_at: string;
  updated_at: string;
}

export interface Equipe {
  id: number;
  nome: string;
  gestor_id: number | null;
  gestor?: User;
  consultores?: User[];
  celulares?: Celular[];
  created_at: string;
  updated_at: string;
}

export interface Celular {
  id: number;
  marca: string;
  modelo: string;
  imei: string | null;
  observacao: string | null;
  consultor_id: number;
  equipe_id: number;
  consultor?: User;
  equipe?: Equipe;
  whatsappNumeros?: WhatsappNumero[];
  created_at: string;
  updated_at: string;
}

export interface WhatsappNumero {
  id: number;
  numero: string;
  status: WhatsappStatus;
  celular_id: number;
  consultor_id: number;
  equipe_id: number;
  celular?: Celular;
  consultor?: User;
  equipe?: Equipe;
  created_at: string;
  updated_at: string;
}

export interface PaginatedResponse<T> {
  data: T[];
  current_page: number;
  last_page: number;
  per_page: number;
  total: number;
}

export interface ApiError {
  message: string;
  errors?: Record<string, string[]>;
}

export interface LoginRequest {
  email: string;
  password: string;
}

export interface RegisterRequest {
  name: string;
  email: string;
  password: string;
  password_confirmation: string;
  cargo?: Cargo;
  equipe_id?: number;
}

export interface AuthResponse {
  user: User;
  token?: string;
}

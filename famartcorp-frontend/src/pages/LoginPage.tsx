import { useState } from 'react';
import { useNavigate, Link } from 'react-router-dom';
import { useAuth } from '../hooks/useAuth';
import './Auth.css';

export const LoginPage = () => {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const { login, error, clearError } = useAuth();
  const navigate = useNavigate();

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    clearError();
    
    try {
      await login({ email, password });
      navigate('/dashboard');
    } catch (error) {
      // Erro já está sendo tratado no store
    }
  };

  return (
    <div className="auth-container">
      <div className="auth-card">
        <h1>Famartcorp Manager</h1>
        <h2>Login</h2>
        
        {error && <div className="error-message">{error}</div>}
        
        <form onSubmit={handleSubmit}>
          <div className="form-group">
            <label htmlFor="email">Email</label>
            <input
              type="email"
              id="email"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              required
              placeholder="seu@email.com"
            />
          </div>

          <div className="form-group">
            <label htmlFor="password">Senha</label>
            <input
              type="password"
              id="password"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
              required
              placeholder="••••••••"
            />
          </div>

          <button type="submit" className="btn-primary">
            Entrar
          </button>
        </form>

        <p className="auth-link">
          Não tem uma conta? <Link to="/register">Registre-se</Link>
        </p>

        <div className="demo-credentials">
          <h3>Credenciais de Demonstração:</h3>
          <p><strong>Master:</strong> admin@famartcorp.com / password</p>
          <p><strong>Gestor:</strong> joao.silva@famartcorp.com / password</p>
          <p><strong>Consultor:</strong> pedro.oliveira@famartcorp.com / password</p>
        </div>
      </div>
    </div>
  );
};

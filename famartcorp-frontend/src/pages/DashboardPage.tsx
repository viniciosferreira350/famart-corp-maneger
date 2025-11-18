import { useAuth } from '../hooks/useAuth';
import './Dashboard.css';

export const DashboardPage = () => {
  const { user, isMaster, isGestor, isConsultor } = useAuth();

  return (
    <div className="dashboard">
      <h1>Dashboard</h1>
      
      <div className="welcome-card">
        <h2>Bem-vindo, {user?.name}!</h2>
        <p>Cargo: <strong>{user?.cargo}</strong></p>
        {user?.equipe && <p>Equipe: <strong>{user.equipe.nome}</strong></p>}
      </div>

      <div className="stats-grid">
        {isMaster && (
          <>
            <div className="stat-card">
              <h3>Total de Equipes</h3>
              <p className="stat-number">-</p>
            </div>
            <div className="stat-card">
              <h3>Total de Consultores</h3>
              <p className="stat-number">-</p>
            </div>
          </>
        )}
        
        <div className="stat-card">
          <h3>Celulares {isConsultor && 'Meus'}</h3>
          <p className="stat-number">-</p>
        </div>
        
        <div className="stat-card">
          <h3>Números WhatsApp {isConsultor && 'Meus'}</h3>
          <p className="stat-number">-</p>
        </div>

        <div className="stat-card">
          <h3>Números Ativos</h3>
          <p className="stat-number">-</p>
        </div>

        <div className="stat-card">
          <h3>Números Restritos</h3>
          <p className="stat-number">-</p>
        </div>
      </div>

      <div className="info-card">
        <h3>Próximos Passos</h3>
        <ul>
          <li>Navegue pelo menu superior para acessar as diferentes seções</li>
          {(isMaster || isGestor) && <li>Gerencie equipes e consultores</li>}
          <li>Visualize e gerencie celulares e números WhatsApp</li>
          <li>Atualize o status dos números conforme necessário</li>
        </ul>
      </div>
    </div>
  );
};

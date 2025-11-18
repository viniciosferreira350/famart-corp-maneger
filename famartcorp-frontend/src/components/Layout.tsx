import { Link, Outlet, useNavigate } from 'react-router-dom';
import { useAuth } from '../hooks/useAuth';
import './Layout.css';

export const Layout = () => {
  const { user, logout, isMaster, isGestor } = useAuth();
  const navigate = useNavigate();

  const handleLogout = async () => {
    await logout();
    navigate('/login');
  };

  return (
    <div className="layout">
      <nav className="navbar">
        <div className="navbar-brand">
          <h1>Famartcorp Manager</h1>
        </div>
        <ul className="navbar-menu">
          <li><Link to="/dashboard">Dashboard</Link></li>
          {(isMaster || isGestor) && (
            <li><Link to="/equipes">Equipes</Link></li>
          )}
          <li><Link to="/celulares">Celulares</Link></li>
          <li><Link to="/whatsapp">WhatsApp</Link></li>
          {(isMaster || isGestor) && (
            <li><Link to="/consultores">Consultores</Link></li>
          )}
        </ul>
        <div className="navbar-user">
          <span>{user?.name} ({user?.cargo})</span>
          <button onClick={handleLogout}>Sair</button>
        </div>
      </nav>
      <main className="main-content">
        <Outlet />
      </main>
    </div>
  );
};

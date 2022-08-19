import axios from '../Services/axios';
import { useNavigate } from 'react-router-dom';
import { FaRegUserCircle } from 'react-icons/fa';
import { useRef, useState, useEffect } from 'react';
import { CookiesProvider, useCookies } from 'react-cookie';

const LOGIN_URL = '/api/login_check';

const Login = () => {
  const userRef = useRef();

  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');
  const [errMsg, setErrMsg] = useState('');
  const [cookies, setCookie] = useCookies(['token']); // eslint-disable-line

  useEffect(() => {
    userRef.current.focus();
  }, [])

  useEffect(() => {
    setErrMsg('');
  }, [username, password])

  const navigate = useNavigate();

  const navigateHome = () => {
    navigate('/');
  }

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      const response = await axios.post(
        LOGIN_URL,
        JSON.stringify({ username, password }),
        { headers: { 'content-type': 'application/json' } }
      );
      const accessToken = response?.data.token
      setCookie('token', accessToken);
      setUsername('');
      setPassword('');
      navigateHome();
    } catch (err) {
      setErrMsg('Identifiants invalides');
      if (!err?.response) setErrMsg('Server muet');
    }
  }

  return (
    <CookiesProvider>
      <main>
        <section className='container'>
          <div className='d-flex justify-content-center vh-100 align-items-center'>
            <form
              onSubmit={handleSubmit}
              className='p-3 mt-3'
            >
              <p className='svg-login text-center'><FaRegUserCircle /></p>
              <p className='text-center text-danger'>{errMsg}</p>
              <div className='row g-3'>
                <input
                  className='form-control'
                  placeholder='Votre email'
                  type="text"
                  id="username"
                  ref={userRef}
                  onChange={(e) => setUsername(e.target.value)}
                  value={username}
                  required
                />
              </div>
              <br />
              <div className='row g-3'>
                <input
                  className='form-control'
                  placeholder='Votre mot de passe'
                  type="password"
                  id="password"
                  onChange={(e) => setPassword(e.target.value)}
                  value={password}
                  required
                />
              </div>
              <div className='d-grid mx-auto'>
                <button className='btn btn-primary mt-5'>
                  Login
                </button>
              </div>
            </form>
          </div>
        </section>
      </main>
    </CookiesProvider>
  )
}

export default Login

import Login from '../Components/Login';
import '@testing-library/jest-dom/extend-expect';
import {BrowserRouter as Router} from 'react-router-dom';
import { render, screen } from '@testing-library/react';

it('should render login component', () => {
  render(
    <Router>
      <Login />,
    </Router>,
  );

  const emailInput = screen.getByTestId('email');
  expect(emailInput).toBeInTheDocument();

  const emailInputPlaceholder = screen.queryByPlaceholderText('Votre email');
  expect(emailInputPlaceholder).toBeInTheDocument();

  const passwordInput = screen.getByTestId('password');
  expect(passwordInput).toBeInTheDocument();

  const passwordInputPlaceholder = screen.queryByPlaceholderText('Votre mot de passe');
  expect(passwordInputPlaceholder).toBeInTheDocument();

  const loginButton = screen.getByTestId('login');
  expect(loginButton).toBeInTheDocument();
  expect(loginButton).toHaveTextContent('Login');
});

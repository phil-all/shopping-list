import './index.scss';
import App from './App';
import ReactDOM from "react-dom/client";
import { CookiesProvider } from "react-cookie";

const root = ReactDOM.createRoot(
  document.getElementById("root")
);
root.render(
  <CookiesProvider>
    <App />
  </CookiesProvider>
);

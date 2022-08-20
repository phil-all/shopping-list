import { useNavigate } from "react-router-dom";

export const Login = () => {
    useNavigate('/login');
    }

const Home = () => {
    useNavigate('/');
    }

export default Home;
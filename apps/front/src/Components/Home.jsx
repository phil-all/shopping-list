import React from 'react';
import { useState, useEffect } from 'react';
import axios from '../Services/Http/axios';
import { useCookies } from "react-cookie";
import { useNavigate } from 'react-router-dom';
import Header from './_Base/Header';
import Footer from './_Base/Footer';
import List from './_Home/List';
import ProductManagement from './_Home/ProductManagement';

/**
 * Dashboard component
 */
const Home = () => {
  const [cookies] = useCookies();
  const [shoppingLists, setShoppingLists] = useState([]);

  const config = {
    headers: {
      'Content-Type': 'application/json',
      'Authorization': 'Bearer ' + cookies.token
    }
  }

  const navigate = useNavigate();

  const navigateLogin = () => {
    navigate('/login');
  }

  useEffect(() => {
    const fetchShoppingLists = async () => {
      try {
        const responseShoppingLists = await axios.get(
          '/api/shopping_lists',
          config
        );
        const lists = responseShoppingLists.data;

        setShoppingLists(lists);
      } catch (err) {
        if (err.request.status === 401) navigateLogin();
      }
    }
    (async () => await fetchShoppingLists())();
  }, [])

  return (
    <main className='d-flex flex-column'>
      <section>
        <Header title="Mon espace" />
      </section>
      <section className='d-flex flex-grow-1'>
        <div className='container'>
          <List
            shoppingLists={shoppingLists}
          />
          <ProductManagement />
        </div>
      </section>
      <Footer />
    </main>
  );
}

export default Home
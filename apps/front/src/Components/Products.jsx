import axios from '../Services/axios';
import Header from './_Base/Header';
import Footer from './_Base/Footer';
import { useCookies } from "react-cookie";
import { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import AddProduct from './_Products/AddProduct';
import ProductsContent from './_Products/ProductsContent';

const Products = () => {
  const [cookies] = useCookies();
  const [products, setProducts] = useState([]);
  const [newProduct, setNewProduct] = useState('');

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
    const fetchProducts = async () => {
      try {
        const response = await axios.get(
          '/api/products',
          config
        );
        const listProducts = response.data;
        setProducts(listProducts);
      } catch (err) {
        if (err.request.status === 401) navigateLogin();
      }
    }
    (async () => await fetchProducts())();
  }, [])

  const setAndSaveProducts = (newProducts) => {
    setProducts(newProducts);
    localStorage.setProduct('shoppinglist', JSON.stringify(newProducts));
  }

  const addProduct = async (name) => {
    try {
      const response = axios.post(
        '/api/products',
        { 'name': name },
        config
      );
      const myNewProduct = (await response).data;
      const listProducts = [...products, myNewProduct];
      setAndSaveProducts(listProducts);
    } catch (err) {
      console.log(err.stack)
    }
  }

  const removeItem = async (id) => {
    try {
      axios.delete(
        '/api/products/' + id,
        config
      );
      const listProducts = products.filter((product) => product.id !== id);
      setAndSaveProducts(listProducts);
    } catch (err) {
      console.log(err.stack)
    }
  }

  const handleDelete = (id) => {
    removeItem(id);
  }

  const handleSubmit = (e) => {
    e.preventDefault();
    if (!newProduct) return;
    addProduct(newProduct);
    setNewProduct('');
  }

  return (
    <main className='d-flex flex-column'>
      <section>
      <Header title="Mes produits" />
      <AddProduct
        newProduct={newProduct}
        setNewProduct={setNewProduct}
        handleSubmit={handleSubmit}
      />
      </section>
      <section className='d-flex flex-grow-1'>
      <div className='container'>
        <ProductsContent
          products={products}
          handleDelete={handleDelete}
        />
      </div>
      </section>
      <Footer />
    </main>
  );
}

export default Products;

import Header from './_Base/Header';
import Footer from './_Base/Footer';
import { useCookies } from "react-cookie";
import axios from '../Services/Http/axios';
import { useNavigate } from 'react-router-dom';
import AddProduct from './_Products/AddProduct';
import { React, useEffect, useState } from 'react';
import ProductsContent from './_Products/ProductsContent';

/**
 * Products manager component.
 */
const Products = () => {
  const [cookies] = useCookies();
  const [products, setProducts] = useState([]);
  const [newProduct, setNewProduct] = useState('');

  const [departments, setDepartments] = useState('');
  const [newDepartment, setNewDepartment] = useState('');

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
        const responseProducts = await axios.get(
          '/api/products',
          config
        );

        const responseDepartments = await axios.get(
          '/api/departments',
          config
        );

        const listProducts = responseProducts.data;
        const listDepartments = responseDepartments.data;

        listProducts.sort((a, b) => (a.department.id > b.department.id) ? 1 : -1)

        setProducts(listProducts);
        setDepartments(listDepartments);
      } catch (err) {
        if (err.request.status === 401) navigateLogin();
      }
    }
    (async () => await fetchProducts())();
  }, [])

  const setAndSaveProducts = (listProducts) => {
    setProducts(listProducts);
  }

  const addProduct = async (productName, department) => {
    try {
      const postUrl = "/api/departments/" + department.id;

      const response = axios.post(
        '/api/products',
        {
          'name': productName,
          "department": postUrl
        },
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
    //if (!newProduct || !newDepartment) return;

    addProduct(newProduct, newDepartment);
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
          departments={departments}
          newDepartment={newDepartment}
          setNewDepartment={setNewDepartment}
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

import Header from './_Base/Header';
import { useCookies } from 'react-cookie';
import { useParams } from 'react-router-dom';
import React, { useEffect, useState } from 'react';
import NewProductForm from './_ShoppingList/NewProductForm';
import SearchItemForm from './_ShoppingList/SearchItemForm';
import SelectedProducts from './_ShoppingList/SelectedProducts';
import SearchResults from './_ShoppingList/SearchResults';
import { getShoppingLists, getItemList } from '../Services/Requests/shoppingListsRequests'
import { getProducts, postProducts } from '../Services/Requests/productsRequests';
import { getDepartmenents } from '../Services/Requests/departmentsRequest';
import { createItemList, putQuantityItemList, deleteItemList } from '../Services/Requests/itemListsRequests';

/**
 * Shopping list component, could return:
 *  - SelectedProducts
 *  - SearchResults
 *  - NewProductForm
 */
const ShoppingList = () => {
  const [cookie] = useCookies();
  const shoppingListId = (useParams()).shoppingListId;

  const [list, setList] = useState([]);
  const [items, setItems] = useState([]);
  const [searchItem, setSearchItem] = useState('');
  const [products, setProducts] = useState([]);
  const [departments, setDepartments] = useState([]);

  useEffect(() => {
    const fetchItems = async () => {
      try {
        const responseList = await getShoppingLists(cookie.token, shoppingListId);
        const responseItems = await getItemList(cookie.token, shoppingListId);
        const responseProducts = await getProducts(cookie.token);
        const responseDepartments = await getDepartmenents(cookie.token);

        const listData = responseList.data;
        const itemsData = responseItems.data;
        const productsData = responseProducts.data;
        const departmentsData = responseDepartments.data;

        itemsData.sort((a, b) => (a.product.department.id > b.product.department.id) ? 1 : -1);

        setList(listData);
        setItems(itemsData);
        setProducts(productsData);
        setDepartments(departmentsData);

      } catch (err) {
        console.log(err);
        //if (err.request.status === 401) navigateLogin();
        if (err.request.status === 401) alert('erreur 401, merci de vous reconnecter.');
      }
    }
    (async () => await fetchItems())();
  }, [])

  /**
   * Add new item to current list
   * 
   * @param {*} newList 
   */
  const updateList = (newList) => {
    newList.sort((a, b) => (a.product.department.id > b.product.department.id) ? 1 : -1)
    setItems(newList);
  }

  /**
   * Handle delete item from selected products list
   * @param {int} itemId 
   */
  const handleDeleteItem = (itemId) => {
    removeItemList(itemId);
  }

  /**
   * Handle new product form submit from to create new item list
   * @param {*} e 
   */
  const handleSubmitNewProduct = async (e) => {
    try {
      e.preventDefault();
      const newProductDepartmentId = parseInt(e.target[2].value);
      const newProductName = e.target[3].value;
      const newProductQuantity = parseInt(e.target[4].value);
      console.log(newProductDepartmentId, e);
      const responseProduct = await postProducts(cookie.token, newProductName, newProductDepartmentId);

      const newProduct = responseProduct.data;
      const productUrl = '/api/products/' + newProduct.id;

      const responseItemList = await createItemList(cookie.token, shoppingListId, productUrl, newProductQuantity);

      const newItem = responseItemList.data;
      const newList = [...items, newItem];

      updateList(newList);
      setSearchItem('');

    } catch (err) {
      console.log(err);
      //if (err.request.status === 401) navigateLogin();
      if (err.request.status === 401) alert('erreur 401, merci de vous reconnecter.');
    }
  }

  /**
   * Handle form submit from filtered product item list to create new item list
   * 
   * @param {*} e 
   */
  const handleSubmitRegistredProduct = (e) => {
    e.preventDefault();
    const productUrl = '/api/products/' + e.target[0].value;
    const quantity = parseInt(e.target[1].value);

    createNewItemList(productUrl, quantity);
    setSearchItem('');
  }

  /**
   * Handle quantity update from selected products list
   * 
   * @param {int} itemId 
   * @param {int} quantity 
   * @param {int} value 
   */
  const handleQuantity = async (itemId, quantity, value) => {
    const newQuantity = quantity + value;

    if (newQuantity > 0 && newQuantity < 100) {
      try {
        await putQuantityItemList(cookie.token, itemId, newQuantity);
        const responseItems = await getItemList(cookie.token, shoppingListId);
        const newList = responseItems.data;

        updateList(newList);

      } catch (err) {
        console.log(err);
        //if (err.request.status === 401) navigateLogin();
        if (err.request.status === 401) alert('erreur 401, merci de vous reconnecter.');
      }
    }
  }

  /**
   * Create a new item in current shopping list
   * 
   * @param {string} productUrl 
   * @param {int} quantity 
   */
  const createNewItemList = async (productUrl, quantity) => {
    try {
      const responseItemList = await createItemList(cookie.token, shoppingListId, productUrl, quantity);

      const newItem = responseItemList.data;
      const newList = [...items, newItem];

      updateList(newList);
    } catch (err) {
      console.log(err);
      //if (err.request.status === 401) navigateLogin();
      if (err.request.status === 401) alert('erreur 401, merci de vous reconnecter.');
    }
  }

  /**
   * Remove a specific item from shopping list
   * @param {int} itemId 
   */
  const removeItemList = async (itemId) => {
    try {
      const response = await deleteItemList(cookie.token, itemId);
      const newList = items.filter((item) => item.id !== itemId);
      updateList(newList);

    } catch (err) {
      console.log(err);
      //if (err.request.status === 401) navigateLogin();
      if (err.request.status === 401) alert('erreur 401, merci de vous reconnecter.');
    }
  }

  /**
   * Return component to display in shopping list page,
   * depending on search field content.
   */
  const DisplayContent = () => {
    if (searchItem === '') {
      return <SelectedProducts
        items={items}
        handleDeleteItem={handleDeleteItem}
        handleQuantity={handleQuantity}
      />
        ;
    } else {
      const searchResults = products.filter(value => value.name.toLowerCase().includes(searchItem));
      if (searchResults.length) {
        return <SearchResults
          products={products}
          searchItem={searchItem}
          handleSubmitRegistredProduct={handleSubmitRegistredProduct}
        />;
      } else {
        return <NewProductForm
          searchItem={searchItem}
          departments={departments}
          handleSubmitNewProduct={handleSubmitNewProduct}
        />;
      }
    }
  }

  return (
    <div>
      <header>
        <Header title={list.name} />
      </header>
      <section>
        <SearchItemForm
          searchItem={searchItem}
          setSearchItem={setSearchItem}
          products={products}
        />
      </section>
      <section>
        <div className='container'>
          <DisplayContent />
        </div>
      </section>
    </div>
  )
}

export default ShoppingList
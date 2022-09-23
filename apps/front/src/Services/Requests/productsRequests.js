import axios from '../Http/axios';
import { headers } from '../Http/headers';

/**
 * Return HTTP request to get products.
 * 
 * @param {string} token 
 * @returns
 */
const getProducts = async (token) => {
  return await axios.get(
    '/api/products',
    headers(token)
  );
}

/**
 * Retun HTTP request ro post new product.
 * 
 * @param {string} token 
 * @param {string} name 
 * @param {int} departmentId
 * @returns 
 */
const postProducts = async (token, name, departmentId) => {
  const body = {
    "name": name,
    "department": '/api/departments/' + departmentId
  }

  return await axios.post(
    'api/products',
    body,
    headers(token)
  )
}

export { getProducts, postProducts };
import axios from '../Http/axios';
import { headers } from '../Http/headers';

/**
 * Return HTTP request to get departments.
 * 
 * @param {string} token 
 * @returns
 */
const getDepartmenents = async (token) => {
  return await axios.get(
    '/api/departments',
    headers(token)
  );
}

export { getDepartmenents };
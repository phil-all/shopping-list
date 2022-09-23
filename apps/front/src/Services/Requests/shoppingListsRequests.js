import axios from '../Http/axios';
import { headers } from '../Http/headers';

/**
 * Return HTTP request to get a specific shopping list.
 * 
 * @param {*} token 
 * @param {*} shoppingListId 
 * @returns 
 */
const getShoppingLists = async (token, shoppingListId) => {
  return await axios.get(
    '/api/shopping_lists/' + shoppingListId,
    headers(token)
  );
}

/**
 * Return HTTP request to get items from a specific shopping list.
 * 
 * @param {*} token 
 * @param {*} shoppingListId 
 * @returns 
 */
const getItemList = async (token, shoppingListId) => {
  return await axios.get(
    '/api/shopping_lists/' + shoppingListId + '/item_lists',
    headers(token)
  );
}

export { getShoppingLists, getItemList };

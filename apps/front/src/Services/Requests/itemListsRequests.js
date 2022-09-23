import axios from '../Http/axios';
import { headers } from '../Http/headers';

/**
 * Return Http request to create new item list.
 * 
 * @param {string} token 
 * @param {string} shoppingListId 
 * @param {string} productUrl 
 * @param {int} quantity 
 * @returns 
 */
const createItemList = async (token, shoppingListId, productUrl, quantity) => {
  const currentShoppingListUrl = '/api/shopping_lists/' + shoppingListId;

  return await axios.post(
    '/api/item_lists',
    {
      "quantity": quantity,
      "shoppingList": currentShoppingListUrl,
      "product": productUrl
    },
    headers(token)
  );
}

/**
 * Return Http request to delete a specific item list.
 * @param {string} token 
 * @param {int} itemId 
 * @returns 
 */
const deleteItemList = (token, itemId) => {
  return axios.delete(
    '/api/item_lists/' + itemId,
    headers(token)
  );
}

const putQuantityItemList = async (token, itemId, newQuantity) => {
  const body = { "quantity": newQuantity };
  return await putItemList(token, itemId, body);
}

const putItemList = async (token, itemId, body) => {
  return await axios.put(
    '/api/item_lists/' + itemId,
    body,
    headers(token)
  );
}

export { createItemList, putQuantityItemList, deleteItemList };
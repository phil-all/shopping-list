import React from 'react';
import { Link } from 'react-router-dom';

const ShoppingListsItem = ({ list }) => {
  const link = "/shopping-lists/" + list.id;
  return (
    <li
      key={list.id}
      className='list list-group-item'
    >
      <Link
        to={link}
        style={{ textDecoration: 'none' }}
      >
        {list.name}
      </Link>
    </li>
  )
}

export default ShoppingListsItem
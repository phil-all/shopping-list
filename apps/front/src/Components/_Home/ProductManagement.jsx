import React from 'react';
import { Link } from 'react-router-dom';

const ProductManagement = () => {
  return (
    <>
      <h5 className='mt-2 text-primary'>Catalogue</h5>
      <ul className='list-group my-3 list-group'>
        <li className='list list-group-item'>
          <Link
            to={'/products'}
            style={{ textDecoration: 'none' }}
          >
            Produits enregistrés
          </Link>
        </li>
      </ul>
    </>
  )
}

export default ProductManagement
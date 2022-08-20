import React from 'react';
import { FaTrashAlt } from 'react-icons/fa';

const ProductListItem = ({ product, handleCheck, handleDelete }) => {
  return (
    <li className="product list-group-item">
      <article className='d-flex justify-content-between'>
        <label>
          {product.name}
        </label>
        <div className='trash'>
          <FaTrashAlt
            onClick={() => handleDelete(product.id)}
            role="button"
            tabIndex="0"
            aria-label={`Delete ${product.name}`}
          />
        </div>
      </article>
    </li>
  );
}

export default ProductListItem

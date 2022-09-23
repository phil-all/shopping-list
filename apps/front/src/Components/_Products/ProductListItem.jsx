import React from 'react';
import { FaTrashAlt } from 'react-icons/fa';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';

const ProductListItem = ({ product, handleDelete }) => {
  return (
    <li className="list list-group-item">
      <article className='row'>
        <div className='col-1'>
          <div style={{
            width: '24px',
            backgroundColor: product.department.color,
            color: 'black',
            textAlign: 'center',
            borderRadius: '50%'
          }}>
            <FontAwesomeIcon icon={product.department.icon} />
          </div>
        </div>
        <label className='col-8 col-sm-9 ps-3'>
          {product.name}
        </label>
        <div className='text-success pe-3 col-1'>
          <FontAwesomeIcon icon="gear" />
        </div>
        <div className='text-danger col-1'>
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

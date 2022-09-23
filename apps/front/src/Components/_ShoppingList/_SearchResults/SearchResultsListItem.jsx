import React, { useState } from 'react';
import { FaPlus } from 'react-icons/fa';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';

const SearchResultsListItem = ({ product, handleSubmitRegistredProduct }) => {
  const [quantity, setQuantity] = useState(1);

  return (
    <li className="list list-group-item p-1">
      <form
        className='d-flex'
        onSubmit={handleSubmitRegistredProduct}
      >
        {/* *** department icon *** */}
        <div style={{
          minWidth: '24px',
          height: '24px',
          backgroundColor: product.department.color,
          color: 'black',
          textAlign: 'center',
          borderRadius: '50%'
        }}>
          <FontAwesomeIcon icon={product.department.icon} />
        </div>

        {/* *** hidden input to submit product id */}
        <div className='d-none'>
          <input
            id='product'
            type='text'
            name='product_id'
            defaultValue={product.id}
            data-testid='product'
          />
        </div>

        {/* *** filtered product name *** */}
        <div
          className='ps-3'
          style={{ width: '100%' }}
        >
          {product.name}
        </div>

        {/* *** quantity *** */}
        <div className='pe-3'>
          <input
            id='quantity'
            placeholder='1'
            required
            className='bg-dark form-control text-primary text-center'
            style={{ height: '25px', width: '55px', border: 'none' }}
            type='text'
            name='quantity'
            value={quantity}
            onClick={() => setQuantity('')}
            onChange={(e) => setQuantity(e.target.value)}
          />
        </div>

        {/* *** submit button *** */}
        <button
          className='text-danger'
          style={{
            border: 'none',
            backgroundColor: 'transparent'
          }}
          type='submit'
          tabIndex={0}
          aria-label={`Add ${product.name}`}
        >
          <FaPlus />
        </button>
      </form>
    </li>
  )
}

export default SearchResultsListItem
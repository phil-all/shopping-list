import React from 'react';
import { FaTrashAlt } from 'react-icons/fa';

import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';

// import { faQuestion, faCarrot, faBottleWater, faCheeseSwiss, faSandwich, faToiletPaper } from'@fortawesome/free-solid-svg-icons';

const ProductListItem = ({ product, handleDelete, departments }) => {
  //alert(Object.keys(departments).map((key) => {return departments[key]}));
  //alert(departments);

  const departmentId = product.department.replace('/api/departments/', '');

  return (
    <li className="product list-group-item">
      <article className='row'>
        <div className='col-1'>
          <div style={{
            width: '24px',
            backgroundColor: departments[departmentId - 1].color,
            color: 'black',
            textAlign: 'center',
            borderRadius: '50%'
          }}>
            <FontAwesomeIcon icon={departments[departmentId - 1].icon} />
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

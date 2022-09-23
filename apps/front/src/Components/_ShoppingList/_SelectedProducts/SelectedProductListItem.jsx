import React from 'react';
import { ImCross } from 'react-icons/im';
import { AiFillCaretDown, AiFillCaretUp } from 'react-icons/ai';
import { FaCartArrowDown } from 'react-icons/fa';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';

const SelectedProductListItem = ({ item, handleDeleteItem, handleCheck, handleQuantity }) => {
  var arrowDownStyle = (item.quantity === 1) ? { color: 'gray' } : { cursor: 'pointer', color: 'crimson' };
  var arrowUpStyle = (item.quantity === 99) ? { color: 'gray' } : { cursor: 'pointer', color: 'green' };

  return (
    <li className="list list-group-item p-1">
      <article className='d-flex'>
        {/* *** department icon *** */}
        <div style={{
          minWidth: '24px',
          height: '24px',
          backgroundColor: item.product.department.color,
          color: 'black',
          textAlign: 'center',
          borderRadius: '50%'
        }}>
          <FontAwesomeIcon icon={item.product.department.icon} />
        </div>

        {/* *** product name *** */}
        <div
          className='ps-3'
          style={{ width: '100%' }}
        >
          {item.product.name}
        </div>

        {/* *** quantity *** */}
        <div
          className='pe-3'
          style={{ minWidth: '75px' }}
        >
          <span style={arrowDownStyle}>
            <AiFillCaretDown
              //style={arrowDownStyle}
              onClick={() => handleQuantity(item.id, item.quantity, -1)}
            />
          </span>
          &nbsp;{item.quantity}&nbsp;
          <span style={arrowUpStyle}>
            <AiFillCaretUp
              onClick={() => handleQuantity(item.id, item.quantity, 1)}
            />
          </span>
        </div>

        {/* *** delete button *** */}
        <div className='text-danger'>
          <ImCross
            style={{ cursor: 'pointer' }}
            onClick={() => handleDeleteItem(item.id)}
          />
        </div>
      </article>
    </li >
  );
}

export default SelectedProductListItem
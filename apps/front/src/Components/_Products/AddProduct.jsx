import Select from 'react-select';
import { FaPlus } from 'react-icons/fa';
import { React, useRef, useState } from 'react';

import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';

const AddProduct = ({ newProduct, setNewProduct, handleSubmitNewProduct, departments, newDepartment, setNewDepartment }) => {
  const inputRef = useRef();
  
  const darkColor = '#222525';

  const selectStyle = {
    control: styles => ({ ...styles, backgroundColor: darkColor, borderRadius: '6px'}),
    menu: styles => ({ ...styles, backgroundColor: darkColor }),
    option: styles => ({ ...styles, backgroundColor: darkColor })
  }

  const handleDropdown = (e) => {
    setNewDepartment(e);
  }

  return (
    <div className='bg-primary pb-2'>
      <form
        className='row container mx-auto'
        onSubmit={handleSubmitNewProduct}
      >
        <div className='col-md-6 my-auto'>
          <input
            className='form-control bg-dark text-primary'
            autoFocus
            ref={inputRef}
            id='addProduct'
            type='text'
            placeholder='nouveau produit'
            required
            value={newProduct}
            onChange={(e) => setNewProduct(e.target.value)}
            data-testid='new_product'
          />
        </div>
        <div className='col-10 col-md-5 my-auto'>
          <Select
            placeholder='rayon'
            value={newDepartment}
            styles={selectStyle}
            options={departments}
            onChange={handleDropdown}
            aria-label='departments'
            getOptionLabel={(e) => (
              <div style={{
                display: 'flex',
                alignItems: 'center',
                color: e.color,
                borderRadius: 20,
                paddingLeft: 10
              }}>
                <div style={{ 
                  minWidth: '24px',
                  backgroundColor: e.color,
                  color: darkColor,
                  textAlign: 'center',
                  borderRadius: '50%'
                }}>
                  <FontAwesomeIcon icon={e.icon} />
                </div>
                <span style={{ marginLeft: 5 }}>&nbsp;{e.name}</span>
              </div>
            )}
          />
        </div>
        <div className='col-1 py-2 my-auto'>
          <div className='d-flex justify-content-center'>
            <button
              className='btn btn-dark'
              type='submit'
              aria-label='nouveau produit'
              onClick={() => inputRef.current.focus()}
              data-testid='add'
            >
              <FaPlus />
            </button>
          </div>
        </div>
      </form>
    </div>
  );
}

export default AddProduct

import { React, useState } from 'react';
import Select, { components } from 'react-select';
import { FaPlus } from 'react-icons/fa';
import { HiChevronDoubleDown } from "react-icons/hi";
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { AiFillCaretDown, AiFillCaretUp } from 'react-icons/ai';

const NewProductForm = ({ searchItem, departments, handleSubmitNewProduct }) => {
  const [newDepartment, setNewDepartment] = useState(1);
  const [quantity, setQuantity] = useState(1);

  const transparent = 'transparent';

  const selectStyle = {
    control: styles => ({ ...styles, backgroundColor: transparent, borderRadius: '6px', border: 'none', minHeight: '24px' }),
    menu: styles => ({ ...styles, backgroundColor: transparent, minWidth: '300px' }),
    option: styles => ({ ...styles, backgroundColor: transparent }),
    input: styles => ({ ...styles, margin: '0', padding: '0' }),
    placeholder: styles => ({ ...styles, margin: '0' })
  }

  const handleDropdown = (e) => {
    console.log('handle');
    setNewDepartment(e.id);
    setNewDepartment(e.id);
    console.log(e.id);
    console.log(newDepartment);
  }

  return (
    <section className='mt-3'>
      <div className='list-group'>
        <div className='list list-group-item p-1'>
          <form
            className='d-flex'
            onSubmit={handleSubmitNewProduct}
            data-testid='new_product_form'
          >
            {/* *** select menu for department choice *** */}
            <div>
              <Select
                id='addDepartment'
                name='department_select'
                placeholder={
                  <div style={{
                    minWidth: '24px',
                    height: '24px',
                    backgroundColor: '#eceff4',
                    color: 'green',
                    textAlign: 'center',
                    borderRadius: '50%'
                  }}>
                    <HiChevronDoubleDown />
                  </div>
                }
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
                      color: '#000',
                      textAlign: 'center',
                      borderRadius: '50%'
                    }}>
                      <FontAwesomeIcon icon={e.icon} />
                    </div>
                    <span style={{ marginLeft: 5 }}>&nbsp;{e.name}</span>
                  </div>
                )}
                components={{
                  DropdownIndicator: () => null,
                  IndicatorSeparator: () => null
                }}
              />
            </div>

            {/* *** hidden input to submit department id */}
            <div className=''>
              <input
                id='department_id'
                type='text'
                name='department_id'
                value={newDepartment} // do not replace value by defaultValue, it will set value on 1
              />
            </div>

            {/* *** hidden input to submit new product name */}
            <div className='d-none'>
              <input
                id='product_name'
                type='text'
                name='product_name'
                defaultValue={searchItem}
                data-testid='product_id'
              />
            </div>

            {/* *** new product name *** */}
            <div
              className='ps-2'
              style={{ width: '100%' }}
            >
              {searchItem}
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
              aria-label={`Add ${searchItem}`}
            >
              <FaPlus />
            </button>
          </form>
        </div>
      </div>
    </section>
  )
}

export default NewProductForm
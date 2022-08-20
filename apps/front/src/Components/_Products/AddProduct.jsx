import { useRef } from 'react';
import { FaPlus } from 'react-icons/fa';

const AddProduct = ({ newProduct, setNewProduct, handleSubmit }) => {
  const inputRef = useRef();

  return (
    <form className='add-product' onSubmit={handleSubmit}>
      <div className='container'>
        <div className='row'>
          <div className='col-10 col-md-11'>
            <input
              className='form-control'
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
          <div className='col-1 my-auto d-flex justify-content-center'>
              <button
                className='btn'
                type='submit'
                aria-label='nouveau produit'
                onClick={() => inputRef.current.focus()}
                data-testid='add'
              >
                <FaPlus />
              </button>
          </div>
        </div>
      </div>
    </form>
  )
}

export default AddProduct

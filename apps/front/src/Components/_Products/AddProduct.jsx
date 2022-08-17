import { useRef } from 'react';
import { FaPlus } from 'react-icons/fa';

const AddProduct = ({ newProduct, setNewProduct, handleSubmit }) => {
    const inputRef = useRef();

    return (
        <form className='addForm' onSubmit={handleSubmit}>
            <input
                autoFocus
                ref={inputRef}
                id='addProduct'
                type='text'
                placeholder='nouveau produit'
                required
                value={newProduct}
                onChange={(e) => setNewProduct(e.target.value)}
            />
            <button
                type='submit'
                aria-label='nouveau produit'
                onClick={() => inputRef.current.focus()}
            >
                <FaPlus />
            </button>
        </form>
    )
}

export default AddProduct

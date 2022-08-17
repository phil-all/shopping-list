import { FaTrashAlt } from 'react-icons/fa';

const ProductListItem = ({ product, handleCheck, handleDelete }) => {
    return (
        <li className="product">
            <label
                style={(product.checked) ? { textDecoration: 'line-through' } : null}
                onDoubleClick={() => handleCheck(product.id)}
            >{product.name}</label>
            <FaTrashAlt
                onClick={() => handleDelete(product.id)}
                role="button"
                tabIndex="0"
                aria-label={`Delete ${product.name}`}
            />
        </li>
    )
}

export default ProductListItem

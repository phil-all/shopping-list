import ProductListItem from './ProductListItem';

const ProductsList = ({ products, handleCheck, handleDelete }) => {
    return (
        <ul>
            {products.map((product) => (
                <ProductListItem
                    key={product.id}
                    product={product}
                    handleCheck={handleCheck}
                    handleDelete={handleDelete}
                />
            ))}
        </ul>
    )
}

export default ProductsList

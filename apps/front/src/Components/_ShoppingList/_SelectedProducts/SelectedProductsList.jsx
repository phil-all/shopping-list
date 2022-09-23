import React from 'react'
import SelectedProductListItem from './SelectedProductListItem'

const SelectedProductsList = ({ items, handleDeleteItem, handleCheck, handleQuantity }) => {
  return (
    <ul className='list-group my-3'>
      {items.map((item) => (
        <SelectedProductListItem
          key={item.id}
          item={item}
          handleDeleteItem={handleDeleteItem}
          handleCheck={handleCheck}
          handleQuantity={handleQuantity}
        />
      ))}
    </ul>
  )
}

export default SelectedProductsList
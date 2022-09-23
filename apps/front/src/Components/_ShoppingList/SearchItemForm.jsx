import React from 'react'

const SearchItemForm = ({ searchItem, setSearchItem }) => {
  return (
    <div className='bg-primary pb-2'>
      <form className='row container mx-auto px-0'>
        <div className='my-auto'>
          <input
            className='form-control bg-dark text-primary'
            autoFocus
            id='addProduct'
            type='text'
            placeholder="J'ai besoin de..."
            value={searchItem}
            onChange={(e) => setSearchItem(e.target.value)}
            required
            autoComplete='off'
            data-testid='search_item'
          />
        </div>
      </form>
    </div>
  )
}

export default SearchItemForm
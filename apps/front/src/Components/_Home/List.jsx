import React from 'react';
import ListItem from './ListItem';

const List = ({ shoppingLists }) => {
  return (
    <>
      <h5 className='mt-2 text-primary'>Mes listes</h5>
      <ul className='list-group my-3 list-group'>
        {Object(shoppingLists).map((list) => (
          <ListItem
            key={list.id}
            list={list}
          />
        ))}
      </ul>
    </>
  )
}

export default List
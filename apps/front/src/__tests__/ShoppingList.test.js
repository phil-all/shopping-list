import ShoppingList from '../Components/ShoppingList';
import '@testing-library/jest-dom/extend-expect';
import { BrowserRouter as Router } from 'react-router-dom';
import { render, screen } from '@testing-library/react';
import user from '@testing-library/user-event';

describe('testing shopping list component behavior depends on search item value', () => {

  const getSearchItem = () => {
    return screen.getByTestId('search_item');
  }

  it('should render selected products list content', () => {
    render(
      <Router>
        <ShoppingList />
      </Router>
    );

    const title = screen.getByTestId('title');

    expect(title).toBeInTheDocument();
    const content = screen.getByTestId('selected_product_list');
    expect(content).toBeInTheDocument();
  });

  /**
   * mock useState products to test follow
   */
  it.todo('should render filtered products list');

  it('should render new product form', () => {
    render(
      <Router>
        <ShoppingList />
      </Router>
    );

    user.type(getSearchItem(), 'saxyz');

    const title = screen.getByTestId('title');
    expect(title).toBeInTheDocument();
    const content = screen.getByTestId('new_product_form');
    expect(content).toBeInTheDocument();
  });
})



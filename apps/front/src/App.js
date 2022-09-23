
import Home from './Components/Home';
import Login from './Components/Login';
import Products from './Components/Products';
import ShoppingList from "./Components/ShoppingList";
import * as Icons from '@fortawesome/free-solid-svg-icons';
import { library } from '@fortawesome/fontawesome-svg-core';
import { BrowserRouter, Routes, Route, } from "react-router-dom";

function App() {
  const iconList = Object.keys(Icons)
    .filter((key) => key !== 'fas' && key !== 'prefix')
    .map((icon) => Icons[icon]);

  library.add(...iconList);

  return (
    <BrowserRouter>
      <Routes>
        <Route
          path="/login"
          element={<Login />}
        >
        </Route>
        <Route
          path="/"
          element={<Home />}
        >
        </Route>
        <Route
          path="/shopping-lists/:shoppingListId"
          element={<ShoppingList />}
        >
        </Route>
        <Route
          path="/products"
          element={<Products />}
        >
        </Route>
      </Routes>
    </BrowserRouter>
  );
}

export default App;

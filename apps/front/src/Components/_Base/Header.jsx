import { BsCart4 } from 'react-icons/bs'

const Header = ({ title }) => {
  return (
    <header>
      <div className='container d-flex'>
        <div className='d-flex my-auto'>
          <BsCart4 className='svg-header'/>
        </div>
        <h1 
          className='my-auto'
          data-testid='title'
        >
          &nbsp;{title}
        </h1>
      </div>
    </header>
  )
}

Header.defaultProps = {
  title: "Shopping List"
}

export default Header;

import Navbar from '../Backend/Navbar'
import 'bootstrap/dist/css/bootstrap.min.css';
export default function Layout({ children }) {
  return (
    <>
      <Navbar />
      <main>{children}</main>
    </>
  )
}
import { Link, Head, usePage } from "@inertiajs/react";
import Logo from "../../Assets/Images/saas.png";
import { react, useState, useEffect, useRef } from "react";
import { CiMenuBurger } from "react-icons/ci";
import { RxCross1 } from "react-icons/rx";
import { CiUser } from "react-icons/ci";

export default function Header() {
  const [nav, showNav] = useState(false);

  const { auth } = usePage().props;

  const toggleFloatingBar = () => {
    showNav((prevNav) => !prevNav);
  };

  const [userDrop, setUserDrop] = useState(false);

  const userDropRef = useRef(null);

  const toggleUserDrop = () => {
    setUserDrop((prevUserDrop) => !prevUserDrop);
  };

  useEffect(() => {
    const handleClickOutside = (event) => {
      if (userDropRef.current && !userDropRef.current.contains(event.target)) {
        setUserDrop(false);
      }
    };

    document.addEventListener("mousedown", handleClickOutside);
    return () => {
      document.removeEventListener("mousedown", handleClickOutside);
    };
  }, [userDropRef]);

  return (
    <div
      ref={userDropRef}
      className="flex items-center justify-between md:p-5 p-2 h-[90px]"
    >
      <div className="logo-area">
        <Link href="/">
          <img src={Logo} className="h-[130px] w-[150px]" alt="" />
        </Link>
      </div>

      <div className="menu-area flex items-center gap-5 text-lg text-semibold md:flex hidden">
        <a href="/" className="transition-all hover:text-blue-700">
          Home
        </a>
        <a href="#feature" className="transition-all hover:text-blue-700">
          Features
        </a>
        <a href="#testimonial" className="transition-all hover:text-blue-700">
          Testimonial
        </a>
        <a href="#pricing" className="transition-all hover:text-blue-700">
          Pricing
        </a>
        <a href="#contact" className="transition-all hover:text-blue-700">
          Contact us
        </a>
      </div>

      <div className="auth-area flex gap-5 font-bold text-lg md:flex hidden">
        {auth.user ? (
          <div>
            <CiUser
              onClick={toggleUserDrop}
              className="text-2xl cursor-pointer transition-all delay-5 hover:text-rose-600"
            />
            <div
              className={`${
                userDrop ? "block" : "hidden"
              } bg-white fixed w-[200px] p-4 top-[75px] right-[110px]`}
            >
              <Link
                href={route("home.home")}
                className="text-md font-normal transition-all delay-5 hover:border-b-2"
              >
                Dashboard
              </Link>
              <br />
              <Link
                href={route("profile.edit")}
                className="text-md font-normal transition-all delay-5 hover:border-b-2"
              >
                Profile
              </Link>
              <br />
              <Link
                href={route("logout")}
                className="text-md font-normal transition-all delay-5 hover:border-b-2"
              >
                Logout
              </Link>
            </div>

            {/* <Link href={route('logout')} className="text-red-500 p-2 transition-all hover:text-red-700">Logout</Link> */}
          </div>
        ) : (
          <div>
            <Link
              href={route("login")}
              className="text-gray-500 p-2 transition-all hover:text-blue-700"
            >
              Sign in
            </Link>
            <Link
              href={route("register")}
              className="bg-slate-700 text-white p-2 transition-all hover:shadow-xl delay-5"
            >
              Sign up
            </Link>
          </div>
        )}
      </div>

      <div
        className={`burger-menu md:hidden flex p-2`}
        onClick={toggleFloatingBar}
      >
        <CiMenuBurger className="text-xl cursor-pointer" />
      </div>

      <div
        className={`md:hidden flex flex-col w-[200px] gap-5 items-start p-3 fixed 
                 bg-white shadow-lg rounded top-[60px] sm:left-[200px] right-5 ${
                   nav ? "flex" : "hidden"
                 }`}
      >
        <Link href="#header" className="transition-all hover:text-blue-700">
          Home
        </Link>
        <Link className="transition-all hover:text-blue-700">Sign up</Link>
        <Link
          href="#testimonial"
          className="transition-all hover:text-blue-700"
        >
          Sign in
        </Link>
        <Link className="transition-all hover:text-blue-700">Service</Link>
        <Link className="transition-all hover:text-blue-700">Pricing</Link>
        <Link className="transition-all hover:text-blue-700">About us</Link>
        <Link className="transition-all hover:text-blue-700">Contact us</Link>
      </div>
    </div>
  );
}

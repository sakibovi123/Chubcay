import { Link, Head, usePage } from '@inertiajs/react';
import Logo from '../../Assets/Images/saas.png';
import {react, useState, useEffect} from 'react';
import { CiMenuBurger } from "react-icons/ci";
import { RxCross1 } from "react-icons/rx";

export default function Header() {
    const [ nav, showNav ] = useState(false);

    const { auth } = usePage().props;
    
    const toggleFloatingBar = () => {
        showNav(prevNav => !prevNav);
    };


    return (
        <div className="flex items-center justify-between md:p-5 p-2 h-[90px]">
            <div className="logo-area">
                <Link href="/"><img src={Logo} className='h-[130px] w-[150px]' alt="" /></Link>
            </div>

            <div className="menu-area flex items-center gap-5 text-lg text-semibold md:flex hidden">
                <a href="/" className="transition-all hover:text-blue-700">Home</a>
                <a href="#feature" className="transition-all hover:text-blue-700">Features</a>
                <a href="#testimonial" className="transition-all hover:text-blue-700">Testimonial</a>
                <a href="#pricing" className="transition-all hover:text-blue-700">Pricing</a>
                <a href="#contact" className="transition-all hover:text-blue-700">Contact us</a>
            </div>

            <div className="auth-area flex gap-5 font-bold text-lg md:flex hidden">
                {
                    auth.user ? (
                        <Link href={route('logout')} className="text-red-500 p-2 transition-all hover:text-red-700">Logout</Link>
                    ) : (
                        <div>
                            <Link href={route('login')} className="text-gray-500 p-2 transition-all hover:text-blue-700">Sign in</Link>
                            <Link href={route('register')} className="bg-slate-700 text-white p-2 transition-all hover:shadow-xl delay-5">Sign up</Link>
                        </div>
                        
                    )
                }
                
            </div>

            <div className={`burger-menu md:hidden flex p-2`} onClick={toggleFloatingBar}>
                <CiMenuBurger className="text-xl cursor-pointer" />
            </div>

            <div className={`md:hidden flex flex-col w-[200px] gap-5 items-start p-3 fixed left-0
                 bg-white shadow-lg rounded top-[60px] sm:left-[200px] left-[230px] ${nav ? 'flex' : 'hidden'}`}>
                <Link href="#header" className="transition-all hover:text-blue-700">Home</Link>
                <Link className="transition-all hover:text-blue-700">Sign up</Link>
                <Link href="#testimonial" className="transition-all hover:text-blue-700">Sign in</Link>
                <Link className="transition-all hover:text-blue-700">Service</Link>
                <Link className="transition-all hover:text-blue-700">Pricing</Link>
                <Link className="transition-all hover:text-blue-700">About us</Link>
                <Link className="transition-all hover:text-blue-700">Contact us</Link>
            </div>
        </div>
    )
}
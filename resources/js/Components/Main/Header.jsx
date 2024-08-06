import { Link, Head, usePage } from '@inertiajs/react';
import Logo from '../../Assets/Images/logo-1.svg';
import {react, useState, useEffect, useRef} from 'react';
import { CiMenuBurger } from "react-icons/ci";
import { RxCross1 } from "react-icons/rx";
import { CiUser } from "react-icons/ci";


export default function Header() {
    const [ nav, showNav ] = useState(false);
    const navRef = useRef(null);

    const { auth } = usePage().props;
    
    const toggleFloatingBar = () => {
        showNav(prevNav => !prevNav);
    };

    const [ userDrop, setUserDrop ] = useState(false);

    const userDropRef = useRef(null);

    const toggleUserDrop = () => {
        setUserDrop(prevUserDrop => !prevUserDrop);
    }

    useEffect(()=> {
        const handleClickOutside = (event) => {
            if (userDropRef.current && !userDropRef.current.contains(event.target)) {
                setUserDrop(false);
            }

            if( navRef.current && !navRef.current.contains(event.target) ) {
                showNav(false);
            }
        };

        // const hanndleMenuDropDown = (event) => {
            
        // }

        document.addEventListener('mousedown', handleClickOutside);
        // document.addEventListener('mousedown', hanndleMenuDropDown);
        return () => {
            document.removeEventListener('mousedown', handleClickOutside);

        };
    }, [userDropRef, navRef])


    return (
        <div className="bg-slate-800 flex items-center justify-between md:p-5 p-2 h-[90px]">
            <div className="logo-area p-0">
                <Link href="/"><img src={Logo} className='h-[110px] w-[150px] p-3' alt="" /></Link>
            </div>

            <div className="text-white menu-area flex items-center gap-5 text-lg font-bold md:flex hidden">
                <a href="/" className="transition-all hover:text-blue-700">Home</a>
                <a href="#feature" className="transition-all hover:text-blue-700">Features</a>
                <a href="#testimonial" className="transition-all hover:text-blue-700">Testimonial</a>
                <a href="#pricing" className="transition-all hover:text-blue-700">Pricing</a>
                <a href="#contact" className="transition-all hover:text-blue-700">Contact us</a>
            </div>

            <div className="auth-area flex gap-5 font-bold text-lg md:flex hidden">
                {
                    auth.user ? (
                        <div ref={userDropRef}>
                            <CiUser onClick={toggleUserDrop} className="text-white text-3xl cursor-pointer transition-all delay-5 hover:text-rose-600" />
                            <div className={`${userDrop ? 'block' : 'hidden'} bg-white fixed
                             w-[200px] p-4 top-[75px] xl:right-[10px] md:right-[150px] right-[2px]`}>
                                {
                                    auth.user.is_admin == true && (
                                        <div>
                                            <a href={route('admin.index')} className="text-md font-normal transition-all delay-5 hover:border-b-2">
                                                Dashboard
                                            </a> <br />
                                        </div>
                                        
                                    )
                                }
                                
                                <Link href={route('profile.edit')} className="text-md font-normal transition-all delay-5 hover:border-b-2">Profile</Link><br />
                                <Link href={route('logout')} className="text-md font-normal transition-all delay-5 hover:border-b-2">Logout</Link>
                            </div>
                            
                            {/* <Link href={route('logout')} className="text-red-500 p-2 transition-all hover:text-red-700">Logout</Link> */}
                        </div>
                        
                    ) : (
                        <div>
                            <Link href={route('login')} className="text-white p-2 transition-all hover:text-blue-700">Sign in</Link>
                            <Link href={route('register')} className="bg-purple-600 rounded text-white p-2 transition-all hover:shadow-xl delay-5 hover:bg-purple-500">Sign up</Link>
                        </div>
                        
                    )
                }
                
            </div>

            <div className={`text-white burger-menu md:hidden flex p-2`} onClick={toggleFloatingBar}>
                <CiMenuBurger className="text-xl cursor-pointer" />
            </div>

            <div ref={navRef} className={`md:hidden flex flex-col w-[200px] gap-5 items-start p-3 fixed left-0
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
import React from 'react'
import logo from '../../Assets/Images/logo-1.svg'
import { CiFacebook } from "react-icons/ci";
import { FaInstagram } from "react-icons/fa";
import { FaSquareThreads } from "react-icons/fa6";
import { FaWhatsapp } from "react-icons/fa";




function Footer() {
  return (
    <div className="bg-slate-800 rounded p-5">
        <div className="container mx-auto flex flex-col md:flex-row items-start md:items-center justify-between gap-5">
            <div className="w-full text-left">
                <img src={logo} className="w-[120px]" alt="" />
                <p className="text-lg text-white font-bold my-5">
                    © 2024 Chubcay, All Rights Reserved
                </p>
            </div>
            <div className="w-full text-left">
                <h1 className="text-white text-3xl font-bold h-[60px]">Quick Links</h1>
                <div className="flex flex-wrap items-center justify-start gap-4">
                    <a href="/" className="font-bold text-white text-lg">Home</a>
                    <a href="#feature" className="font-bold text-white text-lg">Features</a>
                    <a href="#testimonial" className="font-bold text-white text-lg">Testimonial</a>
                    <a href="#pricing" className="font-bold text-white text-lg">Pricing</a>
                    <a href="#contact" className="font-bold text-white text-lg">Contact</a>
                </div>
            </div>
            <div className="w-full text-left md:text-right">
                <h1 className="text-white text-3xl font-bold h-[60px]">
                    Follow us
                </h1>
                <div className="text-white flex items-center justify-start md:justify-end gap-7">
                    <CiFacebook className="text-3xl cursor-pointer transition-all hover:text-blue-700" />
                    <FaInstagram className="text-3xl cursor-pointer transition-all hover:text-rose-700" />
                    <FaSquareThreads className="text-3xl cursor-pointer transition-all hover:text-sky-300" />
                    <FaWhatsapp className="text-3xl cursor-pointer transition-all hover:text-green-700" />
                </div>
            </div>
        </div>
       
    </div>

  )
}

export default Footer

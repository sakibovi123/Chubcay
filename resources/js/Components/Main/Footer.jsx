import React from 'react'
import logo from '../../Assets/Images/saas.png'
import { CiFacebook } from "react-icons/ci";
import { FaInstagram } from "react-icons/fa";
import { FaSquareThreads } from "react-icons/fa6";
import { FaWhatsapp } from "react-icons/fa";



function Footer() {
  return (
    <div className="bg-white rounded container mx-auto p-5 w-[90%] md:w-[80%] flex flex-col md:flex-row items-start md:items-center justify-between gap-5">
    <div className="w-full text-left">
        <h1 className="text-gray-600 text-3xl font-bold h-[60px]">Chubcay</h1>
        <p className="text-lg text-gray-500 font-bold">
            © 2024 Chubcay, All Rights Reserved
        </p>
    </div>
    <div className="w-full text-left">
        <h1 className="text-gray-600 text-3xl font-bold h-[60px]">Quick Links</h1>
        <div className="flex flex-wrap items-center justify-start gap-4">
            <a href="/" className="font-bold text-gray-500 text-lg">Home</a>
            <a href="#feature" className="font-bold text-gray-500 text-lg">Features</a>
            <a href="#testimonial" className="font-bold text-gray-500 text-lg">Testimonial</a>
            <a href="#pricing" className="font-bold text-gray-500 text-lg">Pricing</a>
            <a href="#contact" className="font-bold text-gray-500 text-lg">Contact</a>
        </div>
    </div>
    <div className="w-full text-left md:text-right">
        <h1 className="text-gray-600 text-3xl font-bold h-[60px]">
            Follow us
        </h1>
        <div className="flex items-center justify-start md:justify-end gap-7">
            <CiFacebook className="text-3xl cursor-pointer transition-all hover:text-blue-700" />
            <FaInstagram className="text-3xl cursor-pointer transition-all hover:text-rose-700" />
            <FaSquareThreads className="text-3xl cursor-pointer transition-all hover:text-slate-700" />
            <FaWhatsapp className="text-3xl cursor-pointer transition-all hover:text-green-700" />
        </div>
    </div>
</div>

  )
}

export default Footer

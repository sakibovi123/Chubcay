import React from "react";
import { IoGolfOutline } from "react-icons/io5";


export default function FeatureCard({icon, title, desc})
{
    return (
        <div className="bg-white flex flex-col items-center h-[380px]
            w-[350px] p-5 shadow-lg rounded gap-6 my-2">

            <div className="text-center text-7xl text-blue-600 bg-blue-50 rounded-full p-3">
                {icon}
            </div>
            <h1 className="font-bold text-3xl">{title}</h1>
            <p className="text-gray-400 font-semibold p-2">
                {desc}
            </p>
        </div>
    )
}
import React from "react";
import { IoGolfOutline } from "react-icons/io5";


export default function FeatureCard({icon})
{
    return (
        <div className="flex flex-col items-center h-[380px]
            w-[350px] p-5 shadow-xl rounded gap-6 my-2">

            <div className="text-center text-7xl text-blue-600 bg-blue-50 rounded-full p-3">
                {icon}
            </div>
            <h1 className="font-bold text-3xl">Lorem Ipsum Dolor</h1>
            <p className="text-gray-400 font-semibold p-2">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sunt, vitae a? Tenetur impedit molestiae, veritatis asperiores, voluptas porro dolor alias obcaecati ullam minus ipsa ab, eius quam aliquid architecto suscipit!</p>
        </div>
    )
}
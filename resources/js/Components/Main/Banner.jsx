import { useEffect, useState } from "react";


export default function Banner() {
    return (
        <div className="md:h-[550px] w-full flex flex-col items-center md:justify-center text-center">
            <div className="md:w-[60%] w-full p-2">
                {/* title section */}
            
                <h1 className="md:text-7xl text-3xl font-bold my-6">
                    Chubcay Membership
                </h1>
                {/* subtitle section */}
                <p className=" md:text-2xl text-xl text-gray-500 font-bold my-4">
                Chubcay Membership is your go-to platform for buying and selling memberships easily and securely. With user-friendly tools and dedicated support, we make membership management hassle-free. Join us today for a seamless experience!
                </p>
                {/* button sectio */}

                <button className="rounded w-[300px] my-6 text-center bg-purple-600 p-3 text-white transition-all hover:bg-purple-500 delay-5">
                    Explore Features
                </button>
            </div>


            {/* <div className="
        absolute bg-red-50 rounded-full w-[50px] h-[50px] left-[180px] top-[280px]"></div>

        <div className="
        absolute bg-red-50 rounded-full w-[80px] h-[80px] left-[150px] top-[470px]"></div>
        <div className="
        absolute bg-red-50 rounded-full w-[50px] h-[50px] left-[280px]"></div>
        <div className="
        absolute bg-red-50 rounded-full w-[50px] h-[50px] left-[1680px]"></div>

        <div className="
            absolute bg-red-50 rounded-full w-[50px] h-[50px] top-[220px] left-[1380px]"></div> */}

{/* <div className="
        absolute bg-red-50 rounded-full w-[50px] h-[50px] left-[1180px] top-[3270px]"></div> */}
            
        </div>
    ) 
}
import React from "react";
import author_2 from "../../Assets/Images/author-02.png"
import { CiStar } from "react-icons/ci";


export default function TestimonialCard({ name, desg, review })
 {
    return (
        <div className="bg-white shadow-xl rounded-xl md:h-[310px] h-[360px] p-4 w-full">
            <div className="md:p-3 w-full md:flex items-center
             justify-between md:w-[520px] border-b-2">
                <div className="flex gap-3 p-3 w-full">
                    <img src={author_2} alt="" />
                    <div>
                        <p className="text-xl font-semibold">{name}</p>
                        <p className="text-left text-gray-400 font-semibold">{desg}</p>
                    </div>
                    
                </div>
                <div className="w-full md:mx-[-8rem] mx-1 p-3">
                    <p className="md:text-center text-left font-semibold">Review</p>
                    <div className="font-semibold flex items-center md:justify-center justify-start gap-1">
                        <CiStar />
                        <CiStar />
                        <CiStar />
                        <CiStar />
                        <CiStar />
                    </div>
                </div>  
            </div>

            <p className="p-3 text-gray-400 font-semibold">
                {review}
            </p>
            
        </div>
    )
 }
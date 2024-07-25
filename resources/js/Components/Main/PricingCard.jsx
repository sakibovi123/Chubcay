import React from 'react'
import { Link } from '@inertiajs/react';


function PricingCard({price, desc, slug}) {
  return (
    <div className="bg-white h-[480px] md:w-[360px] w-full p-[5rem] shadow-xl
     flex flex-col items-center justify-center gap-5 rounded md:my-0 my-5"
    >
        <div className="text-3xl font-bold">${price} / Month</div>
        <div className="w-[100%] text-gray-400 font-semibold p-1">
            {desc}
        </div>
        <div className="font-bold flex gap-4">All UI Components</div>
        <div className="font-bold flex gap-4">Use with Unlimited Projects</div>
        <div className="font-bold flex gap-4">Commercial Use</div>
        <div className="font-bold flex gap-4">Email Support</div>

        <Link href={route('package.single', slug)} className="bg-blue-500 p-3 w-[300px] text-white font-bold">
            Purchase now
        </Link>

        
      
    </div>
  )
}

export default PricingCard

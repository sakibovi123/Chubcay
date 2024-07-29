import React from 'react'
import { Link } from '@inertiajs/react';


function PricingCard({price, desc, slug, duration}) {
  return (
    <div className="bg-white h-[480px] md:w-[360px] w-full p-[5rem] shadow-xl
     flex flex-col items-center justify-center gap-5 rounded md:my-0 my-5"
    >
        <div className="text-3xl font-bold">${price}</div>
        <div className="w-[100%] text-gray-400 font-semibold p-1">
            {desc}
        </div>
        <div className="font-bold flex gap-4">Swimming Access</div>
        <div className="font-bold flex gap-4">1 Spa access</div>
        <div className="font-bold flex gap-4">1 Match Golf Access</div>
        <div className="font-bold flex gap-4">1 Buffet Lunch</div>

        <Link href={route('package.single', slug)} className="bg-blue-500 p-3 w-[300px] text-white font-bold">
            Purchase now
        </Link>

        
      
    </div>
  )
}

export default PricingCard

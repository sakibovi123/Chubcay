import React from 'react'

function PricingCard() {
  return (
    <div className="bg-white h-[480px] md:w-[360px] w-full p-[5rem] shadow-xl
     flex flex-col items-center justify-center gap-5 rounded md:my-0 my-5"
    >
        <div className="text-3xl font-bold">$58 / Month</div>
        <div className="w-[100%] text-gray-400 font-semibold p-1">
            Lorem ipsum dolor sit amet adiscing elit Mauris egestas enim.
        </div>
        <div className="font-bold flex gap-4">All UI Components</div>
        <div className="font-bold flex gap-4">Use with Unlimited Projects</div>
        <div className="font-bold flex gap-4">Commercial Use</div>
        <div className="font-bold flex gap-4">Email Support</div>

        <button className="bg-blue-500 p-3 w-[300px] text-white font-bold">
            Purchase now
        </button>

        
      
    </div>
  )
}

export default PricingCard

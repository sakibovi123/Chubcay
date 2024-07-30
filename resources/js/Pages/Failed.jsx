import React from 'react'
import { useEffect, useState } from 'react';
import { usePage } from '@inertiajs/react'

function Failed({error}) {
    const [countdown, setCountdown] = useState(3);


    useEffect(() => {
        // Update the countdown every second
        const timer = setInterval(() => {
          setCountdown(prevCountdown => prevCountdown - 1);
        }, 1000);
    
        // Redirect to home after 3 seconds
        const redirectTimer = setTimeout(() => {
          window.location.href = "/";
        }, 3000);
    
        // Clean up the timers
        return () => {
          clearInterval(timer);
          clearTimeout(redirectTimer);
        };
      }, []);

  return (
    <div className="container mx-auto h-full w-full">
      <div className="flex flex-col items-center justify-center gap-5">
        <div className="w-[35%] bg-white p-[5rem] my-[12rem]">
            <h2 className="text-4xl text-center font-bold">FAILED</h2>
            <p className="text-center text-red-600 font-bold text-lg my-5">{error}</p>
            <a className="text-center bg-blue-600 p-2 my-5
             flex items-center justify-center text-white font-bold">Redirecting in {countdown}</a>
        </div>
        
      </div>
    </div>
  )
}

export default Failed

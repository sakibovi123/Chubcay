import React from 'react'

function Contact() {
  return (
    <div id="contact" className="my-[7rem] h-full w-full flex
        flex-col items-center text-center justify-center gap-5 p-3"
     >

        
        <p className="text-purple-600 md:text-4xl text-3xl font-semibold">
            Contact us
        </p>
        <p className="text-lg md:w-[50%] w-full font-semibold text-gray-400">
            We are available 24/7 to assist you with all your needs.
        </p>

        <div className="form flex flex-col items-center gap-5 w-full my-5">
            <div className="flex-col md:flex items-center justify-center gap-5 w-full md:w-[73%]">
                <input className="p-2 w-full border border-gray-300 rounded"
                 type="text" placeholder="Enter your name" />
                 <input className="p-2 w-full border border-gray-300 rounded md:my-0 my-5"
                 type="email" placeholder="Enter your email" />
            </div>
            <textarea name="" rows={8} className="border-gray-300 rounded w-full md:w-[73%]" id="">Enter your message</textarea>
        </div>
        
    </div>
  )
}

export default Contact

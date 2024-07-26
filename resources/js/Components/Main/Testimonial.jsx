import React from "react";
import TestimonialCard from "./TestimonialCard";


export default function Testimonial() {
    return (
    <div id="testimonial" className="h-full w-full flex flex-col items-center text-center justify-center gap-5 p-3">

        <p className="text-xl font-semibold">
            Testimonials
        </p>
        <p className="text-purple-600 md:text-4xl text-3xl font-semibold">
            What Our Clients Say
        </p>
        <p className="text-lg md:w-[50%] w-full font-semibold text-gray-400">
        There are many variations of passages of Lorem Ipsum available but the majority have suffered alteration in some form.
        </p>

        <div className="grid md:grid-cols-2 grid-cols-1 gap-5 md:w-[75%] w-full">
            <TestimonialCard />
            
            <TestimonialCard />

            <TestimonialCard />

            <TestimonialCard />
        </div>
        
    </div>
    )
}
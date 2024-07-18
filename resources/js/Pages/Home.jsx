import Banner from '@/Components/Main/Banner';
import Feature from '@/Components/Main/Feature';
import Header from '@/Components/Main/Header';
import Testimonial from '@/Components/Main/Testimonial';
import { Link, Head } from '@inertiajs/react';



export default function Home() {
  return (
    <div className="h-full container md:mx-auto lg:w-[80%] md:w-[60%] w-full">
      <Header />
      <Banner />
      <Feature />
      <Testimonial />
    </div>
  )
}



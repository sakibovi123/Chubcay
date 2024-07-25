import Banner from '@/Components/Main/Banner';
import Brands from '@/Components/Main/Brands';
import Feature from '@/Components/Main/Feature';
import Header from '@/Components/Main/Header';
import Pricing from '@/Components/Main/Pricing';
import Testimonial from '@/Components/Main/Testimonial';
import { Link, Head } from '@inertiajs/react';



export default function Home({packages}) {
  return (
    <div className="h-full container md:mx-auto lg:w-[80%] md:w-[60%] w-full">
      <Header />
     
      <Banner />
      <Brands />
      <Feature />
      <Testimonial />
      <Pricing packages={packages} />
    </div>
  )
}



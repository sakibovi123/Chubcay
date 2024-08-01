import Banner from '@/Components/Main/Banner';
import Brands from '@/Components/Main/Brands';
import Feature from '@/Components/Main/Feature';
import Header from '@/Components/Main/Header';
import Pricing from '@/Components/Main/Pricing';
import Testimonial from '@/Components/Main/Testimonial';
import { Link, Head } from '@inertiajs/react';
import '../Assets/css/main.css'
import { useRef } from 'react';
import Contact from '@/Components/Main/Contact';
import Footer from '@/Components/Main/Footer';



export default function Home({packages}) {
  return (
    <div>
      <Header />
    <div className="h-full container md:mx-auto lg:w-[80%] md:w-[60%] w-full">
     <Banner />  
      <Brands />
      <Feature />
      <Testimonial />
      <Pricing packages={packages} />
      <Contact />
      
    </div>
    <Footer />
    </div>
    
  )
}



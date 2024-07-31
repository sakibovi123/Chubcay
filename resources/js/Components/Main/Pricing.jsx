import React from 'react'
import PricingCard from './PricingCard'

function Pricing({packages}) {

const duration = (pkg_dur) => {
    if( pkg_dur === 30 ) {
        return 'monthly'
    }
    else if( pkg_dur === 183 ) {
        return 'quaterly'
    }
    else if ( pkg_dur === 365 ){
        return 'yearly'
    }
}
  return (
    <div id="pricing" className="my-[7rem] h-full w-full flex
        flex-col items-center text-center justify-center gap-5 p-3"
     >

        <p className="text-xl font-semibold">
            Affordable Pricing
        </p>
        <p className="text-purple-600 md:text-4xl text-3xl font-semibold">
            Our Pricing Plans
        </p>
        <p className="text-lg md:w-[50%] w-full font-semibold text-gray-400">
            There are many variations of passages of Lorem Ipsum available but the majority have suffered alteration in some form.
        </p>

        <div className="md:flex flex-wrap w-full gap-5 items-center justify-center">
            {
                packages.map((pkg) => (
                    <PricingCard key={pkg.id} price={pkg.price}
                        desc={pkg.title}
                        slug={pkg.slug}
                        duration={duration(pkg.duration)}
                    />
                ))
            }
{/*             
            <PricingCard price="50" desc="lorem ipsum dolor sit amet dolor ipsum" />
            <PricingCard price="150" desc="lorem ipsum dolor sit amet dolor ipsum" /> */}
        </div>
        
    </div>
  )
}

export default Pricing

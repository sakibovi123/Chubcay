import Header from '@/Components/Main/Header'
import React, { useEffect, useState } from 'react'
import { Link, Head, useForm, usePage } from '@inertiajs/react';


function PackageDetails({package_details, shift4Payment, SHIFT4_PK}) {
    // const { shift4Payment } = usePage().props;

    const [ token, setToken ] = useState("");
    


    const { data, setData, post, processing, errors } = useForm({
        // amount: 800
    });

    const handleCheckout = (e) => {
        e.preventDefault();
        post(route('checkout.handle'),
         {data});
    }


    useEffect(() => {
        console.log(JSON.stringify(shift4Payment))
        const script = document.createElement('script');
        script.src = 'https://dev.shift4.com/checkout.js';
        script.className = 'shift4-button';
        script.dataset.key = SHIFT4_PK; // Your public key
        script.dataset.checkoutRequest = shift4Payment
        script.dataset.name = 'Chubcay';
        script.dataset.description = 'Checkout example';
        script.dataset.checkoutButton = 'Pay Now';
        document.body.appendChild(script);

        return () => {
            document.body.removeChild(script);
        };
    }, [shift4Payment]);

  return (
    
    <div className="h-full container md:mx-auto lg:w-[80%] md:w-[60%] w-full">
      <Header />
      {/* shift4: {shift4Payment} */}
    <div className=" gap-5 flex items-center justify-between my-5 p-5 bg-white border rounded shadow-md">
        <div className="w-full border-r-2">
            <h1 className="text-4xl font-bold">Package Name: {package_details.title}</h1>
            <p className="text-md text-gray-500 my-3 font-semibold">{package_details.sub_title}</p>
            <p className="font-bold font-semibold">
                Duration: {package_details.duration}
            </p>
        </div>
        <div className="w-full flex flex-col gap-2">
            <p className="text-4xl font-bold">Payment Details</p>
            <p>Price: <span className="font-bold">${package_details.price}</span></p>
            <p>Tax: <span className="font-bold">0%</span></p>
            <p>Total: <span className="font-bold">${package_details.price}</span></p>
            {/* <button id="payment-button">pay now</button> */}
            <form onSubmit={handleCheckout}>
                <button className="shift4-button"></button>
                {/* <script src="https://dev.shift4.com/checkout.js"
                    className="shift4-button"
                    data-key="pk_test_uEasbndcT9gzaQoWJl5usCqZ"
                    // data-checkout-request="NGRkZWJlNWYwMjgzYWNjMTVkZjg3OTU1OWJjZWQzMWY1ZDBhNWUxMTA2OTI3MzMzYmNjOWQ1NjMzNGEyOGE5OXx7ImNoYXJnZSI6eyJhbW91bnQiOjI0OTksImN1cnJlbmN5IjoiVVNEIn0sInRocmVlRFNlY3VyZSI6eyJlbmFibGUiOmZhbHNlfX0="
                    data-name="Shift4"
                    data-description="Checkout example"
                    data-checkout-button="Buy now"
                    data-class="btn btn-primary btn-lg"
                    >
                </script> */}
            </form>
        {/* </form> */}
        </div>
    </div>

    </div>
  )
}

export default PackageDetails

import Header from '@/Components/Main/Header'
import React, { useEffect, useState, useRef } from 'react'
import { Link, Head, useForm, usePage } from '@inertiajs/react';
import '../Assets/css/main.css'


function PackageDetails({package_details}) {
    const { user } = usePage().props;

    const [ token, setToken ] = useState("");
    
    const formRef = useRef(null);

    const { data, setData, post, processing, errors } = useForm({
        // amount: 809
        first_name: '',
        last_name: '',
        email: user.email || '',
        phone: '',
        package_id: package_details.id,
        card_number: '',
        // expiry: '',
        mm: '',
        year: '',
        cvc: ''
    });

    const handleCheckout = (e) => {
        e.preventDefault();
        post(route('checkout.handle'),
         {data});
    }
    

  return (
    <div className="w-full">
        
        <Header />
        <div className="h-full container md:mx-auto lg:w-[80%] md:w-[60%] w-full">
      
      {/* shift4: {shift4Payment} */}
    <div className=" gap-5 md:flex items-start justify-between my-5 p-5 bg-white border rounded shadow-md">
        <div className="w-full">
            {/* User: {auth.first_name} */}
            <h1 className="p-2 text-3xl font-bold">Package Name: {package_details.title}</h1>
            <p className="p-2 text-md text-gray-500 my-3 font-semibold">{package_details.sub_title}</p>
            <p className="p-2 font-bold font-semibold">
                Duration: {package_details.duration} days
            </p>
            <p className="border-b-2 p-2">
                {
                    Object.entries(package_details.features).map(([key, value], index) => (
                        <p className="p-1" key={index}><strong>{key}:</strong> {value}</p>
                    ))
                }  
            </p>
            <div className="p-2">
                <p className="p-2">Price: <span className="font-bold">${package_details.price}</span></p>
                <p className="p-2">Tax: <span className="font-bold">0%</span></p>
                <p className="p-2">Total: <span className="font-bold">${package_details.price}</span></p>
            </div>
            
            {/* <button id="payment-button">pay now</button> */}
        </div>
        <div className="w-full flex flex-col gap-2">
            <p className="text-3xl font-bold">Confirm & Pay</p>
            {/* <p>Price: <span className="font-bold">${package_details.price}</span></p>
            <p>Tax: <span className="font-bold">0%</span></p>
            <p>Total: <span className="font-bold">${package_details.price}</span></p> */}
            {/* <button id="payment-button">pay now</button> */}

            <form onSubmit={handleCheckout}
                id="payment-form"
                className="flex flex-col items-start gap-3">

                <label htmlFor="Email">Email</label>
                <input
                    required
                    disabled
                    defaultValue={user.email ? user.email : ''}
                    onChange={(e) => setData('email', e.target.value)}
                    type="email"
                    className="bg-red-100 w-full rounded border-gray-300" />

                    {errors.email && <div>{errors.email}</div>}

                <label htmlFor="Email">First Name</label>
                <input
                    required
                    type="text"
                    value={data.first_name}
                    onChange={(e) => setData('first_name', e.target.value)}
                    className="w-full rounded border-gray-300" />

                    {errors.first_name && <div>{errors.first_name}</div>}

                <label htmlFor="Email">Last Name</label>
                <input
                    required
                    type="text"
                    value={data.last_name}
                    onChange={(e) => setData('last_name', e.target.value)}
                    className="w-full rounded border-gray-300" />

                    {errors.last_name && <div>{errors.last_name}</div>}

                <label htmlFor="Email">Phone</label>
                <input
                    required
                    type="number"
                    value={data.phone}
                    onChange={(e) => setData('phone', e.target.value)}
                    className="w-full rounded border-gray-300" />

                    {errors.phone && <div>{errors.phone}</div>}
                
                <label htmlFor="card number">Card Number</label>
                <input
                    required
                    type="text"
                    maxLength={16}
                    value={data.card_number}
                    onChange={(e) => setData('card_number', e.target.value)}
                    className="w-full rounded border-gray-300"
                    placeholder="4242 4242 4242 4242"
                    />

                    {errors.card_number && <div>{errors.card_number}</div>}

                <label htmlFor="card number">Expiry & CVC</label>
                <div className="w-full flex items-center gap-2">
                    <input
                        required
                        type="number"                  
                        id="card-expiration-input"
                        value={data.mm}
                        onChange={(e) => setData('mm', e.target.value)}
                        placeholder="mm"
                        className="w-full rounded border-gray-300" maxLength={2} />

                        {errors.mm && <div>{errors.mm}</div>}

                        <input
                            required
                            type="number"
                            id="card-expiration-input"
                            value={data.year}
                            onChange={(e) => setData('year', e.target.value)}
                            placeholder="yy"
                            maxLength={2}
                            // min={2}
                            className="w-full rounded border-gray-300" />

                        {errors.year && <div>{errors.year}</div>}
                        
                        <input
                            required
                            type="number"
                            id="card-expiration-input"
                            value={data.cvc}
                            onChange={(e) => setData('cvc', e.target.value)}
                            placeholder="cvc"
                            maxLength={3}
                            className="w-full rounded border-gray-300" />

                        {errors.cvc && <div>{errors.cvc}</div>}
                </div>
                

                <div className="flex gap-2 items-center my-2">
                    <input required type="checkbox" />
                    <p>I agree with the terms & conditions</p>
                </div>
                
               {/* <div className="bg-blue-600 w-full p-2">
                    <button className="shift4-button w-full bg-blue-600"></button>
               </div> */}
                <button
                    type="submit"
                    className="bg-blue-500 p-3 w-full
                        text-white rounded font-bold"

                        disabled={processing}
                    >
                        Pay ${package_details.price}
                </button>
            </form>

           

            {/* <form onSubmit={handleCheckout}>
                <button
                 className="bg-blue-500 p-3 w-full
                     text-white rounded font-bold">
                    Pay ${package_details.price}
                </button>
                
            </form> */}
        {/* </form> */}
        </div>
    </div>

    </div>
    </div>
    
  )
}

export default PackageDetails
